@extends('layouts.admin')

@section('title', $training->title)

@section('content')
<div class="admin-header">
    <div class="page-title">
        <h1>{{ $training->title }}</h1>
        <p>
            Training ID: {{ $training->id }} •
            Scheduled For: {{ \Carbon\Carbon::parse($training->scheduled_for)->format('M d, Y') }}
        </p>
    </div>
    <div class="user-menu">
        <a href="{{ route('content-manager.trainings.registrations', $training) }}" class="btn btn-primary">
            <i class="fas fa-users"></i> View Registrations ({{ $training->registrations->count() }})
        </a>
    </div>
</div>

<div class="form-card">
    <h3 style="margin-bottom: 1.5rem;">Session Details</h3>
    
    <div class="form-row">
        <div class="form-group">
            <label class="form-label">Title</label>
            <p>{{ $training->title }}</p>
        </div>
        <div class="form-group">
            <label class="form-label">Training Type</label>
            <p>{{ $training->type->name }}</p>
        </div>
        <div class="form-group">
            <label class="form-label">Description</label>
            <p>{{ $training->description ?? 'No description provided' }}</p>
        </div>
    </div>
    
    <div class="form-row">
        <div class="form-group">
            <label class="form-label">From Time</label>
            <p>{{ $training->from_time }}</p>
        </div>
        <div class="form-group">
            <label class="form-label">To Time</label>
            <p>{{ $training->to_time }}</p>
        </div>
        <div class="form-group">
            <label class="form-label">Duration Seconds</label>
            <p>{{ $training->duration_seconds }}</p>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label class="form-label">Category ID</label>
            <p>{{ $training->category->name }}</p>
        </div>
        <div class="form-group">
            <label class="form-label">Instructor ID</label>
            <p>{{ $training->instructor->name ?? 'Not assigned' }}</p>
        </div>
        <div class="form-group">
            <label class="form-label">Scheduled For</label>
            <p>{{ $training->scheduled_for->format('M d, Y') }}</p>
        </div>
    </div>

    <div class="form-group">
        <label class="form-label">Max Participants</label>
        <p>{{ $training->max_participants ?? 'No limit' }}</p>
    </div>
    
    <div class="form-group">
        <label class="form-label">Created At</label>
        <p>{{ $training->created_at->format('M d, Y H:i') }}</p>
    </div>
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
