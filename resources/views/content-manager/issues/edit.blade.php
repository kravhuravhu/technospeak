@extends('layouts.admin')

@section('title', 'Edit Issue')

@section('content')
<div class="admin-header">
    <div class="page-title">
        <h1>Edit Issue</h1>
        <p>Assign the issue or update its status.</p>
    </div>
</div>

<form action="{{ route('content-manager.issues.update', $issue) }}" method="POST" class="issue-form">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="open" {{ $issue->status == 'open' ? 'selected' : '' }}>Open</option>
            <option value="in_progress" {{ $issue->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
            <option value="resolved" {{ $issue->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
        </select>
    </div>

    <div class="form-group">
        <label>Assign to Instructor</label>
        <select name="assigned_to" class="form-control">
            @foreach($instructors as $instructor)
                <option value="{{ $instructor->id }}" {{ $issue->assigned_to == $instructor->id ? 'selected' : '' }}>
                    {{ $instructor->name }} ({{ $instructor->email }})
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-success">Update Issue</button>
</form>
@endsection
