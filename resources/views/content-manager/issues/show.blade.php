@extends('layouts.admin')

@section('title', 'Issue Details')

@section('content')
<div class="admin-header">
    <div class="page-title">
        <h1>Issue Details</h1>
        <p>Detailed view of the selected issue.</p>
    </div>
</div>

<div class="issue-detail">
    <h3>{{ $issue->title }}</h3>
    <p><strong>Email:</strong> {{ $issue->client->email }}</p>
    <p><strong>Urgency:</strong> {{ ucfirst($issue->urgency) }}</p>
    <p><strong>Status:</strong> {{ ucfirst($issue->status) }}</p>
    <p><strong>Category:</strong> {{ ucfirst($issue->category) }}</p>
    <p><strong>Description:</strong> {{ $issue->description }}</p>
    <p><strong>Created:</strong> {{ $issue->created_at->format('M d, Y H:i') }}</p>
    <a href="{{ route('content-manager.issues.edit', $issue) }}" class="btn btn-primary">Edit Issue</a>
</div>
@endsection
