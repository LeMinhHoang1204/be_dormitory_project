<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Building;
use App\Models\Room;
use App\Models\RoomAsset;
use App\Models\Student;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        return view('admin.admin_rooms.list', compact('building', 'rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Building $building)
    {
        $nextId = DB::select("SHOW TABLE STATUS LIKE 'rooms'")[0]->Auto_increment;

        // Query for the latest room in the building
        $room = Room::where('building_id', $building->id)->latest()->first();

        if (!$room) {
            $room = (object) [
                'id' => $nextId, // Ensure $nextId is defined
                'created_at' => now(),
            ];
        }
        $assets = Asset::all();
        $rooms = $building->hasRooms()->where('building_id', $building->id)->paginate(10);
        $distinctRoomTypes = $this->getAllRoomType();
        return view('admin.admin_rooms.create', compact('building', 'distinctRoomTypes', 'rooms', 'room', 'assets'));
    }

    /**
     * Store a newly created resource in storage.
     */
//    public function store(Request $request, Building $building)
//    {
//        // Validate data
//        $validatedData = $request->validate([
//            'building_id' => 'required|integer',
//            'name' => 'required|string|unique:rooms,name',
//            'floor_number' => 'required|integer',
//            'type' => 'required|string',
//            'unit_price' => 'required|integer',
//
//        ]);
//
//        Room::create($validatedData);
//        return redirect(route('buildings.show', ['building' => $building]))->with('success', 'Room created successfully!');
//    }
    public function store(Request $request, $buildingId)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'floor_number' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'assets' => 'array', // Validate assets as an array
            'assets_quantity' => 'array', // Validate quantities
        ]);
        // Kiểm tra nếu tên phòng đã tồn tại
        $existingRoom = Room::where('building_id', $buildingId)
            ->where('name', $validated['name'])
            ->first();

        if ($existingRoom) {
            return back()->withErrors(['name' => 'Room name already exists. Please choose another name.'])
                ->withInput(); // Quay lại và hiển thị lỗi
        }
        // Tạo phòng mới
        $room = Room::create([
            'name' => $validated['name'],
            'floor_number' => $validated['floor_number'],
            'unit_price' => $validated['unit_price'],
            'building_id' => $buildingId,
        ]);

        // Lưu thông tin tài sản kèm phòng
        if ($request->has('assets')) {
            foreach ($validated['assets'] as $assetId) {
                $quantity = $validated['assets_quantity'][$assetId] ?? 0;
                if ($quantity > 0) {
                    RoomAsset::create([
                        'room_id' => $room->id,
                        'asset_id' => $assetId,
                        'quantity' => $quantity,
                        'issue_date' => now(),
                    ]);
                }
            }
        }

        return redirect()->route('buildings.show', $buildingId)
            ->with('success', 'Room created successfully.');
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
        $room->load('hasRoomAssets.asset');
        $availableAssets = Asset::all(); // Lấy toàn bộ tài sản
        $assets = Asset::all();
        $distinctRoomTypes = $this->getAllRoomType();
        return view('admin.admin_rooms.edit', compact('building', 'room', 'distinctRoomTypes', 'availableAssets', 'assets'));
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
            'assets.*' => 'nullable|integer|min:0',
            'new_assets.*' => 'nullable|exists:assets,id',
            'new_quantities.*' => 'nullable|integer|min:1',
        ]);

        $room->update($validatedData);
        // 1. Cập nhật tài sản hiện có
        if ($request->has('assets')) {
            foreach ($request->input('assets') as $assetId => $quantity) {
                $roomAsset = RoomAsset::where('room_id', $room->id)
                    ->where('asset_id', $assetId)
                    ->first();
                if ($roomAsset) {
                    $roomAsset->quantity = $quantity;
                    $roomAsset->save();
                }
            }
        }

        // 2. Thêm tài sản mới
        if ($request->has('new_assets')) {
            foreach ($request->input('new_assets') as $index => $assetId) {
                $quantity = $request->input('new_quantities')[$index];
                if ($assetId && $quantity) {
                    RoomAsset::create([
                        'room_id' => $room->id,
                        'asset_id' => $assetId,
                        'quantity' => $quantity,
                        'status' => 'In use',
                        'issue_date' => now(),
                    ]);
                }
            }
        }
        return redirect(route('buildings.show', ['building' => $building]))->with('success', 'Room updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($buildingId, $roomId)
    {
        $room = Room::findOrFail($roomId);
        $room->delete();
        return redirect()->back()->with('success', 'Room deleted successfully');
    }

    private function getAllRoomType()
    {
        return Room::distinct('type')->orderBy('type', 'asc')->get('type');
    }

    // Xử lý yêu cầu sửa chữa
    public function repairRequest()
    {
        if (auth()->check() && auth()->user()->role !== 'student') {
            return redirect()->route('home'); // Chuyển hướng nếu không phải sinh viên
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
        return view('Reg_room.reg_room', ['rooms' => $rooms]);
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
