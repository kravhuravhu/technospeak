@extends('layouts.admin')

@section('title', 'Add Episode')

@section('content')
<div class="admin-header">
    <div class="page-title">
        <h1>Add Episode to: {{ $course->title }}</h1>
        <p>Add a new episode to this course</p>
    </div>
</div>

<form action="{{ route('content-manager.courses.episodes.store', $course) }}" method="POST">
    @csrf
    <div class="form-card">
        <div class="form-row">
            <div class="form-group">
                <label for="title" class="form-label">Episode Title</label>
                <input type="text" id="title" name="title" class="form-control" required>
                @error('title')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="episode_number" class="form-label">Episode Number</label>
                <input type="number" id="episode_number" name="episode_number" class="form-control" 
                       min="1" max="{{ $course->noEpisodes }}" required>
                @error('episode_number')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-control" rows="4" required></textarea>
            @error('description')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="video_url" class="form-label">Video URL</label>
                <input type="url" id="video_url" name="video_url" class="form-control" required>
                @error('video_url')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="duration" class="form-label">Duration (minutes)</label>
                <input type="number" id="duration" name="duration" class="form-control" min="1" required>
                @error('duration')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <div class="form-check">
                <input type="checkbox" id="is_free" name="is_free" class="form-check-input" value="1">
                <label for="is_free" class="form-check-label">Free Episode (available without subscription)</label>
            </div>
        </div>

        <div class="form-group" style="margin-top: 1.5rem;">
            <button type="submit" class="btn btn-primary">
                Add Episode
            </button>
            <a href="{{ route('content-manager.courses.episodes.index', $course) }}" class="btn btn-outline">
                Cancel
            </a>
        </div>
    </div>
</form>
@endsection