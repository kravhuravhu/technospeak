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
    </div>

    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>User Email</th>
                <th>Urgency</th>
                <th>Status</th>
                <th>Submitted</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($issues as $issue)
            <tr>
                <td>{{ $issue->title }}</td>
                <td>{{ $issue->client->email }}</td>
                <td>{{ ucfirst($issue->urgency) }}</td>
                <td>{{ ucfirst($issue->status) }}</td>
                <td>{{ $issue->created_at->diffForHumans() }}</td>
                <td>
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
        {{ $issues->links() }}
    </div>
</div>
@endsection
