<?php

namespace App\Http\Controllers;
use App\Models\Student;
use Carbon\Carbon;

use Illuminate\Foundation\Auth\User;
use Illuminate\Routing\Controller;
use App\Models\Activity;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\RegistrationActivity;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::query();
        $user = auth()->user();
        $creators = User::whereIn('role', ['admin', 'building manager'])->get();

//        Lọc trạng thái registered của student (My status)
        if ($request->has('registered') && !empty($request->registered)) {
            if (in_array('Not registered', $request->registered)) {
                $query->whereDoesntHave('hasParticipants', function ($subQuery) {
                    $subQuery->where('participant_id', auth()->id());
                });
            }
            $registeredStatuses = array_diff($request->registered, ['Not registered']);
            if (!empty($registeredStatuses)) {
                $query->whereHas('hasParticipants', function ($subQuery) use ($registeredStatuses) {
                    $subQuery->where('participant_id', auth()->id())
                        ->whereIn('status', $registeredStatuses);
                });
            }
        }
        // Lọc trạng thái của Activity (Status)
        if ($request->has('status') && !empty($request->status)) {
            $query->whereIn('status', $request->status);
        }
        // Lọc theo Creator
        if ($request->has('creator') && $request->creator != 'None' && !empty($request->creator)) {
            $query->where('creator_id', $request->creator);
        }
        // Lọc theo tháng
        if ($request->has('month') && $request->month != 'None' && !empty($request->month)) {
            $query->whereMonth('start_date', $request->month); // Lọc theo tháng
        }

        // Lọc theo năm
        if ($request->has('year')&& $request->year != 'None' && !empty($request->year)) {
            $query->whereYear('start_date', $request->year); // Lọc theo năm
        }

        // Lọc chính xác theo ngày bắt đầu (Start Date)
        if ($request->has('start_date') && !empty($request->start_date)) {
            $query->whereDate('start_date', $request->start_date); // Lọc các hoạt động có ngày bắt đầu trùng với start_date
        }

        // Lọc chính xác theo ngày kết thúc (End Date)
        if ($request->has('end_date') && !empty($request->end_date)) {
            $query->whereDate('end_date', $request->end_date); // Lọc các hoạt động có ngày bắt đầu trùng với end_date
        }

        // Lọc theo số lượng người tham gia (max_participants)
        if ($request->has('max_participants') && !empty($request->max_participants)) {
            foreach ($request->max_participants as $value) {
                if ($value == '<10') {
                    $query->where('max_participants', '<', 10);
                }
                if ($value == '10-50') {
                    $query->whereBetween('max_participants', [10, 50]);
                }
                if ($value == '50-100') {
                    $query->whereBetween('max_participants', [50, 100]);
                }
                if ($value == '>100') {
                    $query->where('max_participants', '>', 100);
                }
            }
        }
        // Lọc theo Full/Not Full
        if ($request->has('full') && !empty($request->full)) {
            if (in_array('Full', $request->full)) {
                $query->whereColumn('registered_participants', '>=', 'max_participants');
            }
            if (in_array('Notfull', $request->full)) {
                $query->whereColumn('registered_participants', '<', 'max_participants');
            }
        }
        $activities = $query->with(['hasParticipants' => function ($query) {
            $query->where('participant_id', auth()->id());
        }])->paginate(10);

        return view('student_activities.list', [
            'activities' => $activities,
            'creators' => $creators,
        ]);
    }

    public function adminIndex(Request $request)
    {
        $query = Activity::query();
        $user = auth()->user();
        $creators = User::whereIn('role', ['admin', 'building manager'])->get();

        if ($request->has('registered') && !empty($request->registered)) {
            if (in_array('Not registered', $request->registered)) {
                $query->whereDoesntHave('hasParticipants', function ($subQuery) {
                    $subQuery->where('participant_id', auth()->id());
                });
            }
            $registeredStatuses = array_diff($request->registered, ['Not registered']);
            if (!empty($registeredStatuses)) {
                $query->whereHas('hasParticipants', function ($subQuery) use ($registeredStatuses) {
                    $subQuery->where('participant_id', auth()->id())
                        ->whereIn('status', $registeredStatuses);
                });
            }
        }
        if ($request->has('status') && !empty($request->status)) {
            $query->whereIn('status', $request->status);
        }
        // Lọc theo Creator
        if ($request->has('creator') && $request->creator != 'None'&& $request->creator != 'None' && !empty($request->creator)) {
            $query->where('creator_id', $request->creator);
        }
        // Lọc theo tháng
        if ($request->has('month') && $request->month != 'None' && !empty($request->month)) {
            $query->whereMonth('start_date', $request->month); // Lọc theo tháng
        }

        // Lọc theo năm
        if ($request->has('year')&& $request->year != 'None' && !empty($request->year)) {
            $query->whereYear('start_date', $request->year); // Lọc theo năm
        }

        // Lọc chính xác theo ngày bắt đầu (Start Date)
        if ($request->has('start_date') && !empty($request->start_date)) {
            $query->whereDate('start_date', $request->start_date); // Lọc các hoạt động có ngày bắt đầu trùng với start_date
        }

        // Lọc chính xác theo ngày kết thúc (End Date)
        if ($request->has('end_date') && !empty($request->end_date)) {
            $query->whereDate('end_date', $request->end_date); // Lọc các hoạt động có ngày bắt đầu trùng với end_date
        }

        // Lọc theo số lượng người tham gia (max_participants)
        if ($request->has('max_participants') && !empty($request->max_participants)) {
            foreach ($request->max_participants as $value) {
                if ($value == '<10') {
                    $query->where('max_participants', '<', 10);
                }
                if ($value == '10-50') {
                    $query->whereBetween('max_participants', [10, 50]);
                }
                if ($value == '50-100') {
                    $query->whereBetween('max_participants', [50, 100]);
                }
                if ($value == '>100') {
                    $query->where('max_participants', '>', 100);
                }
            }
        }
        // Lọc theo Full/Not Full
        if ($request->has('full') && !empty($request->full)) {
            if (in_array('Full', $request->full)) {
                $query->whereColumn('registered_participants', '>=', 'max_participants');
            }
            if (in_array('Notfull', $request->full)) {
                $query->whereColumn('registered_participants', '<', 'max_participants');
            }
        }

        $activities = $query->with(['hasParticipants' => function ($query) {
            $query->where('participant_id', auth()->id());
        }])->paginate(10);

        return view('admin_activities.list', [
            'activities' => $activities,
            'creators' => $creators,
        ]);
    }
    //Trang admin
    public function myActivities(Request $request)
    {
        $query = Activity::query();

        $user = auth()->user();
        $creators = User::whereIn('role', ['admin', 'building manager'])->get();

        $activitiesQuery = Activity::where('creator_id', $user->id);

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

        // Lọc theo số lượng người tham gia (max_participants)
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

        // Lấy danh sách các hoạt động theo các điều kiện trên và phân trang
        $activities = $activitiesQuery->paginate(10);

        return view('admin_activities.my_activities', [
            'activities' => $activities,
            'creators' => $creators,
        ]);    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nextId = DB::select("SHOW TABLE STATUS LIKE 'activities'")[0]->Auto_increment;

        $activity = (object) [
            'id' => $nextId,
            'created_at' => now(),
        ];
        return view('admin_activities.create', compact('activity'));
//        return view('admin_activities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
//    public function store(StoreActivityRequest $request)
//    {
//        //
//    }
    public function store(StoreActivityRequest $request)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable',
            'register_end_date' => 'required|date',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'max_participants' => 'required|integer',
            'ticket_price' => 'required|integer',
            'bonus_point' => 'required|integer',
            'note' => 'nullable',
        ]);
        $validated['creator_id'] = auth()->user()->id;

        $activity = Activity::create($validated);

        return redirect()->route('admin_activities.show', ['id' => $activity->id])->with('success', 'Activity created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $activity = Activity::find($id);
        if (!$activity) {
            return redirect()->route('activities.index')->with('error', 'Activity not found');
        }
        return view('admin_activities.show', compact('activity'));
    }

//    public function participants(Activity $activity)
//    {
//        $participants = $activity->participants()->with([
//            'student.residence' => function ($query) {
//                $query->whereIn('status', ['Paid', 'Checked in','Registered'])
//                ->with(['room.building' => function ($query) {
//                    $query->select('id', 'build_name'); // Lấy tên tòa nhà
//                }]);
//            },
//            'student.residence.room' => function ($query) {
//                $query->select('id', 'name'); // Lấy tên phòng của residence
//            }
//        ])
//            ->select('users.id', 'users.name')
//            ->paginate(10);
//
//        // Kiểm tra nếu không có participants
//        if ($participants->isEmpty()) {
//            return redirect()->back()->with('error', 'No participants found for this activity.');
//        }
//
//        // Trả về view với danh sách người tham gia và thông tin hoạt động
//        return view('admin_activities.participants', compact('participants', 'activity'));
//    }
    public function participants(Activity $activity)
    {
        $query = $activity->participants()->with([
            'student.residence' => function ($query) {
                $query->whereIn('status', ['Paid', 'Checked in', 'Registered'])
                    ->with(['room.building' => function ($query) {
                        $query->select('id', 'build_name');
                    }]);
            },
            'student.residence.room' => function ($query) {
                $query->select('id', 'name');
            }
        ])
            ->select('users.id', 'users.name');

        if ($status = request('status')) {
            $query->whereHas('student.residence', function ($query) use ($status) {
                $query->whereIn('status', $status);
            });
        }

        if ($regis_date = request('regis_date')) {
            $query->whereHas('student.activities', function ($query) use ($regis_date, $activity) {
                $query->whereDate('registration_activities.created_at', '>=', $regis_date)
                    ->where('activity_id', $activity->id);
            });
        }


        if ($building = request('building')) {
            $query->whereHas('student.residence.room.building', function ($query) use ($building) {
                $query->where('build_name', 'like', '%' . $building . '%');
            });
        }

        $query->whereHas('student.residence'); // Chỉ lấy những người có residence

        $participants = $query->paginate(10);

        if ($participants->isEmpty()) {
            return redirect()->back()->with('error', 'No participants found for this activity.');
        }

        // Trả về view với danh sách người tham gia và thông tin hoạt động
        return view('admin_activities.participants', compact('participants', 'activity'));
    }

    public function showProfile($activityId, $studentId)
    {
        $activity = Activity::findOrFail($activityId);
        $student = Student::with('residence.room')->findOrFail($studentId);
        $currentResidence = $student->residence->firstWhere(fn($res) => in_array($res->status, ['Paid', 'Checked in', 'Registered']));

        if (!in_array(auth()->user()->role, ['admin', 'building manager'])) {
            return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }

        return view('admin_activities.profile_participant', compact('student', 'activity', 'currentResidence'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
    {
        $activity->start_date = Carbon::parse($activity->start_date);
        $activity->end_date = Carbon::parse($activity->end_date);
        $activity->register_end_date = Carbon::parse($activity->register_end_date);

        return view('admin_activities.edit', compact('activity'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateActivityRequest $request, Activity $activity)
    {

//        $activity = Activity::findOrFail($id);

        // Validate the incoming data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable',
            'note' => 'nullable',
            'register_end_date' => 'required|date',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'max_participants' => 'required|integer',
            'ticket_price' => 'required|integer',
            'bonus_point' => 'required|integer',
        ]);
        $activity->update($validated);
//        dd($request->all());

        return redirect()->route('activities.show', ['id' => $activity->id])->with('success', 'Activity created successfully.');

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->id !== $activity->creator_id) {
            return redirect()->route('activities.show', ['id' => $activity->id])
                ->with('error', 'Only administrators  or creator of this activity can delete!!');
        }

        $activity->delete();
        return redirect()->route('admin.activities.index')->with('success', 'Activity deleted successfully.');
    }



}
