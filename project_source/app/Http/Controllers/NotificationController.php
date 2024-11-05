<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Notification;
use App\Http\Requests\StoreNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use App\Models\NotificationRecipient;
use App\Models\Room;
use App\Models\Student;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;


class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notifications = Notification::with('recipients.user')->latest()->get();
        return view('/notification/notification-list', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'sender_id' => 'required|integer|exists:ACCOUNT,ACC_ID',
            'type' => 'required|in:1,2',
            'content' => 'required|string|max:2000',
            'recipients' => 'required|array',
            'recipients.*' => 'integer|exists:ACCOUNT,ACC_ID',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        // Tạo bản ghi thông báo
        $notification = Notification::create([
            'sender_id' => $request->sender_id,
            'recevier_id' =>$request->recevier_id,
            'type' => $request->type,
            'content' => $request->content,
        ]);
        $this->index();
//        return response()->json(['message' => 'Notification created successfully.']);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNotificationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNotificationRequest $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification)
    {
        //
    }
}
