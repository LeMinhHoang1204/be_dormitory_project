<?php

namespace App\Http\Controllers;

use App\Models\Notification;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


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
                ->orWhereHas('notification', function ($q) use ($user) {
                    $q->where('user_id', $user->id); // Lọc nếu người dùng là người nhận
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
        $notifications = $query->latest()->get();

        return view('admin/notification/list', compact('notifications'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('admin/notification/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        Gate::authorize('create', Notification::class);

//        $this->authorize('create', Notification::class);

        // Validate data
        $validatedData = $request->validate([
            'sender_id' => 'required|integer',
            'title' => 'required|string',
            'type' => 'required|string',
            'content' => 'required|string',
            'object_id' => 'required|integer',
        ]);

        if ($validatedData['type'] === 'individual') {
            $validatedData['object_type'] = 'App\Models\User';
        }

//        dd($request->all());
        Notification::create($validatedData); // Sử dụng dữ liệu đã xác thực

        return redirect(route('notifications.index', absolute: false));
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
}
