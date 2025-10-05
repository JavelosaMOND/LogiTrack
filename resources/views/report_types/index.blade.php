@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-lg-10">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">Report Types</h3>
                <a href="{{ route('report-types.create') }}" class="btn btn-primary">New Type</a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Purpose</th>
                            <th>Frequency</th>
                            <th>Active</th>
                            
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($types as $t)
                            <tr>
                                <td>{{ $t->name }}</td>
                                <td>{{ $t->purpose }}</td>
                                <td>{{ $t->frequency }}</td>
                                <td>
                                    <span class="badge {{ $t->active ? 'bg-success' : 'bg-secondary' }}">{{ $t->active ? 'Yes' : 'No' }}</span>
                                </td>
                                
                                <td class="text-end">
                                    <a href="{{ route('report-types.edit', $t) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form action="{{ route('report-types.destroy', $t) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this type?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No report types yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div>
                {{ $types->links() }}
            </div>
        </div>
    </div>
</div>
@endsection


