<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Invoice;
use App\Models\Request;
use App\Models\Residence;
use App\Models\Room;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user(); // Lấy người dùng hiện tại

        // Khởi tạo query để lọc dữ liệu
        $query = Request::query();

        if (!$user->isAdmin()) {
            $query->where(function ($q) use ($user) {
                $q->where('sender_id', $user->id) // Lọc nếu người dùng là người gửi
                ->orWhere('receiver_id', $user->id) // Lọc nếu người dùng là người nhận
                ->orWhere('forwarder_id', $user->id); // Lọc nếu người dùng là người chuyển tiếp
            });
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.admin_building_manager_requests.list', compact('requests'));

    }

    public function getCheckInReq()
    {
        $residences = null;
        $user = Auth::user();

        if($user->role == 'building manager') {
            $building = \App\Models\Building::where('manager_id', $user->employee->id)->first();
            if($building) {
                $residences = Residence::where('status', 'Paid')
                    ->whereHas('room.building', function ($query) use ($building) {
                        $query->where('id', $building->id);
                    })->paginate(10);
            }
        }
        else if ($user->role == 'admin') {
            $residences = Residence::where('status', 'Paid')->paginate(10);
        }

        return view('admin.admin_building_manager_check_in_request.list', compact('residences'));
    }

    public function getDetailCheckInReq($id)
    {
        $residence = Residence::find($id);
        return view('admin.admin_building_manager_check_in_request.detail', compact('residence'));
    }

    public function acceptCheckIn(\Illuminate\Http\Request $request, $id)
    {
        Residence::where('id', $id)->update(['status' => 'Checked In', 'note' => $request->note]);
        return redirect()->route('requests.getCheckInReq');
    }

    public function getTransferCheckInReq(Residence $residence)
    {
        return view('admin.admin_building_manager_check_in_request.transfer', compact('residence'));
    }

    public function acceptTransferCheckInReq(\Illuminate\Http\Request $request, Residence $residence)
    {
//        echo($request->image); exit;
        if($request->hasFile('image')) {
            (new ImageController)->saveToResidence($request, $residence->id);
        }

        // cũ
        $residence->update(['status' => 'Transfered', 'check_out_date' => now(),
            'note' => $residence->note . ' - ' . 'Transfered to user '. $request->tranferredID
                . ' - Accepted by ' . Auth::user()->id . ' - ' . Auth::user()->name]);

        $invoice = Invoice::where([
            ['object_id', '=', $request->tranfferingID],
            ['type', '=', 'Room Registration'],
            ['object_type', '=', 'App\Models\User'],
            ['start_date', '=', $residence->start_date],
        ])->first();
        $invoice->update(['status' => 'Transferred Room' ,
            'note' => $invoice->note . ' - ' . 'Transfered to user '. $request->tranferredID
                . ' - Accepted by ' . Auth::user()->id . ' - ' . Auth::user()->name]);

        // mới
        $new_start_date = now();
        $newResidence = \App\Models\Residence::create([
            'stu_user_id' => $request->tranferredID,
            'room_id' => $residence->room_id,
            'start_date' => $new_start_date,
            'months_duration' => Carbon::parse($new_start_date)->diffInMonths(Carbon::parse($residence->end_date)),
            'status' => 'Paid',
            'note' => 'Transfered from ' . $residence->stu_user_id . ' on ' . now() . ' - Accepted by ' . Auth::user()->id . ' - ' . Auth::user()->name,
        ]);

        $newResidence->update(['end_date' => $residence->end_date]);

        $newInvoice = \App\Models\Invoice::create([
            'sender_id' => $invoice->sender_id,
            'object_type' => $invoice->object_type,
            'object_id' => $request->tranferredID,
            'start_date' => $new_start_date,
            'send_date' => $new_start_date,
            'due_date' => $new_start_date,
            'paid_date' => $invoice->paid_date,
            'type' => $invoice->type,
            'status' => 'Paid',
            'total' => $invoice->total,
            'payment_method' => $invoice->payment_method,
            'evidence_image' => $invoice->evidence_image,
            'note' => 'Transfered from ' . $residence->stu_user_id . ' on ' . now() . ' - Accepted by ' . Auth::user()->id . ' - ' . Auth::user()->name,
        ]);

        $newInvoice->update(['due_date' => $new_start_date->addDays(7)]);
        return redirect()->route('requests.getCheckInReq');
    }

    public function rejectCheckIn(\Illuminate\Http\Request $request, Residence $residence)
    {
        $prevResidence = Residence::where('stu_user_id', $residence->stu_user_id)->orderBy('created_at', 'desc')->skip(1)->first();

        $invoice = Invoice::where([
            ['object_id', '=', $residence->stu_user_id],
            ['object_type', '=', 'App\Models\User'],
            ['type', '=', 'Room Registration'],
            ['start_date', '=', $prevResidence->start_date], // start_date de xac dinh hoa don
        ])->first();

        // nếu chưa thanh toán thì không thể đi nhận phòng
        if($invoice->status == 'Paid') {
            $invoice->update(['note' => 'Rejected for user '. $residence->stu_user_id . ' from ' . $residence->room->name .
                ' on ' . $residence->start_date . ' with reason: ' . $request->description]);
        }

        // nếu có ảnh thì chuyển ảnh vào invoice
        if($request->hasFile('image')) {
            (new ImageController)->saveToInvoice($request, $invoice->id);
        }

        $residence->update(['status' => 'Rejected',
            'note' => $residence->note . ' - ' . 'Rejected for user '. $residence->stu_user_id . ' from ' . $residence->room->name .
                ' on ' . $residence->start_date . ' with reason: ' . $request->description]);

        // nếu được chọn hoàn tiền
        if($request->IsRefund == 'on') {
            $residence->update(['note' => $residence->note . ' - ' . 'Refunding for user '. $residence->stu_user_id]);

            if($invoice->status == 'Paid') {
                $invoice->update(['status' => 'Refunding',
                    'note' => $residence->note . ' - ' . 'Refunding for user '. $residence->stu_user_id]);
            }


            $accountant = \App\Models\User::where('role', 'Accountant')->first();
            $newRequest = Request::create([
                'sender_id' => Auth::user()->id,
                'receiver_id' => $accountant->id ?? 1,
                'type' => 'Refund',
                'status' => 'Pending',
                'note' => 'Refund for user '. $residence->stu_user_id . ' from ' . $residence->room->name .
                    ' on ' . $residence->start_date . ' with reason: ' . $request->description,
            ]);

            // neu có hoàn tiền và có ảnh thì chuyển ảnh vào request
            if($request->hasFile('image')) {
                (new ImageController)->saveToRequest($request, $newRequest->id);
            }
        }

        return redirect()->route('requests.getCheckInReq');
    }

    public function accept(\Illuminate\Http\Request $requestApi, Request $request)
    {
        if($requestApi->hasFile('image')) {
            (new ImageController)->saveToRequest($requestApi, $request->id);
        }
        $request->update(['status' => 'Accepted', 'note' => $request->note . " - " . $requestApi->description . ' - Accepted by ' . Auth::user()->id . ' - ' . Auth::user()->name ]);
        if($request->type == 'Renewal') {
            $note = $request->note;
            preg_match('/\d+/', $note, $matches);
            $firstNumber = $matches[0] ?? null;

            if ($firstNumber !== null) {
                $newInvoice = Invoice::create([
                    'sender_id' => Auth::user()->id,
                    'object_type' => 'App\Models\User',
                    'object_id' => $request->sender_id,
                    'send_date' => now(),
                    'due_date' => now()->addDays(7),
                    'type' => 'Room Registration',
                    'total' => $firstNumber * $request->sender->residence()->latest()->first()->room->unit_price,
                    'note' => 'Renewal for user '. $request->sender_id . ' from ' . $request->sender->residence()->latest()->first()->room->name .
                        ' on ' . $request->sender->residence()->latest()->first()->start_date . ' more: ' . $firstNumber . ' months',
                ]);
            }
        }
        else if($request->type == 'Check out'){
            $this->resolve($requestApi, $request);
        }
        else if($request->type == 'Change Room'){

            $oldResidence = $request->sender->residence()->orderBy('created_at', 'desc')->first();

            // lay phong moi
            $pattern = '/to room ([A-Z]\d\.\d+)/';
            preg_match($pattern, $request->note, $matches);
            $newRoomName = $matches[1];
            $newRoom = Room::where('name', $newRoomName)->first();

            // kiểm tra xem phòng mới có cùng tòa nhà với phòng cũ không
            if($oldResidence->room->building_id != $newRoom->building_id
                && $request->receiver_id != $newRoom->building->managedBy->user->id){
                $newRequest = Request::create([
                    'sender_id' => $request->sender_id,
                    'receiver_id' => $newRoom->building->managedBy->user->id,
                    'type' => 'Change Room',
                    'status' => 'Pending',
                    'forwarded_id' => Auth::user()->id,
                    'note' => 'Change Room for user ' . $oldResidence->stu_user_id . ' from room ' . $oldResidence->room->name .
                        ' to room ' . $newRoom->name . ' on ' . $requestApi->new_start_date . ' with reason: ' . $requestApi->description,
                ]);
                (new ImageController)->saveToRequest($requestApi, $newRequest->id);
            }
            else {
                $newCheckOutDate = Carbon::parse($requestApi->new_start_date)->subDay();
                $oldResidence->update(
                    ['status' => 'Changed Room',
                        'check_out_date' => $newCheckOutDate,
                        'note' => $oldResidence->note . ' - ' . "Check out on " . $newCheckOutDate
                    ]);

                if ($newRoomName) {
                    $newResidence = Residence::create([
                        'stu_user_id' => $oldResidence->stu_user_id,
                        'room_id' => $newRoom->id,
                        'start_date' => $requestApi->new_start_date,
                        'months_duration' => Carbon::parse($requestApi->new_start_date)->diffInMonths(Carbon::parse($oldResidence->end_date)),
                        'status' => 'Paid',
                        'note' => 'Change Room from room ' . $oldResidence->room->name . ' to room ' . $newRoom->name . ' on ' . now(),
                    ]);

                    $newResidence->update(['end_date' => $oldResidence->end_date]);
                    $oldResidence->update(['end_date' => $newCheckOutDate]);

                    if ($newRoom->unit_price > $oldResidence->room->unit_price) {
                        $newInvoice = Invoice::create([
                            'sender_id' => Auth::user()->id,
                            'object_type' => 'App\Models\User',
                            'object_id' => $oldResidence->stu_user_id,
                            'start_date' => $requestApi->new_start_date,
                            'send_date' => now(),
                            'due_date' => now()->addDays(7),
                            'type' => 'Room Registration',
                            'total' => ($newRoom->unit_price - $oldResidence->room->unit_price) * $newResidence->months_duration,
                            'note' => 'Change Room from room ' . $oldResidence->room->name . ' to room ' . $newRoom->name . ' on ' . now(),
                        ]);
                    } else if ($newRoom->unit_price < $oldResidence->room->unit_price) {
                        $accountant = \App\Models\User::where('role', 'Accountant')->first();
                        $newRequest = Request::create([
                            'sender_id' => Auth::user()->id,
                            'receiver_id' => $accountant->id,
                            'type' => 'Refund',
                            'status' => 'Pending',
                            'note' => 'Refund for user ' . $oldResidence->stu_user_id . ' from ' . $oldResidence->room->name .
                                ' on ' . $oldResidence->start_date . ' with reason: ' . $request->note,
                        ]);
                        if ($requestApi->hasFile('image')) {
                            (new ImageController)->saveToRequest($requestApi, $newRequest->id);
                        }
                    }
                }
            }


        }

        return redirect()->route('requests.index');
    }

    public function reject(\Illuminate\Http\Request $requestApi, Request $request)
    {
        $request->update(['status' => 'Rejected', 'resolve_date' => now(), 'note' => $request->note . ' - ' . $requestApi->description . ' - Rejected by ' . Auth::user()->id . ' - ' . Auth::user()->name]);
        if($requestApi->hasFile('image')) {
            (new ImageController)->saveToRequest($requestApi, $request->id);
        }
        return redirect()->back();
    }

    public function resolve(\Illuminate\Http\Request $requestApi ,Request $request)
    {
        if ($request->type == 'Refund') {
            // cập nhật cư trú cũ
            $note = $request->note;
            preg_match('/\d+/', $note, $matches);
            $firstNumber = $matches[0] ?? null;

            if ($firstNumber !== null) {
                $residence = Residence::where([
                    ['stu_user_id', '=', $firstNumber],
                ])->orderBy('created_at', 'desc')->first();

                if($residence){
                    $invoice = Invoice::where([
                        ['object_id', '=', $residence->stu_user_id],
                        ['type', '=', 'Room Registration'],
                        ['object_type', '=', 'App\Models\User'],
                        ['start_date', '=', $residence->start_date],
                    ])->first();
                }
            }


            // cái này chỉ phù hợp vơới hoá đơn hoàn tiền khi nhận phòng
            if ($invoice && $invoice->status == 'Refunding' && $residence->status == 'Rejected') {
                $invoice->update(['status' => 'Refunded', 'note' => $invoice->note . ' - ' . 'Refunded for user ' . $residence->stu_user_id]);
                $residence->update(['status' => 'Refunded', 'note' => $residence->note . ' - ' . 'Refunded for user ' . $residence->stu_user_id]);
                // tạo hoá đơn hoàn tiền mới
                $newInvoice = Invoice::create([
                    'sender_id' => Auth::user()->id,
                    'object_type' => 'App\Models\User',
                    'object_id' => $residence->stu_user_id,
                    'send_date' => now(),
                    'due_date' => now()->addDays(7),
                    'paid_date' => now(),
                    'type' => 'Refund',
                    'status' => 'Paid',
                    'total' => $invoice->total, // sai tiền đóối với hoàn tiền đổi phong
                    'payment_method' => 'Bank Transfer',
                    'note' => 'Refunded for user ' . $residence->stu_user_id . ' from ' . $residence->room->name .
                        ' on ' . $residence->start_date . ' with reason: ' . $request->description . ' - Refunded by ' . Auth::user()->id . ' - ' . Auth::user()->name,
                ]);
                if ($requestApi->hasFile('image')) {
                    (new ImageController)->saveToInvoice($requestApi, $newInvoice->id);
                }

            }

            // sinh vien dang ky phong moi it tien hon phong cu
            // tinh so tien can hoan = (so tien phong cu - so tien phong moi) * so thang con lai
            // lay oldResidence paid
            elseif ($residence->status == 'Paid') {
                // start date moi nen khong tim duoc hoa don cu --> bo qua hoa don cu
                // tạo hoá đơn hoàn tiền mới
                // so tien phong cu = note
                // so tien phong moi = residence->room->unit_price
                // so thang con lai = residence->months_duration

                // lay phong cu
                $pattern = '/from room ([A-Z]\d\.\d+)/';
                preg_match($pattern, $residence->note, $matches);
                $oldRoomName = $matches[1];
                $oldRoom = Room::where('name', $oldRoomName)->first();

                $total = ($oldRoom->unit_price - $residence->room->unit_price) * $residence->months_duration;

                $newInvoice = Invoice::create([
                    'sender_id' => Auth::user()->id,
                    'object_type' => 'App\Models\User',
                    'object_id' => $residence->stu_user_id,
                    'send_date' => now(),
                    'due_date' => now()->addDays(7),
                    'paid_date' => now(),
                    'type' => 'Refund',
                    'status' => 'Paid',
                    'total' => $total,
                    'payment_method' => 'Bank Transfer',
                    'note' => 'Refunded for user ' . $residence->stu_user_id . ' from ' . $residence->room->name .
                        ' on ' . $residence->start_date . ' with reason: ' . $request->description . ' - Refunded by ' . Auth::user()->id . ' - ' . Auth::user()->name,
                ]);
                if ($requestApi->hasFile('image')) {
                    (new ImageController)->saveToInvoice($requestApi, $newInvoice->id);
                }
            }
            } else if ($request->type == 'Check out') {
                $residence = $request->sender->residence()->latest()->first();
                $residence->update(['status' => 'Checked Out', 'check_out_date' => now(), 'note' => $residence->note . " - " . "Checked out on " . now()]);
            } else if ($request->type == 'Fixing') {
                if ($requestApi->IsCost == 'on') {
                    Invoice::create([
                        'sender_id' => Auth::user()->id,
                        'object_type' => 'App\Models\User',
                        'object_id' => $request->sender_id,
                        'send_date' => now(),
                        'due_date' => now()->addDays(7),
                        'type' => 'Fixing',
                        'total' => $requestApi->fixingCost,
                        'note' => 'Fixing cost for user ' . $request->sender_id . ' on room: ' . $request->sender->residence()->latest()->first()->room->name
                            . ' with reason: ' . $requestApi->description,
                    ]);
                }
            }

            // cập nhật request
            if ($requestApi->hasFile('image')) {
                (new ImageController)->saveToRequest($requestApi, $request->id);
            }
            $request->update(['status' => 'Resolved', 'resolve_date' => now(), 'note' => $request->note . ' - ' . $requestApi->description . ' - Resolved by ' . Auth::user()->id . ' - ' . Auth::user()->name]);
            return redirect()->route('requests.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $user = Auth::user();
//        if($user->role == 'student') {
//            return view('student_payment.payment', compact('request'));
//        } else {

        //khong xai duoc cho repair, renewal
//            preg_match('/\d+/', $request->note, $matches);
//            $stu_user_id = $matches[0] ?? null;
        // khong xai duoc cho ke toan xem hoan tien
        if($user->role == 'accountant') {
            preg_match('/\d+/', $request->note, $matches);
            $stu_user_id = $matches[0] ?? null;
            if($stu_user_id) {
                $residence = Residence::where('stu_user_id', $stu_user_id)->orderBy('created_at', 'desc')->first();
            }
        }
        else {
            $residence = Residence::where([
                ['stu_user_id', '=', $request->sender_id],
            ])->orderBy('created_at', 'desc')->first();
        }
            return view('admin.admin_building_manager_requests.detail', compact('request', 'residence'));
//        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $requestAPI, Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
    }

    public function checkHasOldRequestSameType(\Illuminate\Http\Request $request)
    {
        $oldRequest = \App\Models\Request::where('sender_id', Auth::id())->where('type', $request->type)->where('status', 'Pending')->first();
        if ($oldRequest) {
            return true;
        }
        else
            return false;
    }

    // Process student's request

    // repari request
    public function showRepairRequestForm()
    {
        $assets = Asset::all();
        $residence = Residence::where('stu_user_id', auth()->id())
            ->orderBy('start_date', 'desc')->first();
        return view('user_student.student.repair', compact('assets', 'residence'));
    }

    public function createRepairRequest(\Illuminate\Http\Request $request)
    {
        if($request->damaged_item == 'other' && !$request->other_item) {
            session()->flash('error', [
                'message' => 'Please specify the damaged item.',
            ]);
            return redirect()->back();
        }
        $residence = Residence::where('stu_user_id', auth()->id())
            ->orderBy('start_date', 'desc')->first();

        $note ="Room: ". $residence->room->name .
            " Assets require fixing: " . ($request->damaged_item === 'other' ?  $request->other_item  : $request->damaged_item) .
            " quantity: " . $request->quantity . ", Description: " . $request->description . " on time: " . $request->repair_time;

        $newRequest = \App\Models\Request::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $residence->room->building->managedBy->user->id ?? 1,
            'type' => 'Fixing',
            'note' => $note,
        ]);

        if($request->hasFile('image')) {
            (new ImageController)->saveToRequest($request, $newRequest->id);
        }

        session()->flash('notification', [
            'message' => 'You already created a new fixing request!',
        ]);

        return redirect()->route('dashboard')->with('status', 'Fixing request created successfully!');
    }

    // renewal request
    public function showRoomRenewalForm()
    {
        $residence = Residence::where('stu_user_id', auth()->id())
            ->orderBy('created_at', 'desc')->first();

        if (!$residence) {
            return view('user_student.student.room')->with('error', 'You have not checked in the room, cannot check out!');
        }

        return view('user_student.student.extension', compact('residence'));
    }

    public function createRenewalRequest(\Illuminate\Http\Request $request)
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
                'message' => "You don't have a current room to renew!",
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

    // check out request
    public function showCheckOutForm()
    {
        $user = auth()->user();

        // Lấy thông tin sinh viên từ cơ sở dữ liệu
        $student = Auth::user()->student;

        // Kiểm tra nếu không có thông tin sinh viên
        if (!$student) {
            return view('students.register-room.list', ['message' => 'You do not have a current room, register!']);
        }

        // Lấy thông tin phòng của sinh viên
        $residence = Residence::where('stu_user_id', $user->id)->latest()
            ->with('room.building')
            ->first();


        if (!$residence) {
            return redirect()->route('students.register-room.list')->with('error', 'You do not have a current room, register!');
        }

        // Trả về trang checkout với thông tin sinh viên và phòng
        return view('user_student.student.checkout', compact('student', 'residence'));
    }

    public function leaveRequest(\Illuminate\Http\Request $request, Residence $residence)
    {
        if($this->checkHasOldRequestSameType($request)) {
            session()->flash('error', [
                'message' => 'You already have a ' . strtolower($request->type) . ' request pending!',
            ]);
            return redirect()->back();
        }
        else if(!$residence || $residence->status == 'Checked out') {
            session()->flash('error', [
                'message' => "You don't have a current room to " . strtolower($request->type). ' !',
            ]);
            return redirect()->back();
        }
        else
        {
            $note = "Check out request for user " . Auth::id() . " from room " . $residence->room_id;
            $newRequest = \App\Models\Request::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $residence->room->building->managedBy->user->id ?? 1,
                'type' => 'Check out',
                'note' => $note,
            ]);

            session()->flash('notification', [
                'message' => 'You already created a new checkout request!',
            ]);

            return redirect()->route('dashboard');
        }
    }

    public function showChangeRequestForm()
    {
        $rooms = Room::with('hasRoomAssets.asset')
            ->where('status', 1)
            ->whereColumn('member_count' , '<', 'type')
            ->whereHas('building', function ($query) {
                $query->where('type', auth()->user()->student->gender);
            })
            ->paginate(9);

        return view('user_student.student.change_room', compact('rooms'));
    }

    public function createChangeRoomRequest(\Illuminate\Http\Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'reason' => 'required|string',
        ]);

        $newRoom = Room::find($validatedData['room_id']);

        // lay cu tru hien tai
        $residence = Residence::where('stu_user_id', auth()->id())
            ->orderBy('created_at', 'desc')->first();

        if($this->checkHasOldRequestSameType($request)) {
            session()->flash('error', [
                'message' => 'You already have a ' . strtolower($request->type) . ' request pending!',
            ]);
            return redirect()->back();
        }
        else if(!$residence || $residence->status == 'Checked out') {
            session()->flash('error', [
                'message' => "You don't have a current room to change !",
            ]);
            return redirect()->back();
        }
        else
        {
            $newRequest = \App\Models\Request::create(
                [
                    'sender_id' => Auth::id(),
                    'receiver_id' => $residence->room->building->managedBy->user->id ?? 1,
                    'type' => 'Change room',
                    'note' => 'Change room request for user ' . Auth::id() . ' from room ' . $residence->room->name .
                        ' to room ' . $newRoom->name . ' with reason: ' . $validatedData['reason'],
                ]
            );

            session()->flash('notification', [
                'message' => 'You already created a new room change request!',
            ]);

            return redirect()->route('dashboard');
        }
    }
}
