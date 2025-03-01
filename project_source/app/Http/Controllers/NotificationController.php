<?php

namespace App\Http\Controllers;

use App\Events\NewNotification;
use App\Events\NotificationEvent;
use App\Models\Building;
use App\Models\Notification;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $user = auth()->user(); // Lấy người dùng hiện tại

        // Khởi tạo query để lọc dữ liệu
        $query = Notification::with('object');

        if (!$user->isAdmin()) {
            $query->where(function ($q) use ($user) {
                $q->where('sender_id', $user->id) // Lọc nếu người dùng là người gửi
                    ->orWhereHas('object', function ($q) use ($user) {
                        $q->where(function ($q) use ($user) {
                            $q->where('object_type', 'App\Models\User')
                                ->where('object_id', $user->id); // So sánh object_id với user_id

                        })->orWhere(function ($q) use ($user) {
                            $residence = $user->residence()->where('status', 'Checked in')->first();
                            if ($residence && $residence->room) {
                                $q->where('object_type', 'App\Models\Room')
                                    ->where('object_id', $user->residence()->where('status', 'Checked in')->first()->room->id); // So sánh object_id với residence->room->name
                            }
                        })->orWhere(function ($q) use ($user) {
                            $residence = $user->residence()->where('status', 'Checked in')->first();
                            if ($residence && $residence->room && $residence->room->building) {
                                $q->where('object_type', 'App\Models\Building')
                                    ->where('object_id', $user->residence()->where('status', 'Checked in')->first()->room->building->id); // So sánh object_id với residence->room->building->build_name
                            }
                        });
                    });
            });
        }

        // Lọc theo ngày tạo gần đây hoặc xa nhất
        if ($request->has('sort_date') && !empty($request->sort_date)) {
            if ($request->sort_date === 'recent') {
                $query->orderBy('created_at', 'desc');
            } elseif ($request->sort_date === 'oldest') {
                $query->orderBy('created_at', 'asc');
            }
        }

        // Lọc theo một ngày cụ thể
        if ($request->has('specific_date') && !empty($request->specific_date)) {
            $query->whereDate('created_at', $request->specific_date);
        }

        // Lọc theo khoảng thời gian
        if ($request->has('start_date') && $request->has('end_date')
            && !empty($request->start_date) && !empty($request->end_date)) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // Lọc theo người đăng thông báo
        if ($request->has('posted_by') && is_array($request->posted_by)) {
            $query->whereHas('senderNotification', function ($q) use ($request) {
                $q->whereIn('role', $request->posted_by); // Giả sử "role" là trường để xác định vai trò của người gửi
            });
        }

        // Lấy danh sách thông báo sau khi áp dụng bộ lọc

        // $notifications = $query->latest()->get();
        $notifications = $query->latest()->paginate(3)->withQueryString();

        return view('admin/notification/list', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $buildings = Building::all();
        return view('admin/notification/create', compact('buildings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        dd($request);
//        echo($request);exit;
        // Validate data
        $validatedData = $request->validate([
            'sender_id' => 'required|integer',
            'title' => 'required|string',
            'type' => 'required|string|in:individual,group',
            'content' => 'required|string',
            'user_object_id' => 'required_if:type,individual|integer|nullable',
            'building_object_id' => 'required_if:group,building|integer|nullable',
            'room_object_id' => 'required_if:group,room|integer|nullable',
            'group' => 'required_if:type,group|in:building,room|nullable',
        ]);

        // Set object type and ID based on notification type
        if ($validatedData['type'] === 'individual') {
            $validatedData['object_type'] = 'App\Models\User';
            $validatedData['object_id'] = $request->user_object_id;
        } elseif ($validatedData['type'] === 'group') {
            if ($request->group === 'building') {
                $validatedData['object_type'] = 'App\Models\Building';
                $validatedData['object_id'] = $request->building_object_id;
            } elseif ($request->group === 'room') {
                $validatedData['object_type'] = 'App\Models\Room';
                $validatedData['object_id'] = $request->room_object_id;
            }
        }

        // Create notification
        $notification = Notification::create([
            'sender_id' => $validatedData['sender_id'],
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'object_type' => $validatedData['object_type'],
            'object_id' => $validatedData['object_id'],
        ]);

        $sender = User::getSpecificUser($validatedData['sender_id']);
//        event(new NotificationEvent($sender->name, $validatedData['object_id']));

//        return redirect(route('notifications.index', absolute: false));

//        // Xác định recipientIds dựa trên loại thông báo
        $recipientIds = [];
        if ($validatedData['type'] === 'individual') {
            $recipientIds[] = $request->user_object_id;
        } elseif ($validatedData['type'] === 'group') {
            if ($request->group === 'building') {
                // Lấy tất cả user ID trong tòa nhà
                $recipientIds = User::whereHas('residence', function ($query) use ($request) {
                    $query->whereHas('room', function ($q) use ($request) {
                        $q->where('building_id', $request->building_object_id);
                    })->where('status', 'Checked in');
                })->pluck('id')->toArray();
            } elseif ($request->group === 'room') {
                // Lấy tất cả user ID trong phòng
                $recipientIds = User::whereHas('residence', function ($query) use ($request) {
                    $query->where('room_id', $request->room_object_id)
                        ->where('status', 'Checked in');
                })->pluck('id')->toArray();
            }
        }

        // Broadcast event với recipientIds
        foreach ($recipientIds as $recipientId) {
            broadcast(new NotificationEvent(
                $sender->name,
                $recipientId
            ))->toOthers();
        }

        return response()->json([
            'success' => true,
            'message' => 'Notification created successfully',
            'notification' => $notification,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Notification $notification)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notification $notification)
    {
        return view('admin/notification/edit', compact('notification'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notification $notification)
    {
        // Kiểm tra quyền truy cập (có thể sử dụng policy nếu có)
        $this->authorize('update', $notification);

        // Validate dữ liệu nhập vào
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|string',
            'sender_id' => 'required|integer',
            'object_id' => 'required|integer',
        ]);
        // Cập nhật thông báo
        $notification->update($validatedData);

        return redirect(route('notifications.index', absolute: false));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification)
    {
        $this->authorize('delete', $notification);

        // Xóa thông báo khỏi cơ sở dữ liệu
        $notification->delete();

        // Chuyển hướng về danh sách thông báo với thông báo thành công
        return redirect(route('notifications.index', absolute: false));
    }

    public function getAllBuilding()
    {
        $buildings = Building::all();
        return response()->json($buildings);
    }

    public function getAllRoom(int $building)
    {
        $rooms = Room::where('building_id', $building)->get();
        return response()->json($rooms);
    }

    public function getAllUser()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return response()->json($users);
    }

    public function getUsersByRoom($roomId)
    {
        try {
            // Lấy users thông qua residences
            $users = User::whereHas('residence', function ($query) use ($roomId) {
                $query->where('room_id', $roomId)
                    ->where('status', 'Checked in');
            })
                ->select('id', 'name')
                ->get();

            if ($users->isEmpty()) {
                return response()->json(['message' => 'No users found in this room'], 404);
            }

            return response()->json($users);
        } catch (\Exception $e) {
            \Log::error('Error fetching users by room: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch users'], 500);
        }
    }

}
