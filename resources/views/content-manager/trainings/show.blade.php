@extends('layouts.admin')

@section('title', $training->title)

@section('content')
<div class="admin-header">
    <div class="page-title">
        <h1>{{ $training->title }}</h1>
        <p>
            {{ $training->type->name }} • 
            {{ $training->scheduled_at->format('M d, Y H:i') }} • 
            {{ $training->duration_minutes }} minutes
        </p>
    </div>
    <div class="user-menu">
        <a href="{{ route('content-manager.trainings.registrations', $training) }}" class="btn btn-primary">
            <i class="fas fa-users"></i> View Registrations ({{ $training->registrations->count() }})
        </a>
    </div>
</div>

<div class="form-row">
    <div class="form-card" style="flex: 2;">
        <h3 style="margin-bottom: 1.5rem;">Session Details</h3>
        
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Instructor</label>
                <p>{{ $training->instructor ? $training->instructor->name : 'Not assigned' }}</p>
            </div>
            
            <div class="form-group">
                <label class="form-label">Price</label>
                <p>${{ number_format($training->price, 2) }}</p>
            </div>
        </div>
        
        <div class="form-group">
            <label class="form-label">Description</label>
            <p>{{ $training->description ?? 'No description provided' }}</p>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Max Participants</label>
                <p>{{ $training->max_participants ?? 'No limit' }}</p>
            </div>
            
            <div class="form-group">
                <label class="form-label">Available Spots</label>
                <p>{{ $training->max_participants ? $training->max_participants - $training->registrations->count() : 'Unlimited' }}</p>
            </div>
            
            <div class="form-group">
                <label class="form-label">Status</label>
                <p>
                    @if($training->scheduled_at->isPast())
                        <span class="status-badge status-inactive">Completed</span>
                    @else
                        <span class="status-badge status-active">Upcoming</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
    
    @if($training->thumbnail)
    <div class="form-card" style="flex: 1;">
        <h3 style="margin-bottom: 1.5rem;">Thumbnail</h3>
        <img src="{{ asset('storage/'.$training->thumbnail) }}" alt="Session Thumbnail" style="width: 100%; border-radius: 8px;">
    </div>
    @endif
</div>

<div class="form-group" style="margin-top: 1.5rem;">
    <a href="{{ route('content-manager.trainings.edit', $training) }}" class="btn btn-primary">
        <i class="fas fa-edit"></i> Edit Session
    </a>
    <a href="{{ route('content-manager.trainings.index') }}" class="btn btn-outline">
        Back to List
    </a>
</div>
@endsection