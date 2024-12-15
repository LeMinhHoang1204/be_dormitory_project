<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Residence;
use App\Http\Requests\StoreResidenceRequest;
use App\Http\Requests\UpdateResidenceRequest;
use App\Models\Room;
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
        return view('reg_room.reg_room');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

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
