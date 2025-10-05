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
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'purpose' => 'nullable|string|max:255',
            'frequency' => 'nullable|string|max:255',
            'active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $data['active'] = $request->boolean('active', true);
        ReportType::create($data);
        return redirect()->route('report-types.index')->with('success', 'Report type created.');
    }

    public function edit(ReportType $reportType)
    {
        return view('report_types.edit', compact('reportType'));
    }

    public function update(Request $request, ReportType $reportType)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'purpose' => 'nullable|string|max:255',
            'frequency' => 'nullable|string|max:255',
            'active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $data['active'] = $request->boolean('active', true);
        $reportType->update($data);
        return redirect()->route('report-types.index')->with('success', 'Report type updated.');
    }

    public function destroy(ReportType $reportType)
    {
        $reportType->delete();
        return redirect()->route('report-types.index')->with('success', 'Report type deleted.');
    }
}


