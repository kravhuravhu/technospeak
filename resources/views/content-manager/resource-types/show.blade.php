@extends('layouts.admin')

@section('title', 'Resource Type Details')

@section('content')
<style>
    .profile-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        padding: 2rem;
        margin-bottom: 2rem;
    }
    .profile-header {
        margin-bottom: 2rem;
    }
    .profile-info h2 {
        margin: 0;
        color: var(--skBlue);
    }
    .profile-meta {
        color: #64748b;
        margin-top: 0.5rem;
    }
    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }
    .detail-card {
        background: #f8fafc;
        border-radius: 6px;
        padding: 1.5rem;
    }
    .detail-card h4 {
        margin-top: 0;
        color: #475569;
    }
    .detail-value {
        font-size: 1.1rem;
        color: #1e293b;
    }
    .admin-header {
        margin-bottom: 2rem;
    }
    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }
    .resource-list {
        margin-top: 1rem;
    }
    .resource-item {
        padding: 1rem;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .resource-item:last-child {
        border-bottom: none;
    }
    .timestamp {
        font-size: 0.85rem;
        color: #64748b;
    }
</style>

<div class="admin-header">
    <div class="page-title">
        <h1>Resource Type Details</h1>
        <p>View and manage resource type information</p>
    </div>
</div>

<div class="profile-card">
    <div class="profile-header">
        <div class="profile-info">
            <h2>{{ $resourceType->name }}</h2>
            <div class="timestamp">
                Created: {{ $resourceType->created_at->format('M d, Y') }} • 
                Last updated: {{ $resourceType->updated_at->format('M d, Y') }}
            </div>
        </div>
    </div>

    <div class="action-buttons">
        <a href="{{ route('content-manager.other-features.resource-types.edit', $resourceType) }}" class="btn btn-outline">
            <i class="fas fa-edit"></i> Edit
        </a>
        <form action="{{ route('content-manager.other-features.resource-types.destroy', $resourceType) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this resource type?')">
                <i class="fas fa-trash"></i> Delete
            </button>
        </form>
    </div>
    
    <div class="details-grid">
        <div class="detail-card">
            <h4>Total Resources</h4>
            <div class="detail-value">{{ $resourceType->resources->count() }}</div>
        </div>
    </div>
    
    @if($resourceType->resources_count > 0)
    <div class="detail-card" style="grid-column: 1 / -1;">
        <h4>Associated Resources</h4>
        <div class="resource-list">
            @foreach($resourceType->resources as $resource)
            <div class="resource-item">
                <div>
                    <strong>{{ $resource->title }}</strong>
                    <div class="timestamp">Course: {{ $resource->course->title }}</div>
                </div>
                <a href="{{ route('content-manager.courses.show', $resource->course) }}" class="btn btn-sm btn-outline">
                    View Course
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<div class="action-buttons">
    <a href="{{ route('content-manager.other-features.index') }}" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Back to Resource Types
    </a>
</div>
@endsection