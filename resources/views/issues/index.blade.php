@extends('layouts.admin')

@section('title', 'User Issues')

@section('content')
<div class="admin-header">
    <div class="page-title">
        <h1>Issue Management</h1>
        <p>View and manage all user-reported tech issues.</p>
    </div>
</div>

<div class="data-table">
    <div class="data-table-header">
        <h3>All Issues</h3>
        <div class="filters">
            <form method="GET" action="">
                <select name="status" onchange="this.form.submit()">
                    <option value="">All Statuses</option>
                    <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </form>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>User</th>
                <th>Urgency</th>
                <th>Status</th>
                <th>Assigned To</th>
                <th>Submitted</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($issues as $issue)
            <tr class="status-{{ $issue->status }}">
                <td>#{{ $issue->id }}</td>
                <td>{{ Str::limit($issue->title, 30) }}</td>
                <td>{{ $issue->client->email }}</td>
                <td>
                    <span class="badge urgency-{{ $issue->urgency }}">
                        {{ ucfirst($issue->urgency) }}
                    </span>
                </td>
                <td>
                    <span class="badge status-{{ $issue->status }}">
                        {{ ucfirst(str_replace('_', ' ', $issue->status)) }}
                    </span>
                </td>
                <td>
                    {{ $issue->assignedTo ? $issue->assignedTo->name : 'Unassigned' }}
                </td>
                <td>{{ $issue->created_at->diffForHumans() }}</td>
                <td class="actions">
                    <a href="{{ route('content-manager.issues.show', $issue) }}" class="btn btn-sm btn-outline">View</a>
                    <a href="{{ route('content-manager.issues.edit', $issue) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form action="{{ route('content-manager.issues.destroy', $issue) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this issue?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="data-table-footer">
        {{ $issues->appends(request()->query())->links() }}
    </div>
</div>
@endsection