@extends('layouts.admin')

@section('title', 'Issue Details')

@section('content')
<div class="admin-header">
    <div class="page-title">
        <h1>Issue Details</h1>
        <p>Detailed view of the selected issue.</p>
    </div>
</div>

<div class="issue-detail-container">
    <div class="issue-main">
        <div class="issue-header">
            <h2>#{{ $issue->id }} - {{ $issue->title }}</h2>
            <div class="issue-meta">
                <span class="badge status-{{ $issue->status }}">{{ ucfirst(str_replace('_', ' ', $issue->status)) }}</span>
                <span class="badge urgency-{{ $issue->urgency }}">{{ ucfirst($issue->urgency) }}</span>
            </div>
        </div>

        <div class="issue-details">
            <div class="detail-group">
                <h4>User Information</h4>
                <p><strong>Email:</strong> {{ $issue->client->email }}</p>
                <p><strong>Client ID:</strong> {{ $issue->client_id }}</p>
            </div>

            <div class="detail-group">
                <h4>Issue Information</h4>
                <p><strong>Category:</strong> {{ ucfirst($issue->category) }}</p>
                <p><strong>Created:</strong> {{ $issue->created_at->format('M d, Y H:i') }}</p>
                @if($issue->assigned_to)
                    <p><strong>Assigned To:</strong> {{ $issue->assignedTo->name }} ({{ $issue->assignedTo->email }})</p>
                @endif
                @if($issue->resolved_at)
                    <p><strong>Resolved At:</strong> {{ $issue->resolved_at->format('M d, Y H:i') }}</p>
                @endif
                @if($issue->closed_at)
                    <p><strong>Closed At:</strong> {{ $issue->closed_at->format('M d, Y H:i') }}</p>
                @endif
            </div>

            <div class="detail-group">
                <h4>Description</h4>
                <div class="description-box">{{ $issue->description }}</div>
            </div>

            @if($issue->resolution_details)
            <div class="detail-group">
                <h4>Resolution Details</h4>
                <div class="resolution-box">{{ $issue->resolution_details }}</div>
            </div>
            @endif

            @if($issue->admin_notes)
            <div class="detail-group">
                <h4>Admin Notes</h4>
                <div class="notes-box">{{ $issue->admin_notes }}</div>
            </div>
            @endif
        </div>
    </div>

    <div class="issue-actions">
        <a href="{{ route('content-manager.issues.edit', $issue) }}" class="btn btn-primary">Edit Issue</a>
        <a href="{{ route('content-manager.issues.index') }}" class="btn btn-outline">Back to List</a>
    </div>

    <div class="responses-section">
        <h3>Responses & Activity</h3>
        
        <div class="response-form">
            <form action="{{ route('content-manager.issues.add-response', $issue) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Response Type</label>
                    <select name="response_type" class="form-control">
                        <option value="comment">Comment</option>
                        <option value="solution">Solution</option>
                        <option value="internal_note">Internal Note</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Content</label>
                    <textarea name="content" class="form-control" rows="3" required></textarea>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="is_customer_visible" id="is_customer_visible" value="1" class="form-check-input">
                    <label for="is_customer_visible" class="form-check-label">Visible to customer</label>
                </div>
                <button type="submit" class="btn btn-success mt-3">Add Response</button>
            </form>
        </div>

        <div class="responses-list">
            @forelse($responses as $response)
            <div class="response response-{{ $response->response_type }}">
                <div class="response-header">
                    <strong>{{ $response->responder->name ?? 'System' }}</strong>
                    <span class="response-type">{{ ucfirst($response->response_type) }}</span>
                    <span class="response-date">{{ $response->created_at->format('M j, Y g:i a') }}</span>
                </div>
                <div class="response-content">
                    {{ $response->content }}
                </div>
                @if($response->response_type == 'solution' && $issue->status == 'open')
                <div class="response-actions">
                    <form action="{{ route('content-manager.issues.mark-resolved', $issue) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success">Mark as Resolved</button>
                    </form>
                </div>
                @endif
            </div>
            @empty
            <div class="alert alert-info">No responses yet.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection