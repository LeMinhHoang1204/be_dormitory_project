<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\Invoice;
use App\Models\Residence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $invoices = Invoice::query();

        if ($user->role == 'student') {
            $invoices->where(function ($q) use ($user) {
                $q->where('sender_id', $user->id) // Lọc nếu người dùng là người gửi
                ->orWhereHas('object', function ($q) use ($user) {
                    $q->where(function ($q) use ($user) {
                        $q->where('object_type', 'App\Models\User')
                            ->where('object_id', $user->id); // So sánh object_id với user_id

                    })->orWhere(function ($q) use ($user) {
                        $residence = $user->residence()->where('status', 'Checked in')->first();
                        if ($residence && $residence->room) {
                            $q->where('object_type', 'App\Models\Room')
                                ->where('object_id', $residence->room->id); // So sánh object_id với residence->room->name
                        }
                    })->orWhere(function ($q) use ($user) {
                        $residence = $user->residence()->where('status', 'Checked in')->first();
                        if ($residence && $residence->room && $residence->room->building) {
                            $q->where('object_type', 'App\Models\Building')
                                ->where('object_id', $residence->room->building->id); // So sánh object_id với residence->room->building->build_name
                        }
                    });
                });
            });
        }

        $invoices = $invoices->orderBy('id', 'desc')->paginate(8);
        if($user->role == 'student') {
            return view('student_payment.payment', ['invoices' => $invoices]);
        } elseif($user->role == 'accountant' || $user->role == 'admin') {
            return view('accountant.invoices.payment', ['invoices' => $invoices]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }

    public function showDetail(Invoice $invoice)
    {
        $user = Auth::user();
        if($user->role == 'student') {
            return view('student_payment.detail_payment', ['invoice' => $invoice]);
        } elseif($user->role == 'accountant' || $user->role == 'admin') {
            return view('accountant.invoices.detail_payment', ['invoice' => $invoice]);
        }
    }


    public function studentConfirmInvoice(Request $request, $id)
    {
        Invoice::where('id', $id)->update([
            'note' => $request->description,
        ]);

        (new ImageController)->saveToInvoice($request, $id);

        return redirect()->route('showAllInvoices');
    }

    public function accountantConfirmInvoice(Request $request, Invoice $invoice)
    {

        $invoice->update([
            'status' => 'Paid',
            'paid_date' => now(),
            'note' => $request->description,
        ]);

        if($request->IsDirectPayment == 'direct') {
            $invoice->update([
                'payment_method' => 'Cash',
            ]);
        }
        else{
            $invoice->update([
                'payment_method' => 'Bank transfer',
            ]);
        }

        // default: khong co anh khong update
        (new ImageController)->saveToInvoice($request, $invoice->id);

        if($invoice->object_type == 'App\Models\User' && $invoice->type == 'Room') {

            $residence = Residence::where('stu_user_id', $invoice->object_id)->where('status', 'Registered')->orderBy('start_date', 'desc')->first();
            $residence->update([
                'status' => 'Paid',
            ]);
        }


        session()->flash('notification', [
            'message' => 'Payment success!',
        ]);

        return redirect()->route('showAllInvoices');
    }
}
