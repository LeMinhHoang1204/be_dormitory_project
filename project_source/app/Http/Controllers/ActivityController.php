<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use Illuminate\Routing\Controller;
use App\Models\Activity;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{

//    public function __construct()
//    {
//        $this->middleware('can:update,activity')->only(['edit', 'update']);
//    }

    public function index()
    {
        $activities = Activity::paginate(10);
        return view('student_activities.list', compact('activities'));
    }

    public function adminIndex()
    {
        $activities = Activity::paginate(8);
        return view('admin_activities.list', compact('activities'));
    }

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
//    public function show($id)
//    {
//        $activity = Activity::find($id);
//        if (!$activity) {
//            return redirect()->route('activities.index')->with('error', 'Activity not found');
//        }
//        return view('admin_activities.show', compact('activity'));
//    }
    public function show($id)
    {
        $activity = Activity::find($id);
        if (!$activity) {
            return redirect()->route('admin_activities.index')->with('error', 'Activity not found');
        }
        return view('admin_activities.show', compact('activity'));
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
//    public function update(UpdateActivityRequest $request, Activity $activity)
//    {
////        dd(auth()->user(), $activity);
////        $this->authorize('update', $activity);
//
//        $validated = $request->validate([
//            'title' => 'required|string|max:255',
//            'description' => 'nullable',
//            'note' => 'nullable',
//            'register_end_date' => 'required|date',
//            'start_date' => 'required|date',
//            'end_date' => 'required|date',
//            'max_participants' => 'required|integer',
//            'ticket_price' => 'required|integer',
//            'bonus_point' => 'required|integer',
//        ]);
////        $activity->update($validated);
//        $activity->update($request->validated());
//        return redirect()->route('admin_activities.show', $activity->id)
//            ->with('success', 'Activity updated successfully.');
//    }
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
        $activity->delete();

        return redirect()->route('admin.activities.index')->with('success', 'Activity deleted successfully.');
    }



}
