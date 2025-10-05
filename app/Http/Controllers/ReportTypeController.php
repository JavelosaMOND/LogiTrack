<?php

namespace App\Http\Controllers;

use App\Models\ReportType;
use Illuminate\Http\Request;

class ReportTypeController extends Controller
{
    public function index()
    {
        $types = ReportType::orderByRaw('COALESCE(sort_order, 9999)')->orderBy('name')->paginate(15);
        return view('report_types.index', compact('types'));
    }

    public function create()
    {
        return view('report_types.create');
    }

    public function store(Request $request)
    {
        $allowedNames = [
            'Daily Accomplishment',
            'Weekly Operations',
            'Monthly Financial',
            'Incident / Issue',
            'Project Progress',
            'Attendance / Time Log',
        ];
        $data = $request->validate([
            'name' => 'required|string|in:' . implode(',', $allowedNames),
            'active' => 'boolean',
        ]);
        $data['active'] = $request->boolean('active', true);
        // Set fixed purpose text based on type
        $purposeByName = [
            'Daily Accomplishment' => 'Track daily tasks & outputs',
            'Weekly Operations' => 'Summarize weekly activities',
            'Monthly Financial' => 'Track expenses & budget',
            'Incident / Issue' => 'Record problems or accidents',
            'Project Progress' => 'Monitor ongoing projects',
            'Attendance / Time Log' => 'Verify employee attendance',
        ];
        $payload = [
            'name' => $data['name'],
            'purpose' => $purposeByName[$data['name']] ?? null,
            'frequency' => null,
            'active' => $data['active'],
        ];
        ReportType::updateOrCreate(['name' => $data['name']], $payload);
        return redirect()->route('report-types.index')->with('success', 'Report type created.');
    }

    public function edit(ReportType $reportType)
    {
        return view('report_types.edit', compact('reportType'));
    }

    public function update(Request $request, ReportType $reportType)
    {
        $allowedNames = [
            'Daily Accomplishment',
            'Weekly Operations',
            'Monthly Financial',
            'Incident / Issue',
            'Project Progress',
            'Attendance / Time Log',
        ];
        $data = $request->validate([
            'name' => 'required|string|in:' . implode(',', $allowedNames),
            'active' => 'boolean',
        ]);
        $data['active'] = $request->boolean('active', true);
        $purposeByName = [
            'Daily Accomplishment' => 'Track daily tasks & outputs',
            'Weekly Operations' => 'Summarize weekly activities',
            'Monthly Financial' => 'Track expenses & budget',
            'Incident / Issue' => 'Record problems or accidents',
            'Project Progress' => 'Monitor ongoing projects',
            'Attendance / Time Log' => 'Verify employee attendance',
        ];
        $payload = [
            'name' => $data['name'],
            'purpose' => $purposeByName[$data['name']] ?? null,
            'frequency' => null,
            'active' => $data['active'],
        ];
        $reportType->update($payload);
        return redirect()->route('report-types.index')->with('success', 'Report type updated.');
    }

    public function destroy(ReportType $reportType)
    {
        $reportType->delete();
        return redirect()->route('report-types.index')->with('success', 'Report type deleted.');
    }
}


