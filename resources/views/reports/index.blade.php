@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-lg-10">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">Reports</h3>
                <a href="{{ route('reports.create') }}" class="btn btn-primary">Create Report</a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Submitted By</th>
                            <th>Status</th>
                            <th>Submitted At</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $report)
                            <tr>
                                <td>{{ $report->reportType->name ?? $report->type }}</td>
                                <td>{{ $report->user->name ?? 'N/A' }}</td>
                                <td><span class="badge bg-secondary text-uppercase">{{ $report->status }}</span></td>
                                <td>{{ $report->created_at->format('Y-m-d H:i') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('reports.show', $report) }}" class="btn btn-sm btn-outline-primary">View</a>
                                    @if($report->user_id === auth()->id())
                                        @if($report->status === 'draft')
                                            <form action="{{ route('reports.submit', $report) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button class="btn btn-sm btn-success">Submit</button>
                                            </form>
                                            <a href="{{ route('reports.edit', $report) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                        @elseif($report->status === 'pending')
                                            <form action="{{ route('reports.undo', $report) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button class="btn btn-sm btn-warning">Undo Submit</button>
                                            </form>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No reports yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div>
                {{ $reports->links() }}
            </div>
        </div>
    </div>
</div>
@endsection


