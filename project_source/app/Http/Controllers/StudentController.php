<?php

namespace App\Http\Controllers;

use App\Models\Asset;
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
use function Webmozart\Assert\Tests\StaticAnalysis\lower;

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
    public function showRegisterRoomList(Request $request)
    {
        $searchTerm = $request->input('search');

        $rooms = Room::with('hasRoomAssets.asset')
            ->where('status', 1)
            ->whereColumn('member_count', '<', 'type')
            ->whereHas('building', function ($query) {
                $query->where('type', auth()->user()->student->gender);
            });

        if ($searchTerm) {
            $rooms->where('name', 'like', '%' . $searchTerm . '%');
        }

        $rooms = $rooms->paginate(9)->appends(['search' => $searchTerm]);

        return view('Reg_room.reg_room', compact('rooms'));
    }
    public function showFilteredRoomList(Request $request)
    {
        $query = Room::with('hasRoomAssets.asset')
            ->whereHas('building', function ($query) {
                $query->where('type',  auth()->user()->student->gender); // Chỉ lọc theo gender của user
            });

        if ($request->has('status') && !empty($request->input('status'))) {
            $query->whereIn('status', $request->input('status'));
        }
        if ($request->has('floorNumber') && $request->input('floorNumber') != '') {
            $query->where('floor_number', $request->input('floorNumber'));
        }

        if ($request->has('roomType') && !empty($request->input('roomType'))) {
            $query->whereIn('type', $request->input('roomType'));
        }

        if ($request->has('price') && !empty($request->input('price'))) {
            foreach ($request->input('price') as $price) {
                switch ($price) {
                    case 1:
                        $query->where('unit_price', '<', 500000);
                        break;
                    case 2:
                        $query->whereBetween('unit_price', [500000, 1000000]);
                        break;
                    case 3:
                        $query->whereBetween('unit_price', [1000000, 2000000]);
                        break;
                    case 4:
                        $query->whereBetween('unit_price', [2000000, 3000000]);
                        break;
                }
            }
        }
        if ($request->has('facilities') && !empty($request->input('facilities'))) {
            $facilities = $request->input('facilities');

            foreach ($facilities as $facility) {
                $query->whereHas('hasRoomAssets', function ($q) use ($facility) {
                    $q->whereHas('asset', function ($q) use ($facility) {
                        $q->where('name', $facility);
                    });
                });
            }
        }

        $rooms = $query->paginate(9);

        return view('reg_room.reg_room', compact('rooms'));
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
            return view('student.register-room', ['message' => 'You already have a current room.']);
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
                'note' => $request->note,
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
                    'type' => 'Room Registration',
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
