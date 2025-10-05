@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-lg-10">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">Create Report</h3>
                <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary">Back to Reports</a>
            </div>

            

            <form method="POST" action="{{ route('reports.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="report_type_id" class="form-label">Report Type</label>
                    <select name="report_type_id" id="report_type_id" class="form-control">
                        <option value="">-- Select report type --</option>
                        @foreach($reportTypes as $rt)
                            <option value="{{ $rt->id }}" {{ old('report_type_id') == $rt->id ? 'selected' : '' }}>{{ $rt->name }}</option>
                        @endforeach
                    </select>
                    @error('report_type_id')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Details / Content</label>
                    <textarea name="content" id="content" rows="6" class="form-control" placeholder="Enter the report details here...">{{ old('content') }}</textarea>
                    @error('content')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="file" class="form-label">Attachment (optional)</label>
                    <input type="file" name="file" id="file" class="form-control">
                    <div class="form-text">Allowed: pdf, xlsx, xls, jpeg, png (max 10MB)</div>
                    @error('file')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-outline-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">Create Report</button>
                </div>
            </form>
        </div>
    </div>
 </div>
@endsection


