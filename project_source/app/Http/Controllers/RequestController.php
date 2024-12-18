<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Request;
use App\Http\Requests\StoreRequestRequest;
use App\Http\Requests\UpdateRequestRequest;
use App\Models\Residence;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requests = Request::paginate(10);
        return view('admin.admin_building_manager_requests.list', compact('requests'));
    }

    public function getCheckInReq()
    {
        $user = Auth::user();
//        echo($user->employee->manageBuilding->id); exit;

        $residences = Residence::where('status', 'Paid')
        ->whereHas('room.building', function ($query) {
            $query->where('id', auth()->user()->employee->manageBuilding->id);
        })
        ->paginate(10);

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

    public function getTransferCheckInReq($id)
    {
        $residence = Residence::find($id);
        return view('admin.admin_building_manager_check_in_request.transfer', compact('residence'));
    }

    public function acceptTransferCheckInReq(\Illuminate\Http\Request $request, $id)
    {
//        echo($request->image); exit;
        (new ImageController)->saveToResidence($request, $id);
        // cũ
        $residence = Residence::find($id);
        $residence->update(['status' => 'Transfered']);

        $invoice = Invoice::where([
            ['object_id', '=', $request->tranfferingID],
            ['type', '=', 'Room'],
            ['object_type', '=', 'App\Models\User'],
            ['send_date', '=', $residence->start_date],
        ])->first();
        $invoice->update(['status' => 'Transferred Room']);

        // mới
        $new_start_date = now();
        \App\Models\Residence::create([
            'stu_user_id' => $request->tranferredID,
            'room_id' => $residence->room_id,
            'start_date' => $new_start_date,
            'duration' => $residence->duration,
            'end_date' => $residence->end_date,
            'status' => 'Paid',
            'note' => 'Transfered from ' . $residence->stu_user_id . ' on ' . now(),
        ]);

        \App\Models\Invoice::create([
            'sender_id' => $invoice->sender_id,
            'object_type' => $invoice->object_type,
            'object_id' => $request->tranferredID,
            'send_date' => $new_start_date,
            'due_date' => $new_start_date->addDays(7),
            'paid_date' => $invoice->paid_date,
            'type' => $invoice->type,
            'status' => 'Paid',
            'total' => $invoice->total,
            'payment_method' => $invoice->payment_method,
            'evidence_image' => $invoice->evidence_image,
        ]);

        return redirect()->route('requests.getCheckInReq');
    }

    public function rejectCheckIn(\Illuminate\Http\Request $request, $id)
    {
        $residence = Residence::find($id);
        $residence->update(['status' => 'Rejected']);

        $invoice = Invoice::where([
            ['object_id', '=', $residence->stu_user_id],
            ['object_type', '=', 'App\Models\User'],
            ['type', '=', 'Room'],
            ['send_date', '=', $residence->start_date],
        ])->first();

        if($invoice->status == 'Paid') {
            $invoice->update(['note' => 'Rejected for user '. $residence->stu_user_id . ' from ' . $residence->room->name .
                ' on ' . $residence->start_date . ' with reason: ' . $request->description]);
        }

        if($request->IsRefund == 'on') {
            $residence->update(['note' => 'Refund for user '. $residence->stu_user_id . ' from ' . $residence->room->name .
                ' on ' . $residence->start_date . ' with reason: ' . $request->description]);

            if($invoice->status == 'Paid') {
                $invoice->update(['status' => 'Refunding', 'note' => 'Refund for user '. $residence->stu_user_id . ' from ' . $residence->room->name .
                    ' on ' . $residence->start_date . ' with reason: ' . $request->description]);
            }

            $accountant = \App\Models\User::where('role', 'Accountant')->first();
            $newRequest = Request::create([
                'sender_id' => Auth::user()->id,
                'receiver_id' => $accountant->id,
                'type' => 'Refund',
                'status' => 'Pending',
                'note' => 'Refund for user '. $residence->stu_user_id . ' from ' . $residence->room->name .
                    ' on ' . $residence->start_date . ' with reason: ' . $request->description,
            ]);
            (new ImageController)->saveToRequest($request, $newRequest->id);
        }

        return redirect()->route('requests.getCheckInReq');
    }

    public function accept(Request $request)
    {
        $request->update(['status' => 'Accepted']);
        return redirect()->back();
    }

    public function reject(Request $request)
    {
        $request->update(['status' => 'Rejected']);
        return redirect()->back();
    }

    public function resolve(\Illuminate\Http\Request $requestApi ,Request $request)
    {
        if($request->type == 'Refund') {

            // cập nhật cư trú cũ
            $note = $request->note;
            preg_match('/\d+/', $note, $matches);
            $firstNumber = $matches[0] ?? null;

            if ($firstNumber !== null) {
                $residence = Residence::where([
                    ['stu_user_id', '=', $firstNumber],
                    ['status', '=', 'Rejected'],
                ])->first();
                $residence->update(['status' => 'Refunded']);

                // câp nhật hoá đơn cũ
                $invoice = Invoice::where([
                    ['object_id', '=', $residence->stu_user_id],
                    ['type', '=', 'Room'],
                    ['object_type', '=', 'App\Models\User'],
                    ['send_date', '=', $residence->start_date],
                ])->first();

                if($invoice->status == 'Refunding') {
                    $invoice->update(['status' => 'Refunded']);
                }

                // tạo hoá đơn hoàn tiền mới
                $newInvoice = Invoice::create([
                    'sender_id' => Auth::user()->id,
                    'object_type' => 'App\Models\User',
                    'object_id' => 1,
                    'send_date' => now(),
                    'due_date' => now()->addDays(7),
                    'paid_date' => now(),
                    'type' => 'Room',
                    'status' => 'Paid',
                    'total' => $invoice->total,
                    'payment_method' => 'Bank Transfer',
                    'note' => 'Refunded for user '. $residence->stu_user_id . ' from ' . $residence->room->name .
                        ' on ' . $residence->start_date . ' with reason: ' . $request->description,
                ]);

                (new ImageController)->saveToInvoice($requestApi, $newInvoice->id);
            }
        }

        // cập nhật request
        $request->update(['status' => 'Resolved' , 'resolve_date' => now()]);
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
//        echo($request); exit;
        return view('admin.admin_building_manager_requests.detail', compact('request'));
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
}
