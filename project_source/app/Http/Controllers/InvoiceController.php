<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\Building;
use App\Models\Invoice;
use App\Models\Residence;
use App\Models\User;
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

        if ($user->role == 'student') {
            return view('student_payment.payment', ['invoices' => $invoices]);
        } elseif ($user->role == 'accountant' || $user->role == 'admin') {
            return view('accountant.invoices.payment', ['invoices' => $invoices]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Invoice::distinct()->pluck('type')->toArray();
        $buildings = Building::all();
        return view('accountant.invoices.create', compact('types', 'buildings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        echo($request);
        $validated = $request->validate([
            'type' => 'required|string',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
            'due_date' => 'required|date',
            'receiver_id' => 'required|integer',
            'note' => 'nullable|string',
        ]);

        $invoice = Invoice::create([
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'due_date' => $validated['due_date'],
            'receiver_id' => $validated['receiver_id'],
            'note' => $validated['note'],
            'sender_id' => Auth::id(),
        ]);
        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');

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
        if ($user->role == 'student') {
            return view('student_payment.detail_payment', ['invoice' => $invoice]);
        } elseif ($user->role == 'accountant' || $user->role == 'admin') {
            return view('accountant.invoices.detail_payment', ['invoice' => $invoice]);
        }
    }

    public function studentConfirmInvoice(Request $request, Invoice $invoice)
    {
        $invoice->update([
            'note' => $invoice->note . ' - Paid by ' . Auth::user()->id . ' - ' . Auth::user()->name . ' - ' . $request->description,
        ]);

        (new ImageController)->saveToInvoice($request, $invoice->id);

        return redirect()->route('showAllInvoices');
    }

    public function studentReportInvoice(Request $request, Invoice $invoice)
    {
        $invoice->update([
            'status' => 'Reported',
            'note' => $invoice->note . ' - ' . $request->description,
        ]);

        (new ImageController)->saveToInvoice($request, $invoice->id);

        return redirect()->route('showAllInvoices');
    }

    public function accountantConfirmInvoice(Request $request, Invoice $invoice)
    {
        $invoice->update([
            'status' => 'Paid',
            'paid_date' => now(),
            'note' => $invoice->note . ' - ' . $request->description . ' - Confirmed by ' . Auth::user()->name,
        ]);

        if ($request->IsDirectPayment == 'direct') {
            $invoice->update([
                'payment_method' => 'Cash',
            ]);
        } else {
            $invoice->update([
                'payment_method' => 'Bank transfer',
            ]);
        }

        if ($request->hasFile('image')) {
            (new ImageController)->saveToInvoice($request, $invoice->id);
        }

//        preg_match('/\bRenewal\b/', $invoice->note, $matchestring);
        preg_match('/\bRenewal\b|\bChange\b/', $invoice->note, $matchestring);

        if ($invoice->object_type == 'App\Models\User' && $invoice->type == 'Room Registration') {
            $user = User::find($invoice->object_id);
            $latestResidence = $user->residence()->latest()->first();
            if ($latestResidence->status == 'Registered') {
                $latestResidence->update([
                    'status' => 'Paid',
                ]);
            }
            else if (($latestResidence->status == 'Checked in' && ($matchestring[0] == 'Renewal' || $matchestring[0] == 'Change'))
                || ($latestResidence->status == 'Renewed' && $matchestring[0] == 'Renewal')
                || ($latestResidence->status == 'Paid' && $matchestring[0] == 'Change')) {
                    $oldRequest = null;
                    if ($matchestring[0] == 'Change') {
                        $oldRequest = $user->sendRequest()->where('status', 'Accepted')->where('type', 'Change Room')->latest()->first();
                    } else if ($matchestring[0] == 'Renewal') {
                        $oldRequest = $user->sendRequest()->where('status', 'Accepted')->where('type', 'Renewal')->latest()->first();
                    }
                    if($oldRequest) {
                        $oldRequest->update([
                            'status' => 'Resolved',
                            'note' => $oldRequest->note . ' - Confirmed student paid by ' . Auth::user()->id . ' - ' . Auth::user()->name,
                        ]);
                        $note = $oldRequest->note;
                        preg_match('/\d+/', $note, $matches);
                        $firstNumber = $matches[0] ?? null;

                        if ($firstNumber !== null &&  $matchestring[0] == 'Renewal') {
                            $new_end_date = $latestResidence->end_date->addMonths((int) $firstNumber);
                            $new_months_duration = (int) $latestResidence->months_duration + (int) $firstNumber;

                            $latestResidence->update([
                                'end_date' => $new_end_date,
                                'status' => 'Renewed',
                                'months_duration' => $new_months_duration,
                                'note' => $latestResidence->note . ' - ' . 'Renewed ' . $firstNumber . ' months',
                            ]);
                        }
                    }
            }
        }

        return redirect()->route('showAllInvoices');
    }
}
