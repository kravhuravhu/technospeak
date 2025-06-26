@extends('layouts.admin')

@section('title', 'Create Training Session')

@section('content')
<div class="admin-header">
    <div class="page-title">
        <h1>Create Training Session</h1>
        <p>Schedule a new training session</p>
    </div>
</div>

<form action="{{ route('content-manager.trainings.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="form-card">
        <div class="form-row">
            <div class="form-group">
                <label for="type_id" class="form-label">Session Type</label>
                <select id="type_id" name="type_id" class="form-control" required>
                    <option value="">Select Type</option>
                    @foreach($types as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label for="title" class="form-label">Title</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>
        </div>
        
        <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-control" rows="4"></textarea>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="instructor_id" class="form-label">Instructor</label>
                <select id="instructor_id" name="instructor_id" class="form-control">
                    <option value="">Select Instructor</option>
                    @foreach($instructors as $instructor)
                        <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label for="scheduled_at" class="form-label">Scheduled Date & Time</label>
                <input type="datetime-local" id="scheduled_at" name="scheduled_at" class="form-control" required>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="duration_minutes" class="form-label">Duration (minutes)</label>
                <input type="number" id="duration_minutes" name="duration_minutes" class="form-control" min="15" required>
            </div>
            
            <div class="form-group">
                <label for="price" class="form-label">Price</label>
                <input type="number" id="price" name="price" class="form-control" min="0" step="0.01" required>
            </div>
            
            <div class="form-group">
                <label for="max_participants" class="form-label">Max Participants</label>
                <input type="number" id="max_participants" name="max_participants" class="form-control" min="1">
                <small class="text-muted">Leave empty for no limit</small>
            </div>
        </div>
        
        <div class="form-group">
            <label for="thumbnail" class="form-label">Thumbnail Image</label>
            <input type="file" id="thumbnail" name="thumbnail" class="form-control">
        </div>
        
        <div class="form-group" style="margin-top: 1.5rem;">
            <button type="submit" class="btn btn-primary">
                Create Session
            </button>
            <a href="{{ route('content-manager.trainings.index') }}" class="btn btn-outline">
                Cancel
            </a>
        </div>
    </div>
</form>
@endsection