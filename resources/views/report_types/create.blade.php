@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-lg-8">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">New Report Type</h3>
                <a href="{{ route('report-types.index') }}" class="btn btn-outline-secondary">Back</a>
            </div>

            <form method="POST" action="{{ route('report-types.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Report Type</label>
                    <select name="name" class="form-control">
                        <option value="">-- Select report type --</option>
                        @php($types = [
                            'Daily Accomplishment',
                            'Weekly Operations',
                            'Monthly Financial',
                            'Incident / Issue',
                            'Project Progress',
                            'Attendance / Time Log',
                        ])
                        @foreach($types as $t)
                            <option value="{{ $t }}" {{ old('name') === $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                    @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                
                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" role="switch" id="active" name="active" {{ old('active', true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="active">Active</label>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-outline-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


