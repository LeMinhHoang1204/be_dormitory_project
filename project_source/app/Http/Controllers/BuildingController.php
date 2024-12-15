<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Employee;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBuildingRequest;
use Illuminate\Support\Facades\DB;


class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buildings = Building::paginate(8);
        $managers = $this->getAvailableManagers();
        return view('admin.admin_buildings.list', compact('buildings', 'managers'));
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
        $nextId = DB::select("SHOW TABLE STATUS LIKE 'buildings'")[0]->Auto_increment;

        $managers = $this->getAvailableManagers();
        $building = (object) [
            'id' => $nextId,
            'created_at' => now(),
        ];
        return view('admin.admin_buildings.create', compact('managers','building'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBuildingRequest $request)
    {

        $data = $request->validated();

        $building = Building::create($data);
//        Tự động tạo phòng khi tạo tòa
        $this->createRoomsForBuilding($building, $data['floor_numbers'], $data['room_numbers']);

        return redirect()->route('buildings.index')->with('success', 'The building has been successfully created.');
    }

//    Tạo tự động các phòng ngay khi tạo tòa dựa trên floor_numbers và room_numbers, sau đó có thể edit room sau, chứ  tạo tòa No room rồi add từng phòng sau thì mất công
    private function createRoomsForBuilding(Building $building)
    {
        $roomCount = 0;
        $roomTypes = ['2', '4', '6', '8', '10'];
        $floorNumbers = $building->floor_numbers;
        $roomNumbers = $building->room_numbers;
        for ($i = 1; $i <= $floorNumbers; $i++) {
            $roomsPerFloor = $roomNumbers / $floorNumbers;

            for ($j = 1; $j <= $roomsPerFloor; $j++) {
                $roomCount++;

                $roomNumber = str_pad($j, 2, '0', STR_PAD_LEFT);

                $floorNumber = $i < 10 ? $i : str_pad($i, 2, '0', STR_PAD_LEFT); // Chỉ thêm số 0 nếu tầng >= 10

                $roomName = $building->build_name . '.' . $floorNumber . $roomNumber;

                $randomRoomType = $roomTypes[array_rand($roomTypes)];

                Room::create([
                    'building_id' => $building->id,
                    'name' => $roomName,
                    'floor_number' => $i,
                    'type' => $randomRoomType,
                    'unit_price' => rand(5000, 10000) * 100,
                    'status' => 0,
                ]);
            }
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Building $building)
    {
        $rooms = $building->hasRooms()
            ->where('building_id', $building->id)
            ->orderBy('floor_number', 'asc') // Sắp xếp theo số tầng tăng dần
            ->paginate(10);

        return view('admin.admin_buildings.show', compact('building', 'rooms'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Building $building)
    {
        $managers = $this->getAvailableManagers();
        return view('admin.admin_buildings.edit', compact('building', 'managers'));
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

        return redirect(route('buildings.index', absolute: false))->with('success', 'Building updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Building $building)
    {
        $building->delete();
        return redirect(route('buildings.index', absolute: false))->with('success', 'Building deleted successfully');
    }

    private function getAvailableManagers()
    {
        return Employee::where('type', 'building manager')
            ->whereNotIn('id', Building::pluck('manager_id')->filter())
            ->get();
    }

}
