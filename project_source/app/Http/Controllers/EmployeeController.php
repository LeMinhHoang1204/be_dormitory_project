<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        // Validate the request...

        $employee = new Employee();

        $employee->name = $request->name;

        $employee->save();

        return redirect('/flights');
    }
}
