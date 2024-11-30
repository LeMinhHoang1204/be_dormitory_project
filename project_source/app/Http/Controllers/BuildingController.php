<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Employee;
use Illuminate\Http\Request;


class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buildings = Building::all();

        $managers = $this->getAvailableManagers();
        return view('admin_buildings.list', compact('buildings', 'managers'));
    }

    public function updateManager(Request $request, Building $building)
    {
        $building->update(['manager_id' => $request->manager_id]);
        return redirect()->route('buildings.index')->with('success', 'Manager updated successfully');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $managers = $this->getAvailableManagers();
        return view('admin_buildings.create', compact('managers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'manager_id' => 'nullable|exists:employees,id',
            'type' => 'required|string|max:255',
            'floor_numbers' => 'required|integer',
            'room_numbers' => 'required|integer',
        ]);

        Building::create($validatedData);

        return redirect(route('buildings.index', absolute: false));
    }

    /**
     * Display the specified resource.
     */
    public function show(Building $building)
    {
        $rooms = $building->hasRooms()->where('building_id', $building->id)->get();
        return view('admin_buildings.show', compact('building', 'rooms'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Building $building)
    {
        $managers = $this->getAvailableManagers();
        return view('admin_buildings.edit', compact('building', 'managers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Building $building)
    {

        $validatedData = $request->validate([
            'manager_id' => 'nullable|exists:employees,id',
            'type' => 'required|in:male,female',
            'floor_numbers' => 'required|integer',
            'room_numbers' => 'required|integer',
        ]);

        $building->update($validatedData);

        return redirect(route('buildings.index', absolute: false));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Building $building)
    {
        $building->delete();
        return redirect(route('buildings.index', absolute: false));
    }

    private function getAvailableManagers()
    {
        return Employee::where('type', 'building manager')
            ->whereNotIn('id', Building::pluck('manager_id')->filter())
            ->get();
    }

}
