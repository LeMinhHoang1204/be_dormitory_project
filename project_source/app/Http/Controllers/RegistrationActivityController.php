<?php

namespace App\Http\Controllers;

use App\Models\RegistrationActivity;
use App\Http\Requests\StoreRegistrationActivityRequest;
use App\Http\Requests\UpdateRegistrationActivityRequest;

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
//    public function store(StoreRegistrationActivityRequest $request)
//    {
//        //
//    }
    public function store(StoreRegistrationActivityRequest $request, Activity $activity)
    {
        $user = Auth::user();

        // Kiểm tra nếu sinh viên đã đăng ký tham gia hoạt động này
        $existingRegistration = RegistrationActivity::where('activity_id', $activity->id)
            ->where('participant_id', $user->id)
            ->first();

        if ($existingRegistration) {
            return redirect()->route('activities.show', $activity->id)
                ->with('error', 'You have already registered for this activity.');
        }

        // Kiểm tra số lượng người tham gia đã đầy chưa
        if ($activity->registered_participants >= $activity->max_participants) {
            return redirect()->route('activities.show', $activity->id)
                ->with('error', 'This activity is full.');
        }

        // Thêm bản ghi đăng ký mới
        RegistrationActivity::create([
            'activity_id' => $activity->id,
            'participant_id' => $user->id,
            'status' => 'Registered', // Trạng thái mặc định là 'Registered'
        ]);

        // Cập nhật số lượng người tham gia
        $activity->increment('registered_participants');

        return redirect()->route('activities.show', $activity->id)
            ->with('success', 'You have successfully registered for the activity.');
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
                ->with('error', 'You are not registered for this activity.');
        }

        // Cập nhật trạng thái thành 'Cancelled'
        $registration->update(['status' => 'Cancelled']);

        // Giảm số lượng người tham gia
        $activity->decrement('registered_participants');

        return redirect()->route('activities.show', $activity->id)
            ->with('success', 'You have successfully cancelled your registration.');
    }
}
