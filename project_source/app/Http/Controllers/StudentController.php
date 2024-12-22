<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Residence;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        //
    }

//    TODO: FIX THIS
    public function showRoomRenewalForm()
    {
//        echo(auth()->id());
        $residence = Residence::where('stu_user_id', auth()->id())
            ->where('status', 'Checked in')->orderBy('created_at', 'desc')
            ->first();

        if (!$residence) {
            return view('user_student.student.room')->with('error', 'You have not checked in the room, cannot check out!');
        }

        return view('user_student.student.extension', compact('residence'));
    }

    public function createRenewalRequest(Request $request)
    {
        $oldRequest = \App\Models\Request::where('sender_id', Auth::id())->where('type', 'Renewal')->where('status', 'Pending')->first();
        if ($oldRequest) {
            session()->flash('error', [
                'message' => 'You already have a renewal request pending!',
            ]);
            return redirect()->back();
        }
        else if (!$request->residence_id){
            session()->flash('error', [
                'message' => "You don't have a room to renew!",
            ]);
            return redirect()->back();
        }

        $validatedData = $request->validate([
            'renewal_period' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        if (!$request->receiver_id) {
            return redirect()->route('students.extend.form')->with('error', 'Manager ID is missing.');
        }

        $note =  "Renewal Duration: " . $validatedData['renewal_period'] . " months, Description: " . $validatedData['description'];

        $newRequest = \App\Models\Request::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'type' => 'Renewal',
            'note' => $note,
        ]);
        if($request->hasFile('image')) {
            (new ImageController)->saveToRequest($request, $newRequest->id);
        }

        session()->flash('notification', [
            'message' => 'You already created a new renewal request!',
        ]);

        return redirect()->route('dashboard')->with('status', 'Renewal request created successfully!');
    }

    public function showCheckOutForm()
    {
        $user = auth()->user();

        // Lấy thông tin sinh viên từ cơ sở dữ liệu
        $student = Auth::user()->student;

        // Kiểm tra nếu không có thông tin sinh viên
        if (!$student) {
            return view('students.register-room.list', ['message' => 'You do not have a room, register!']);
        }

        // Lấy thông tin phòng của sinh viên
        $residence = Residence::where('stu_user_id', $user->id)
            ->with('room.building')
            ->first();


        if (!$residence) {
            return redirect()->route('students.register-room.list')->with('error', 'You do not have a room, register!');
        }

        // Trả về trang checkout với thông tin sinh viên và phòng
        return view('user_student.student.checkout', compact('student', 'residence'));
    }

    public function leaveRequest()
    {
        // Thực hiện xử lý khi nhấn "Leave" gửi yêu cầu checkout

        // Lưu thông tin yêu cầu checkout vào cơ sở dữ liệu hoặc gửi email thông báo

        // Chuyển hướng về trang checkout và hiển thị thông báo yêu cầu đã được gửi
        return redirect()->route('students.checkout')->with('message', 'Request sent');
    }


    public function showRegisterRoomList()
    {
        $rooms = Room::with('hasRoomAssets.asset')
            ->where('status', 1)
            ->whereColumn('member_count' , '<', 'type')
            ->whereHas('building', function ($query) {
                $query->where('type', auth()->user()->student->gender);
            })
            ->paginate(6);

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
        $residence = Residence::where('stu_user_id', $user->id)
            ->with('room.building')
            ->first();

        if (!$user) {
            return redirect()->route('login')->with('message', 'Please log in first.');
        }

        if ($user->student) {
            $student = $user->student;
            return view('user_profile.student', compact('student', 'residence'));
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



    public function registerRoom(Request $request)
    {
        echo($request);exit;
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

        return redirect()->route('student.room')->with('success', 'Registered room successfully!.');
    }

    public function registerRoom2(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'room_id' => 'required|exists:rooms,id',
                'check_in_date' => 'required|date|after:today',
                'duration' => 'required|in:3,6,9,12',
            ]);

            // Kiểm tra xem phòng còn chỗ không
            $room = Room::find($validated['room_id']);

            if ($room->member_count >= $room->type) {
                return response()->json([
                    'success' => false,
                    'message' => 'This room is already full'
                ], 422);
            }

            $end_date = Carbon::parse($validated['check_in_date'])
                ->addMonths((int) $validated['duration']);

            $residence = Residence::create([
                'room_id' => $validated['room_id'],
                'stu_user_id' => auth()->id(),
                'start_date' => $validated['check_in_date'],
                'end_date' => $end_date,
                'months_duration' => (int) $validated['duration'],
            ]);

            if (!$residence) {
                throw new \Exception('Failed to create residence record');
            }

            // Invoice
            $total = $room->unit_price * (int)$validated['duration'];

            try {
                $invoice = Invoice::create([
                    'sender_id' => 1,
                    'object_type' => 'App\Models\User',
                    'object_id' => auth()->id(),
                    'start_date' => $validated['check_in_date'],
                    'send_date' => now(),
                    'due_date' => now()->addDays(7),
                    'type' => 'Room',
                    'total' => $total,
                    'note' => 'Room registration fee for ' . $room->name,
                ]);

                if (!$invoice) {
                    throw new \Exception('Failed to create invoice record');
                }
            } catch (\Exception $e) {
                \Log::error('Invoice creation failed: ' . $e->getMessage());
                throw new \Exception('Failed to create invoice: ' . $e->getMessage());
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Room registration successful! Please complete your payment.',
                'invoice' => [
                    'total' => $total,
                    'due_date' => $invoice->due_date,
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Registration failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Registration failed: ' . $e->getMessage()
            ], 422);
        }
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
            'residenceStatus' => $residence ? $residence->status : null,
        ]);
    }

    public function getLatestResidence()
    {
        $user = Auth::user();

        $residence = Residence::where('stu_user_id', $user->id)->orderBy('created_at', 'desc')->first();
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