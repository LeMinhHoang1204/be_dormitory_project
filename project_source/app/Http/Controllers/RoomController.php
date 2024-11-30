<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Room;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use AuthorizesRequests;
    public function index(Building $building)
    {
        if (auth()->user()->role == 'admin' ||
            (auth()->user()->role == 'building manager' && $building->managed && $building->managed->user->id == auth()->user()->id)) {
            $rooms = $building->hasRooms()->paginate(10);
        }
        else {
            $rooms = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);
        }

        return view('admin_rooms.list', compact('building', 'rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Building $building)
    {
        $distinctRoomTypes = $this->getAllRoomType();
        return view('admin_rooms.create', compact('building', 'distinctRoomTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Building $building)
    {
        // Validate data
        $validatedData = $request->validate([
            'building_id' => 'required|integer',
            'name' => 'required|string',
            'floor_number' => 'required|integer',
            'type' => 'required|string',
            'unit_price' => 'required|integer',
        ]);

        Room::create($validatedData);
        return redirect(route('rooms.index', ['building' => $building]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        return view('rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Building $building, Room $room)
    {
        $distinctRoomTypes = $this->getAllRoomType();
        return view('admin_rooms.edit', compact('building','room', 'distinctRoomTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Building $building, Room $room)
    {
        $validatedData = $request->validate([
            'building_id' => 'required|integer',
            'name' => 'required|string',
            'floor_number' => 'required|integer',
            'type' => 'required|string',
            'unit_price' => 'required|numeric',
            'status' => 'required|integer',
        ]);

        $room->update($validatedData);

        return redirect(route('rooms.index', ['building' => $building]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->back();
    }

    private function getAllRoomType()
    {
        return Room::distinct('type')->orderBy('type', 'asc')->get('type');
    }


    public function showRoomExtensionForm()
    {
        // Kiểm tra nếu người dùng không phải là student thì chuyển hướng về home
        if (auth()->check() && auth()->user()->role !== 'student') {
            return redirect()->route('home'); // Chuyển hướng nếu không phải sinh viên
        }

        // Lấy thông tin sinh viên từ user
        $student = auth()->user()->student;

        // Kiểm tra nếu không có sinh viên liên kết
        if (!$student) {
            // Nếu không có thông tin sinh viên, vẫn hiển thị trang extension
            return view('/student/extension', ['message' => 'You do not have room, register!']);        }

        // Lấy thông tin phòng của sinh viên
        $studentRoom = $student->rooms()->first(); // Truy xuất phòng của sinh viên

//        // Nếu không tìm thấy phòng, hiển thị thông báo
//        if (!$studentRoom) {
//            return view('/student/extension', ['message' => 'No room found for this student.']);
//        }

        // Nếu có phòng, hiển thị phòng
        return view('/student/extension', compact('studentRoom'));
    }





//
//    public function extendRoomContract(Request $request)
//    {
//        // Lấy thông tin phòng của người dùng
//        $room = Room::where('user_id', auth()->id())->first();
//
//        // Validate dữ liệu gửi từ form
//        $validatedData = $request->validate([
//            'renewal-period' => 'required|in:3,6,9,12',
//            'description' => 'nullable|string|max:255',
//        ]);
//
//        // Cập nhật ngày hết hạn hợp đồng
//        $newExpiryDate = now()->addMonths($validatedData['renewal-period']);
//        $room->expiry_date = $newExpiryDate;
//        $room->description = $validatedData['description'] ?? $room->description;
//
//        // Lưu lại thông tin đã cập nhật
//        $room->save();
//
//        // Trả về thông báo thành công
//        return redirect()->route('student.room.extension')->with('success', 'Room contract has been successfully extended!');
//    }
}
