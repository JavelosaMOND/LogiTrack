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
        // Admins should create report types, not reports
        if (auth()->user()?->hasRole('Admin')) {
            return redirect()->route('report-types.create')
                ->with('info', 'Admins manage report types. Create a report type here.');
        }
        $reportTypes = \App\Models\ReportType::where('active', true)
            ->orderByRaw('COALESCE(sort_order, 9999)')
            ->orderBy('name')
            ->get();

        return view('reports.create', compact('reportTypes'));
    }

    public function store(Request $request)
    {
        // Admins should not submit reports; redirect to report types
        if (auth()->user()?->hasRole('Admin')) {
            return redirect()->route('report-types.create')
                ->with('info', 'Admins manage report types. Create a report type here.');
        }

        $allowedTypes = [
            'Daily Accomplishment',
            'Weekly Operations',
            'Monthly Financial',
            'Incident / Issue',
            'Project Progress',
            'Attendance / Time Log',
        ];
        $request->validate([
            'type' => 'required|string|in:' . implode(',', $allowedTypes),
            'file' => 'nullable|file|mimes:pdf,xlsx,xls,jpeg,png|max:10240',
        ]);

        $path = $request->hasFile('file')
            ? $request->file('file')->store('reports', 'public')
            : null;

        $status = $request->input('action') === 'draft' ? 'draft' : 'pending';

        // Map optional report_type_id by name if exists
        $reportType = \App\Models\ReportType::where('name', $request->type)->first();

        $structured = $this->extractStructuredContent($request);

        Report::create([
            'user_id' => auth()->id(),
            'report_type_id' => $reportType?->id,
            'type' => $request->type,
            'content' => json_encode($structured),
            'file_path' => $path,
            'status' => $status,
        ]);

        return redirect()->route('reports.index')->with('success', $status === 'draft' ? 'Report saved as draft.' : 'Report submitted successfully.');
    }

    private function extractStructuredContent(Request $request): array
    {
        $type = $request->input('type');
        switch ($type) {
            case 'Daily Accomplishment':
                return $request->input('daily', []);
            case 'Weekly Operations':
                return $request->input('weekly', []);
            case 'Monthly Financial':
                return $request->input('monthly', []);
            case 'Incident / Issue':
                return $request->input('incident', []);
            case 'Project Progress':
                return $request->input('project', []);
            case 'Attendance / Time Log':
                $att = $request->input('attendance', []);
                $total = 0.0;
                $pairs = [
                    ['in' => $att['time_in_1'] ?? null, 'out' => $att['time_out_1'] ?? null],
                    ['in' => $att['time_in_2'] ?? null, 'out' => $att['time_out_2'] ?? null],
                ];
                foreach ($pairs as $p) {
                    if ($p['in'] && $p['out']) {
                        $start = strtotime($att['date'] . ' ' . $p['in']);
                        $end = strtotime($att['date'] . ' ' . $p['out']);
                        if ($end > $start) {
                            $total += ($end - $start) / 3600;
                        }
                    }
                }
                $att['total_hours'] = round($total, 2);
                return $att;
            default:
                return [];
        }
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

    public function submit(Report $report)
    {
        if ($report->user_id !== auth()->id()) {
            abort(403);
        }
        if ($report->status !== 'draft') {
            return back()->with('error', 'Only draft reports can be submitted.');
        }
        $report->update(['status' => 'pending']);
        return back()->with('success', 'Report submitted.');
    }

    public function undoSubmit(Report $report)
    {
        if ($report->user_id !== auth()->id()) {
            abort(403);
        }
        if ($report->status !== 'pending') {
            return back()->with('error', 'Only pending reports can be undone.');
        }
        $report->update(['status' => 'draft']);
        return back()->with('success', 'Submission undone. Report is back to draft.');
    }
}
