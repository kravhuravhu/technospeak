@extends('layouts.admin')

@section('title', 'Training Type Details')

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
    .session-list {
        margin-top: 1rem;
    }
    .session-item {
        padding: 1rem;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .session-item:last-child {
        border-bottom: none;
    }
    .timestamp {
        font-size: 0.85rem;
        color: #64748b;
    }
    .badge {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    .badge-primary {
        background-color: rgba(56, 161, 105, 0.1);
        color: var(--success);
    }
    .badge-secondary {
        background-color: rgba(226, 232, 240, 0.5);
        color: #64748b;
    }
    .price-display {
        font-weight: 600;
        color: var(--skBlue);
    }
</style>

<div class="admin-header">
    <div class="page-title">
        <h1>Training Type Details</h1>
        <p>View and manage training type information</p>
    </div>
</div>

<div class="profile-card">
    <div class="profile-header">
        <div class="profile-info">
            <h2>{{ $trainingType->name }}</h2>
            <div class="timestamp">
                Created: {{ $trainingType->created_at->format('M d, Y') }} • 
                Last updated: {{ $trainingType->updated_at->format('M d, Y') }}
            </div>
        </div>
    </div>

    <div class="action-buttons">
        <a href="{{ route('content-manager.other-features.training-types.edit', $trainingType) }}" class="btn btn-outline">
            <i class="fas fa-edit"></i> Edit
        </a>
        <form action="{{ route('content-manager.other-features.training-types.destroy', $trainingType) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this training type?')">
                <i class="fas fa-trash"></i> Delete
            </button>
        </form>
    </div>
    
    <div class="details-grid">
        <div class="detail-card">
            <h4>Session Type</h4>
            <div class="detail-value">
                @if($trainingType->is_group_session)
                    <span class="badge badge-primary">Group Session</span>
                    @if($trainingType->max_participants)
                        (Max {{ $trainingType->max_participants }} participants)
                    @endif
                @else
                    <span class="badge badge-secondary">Individual Session</span>
                @endif
            </div>
        </div>
        
        <div class="detail-card">
            <h4>Student Price</h4>
            <div class="detail-value price-display">R{{ number_format($trainingType->student_price, 2) }}</div>
        </div>
        
        <div class="detail-card">
            <h4>Professional Price</h4>
            <div class="detail-value price-display">R{{ number_format($trainingType->professional_price, 2) }}</div>
        </div>
        
        <div class="detail-card">
            <h4>Total Sessions</h4>
            <div class="detail-value">{{ $trainingType->sessions->count() }}</div>
        </div>
    </div>
    
    @if($trainingType->description)
    <div class="detail-card" style="grid-column: 1 / -1;margin:10px 0;">
        <h4>Description</h4>
        <p>{{ $trainingType->description }}</p>
    </div>
    @endif
    
    @if($trainingType->sessions_count > 0)
    <div class="detail-card" style="grid-column: 1 / -1;">
        <h4>Upcoming Sessions</h4>
        <div class="session-list">
            @foreach($trainingType->sessions->take(5) as $session)
            <div class="session-item">
                <div>
                    <strong>{{ $session->title }}</strong>
                    <div class="timestamp">
                        {{ $session->start_date->format('M d, Y h:i A') }} • 
                        Duration: {{ $session->duration }} minutes •
                        @if($session->registrations_count > 0)
                            {{ $session->registrations_count }} registrations
                        @else
                            No registrations yet
                        @endif
                    </div>
                </div>
                <a href="{{ route('content-manager.trainings.show', $session) }}" class="btn btn-sm btn-outline">
                    View Session
                </a>
            </div>
            @endforeach
            
            @if($trainingType->sessions_count > 5)
            <div class="session-item">
                <div class="text-gray-500">
                    Showing 5 of {{ $trainingType->sessions_count }} sessions
                </div>
                <a href="{{ route('content-manager.trainings.index', ['type' => $trainingType->id]) }}" class="btn btn-sm btn-outline">
                    View All Sessions
                </a>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>

<div class="action-buttons">
    <a href="{{ route('content-manager.other-features.index') }}" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Back to Training Types
    </a>
</div>
@endsection