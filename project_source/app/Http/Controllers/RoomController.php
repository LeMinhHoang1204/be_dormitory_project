<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Residence;
use App\Models\Room;
use App\Models\Student;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    /** Display a listing of the resource. */
    use AuthorizesRequests;

    public function index(Building $building)
    {
        if (
            auth()->user()->role == 'admin' ||
            (auth()->user()->role == 'building manager' && $building->managed && $building->managed->user->id == auth()->user()->id)
        ) {
            $rooms = $building->hasRooms()->paginate(10);
        } else {
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
    public function show(Building $building, Room $room)
    {
        return view('roomInfor.roomInfor', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Building $building, Room $room)
    {
        $distinctRoomTypes = $this->getAllRoomType();
        return view('admin_rooms.edit', compact('building', 'room', 'distinctRoomTypes'));
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


    // Xử lý yêu cầu sửa chữa
    public function repairRequest()
    {
        if (auth()->check() && auth()->user()->role !== 'student') {
            return redirect()->route('home');  // Chuyển hướng nếu không phải sinh viên
        }

        // Lấy thông tin người dùng đang đăng nhập
        $user = auth()->user();

        // Lấy thông tin sinh viên
        $student = Auth::user()->student;
        // Giả lập dữ liệu phòng khi sinh viên chưa đăng ký phòng nào
        $studentRoom = null;
        if ($user->student && $user->student->rooms()->exists()) {
            // Nếu sinh viên đã có phòng, lấy thông tin phòng
            $studentRoom = $user->student->rooms()->first();
        } else {
            // Nếu sinh viên chưa có phòng, tạo dữ liệu giả để hiển thị
            $studentRoom = (object) [
                'room_name' => 'Room 101',
                'unit_price' => 1000000,
                'end_date' => '2024-12-31',
            ];
        }

        return view('.student.repair', compact('studentRoom'));
        //        if (!$student) {
        //            return view('student.repair', ['message' => 'You do not have a room, register!']);
        //        }
        //
        //        // Kiểm tra xem sinh viên có đang ở trong phòng nào không (qua bảng `residences`)
        //        $residence = DB::table('residences')
        //            ->where('stu_id', $student->id)
        //            ->where('status', 'Da nhan phong') // Tìm những sinh viên đã nhận phòng
        //            ->first();
        //
        //        if (!$residence) {
        //            return redirect()->route('dashboard')->with('message', 'Bạn chưa nhận phòng hoặc chưa đủ điều kiện yêu cầu sửa chữa.');
        //        }
        //
        //        // Lấy thông tin phòng từ bảng `rooms` thông qua `room_id` trong bảng `residences`
        //        $room = DB::table('rooms')->where('id', $residence->room_id)->first();
        //
        //        if (!$room) {
        //            return redirect()->route('dashboard')->with('message', 'Phòng của bạn không tồn tại.');
        //        }
        //
        //        // Hiển thị trang yêu cầu sửa chữa với thông tin phòng
        //        return view('student.repair-request', [
        //            'room' => $room, // Chuyển thông tin phòng đến view
        //            'student' => $student,
        //        ]);
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

    public function showRoomInfor(Request $request)
    {
        $roomId = $request->query('roomId');
        $room = Room::findOrFail($roomId);
        return view('roomInfor.roomInfor', compact('room'));
    }

    public function showListRoom()
    {
        $rooms = Room::with(['hasRoomAssets.asset'])->orderBy('id', 'asc')->paginate(6);
        return view('student_rooms.register', ['rooms' => $rooms]);
    }

    public function fetchRoomsForStudent()
    {
        $rooms = Room::with(['hasRoomAssets' => function ($query) {
            $query->select('id', 'room_id', 'asset_id', 'quantity');
        }, 'hasRoomAssets.asset' => function ($query) {
            $query->select('id', 'name');
        }])->get();

        return response()->json($rooms);
    }

    public function getRoomDataforStudent(Room $room)
    {

        $room = Room::find($room->id);
        return response()->json($room);
    }

}
