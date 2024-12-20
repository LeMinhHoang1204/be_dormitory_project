<?php

namespace App\Http\Controllers;
use App\Models\ComplaintViolation;
use App\Models\Student;
use App\Models\Violation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintViolationController extends Controller
{
    public function index()
    {
        $complaints = ComplaintViolation::with(['violation', 'student', 'creator'])->get();
        return view('violation.complaints_list.all', compact('complaints'));
    }
    public function store(Request $request)
    {


        $validated = $request->validate([
            'complaint_description' => 'required|string',
            'violation_id' => 'required|exists:violations,id',
        ]);
        $violation = Violation::findOrFail($validated['violation_id']);

        $complaint = ComplaintViolation::create([
            'complaint_description' => $validated['complaint_description'],
            'violation_id' => $validated['violation_id'],
            'student_id' => auth()->id(),
            'creator_id' => $violation->creator_id,
        ]);

        return redirect()->route('complaints.show', ['id' => $complaint->id])
            ->with('success', 'Complaint submitted successfully!');
    }

    public function show($id)
    {
        $complaint = ComplaintViolation::with(['violation', 'student', 'creator'])->findOrFail($id);

        return view('violation.complaints_list.show_complaint', compact('complaint'));
    }
    public function myComplaints()
    {
        $user = Auth::user();

        if ($user->role === 'admin' || $user->role === 'building manager') {
            $complaints = ComplaintViolation::where('creator_id', $user->id)
                ->with(['violation', 'student', 'creator'])
                ->get();
        } else if($user->role === 'student') {
            $complaints = ComplaintViolation::where('student_id', $user->id)
                ->with(['violation', 'student', 'creator'])
                ->get();
        }

        return view('violation.complaints_list.myComplaints', compact('complaints'));
    }
    public function destroy($id)
    {
        $user = Auth::user();
        $complaint = ComplaintViolation::findOrFail($id);

        if ($complaint->student_id !== $user->id) {
            return redirect()->back()->with('error', 'You are not authorized to delete this complaint.');
        }

        $complaint->delete();

        return redirect()->route('complaints.myComplaints')->with('success', 'Complaint deleted successfully.');
    }
    public function accept($id)
    {
        $complaint = ComplaintViolation::findOrFail($id);

        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'building manager') {
            return redirect()->back()->with('error', 'You are not authorized to accept this complaint.');
        }

        if ($complaint->status === 'Accept') {
            return redirect()->back()->with('error', 'This complaint has already been accepted.');
        }
        $violation = $complaint->violation;

        $student = Student::where('user_id', $violation->receiver_id)->first();


        if ($student) {
            // Cộng lại điểm training_point đã bị trừ
            $student->training_point += $violation->minus_point;
            $student->save();
        }

        $complaint->status = 'Accept';
        $complaint->save();

        return redirect()->back()->with('success', 'Complaint has been accepted. Points have been restored.');
    }
    public function decline($id)
    {
        $complaint = ComplaintViolation::findOrFail($id);

        // Kiểm tra quyền truy cập
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'building manager') {
            return redirect()->back()->with('error', 'You are not authorized to decline this complaint.');
        }

        // Cập nhật trạng thái của complaint
        $complaint->status = 'Decline';
        $complaint->save();

        return redirect()->back()->with('success', 'Complaint has been declined.');
    }
}
