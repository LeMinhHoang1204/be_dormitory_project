<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReportAccountant;

class ReportAccountantController extends Controller
{
    public function index()
    {
        $query = ReportAccountant::with(['student']);
        $reportData = $query;
        return view('Report.report_accountant', compact('reportData'));
    }
}
