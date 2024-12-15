<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\Invoice;
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
        return view('student_payment.payment', ['invoices' => $invoices]);
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

    public function showDetail($id)
    {
        $invoice = Invoice::findOrFail($id);
        return view('student_payment/detail_payment', compact('invoice'));
    }
}
