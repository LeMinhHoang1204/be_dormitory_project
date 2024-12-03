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
            ->join('rooms', 'residences.room_id', '=', 'rooms.roomId')
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

    
//  Hien thi thong tin phong
    public function showRoomInfor($roomId)
    {
        $room = Room::find($roomId);
        return view('roomInfor.roomInfor', compact('room'));
    }

// Lay du lieu room tu DB
    public function showRoom($id)
    {
        $room = Room::find($id);
        return view('roomInfor.roomInfor', compact('room'));
    }


}