<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

//use App\Models\Request;
//use Illuminate\Http\Request;
use App\Models\Violation;
use App\Models\Student;

use App\Models\User;
use App\Models\Residence;
use App\Http\Requests\StoreViolationRequest;
use App\Http\Requests\UpdateViolationRequest;
use Illuminate\Support\Facades\Auth;

class ViolationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function indexManager()
    {
        $violations = Violation::with(['creator', 'receiver.student.latestResidence.room'])
            ->whereHas('receiver', function ($query) {
                $query->where('role', 'student');
            })
            ->paginate(10);

        return view('violation.building_manager.list', compact('violations'));
    }

    public function myViolations()
    {
        $user = auth()->user();

        if ($user->role === 'student') {
            $violations = Violation::where('receiver_id', $user->id)->paginate(10);;
        } elseif ($user->role === 'building manager') {
            if ($user->employee) {
                $violations = Violation::where('creator_id', $user->id)
                    ->orWhereHas('receiver.student.latestResidence', function ($query) use ($user) {
                        $query->whereHas('room.building', function ($query) use ($user) {
                            // Kiểm tra nếu building mà sinh viên cư trú thuộc quản lý của manager
                            $query->where('manager_id', $user->employee->id);
                        });
                    })
                    ->paginate(10);
            } else {
                $violations = Violation::where('creator_id', $user->id)->paginate(10);
            }
        } elseif ($user->role === 'admin') {
            $violations = Violation::where('creator_id', $user->id)->paginate(10);
        } else {
            $violations = collect();
        }

        return view('violation.building_manager.myviolation', compact('violations'));
    }



    public function complaint($violationId)
    {
        $violation = Violation::findOrFail($violationId);
        return view('violation.student.complaint', compact('violation'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = User::where('role', 'student')->get();
        return view('violation.building_manager.create', compact('students'));    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreViolationRequest $request)
    {
        $student = Student::where('user_id', $request->receiver_id)->first();

        if (!$student) {
            return back()->withErrors(['receiver_id' => 'Student not found.']);
        }

        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'type' => 'required|in:Warning,Violation',
            'title' => 'required|string|max:100',
            'description' => 'nullable|string|max:200',
            'occurred_at' => 'required|date',
            'status' => 'required|in:Approved,Complained',
            'minus_point' => 'required|integer|min:1|max:5',
            'note' => 'nullable|string|max:200',
        ]);

        $violation = Violation::create([
            'creator_id' => auth()->id(),
            'receiver_id' => $student->user_id,
            'type' => $request->type,
            'title' => $request->title,
            'description' => $request->description,
            'occurred_at' => $request->occurred_at,
            'status' => $request->status,
            'minus_point' => $request->minus_point,
            'note' => $request->note,
        ]);

        $student->training_point = max(0, $student->training_point - $request->minus_point);
        $student->save();


        return redirect()->route('violations.show', $violation->id)
            ->with('success', 'Violation created and training point updated successfully.');
    }


    public function searchStudents(Request $request): \Illuminate\Http\JsonResponse
    {
        $searchTerm = trim($request->input('q', ''));

        \Log::info('Search Term: ' . $searchTerm);

        $students = Student::select('students.id', 'users.name', 'users.id as user_id')
        ->join('users', 'users.id', '=', 'students.user_id')
            ->where(function ($query) use ($searchTerm) {
                $query->where('users.id', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('users.name', 'LIKE', '%' . $searchTerm . '%');
            })
            ->get();

        return response()->json(
            $students->map(function ($student) {
                return [
                    'id' => $student->user_id,
                    'text' => $student->user_id . ' - ' . $student->name,
                ];
            })
        );
    }





    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $violation = Violation::findOrFail($id);
        $receiver = User::find($violation->receiver_id);
        $student = $receiver->student;
        $manager = User::find($violation->creator_id);

        $currentResidence = $receiver->latestResidence()->first();

        return view('violation.building_manager.show', compact('violation','receiver', 'student', 'currentResidence','manager'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Violation $violation)
    {
        $user = auth()->user();

        if ($violation->creator_id !== $user->id) {
            return redirect()->route('violations.my')
                ->with('error', 'Only creator can edit this violation.');
        }

        $students = User::where('role', 'student')->get();
        return view('violation.building_manager.edit', compact('violation', 'students'));    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateViolationRequest $request, Violation $violation)
    {
        $user = auth()->user();

        if ($violation->creator_id !== $user->id) {
            return redirect()->route('violations.my')
                ->with('error', 'Only creator can edit this violation...');
        }

        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'type' => 'required|in:Warning,Violation',
            'title' => 'required|string|max:100',
            'description' => 'nullable|string|max:200',
            'occurred_at' => 'required|date',
            'status' => 'required|in:Approved,Complained',
            'minus_point' => 'required|integer|min:1|max:5',
            'note' => 'nullable|string|max:200',
        ]);

        $violation->update([
            'receiver_id' => $request->receiver_id,
            'type' => $request->type,
            'title' => $request->title,
            'description' => $request->description,
            'occurred_at' => $request->occurred_at,
            'status' => $request->status,
            'minus_point' => $request->minus_point,
            'note' => $request->note,
        ]);

        return redirect()->route('violations.show', $violation->id)
            ->with('success', 'Violation updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $violation = Violation::find($id);

        if (!$violation) {
            return back()->with('error', 'Violation not found.');
        }

        $user = Auth::user();

        if ($user->role === 'admin' || $violation->creator_id === $user->id) {

            $student = Student::where('user_id', $violation->receiver_id)->first();


            if ($student) {
                // Cộng lại điểm training_point đã bị trừ
                $student->training_point += $violation->minus_point;
                $student->save();
            }

            $violation->delete();

            return back()->with('success', 'Violation deleted successfully. Points have been restored.');
        } else {
            return back()->with('error', 'Only admin or creator can delete this violation.');
        }
    }

}
