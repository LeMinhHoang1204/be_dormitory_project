<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{

    public function index(){
        foreach (Student::all() as $student) {
            echo $student->name;
        }
    }

    public function store(Request $request): RedirectResponse
    {
        // Validate the request...

        $student = new Student();

        $student->name = $request->name;

        $student->save();

        return redirect('/flights');
    }
}
