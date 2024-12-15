<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Notification;
use App\Models\Residence;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ResidenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Building $building, Room $room)
    {
        $residences = Residence::where('room_id', $room->id)->get();
        return view('admin.admin_residences.list', compact('residences', 'building', 'room'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('student_rooms.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Check login
            if (!auth()->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login to register for a room',
                ], 401);
            }

            // Check user is student
            $student = auth()->user()->student;
            if (!$student) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only students can register for rooms',
                ], 403);
            }

            $validated = $request->validate([
                'room_id' => 'required|exists:rooms,id',
                'check_in_date' => 'required|date|after:today',
                'duration' => 'required|in:3,6,9,12',
            ]);

            // Kiểm tra xem sinh viên đã có đăng ký phòng trong khoảng thời gian này chưa
            $existingRegistration = Residence::where('stu_user_id', $student->id)
                ->where('start_date', $validated['check_in_date'])
                ->first();

            if ($existingRegistration) {
                return response()->json([
                    'success' => false,
                    'message' => 'You already have a room registration for this date',
                ], 422);
            }

            // Kiểm tra xem phòng còn chỗ không
            $room = Room::find($validated['room_id']);
            $currentResidents = Residence::where('room_id', $validated['room_id'])
                ->where('status', 'Paid')
                ->where('end_date', '>', now())
                ->count();

            if ($currentResidents >= $room->member_number) {
                return response()->json([
                    'success' => false,
                    'message' => 'This room is already full',
                ], 422);
            }

            $end_date = Carbon::parse($validated['check_in_date'])
                ->addMonths((int) $validated['duration']);

            $residence = Residence::create([
                'room_id' => $validated['room_id'],
                'stu_user_id' => $student->id,
                'start_date' => $validated['check_in_date'],
                'end_date' => $end_date,
                'duration' => (int) $validated['duration'],
                'status' => 'Paid',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Room registration successful!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed: ' . $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Residence $residence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Residence $residence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Residence $residence)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Residence $residence)
    {
        //
    }

    public function myRoom()
    {
        $student = auth()->user()->student;

        if (!$student) {
            return redirect()->back()->with('error', 'You are not assigned as a student.');
        }

        $residence = Residence::where('stu_user_id', $student->id)->with('room')->first()
            ->with('room.building')
            ->first();

        if (!$residence) {
            return redirect()->back()->with('error', 'No room information found.');
        }

        return view('user_student.student.room', compact('residence'));
    }

}