@extends('layouts.admin')

@section('title', 'Edit Training Session')

@section('content')
<div class="admin-header">
    <div class="page-title">
        <h1>Edit Training Session</h1>
        <p>Update session details</p>
    </div>
</div>

<form action="{{ route('content-manager.trainings.update', $training) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="form-card">
        <div class="form-row">
            <div class="form-group">
                <label for="type_id" class="form-label">Session Type</label>
                <select id="type_id" name="type_id" class="form-control" required>
                    <option value="">Select Type</option>
                    @foreach($types as $type)
                        <option value="{{ $type->id }}" {{ $training->type_id == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label for="title" class="form-label">Title</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ $training->title }}" required maxlength="150">
            </div>
        </div>
        
        <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-control" rows="4">{{ $training->description }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="from_time" class="form-label">From Time</label>
                <input type="time" id="from_time" name="from_time" class="form-control" 
                    value="{{ \Carbon\Carbon::parse($training->from_time)->format('H:i') }}" required>
            </div>

            <div class="form-group">
                <label for="to_time" class="form-label">To Time</label>
                <input type="time" id="to_time" name="to_time" class="form-control" 
                    value="{{ \Carbon\Carbon::parse($training->to_time)->format('H:i') }}" required>
            </div>

            <div class="form-group">
                <label for="duration_display" class="form-label">Duration <i>(hh:mm:ss)</i></label>
                <input type="text" id="duration_display" class="form-control" disabled readonly>
            </div>

            <div class="form-group">
                <input type="hidden" id="duration_seconds" name="duration_seconds" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="category_id" class="form-label">Category</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $training->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label for="instructor_id" class="form-label">Instructor</label>
                <select id="instructor_id" name="instructor_id" class="form-control">
                    <option value="">Select Instructor</option>
                    @foreach($instructors as $instructor)
                        <option value="{{ $instructor->id }}" {{ $training->instructor_id == $instructor->id ? 'selected' : '' }}>
                            {{ $instructor->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="scheduled_for" class="form-label">Scheduled Date</label>
                <input type="date" id="scheduled_for" name="scheduled_for" class="form-control" 
                       value="{{ \Carbon\Carbon::parse($training->scheduled_for)->format('Y-m-d') }}" required>
            </div>
            
            <div class="form-group">
                <label for="max_participants" class="form-label">Max Participants</label>
                <input type="number" id="max_participants" name="max_participants" class="form-control" 
                       value="{{ $training->max_participants }}" min="1">
                <small class="text-muted">Leave empty for no limit</small>
            </div>
        </div>
        
        <div class="form-group" style="margin-top: 1.5rem;">
            <button type="submit" class="btn btn-primary">
                Update Session
            </button>
            <a href="{{ route('content-manager.trainings.index') }}" class="btn btn-outline">
                Cancel
            </a>
        </div>
    </div>
</form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fromInput = document.getElementById('from_time');
        const toInput = document.getElementById('to_time');
        const durationField = document.getElementById('duration_seconds');
        const durationDisplay = document.getElementById('duration_display');

        function calculateDuration() {
            const from = fromInput.value;
            const to = toInput.value;

            if (from && to) {
                const [fh, fm] = from.split(':').map(Number);
                const [th, tm] = to.split(':').map(Number);

                const fromSeconds = fh * 3600 + fm * 60;
                const toSeconds = th * 3600 + tm * 60;

                let duration = toSeconds - fromSeconds;

                if (duration < 60) {
                    durationDisplay.value = '';
                    durationField.value = '';
                    return;
                }

                const hours = Math.floor(duration / 3600);
                const minutes = Math.floor((duration % 3600) / 60);
                const seconds = duration % 60;

                durationDisplay.value = 
                    String(hours).padStart(2, '0') + ':' +
                    String(minutes).padStart(2, '0') + ':' +
                    String(seconds).padStart(2, '0');

                durationField.value = duration;
            }
        }

        fromInput.addEventListener('change', calculateDuration);
        toInput.addEventListener('change', calculateDuration);

        // Trigger once to populate on load
        calculateDuration();
    });
</script>
@endpush

@endsection
