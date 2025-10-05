@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-lg-10">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">Report Details</h3>
                <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary">Back</a>
            </div>

            <dl class="row">
                <dt class="col-sm-3">Type</dt>
                <dd class="col-sm-9">{{ $report->reportType->name ?? $report->type }}</dd>

                <dt class="col-sm-3">Status</dt>
                <dd class="col-sm-9"><span class="badge bg-secondary text-uppercase">{{ $report->status }}</span></dd>

                <dt class="col-sm-3">Submitted By</dt>
                <dd class="col-sm-9">{{ $report->user->name ?? 'N/A' }}</dd>

                <dt class="col-sm-3">Created</dt>
                <dd class="col-sm-9">{{ $report->created_at->format('Y-m-d H:i') }}</dd>
            </dl>

            <div class="mb-4">
                <h5>Content</h5>
                <div class="border rounded p-3 bg-light">{!! nl2br(e($report->content)) !!}</div>
            </div>

            @if($report->file_path)
                <div class="mb-4">
                    <h5>Attachment</h5>
                    <a href="{{ Storage::disk('public')->url($report->file_path) }}" target="_blank">Download</a>
                </div>
            @endif

            @if($report->user_id === auth()->id())
                <div class="d-flex gap-2">
                    @if($report->status === 'draft')
                        <form action="{{ route('reports.submit', $report) }}" method="POST">
                            @csrf
                            <button class="btn btn-success">Submit</button>
                        </form>
                        <a href="{{ route('reports.edit', $report) }}" class="btn btn-outline-secondary">Edit</a>
                    @elseif($report->status === 'pending')
                        <form action="{{ route('reports.undo', $report) }}" method="POST">
                            @csrf
                            <button class="btn btn-warning">Undo Submit</button>
                        </form>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection



