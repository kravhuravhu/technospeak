@extends('layouts.admin')

@section('title', 'Edit Course: ' . $course->title)

@section('content')
<style>
    .edit-course-container {
        margin: 0 auto;
        padding: 0 20px;
    }
    
    /* Modern Card Styles */
    .edit-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        margin-bottom: 2rem;
        overflow: hidden;
        border-left: 4px solid var(--skBlue);
    }
    
    .edit-card-header {
        padding: 1.5rem;
        background-color: rgba(56, 182, 255, 0.1);
        border-bottom: 1px solid rgba(56, 182, 255, 0.2);
    }
    
    .edit-card-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--darkBlue);
        display: flex;
        align-items: center;
    }
    
    .edit-card-title i {
        margin-right: 0.75rem;
        color: var(--skBlue);
    }
    
    .edit-card-body {
        padding: 1.5rem;
    }
    
    /* Form Elements */
    .edit-form-group {
        margin-bottom: 1.75rem;
    }
    
    .edit-form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        font-size: 0.95rem;
        color: var(--darkBlue);
    }
    
    .edit-form-control {
        width: 100%;
        padding: 0.85rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s;
        background-color: #f8fafc;
    }
    
    .edit-form-control:focus {
        border-color: var(--skBlue);
        box-shadow: 0 0 0 3px rgba(56, 182, 255, 0.2);
        background-color: white;
    }
    
    /* Two-column layout */
    .edit-form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    
    /* Preview Areas */
    .preview-container {
        border: 1px dashed #cbd5e0;
        border-radius: 8px;
        padding: 1rem;
        margin-top: 0.5rem;
        background-color: #f7fafc;
        text-align: center;
    }
    
    .thumbnail-preview {
        max-width: 200px;
        max-height: 120px;
        border-radius: 4px;
        margin: 0 auto;
    }
    
    .icon-preview {
        max-width: 48px;
        margin: 0 auto;
    }
    
    /* Episode Editor */
    .episode-editor {
        background-color: #f8fafc;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .episode-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .episode-number-badge {
        background-color: var(--skBlue);
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }
    
    /* Duration Display */
    .duration-display {
        background-color: white;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.75rem;
        font-family: monospace;
        text-align: center;
        font-size: 0.9rem;
    }
    
    /* Action Buttons */
    .edit-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e2e8f0;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .edit-form-grid {
            grid-template-columns: 1fr;
        }
        
        .edit-card-header {
            padding: 1rem;
        }
        
        .edit-card-body {
            padding: 1rem;
        }
    }
</style>

<div class="edit-course-container">
    <div class="admin-header">
        <div class="page-title">
            <h1>Edit Course: {{ $course->title }}</h1>
            <p>Update course details and content | CourseID • {{ $course->id }}</p>
        </div>
        <div class="user-menu">
            <a href="{{ route('content-manager.courses.show', $course->id) }}" class="btn btn-outline">
                <i class="fas fa-eye"></i> Preview
            </a>
        </div>
    </div>

    <form action="{{ route('content-manager.courses.update', $course->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="edit-card">
            <div class="edit-card-header">
                <h3 class="edit-card-title">
                    <i class="fas fa-info-circle"></i> Course Information
                </h3>
            </div>
            <div class="edit-card-body">
                <div class="edit-form-grid">
                    <div class="edit-form-group">
                        <label class="edit-form-label">Course Title</label>
                        <input type="text" name="title" class="edit-form-control" 
                               value="{{ old('title', $course->title) }}" required>
                    </div>
                    
                    <div class="edit-form-group">
                        <label class="edit-form-label">Catch Phrase</label>
                        <input type="text" name="catch_phrase" class="edit-form-control"
                               value="{{ old('catch_phrase', $course->catch_phrase) }}" 
                               minlength="50" maxlength="90" required>
                    </div>
                </div>
                
                <div class="edit-form-group">
                    <label class="edit-form-label">Description</label>
                    <textarea name="description" class="edit-form-control" rows="5" required>{{ old('description', $course->description) }}</textarea>
                </div>
                
                <div class="edit-form-grid">
                    <div class="edit-form-group">
                        <label class="edit-form-label">Category</label>
                        <select name="category_id" class="edit-form-control" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $course->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="edit-form-group">
                        <label class="edit-form-label">Instructor</label>
                        <select name="instructor_id" class="edit-form-control" required>
                            @foreach($instructors as $instructor)
                                <option value="{{ $instructor->id }}" {{ $course->instructor_id == $instructor->id ? 'selected' : '' }}>
                                    {{ $instructor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="edit-form-grid">
                    <div class="edit-form-group">
                        <label class="edit-form-label">Plan Type</label>
                        <select name="plan_type" class="edit-form-control" required>
                            <option value="free" {{ $course->plan_type == 'free' ? 'selected' : '' }}>Free</option>
                            <option value="paid" {{ $course->plan_type == 'paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                    </div>
                    
                    <div class="edit-form-group">
                        <label class="edit-form-label">Difficulty Level</label>
                        <select name="level" class="edit-form-control" required>
                            @foreach(['beginner', 'intermediate', 'advanced', 'expert', 'all levels'] as $lvl)
                                <option value="{{ $lvl }}" {{ $course->level == $lvl ? 'selected' : '' }}>
                                    {{ ucfirst($lvl) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Media Assets Card -->
        <div class="edit-card">
            <div class="edit-card-header">
                <h3 class="edit-card-title">
                    <i class="fas fa-images"></i> Media Assets
                </h3>
            </div>
            <div class="edit-card-body">
                <div class="edit-form-grid">
                    <div class="edit-form-group">
                        <label class="edit-form-label">Thumbnail URL</label>
                        <input type="url" name="thumbnail" class="edit-form-control" 
                               value="{{ old('thumbnail', $course->thumbnail) }}" required>
                        <div class="preview-container">
                            @if($course->thumbnail)
                                <img src="{{ $course->thumbnail }}" class="thumbnail-preview" id="thumbnailPreview">
                            @else
                                <p class="text-muted">No thumbnail preview</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="edit-form-group">
                        <label class="edit-form-label">Software/App Icon URL</label>
                        <input type="url" name="software_app_icon" class="edit-form-control" 
                               value="{{ old('software_app_icon', $course->software_app_icon) }}" required>
                        <div class="preview-container">
                            @if($course->software_app_icon)
                                <img src="{{ $course->software_app_icon }}" class="icon-preview" id="iconPreview">
                            @else
                                <p class="text-muted">No icon preview</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Episodes Editor -->
        <div class="edit-card">
            <div class="edit-card-header">
                <h3 class="edit-card-title">
                    <i class="fas fa-film"></i> Course Episodes
                </h3>
            </div>
            <div class="edit-card-body">
                <div class="edit-form-grid">
                    <div class="edit-form-group">
                        <label class="edit-form-label">Total Episodes</label>
                        <input type="number" name="noEpisodes" class="edit-form-control" 
                               value="{{ old('noEpisodes', $course->noEpisodes) }}" readonly>
                    </div>
                    
                    <div class="edit-form-group">
                        <label class="edit-form-label">Total Duration</label>
                        <div class="duration-display">
                            @php
                                $hours = floor($course->total_duration / 3600);
                                $minutes = floor(($course->total_duration % 3600) / 60);
                                $seconds = $course->total_duration % 60;
                                
                                if ($hours > 0) {
                                    echo $hours.'h '.$minutes.'m '.$seconds.'s';
                                } else {
                                    echo $minutes.'m '.$seconds.'s';
                                }
                            @endphp
                        </div>
                    </div>
                </div>
                
                @foreach($course->episodes as $index => $episode)
                <div class="episode-editor">
                    <div class="episode-header">
                        <div class="episode-number-badge">
                            {{ $episode->episode_number }}
                        </div>
                        <button type="button" class="btn btn-danger btn-sm remove-episode">
                            <i class="fas fa-trash"></i> Remove
                        </button>
                    </div>
                    
                    <div class="edit-form-group">
                        <label class="edit-form-label">Episode Title</label>
                        <input type="text" name="episodes[{{ $index }}][title]" class="edit-form-control" 
                               value="{{ old("episodes.$index.title", $episode->title) }}" required>
                    </div>
                    
                    <div class="edit-form-group">
                        <label class="edit-form-label">Description</label>
                        <textarea name="episodes[{{ $index }}][description]" class="edit-form-control" rows="3">{{ old("episodes.$index.description", $episode->description) }}</textarea>
                    </div>
                    
                    <div class="edit-form-grid">
                        <div class="edit-form-group">
                            <label class="edit-form-label">Video URL</label>
                            <input type="url" name="episodes[{{ $index }}][video_url]" class="edit-form-control" 
                                   value="{{ old("episodes.$index.video_url", $episode->video_url) }}" required>
                        </div>
                        
                        <div class="edit-form-group">
                            <label class="edit-form-label">Duration</label>
                            @php
                                $minutes = floor($episode->duration / 60);
                                $seconds = $episode->duration % 60;
                                $durationDisplay = sprintf('%d:%02d', $minutes, $seconds);
                            @endphp
                            <input type="text" name="episodes[{{ $index }}][duration]" class="edit-form-control" 
                                   value="{{ old("episodes.$index.duration", $durationDisplay) }}" readonly>
                        </div>
                    </div>
                    
                    <input type="hidden" name="episodes[{{ $index }}][episode_number]" value="{{ $episode->episode_number }}">
                </div>
                @endforeach
            </div>
        </div>
        
        <div class="edit-actions">
            <a href="{{ route('content-manager.courses.index') }}" class="btn btn-outline">
                <i class="fas fa-times"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Changes
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Thumbnail preview
    const thumbnailInput = document.querySelector('input[name="thumbnail"]');
    const thumbnailPreview = document.getElementById('thumbnailPreview');
    
    if (thumbnailInput && thumbnailPreview) {
        thumbnailInput.addEventListener('input', function() {
            if (this.value) {
                thumbnailPreview.src = this.value;
                thumbnailPreview.style.display = 'block';
            }
        });
    }
    
    // Icon preview
    const iconInput = document.querySelector('input[name="software_app_icon"]');
    const iconPreview = document.getElementById('iconPreview');
    
    if (iconInput && iconPreview) {
        iconInput.addEventListener('input', function() {
            if (this.value) {
                iconPreview.src = this.value;
                iconPreview.style.display = 'block';
            }
        });
    }
    
    // Remove episode buttons
    document.querySelectorAll('.remove-episode').forEach(button => {
        button.addEventListener('click', function() {
            if (confirm('Are you sure you want to remove this episode?')) {
                this.closest('.episode-editor').remove();
                // Update episode numbers and counts would need additional JS
            }
        });
    });
});
</script>
@endsection