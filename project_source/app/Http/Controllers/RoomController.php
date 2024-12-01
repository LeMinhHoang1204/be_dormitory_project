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
        // 1. Kiểm tra quyền truy cập
        if (auth()->check() && auth()->user()->role !== 'student') {
            return redirect()->route('home')->with('error', 'Access denied.');
        }

        // 2. Lấy thông tin sinh viên từ người dùng hiện tại
        $user = auth()->user();
        $student = $user->student;

        if (!$student) {
            // Nếu không có thông tin sinh viên
            return view('student.extension', ['message' => 'You do not have a registered room. Please register!']);
        }

        // 3. Lấy thông tin phòng hiện tại của sinh viên
        $studentRoom = $student->residences()
            ->where('status', 'Da nhan phong')
            ->join('rooms', 'residences.room_id', '=', 'rooms.id')
            ->select('rooms.name as room_name', 'rooms.unit_price', 'residences.end_date')
            ->first();

        // 4. Kiểm tra nếu sinh viên chưa có phòng
        if (!$studentRoom) {
            return view('student.extension', ['message' => 'No active room found. Please contact the management.']);
        }

        // 5. Trả dữ liệu về view
        return view('student.extension', compact('studentRoom'));
    }


// TODO: Xử lý trang check out.

    public function showCheckOutPage()
    {
        // Kiểm tra nếu người dùng không phải là student thì chuyển hướng về home
        if (auth()->check() && auth()->user()->role !== 'student') {
            return redirect()->route('home'); // Chuyển hướng nếu không phải sinh viên
        }

        // Lấy thông tin sinh viên từ cơ sở dữ liệu
        $student = Auth::user()->student;

        // Kiểm tra nếu không có thông tin sinh viên
        if (!$student) {
            return view('student.checkout', ['message' => 'You do not have a room, register!']);
        }

        // Lấy thông tin phòng của sinh viên
        $studentRoom = $student->rooms()->first();

        // Nếu sinh viên không có phòng, chuyển hướng hoặc hiển thị thông báo
        if (!$studentRoom) {
            return view('student.checkout', ['message' => 'No room found for this student.']);
        }

        // Trả về trang checkout với thông tin sinh viên và phòng
        return view('student.checkout', compact('student', 'studentRoom'));
    }

    public function leaveRequest()
    {
        // Thực hiện xử lý khi nhấn "Leave" gửi yêu cầu checkout

        // Lưu thông tin yêu cầu checkout vào cơ sở dữ liệu hoặc gửi email thông báo

        // Chuyển hướng về trang checkout và hiển thị thông báo yêu cầu đã được gửi
        return redirect()->route('student.checkout')->with('message', 'Request sent');
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
