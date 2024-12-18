<?php

namespace App\Http\Controllers;

use App\Models\Residence;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{

    public function index(){
        foreach (Student::all() as $student) {
            echo $student->name;
        }
    }

    public function store(Request $request): RedirectResponse
    {
        // Validate the request...

        $student = new Student();

        $student->name = $request->name;

        $student->save();

        return redirect('/flights');
    }

//    TODO: FIX THIS
    public function showRoomRenewalForm()
    {
        $residence = Auth::user()->residence()
            ->where('status', 'Checked in')
            ->first();

        if (!$residence) {
            return view('user_student.student.extension')->with('no_residence', true);
        }

        return view('user_student.student.extension', compact('residence'));
    }

    public function createRenewalRequest(Request $request)
    {

        $validatedData = $request->validate([
            'start_date' => 'required|string',
            'renewal-period' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $note = "Start Date: " . $validatedData['start_date'] . ", Renewal Period: " . $validatedData['renewal-period'] . " months, Description: " . $validatedData['description'];

        \App\Models\Request::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'type' => 'Renewal',
            'note' => $note,
        ]);

        return view('dashboard');
    }

    public function showCheckOutForm()
    {
        // Lấy thông tin sinh viên từ cơ sở dữ liệu
        $student = Auth::user()->student;

        // Kiểm tra nếu không có thông tin sinh viên
        if (!$student) {
            return view('student.checkout', ['message' => 'You do not have a room, register!']);
        }

        // Lấy thông tin phòng của sinh viên
        $residence = Auth::user()->residence()
            ->where('status', 'Checked in')
            ->first();

        // Nếu sinh viên không có phòng, chuyển hướng hoặc hiển thị thông báo
        if (!$residence) {
            return view('student.checkout', ['message' => 'No room found for this student.']);
        }

        // Trả về trang checkout với thông tin sinh viên và phòng
        return view('user_student.student.checkout', compact('student', 'residence'));
    }

    public function leaveRequest()
    {
        // Thực hiện xử lý khi nhấn "Leave" gửi yêu cầu checkout

        // Lưu thông tin yêu cầu checkout vào cơ sở dữ liệu hoặc gửi email thông báo

        // Chuyển hướng về trang checkout và hiển thị thông báo yêu cầu đã được gửi
        return redirect()->route('student.checkout')->with('message', 'Request sent');
    }

//    public function showRegisterRoomList()
//    {
//        $rooms = Room::paginate(6);
//        return view('Reg_room.reg_room', compact('rooms'));
//    }
    public function showRegisterRoomList()
    {
        $rooms = Room::with('hasRoomAssets.asset')
        ->where('status', '=',1)
        ->whereColumn('member_count', '<', 'type')
        ->whereHas('building', function ($query) {
            $query->where('type', auth()->user()->student->gender);
        })
        ->paginate(9);


        return view('Reg_room.reg_room', compact('rooms'));
    }

    public function showRegisterRoomForm($room)
    {
        // Lấy thông tin sinh viên từ cơ sở dữ liệu
        $student = Auth::user()->student;

        // Kiểm tra nếu không có thông tin sinh viên
        if (!$student) {
            return view('student.register-room', ['message' => 'You do not have a student user_profile.php.']);
        }

        // Lấy thông tin phòng của sinh viên
        $residence = Auth::user()->residence()
            ->where('status', 'Checked in')
            ->first();

        // Nếu sinh viên không có phòng, chuyển hướng hoặc hiển thị thông báo
        if ($residence) {
            return view('student.register-room', ['message' => 'You already have a room.']);
        }

        // Trả về trang đăng ký phòng với thông tin sinh viên và phòng
        return view('student.register-room', compact('student', 'room'));
    }

    public function showProfile()
    {
        $user = auth()->user();
        $currentResidence = Residence::where('stu_user_id', auth()->id())
            ->where('status', 'Checked in', 'Paid')
            ->with('room')
            ->first();
        if (!$user) {
            return redirect()->route('login')->with('message', 'Please log in first.');
        }

        if ($user->student) {
            $student = $user->student;
            return view('user_profile.student', compact('student'));
        } else {
            return redirect()->back()->with('message', 'Student user_profile.php not found');
        }
    }
    public function updateProfileImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        $user = auth()->user();

        if ($user->profile_image_path && Storage::disk('public')->exists($user->profile_image_path)) {
            Storage::disk('public')->delete($user->profile_image_path);
        }

        $imagePath = $request->file('profile_image')->store('profile_images', 'public');

        $user->profile_image_path = $imagePath;
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.!');
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

    public function getCurrentUser()
    {
        $user = Auth::user();

        $residence = Residence::where('stu_user_id', $user->id)->orderBy('start_date', 'desc')->first();

        return response()->json([
            'userId' => $user->id,
            'studentId' => $user->student->id,
            'name' => $user->name,
            'gender' => $user->student->gender,
            'residenceStatus' => $residence->status,
        ]);
    }

    public function registerRoom(Request $request)
    {
        $currentRoom = Room::where('id', $request->roomId)->first();
        if($currentRoom->member_count >= $currentRoom->type){
            session()->flash('notification', [
                'message' => 'Room is full!',
            ]);
            return redirect()->back();
        }

        $validatedData = $request->validate([
            'dormId' => 'required|integer',
            'roomId' => 'required|integer',
            'startDate' => 'required|date',
            'duration' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        $end_date = Residence::calculateEndDate($validatedData['startDate'], $validatedData['duration']);

        \App\Models\Residence::create([
            'stu_user_id' => $validatedData['dormId'],
            'room_id' => $validatedData['roomId'],
            'start_date' => $validatedData['startDate'],
            'duration' => $validatedData['duration'],
            'end_date' => $end_date,
        ]);

        \App\Models\Invoice::create([
            'sender_id' => '1',
            'object_type' => 'App\Models\User',
            'object_id' => $validatedData['dormId'],
            'send_date' => $validatedData['startDate'],
            'due_date' => now()->addDays(7),
            'type' => 'Room',
            'total' => $validatedData['duration'] * $validatedData['price'],
        ]);

        // Store notification data in session
        session()->flash('notification', [
            'message' => 'You had a new room invoice!',
//            'details' => [
//                'type' => 'Room',
//            ],
        ]);

        return redirect()->route('dashboard');
    }

    public function getLatestResidence($userId)
    {
        $residence = Residence::where('stu_user_id', $userId)->orderBy('start_date', 'desc')->first();
        return response()->json(['residence' => $residence]);
    }

    public function getStudentInfo($id)
    {
        $student = Student::with(['user.residence' => function ($query) {
            $query->orderBy('start_date', 'desc')->first();
        }, 'user.residence.room'])->where('user_id', $id)->first();

        if (!$student) {
            return response()->json(['success' => false, 'message' => 'Student not found.']);
        }

        return response()->json(['success' => true, 'student' => $student]);
    }
}
