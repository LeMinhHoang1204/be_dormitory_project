<?php

namespace App\Http\Controllers;

use App\Models\Residence;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

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

    public function showRoomRenewalForm()
    {
        $residence = Auth::user()->residence()
            ->where('status', 'Checked in')
            ->first();

        if (!$residence) {
            return view('student.extension')->with('no_residence', true);
        }

        return view('student.extension', compact('residence'));
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
        return view('student.checkout', compact('student', 'residence'));
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
        $rooms = Room::with('hasRoomAssets.asset')->paginate(9);
        return view('Reg_room.reg_room', compact('rooms'));
    }

    public function showRegisterRoomForm($room)
    {
        // Lấy thông tin sinh viên từ cơ sở dữ liệu
        $student = Auth::user()->student;

        // Kiểm tra nếu không có thông tin sinh viên
        if (!$student) {
            return view('student.register-room', ['message' => 'You do not have a student profile.']);
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

    public function getCurrentUser()
    {
        $user = Auth::user();

        return response()->json([
            'userId' => $user->id,
            'studentId' => $user->student->id,
            'name' => $user->name,
            'gender' => $user->student->gender,
        ]);
    }

    public function createNewResidence(Request $request)
    {

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
            'object_type' => 'User',
            'object_id' => $validatedData['dormId'],
            'send_date' => now(),
            'due_date' => now()->addDays(7),
            'type' => 'Room',
            'total' => $validatedData['duration'] * $validatedData['price'],
        ]);

        return view('dashboard');
    }
}
