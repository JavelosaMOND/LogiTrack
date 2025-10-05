<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with(['user','reportType'])->latest()->paginate(10);
        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        $reportTypes = \App\Models\ReportType::where('active', true)
            ->orderByRaw('COALESCE(sort_order, 9999)')
            ->orderBy('name')
            ->get();

        return view('reports.create', compact('reportTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'report_type_id' => 'required|exists:report_types,id',
            'content' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,xlsx,xls,jpeg,png|max:10240',
        ]);

        $path = $request->hasFile('file')
            ? $request->file('file')->store('reports', 'public')
            : null;

        $reportType = \App\Models\ReportType::find($request->report_type_id);

        Report::create([
            'user_id' => auth()->id(),
            'report_type_id' => $request->report_type_id,
            'type' => $reportType?->name ?? '',
            'content' => $request->content,
            'file_path' => $path,
        ]);

        return redirect()->route('reports.index')->with('success', 'Report submitted successfully.');
    }

    public function show(Report $report)
    {
        return view('reports.show', compact('report'));
    }

    public function edit(Report $report)
    {
        return view('reports.edit', compact('report'));
    }

    public function update(Request $request, Report $report)
    {
        $request->validate([
            'report_type_id' => 'required|exists:report_types,id',
            'content' => 'required|string',
        ]);

        $path = $report->file_path;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('reports', 'public');
        }

        $reportType = \App\Models\ReportType::find($request->report_type_id);

        $report->update([
            'report_type_id' => $request->report_type_id,
            'type' => $reportType?->name ?? $report->type,
            'content' => $request->content,
            'file_path' => $path,
        ]);

        return redirect()->route('reports.index')->with('success', 'Report updated successfully.');
    }

    public function destroy(Report $report)
    {
        $report->delete();
        return redirect()->route('reports.index')->with('success', 'Report deleted successfully.');
    }

    // Custom actions
    public function approve(Report $report)
    {
        $report->update(['status' => 'approved']);
        return back()->with('success', 'Report approved.');
    }

    public function reject(Report $report)
    {
        $report->update(['status' => 'rejected']);
        return back()->with('error', 'Report rejected.');
    }
}
