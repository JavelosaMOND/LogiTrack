<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class DashboardController extends Controller
{
    public function index()
    {
        // Example: Show summary of reports
        $reports = Report::latest()->take(5)->get();
        $stats = [
            'total_reports' => Report::count(),
            'pending' => Report::where('status', 'pending')->count(),
            'approved' => Report::where('status', 'approved')->count(),
            'rejected' => Report::where('status', 'rejected')->count(),
        ];

        return view('dashboard.index', compact('reports', 'stats'));
    }
}

