<?php

namespace App\Http\Controllers;

use App\Models\RegistrationActivity;
use App\Models\Activity;
use App\Http\Requests\StoreRegistrationActivityRequest;
use App\Http\Requests\UpdateRegistrationActivityRequest;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class RegistrationActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function myActivities(Request $request)
    {
        $query = Activity::query();

        $user = auth()->user();
        $creators = User::whereIn('role', ['admin', 'building manager'])->get();

        $activitiesQuery = Activity::whereHas('hasParticipants', function ($query) use ($user) {
            $query->where('participant_id', $user->id);
        });

        if ($request->has('registered') && !empty($request->registered)) {
            $registeredStatuses = array_diff($request->registered, ['Not registered']);
            if (!empty($registeredStatuses)) {
                $activitiesQuery->whereHas('hasParticipants', function ($subQuery) use ($user, $registeredStatuses) {
                    $subQuery->where('participant_id', $user->id)
                        ->whereIn('status', $registeredStatuses);
                });
            }
        }

        if ($request->has('status') && !empty($request->status)) {
            $activitiesQuery->whereIn('status', $request->status);
        }

        // Lọc theo tháng
        if ($request->has('month') && $request->month != 'None' && !empty($request->month)) {
            $activitiesQuery->whereMonth('start_date', $request->month); // Lọc theo tháng
        }

        // Lọc theo năm
        if ($request->has('year') && $request->year != 'None' && !empty($request->year)) {
            $activitiesQuery->whereYear('start_date', $request->year); // Lọc theo năm
        }

        // Lọc chính xác theo ngày bắt đầu (Start Date)
        if ($request->has('start_date') && !empty($request->start_date)) {
            $activitiesQuery->whereDate('start_date', $request->start_date);
        }

        // Lọc chính xác theo ngày kết thúc (End Date)
        if ($request->has('end_date') && !empty($request->end_date)) {
            $activitiesQuery->whereDate('end_date', $request->end_date);
        }
        // Lọc theo Creator
        if ($request->has('creator')&& $request->creator != 'None' && !empty($request->creator)) {
            $activitiesQuery->where('creator_id', $request->creator);
        }

        // Lọc theo số l    ượng người tham gia (max_participants)
        if ($request->has('max_participants') && !empty($request->max_participants)) {
            foreach ($request->max_participants as $value) {
                if ($value == '<10') {
                    $activitiesQuery->where('max_participants', '<', 10);
                }
                if ($value == '10-50') {
                    $activitiesQuery->whereBetween('max_participants', [10, 50]);
                }
                if ($value == '50-100') {
                    $activitiesQuery->whereBetween('max_participants', [50, 100]);
                }
                if ($value == '>100') {
                    $activitiesQuery->where('max_participants', '>', 100);
                }
            }
        }

        // Lọc theo Full/Not Full
        if ($request->has('full') && !empty($request->full)) {
            if (in_array('Full', $request->full)) {
                $activitiesQuery->whereColumn('registered_participants', '>=', 'max_participants');
            }
            if (in_array('Notfull', $request->full)) {
                $activitiesQuery->whereColumn('registered_participants', '<', 'max_participants');
            }
        }

        $activities = $activitiesQuery->paginate(10);

        return view('student_activities.my_activities', [
            'activities' => $activities,
            'creators' => $creators,
        ]);    }


    public function store(StoreRegistrationActivityRequest $request, Activity $activity)
    {
        $user = Auth::user();

        if (Gate::denies('store', new RegistrationActivity(['activity_id' => $activity->id]))) {
            return redirect()->route('activities.show', $activity->id)
                ->with('error', 'You are not authorized to register for this activity.');
        }

        if ($activity->register_end_date < now()) {
            return redirect()->route('activities.show', $activity->id)
                ->with('error', 'Has expired to register for this activity.');
        }

        // neu đã đăng ký hoặc tham gia rồi thì acti đó không hiện nút đăng ký
//        $existingRegistration = $activity->hasParticipants()->where('participant_id', $user->id)
//            ->whereIn('status', ['Registered', 'Joined'])
//            ->first();
//
//        if ($existingRegistration) {
//            return redirect()->route('activities.show', $activity->id)
//                ->with('success', 'You have already registered for this activity before.');
//        }

//        // Nếu đã hủy đăng ký trước đó, có thể đăng ký lại
        $existingCancelled = $activity->hasParticipants()->where('participant_id', $user->id)
            ->where('status', 'Cancelled')
            ->first();

        if ($existingCancelled) {
            // Nếu đã hủy đăng ký trước đó, có thể đăng ký lại
            $existingCancelled->delete();
        }

        if ($activity->registered_participants >= $activity->max_participants) {
            return redirect()->route('activities.show', $activity->id)
                ->with('error', 'This activity is full.');
        }

        RegistrationActivity::create([
            'activity_id' => $activity->id,
            'participant_id' => $user->id,
            'status' => 'Registered',
        ]);

        $activity->increment('registered_participants');

        return redirect()->route('activities.show', ['id' => $activity->id])
            ->with('success', 'You have successfully registered for this activity.');
    }


    /**
     * Display the specified resource.
     */
    public function show(RegistrationActivity $registrationActivity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RegistrationActivity $registrationActivity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRegistrationActivityRequest $request, RegistrationActivity $registrationActivity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        $user = Auth::user();

        // Kiểm tra nếu người dùng đã đăng ký tham gia hoạt động này
        $registration = RegistrationActivity::where('activity_id', $activity->id)
            ->where('participant_id', $user->id)
            ->first();

        if (!$registration) {
            return redirect()->route('activities.show', $activity->id)
                ->with('error', 'You have not registered for this activity before.');
        }

        // Cập nhật trạng thái thành 'Cancelled'
        $registration->update(['status' => 'Cancelled']);

        // Giảm số lượng người tham gia
        $activity->decrement('registered_participants');

        return redirect()->route('activities.show', $activity->id)
            ->with('success', 'You have successfully cancelled your registration.');
    }

}
