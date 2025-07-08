@extends('layouts.admin')

@section('title', 'Edit Course: ' . $course->title)

@section('head')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
@endsection

@section('content')

<style>
    .edit-container {
        margin: 0 auto;
        padding: 0 2rem;
    }
    
    .edit-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .edit-title {
        font-size: 1.75rem;
        font-weight: 600;
        color: var(--darkBlue);
    }
    
    .edit-form-section {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        margin-bottom: 2rem;
        padding: 1.5rem;
    }
    
    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--skBlue);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }
    
    .section-title i {
        margin-right: 0.75rem;
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .form-group {
        margin-bottom: 1.25rem;
    }
    
    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        font-size: 0.9rem;
        color: var(--darkBlue);
    }
    
    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        font-size: 0.95rem;
        transition: border-color 0.2s;
        color:rgb(109, 122, 149);
    }
    
    .form-input:focus {
        border-color: var(--skBlue);
        outline: none;
    }
    
    /* Episode Editor */
    .episode-editor {
        background: #f8fafc;
        border-radius: 6px;
        padding: 1.25rem;
        margin-bottom: 1rem;
        position: relative;
        border: 1px solid #e2e8f0;
    }
    
    .episode-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .episode-number {
        background: var(--skBlue);
        color: white;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .remove-episode {
        background: #fee2e2;
        border: 1px solid #fca5a5;
        color: var(--danger);
        cursor: pointer;
        font-size: 0.85rem;
        padding: 0.25rem 0.75rem;
        border-radius: 4px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .remove-episode:hover {
        background: #fecaca;
    }
    
    /* Action Buttons */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e2e8f0;
    }
    
    /* Confirmation modal */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    
    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    
    .modal-content {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 1.5rem;
    }
    
    /* Status indicators */
    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .status-active {
        background: #dcfce7;
        color: #166534;
    }
    
    .status-inactive {
        background: #fee2e2;
        color: #991b1b;
    }
    
    /* Episode duration display */
    .duration-display {
        font-family: monospace;
        background: #f1f5f9;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.9rem;
    }
</style>

<div class="edit-container">
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

    <form action="{{ route('content-manager.courses.update', $course->id) }}" method="POST" id="course-form">
        @csrf
        @method('PUT')
        
        <!-- Basic Information Section -->
        <div class="edit-form-section">
            <h3 class="section-title">
                <i class="fas fa-info-circle"></i> Course Information
            </h3>
            
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Course Title</label>
                    <input type="text" name="title" class="form-input" 
                           value="{{ old('title', $course->title) }}" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Catch Phrase</label>
                    <input type="text" name="catch_phrase" class="form-input"
                           value="{{ old('catch_phrase', $course->catch_phrase) }}" 
                           minlength="50" maxlength="90" required>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-input" rows="4" required>{{ old('description', $course->description) }}</textarea>
            </div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-input" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $course->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Instructor</label>
                    <select name="instructor_id" class="form-input" required>
                        @foreach($instructors as $instructor)
                            <option value="{{ $instructor->id }}" {{ $course->instructor_id == $instructor->id ? 'selected' : '' }}>
                                {{ $instructor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Plan Type</label>
                    <select name="plan_type" class="form-input" required>
                        <option value="free" {{ $course->plan_type == 'free' ? 'selected' : '' }}>Free</option>
                        <option value="paid" {{ $course->plan_type == 'paid' ? 'selected' : '' }}>Paid</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Difficulty Level</label>
                    <select name="level" class="form-input" required>
                        @foreach(['beginner', 'intermediate', 'advanced', 'expert', 'all levels'] as $lvl)
                            <option value="{{ $lvl }}" {{ $course->level == $lvl ? 'selected' : '' }}>
                                {{ ucfirst($lvl) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <div>
                        <span class="status-badge {{ $course->is_active ? 'status-active' : 'status-inactive' }}">
                            {{ $course->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Media Section -->
        <div class="edit-form-section">
            <h3 class="section-title">
                <i class="fas fa-image"></i> Media URLs
            </h3>
            
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Thumbnail URL</label>
                    <input type="url" name="thumbnail" class="form-input" 
                           value="{{ old('thumbnail', $course->thumbnail) }}" required>
                    @if($course->thumbnail)
                        <div class="mt-2">
                            <img src="{{ $course->thumbnail }}" alt="Thumbnail preview" style="max-width: 150px; border-radius: 4px;">
                        </div>
                    @endif
                </div>
                
                <div class="form-group">
                    <label class="form-label">Software/App Icon URL</label>
                    <input type="url" name="software_app_icon" class="form-input" 
                           value="{{ old('software_app_icon', $course->software_app_icon) }}" required>
                    @if($course->software_app_icon)
                        <div class="mt-2">
                            <img src="{{ $course->software_app_icon }}" alt="Icon preview" style="max-width: 50px; border-radius: 4px;">
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Episodes Section -->
        <div class="edit-form-section">
            <h3 class="section-title">
                <i class="fas fa-film"></i> Course Episodes
            </h3>
            
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Total Episodes</label>
                    <input type="number" name="noEpisodes" class="form-input" 
                           value="{{ old('noEpisodes', $course->noEpisodes) }}" readonly>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Total Duration</label>
                    <div class="duration-display">
                        {{ gmdate('H:i:s', $course->total_duration) }}
                    </div>
                    <input type="hidden" name="total_duration" value="{{ $course->total_duration }}">
                </div>
            </div>
            
            <div id="episodes-container">
                @foreach($course->episodes as $index => $episode)
                <div class="episode-editor" data-episode-id="{{ $episode->id }}" data-index="{{ $index }}">
                    <div class="episode-header">
                        <div class="episode-number">{{ $episode->episode_number }}</div>
                        <button type="button" class="remove-episode" data-episode-id="{{ $episode->id }}">
                            <i class="fas fa-trash"></i> Remove
                        </button>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Episode Title</label>
                            <input type="text" name="episodes[{{ $index }}][title]" class="form-input" 
                                   value="{{ old("episodes.$index.title", $episode->title) }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Video URL</label>
                            <input type="url" name="episodes[{{ $index }}][video_url]" class="form-input episode-video-url" 
                                   value="{{ old("episodes.$index.video_url", $episode->video_url) }}" required>
                            @if($episode->video_url)
                                <div class="mt-2">
                                    <video src="{{ $episode->video_url }}" controls style="max-width: 100%; height: auto;"></video>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="episodes[{{ $index }}][description]" class="form-input" rows="2">{{ old("episodes.$index.description", $episode->description) }}</textarea>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Duration</label>
                            <div class="duration-display">
                                {{ gmdate('H:i:s', $episode->duration * 60) }}
                            </div>
                            <input type="hidden" name="episodes[{{ $index }}][duration]" value="{{ $episode->duration * 60 }}">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <div>
                                <span class="status-badge {{ $episode->is_active ? 'status-active' : 'status-inactive' }}">
                                    {{ $episode->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <input type="hidden" name="episodes[{{ $index }}][episode_number]" value="{{ $episode->episode_number }}">
                    <input type="hidden" name="episodes[{{ $index }}][id]" value="{{ $episode->id }}">
                </div>
                @endforeach
            </div>
            
            <button type="button" id="add-episode" class="btn btn-outline mt-2">
                <i class="fas fa-plus"></i> Add Episode
            </button>
        </div>
        
        <div class="form-actions">
            <a href="{{ route('content-manager.courses.index') }}" class="btn btn-outline">
                <i class="fas fa-times"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Changes
            </button>
        </div>
    </form>
</div>

<div class="modal-overlay" id="confirmation-modal">
    <div class="modal-content">
        <h3>Confirm Deletion</h3>
        <p>Are you sure you want to delete this episode? This action cannot be undone.</p>
        <div class="modal-actions">
            <button type="button" class="btn btn-outline" id="cancel-delete">Cancel</button>
            <button type="button" class="btn btn-danger" id="confirm-delete">Delete Episode</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add Episode Functionality
    const addEpisodeBtn = document.getElementById('add-episode');
    const episodesContainer = document.getElementById('episodes-container');
    let episodeCount = {{ $course->episodes->count() }};
    let episodeToDelete = null;
    
    // Confirmation modal elements
    const confirmationModal = document.getElementById('confirmation-modal');
    const confirmDeleteBtn = document.getElementById('confirm-delete');
    const cancelDeleteBtn = document.getElementById('cancel-delete');
    
    // Function to show confirmation modal
    function showConfirmationModal(episodeId) {
        episodeToDelete = episodeId;
        confirmationModal.classList.add('active');
    }
    
    // Function to hide confirmation modal
    function hideConfirmationModal() {
        confirmationModal.classList.remove('active');
        episodeToDelete = null;
    }
    
    // Event listeners for modal buttons
    confirmDeleteBtn.addEventListener('click', function() {
        if (episodeToDelete) {
            // If episode has an ID (exists in database), send DELETE request
            if (episodeToDelete !== 'new' && !episodeToDelete.startsWith('new-')) {
                fetch(`{{ route('content-manager.courses.episodes.destroy', ['course' => $course->id, 'episode' => 'EPISODE_ID']) }}`.replace('EPISODE_ID', episodeToDelete), {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (response.status === 404) {
                        throw new Error('Episode not found');
                    }
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Remove the episode from UI
                        const episodeElement = document.querySelector(`.episode-editor[data-episode-id="${episodeToDelete}"]`);
                        if (episodeElement) {
                            episodeElement.remove();
                            updateEpisodeNumbers();
                            updateTotalEpisodesCount();
                            calculateTotalDuration();
                        }
                    } else {
                        alert('Error deleting episode: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error deleting episode:', error);
                    alert('Error deleting episode: ' + error.message);
                });
            } else {
                // For new episodes not yet saved to database, just remove from UI
                const episodeElement = document.querySelector(`.episode-editor[data-episode-id="${episodeToDelete}"]`);
                if (episodeElement) {
                    episodeElement.remove();
                    updateEpisodeNumbers();
                    updateTotalEpisodesCount();
                    calculateTotalDuration();
                }
            }
        }
        hideConfirmationModal();
    });
    
    cancelDeleteBtn.addEventListener('click', hideConfirmationModal);
    
    // Add new episode
    addEpisodeBtn.addEventListener('click', function() {
        episodeCount++;
        const newIndex = episodeCount - 1;
        const newId = 'new-' + Date.now(); // Unique ID for new episode
        
        const newEpisode = document.createElement('div');
        newEpisode.className = 'episode-editor';
        newEpisode.dataset.index = newIndex;
        newEpisode.dataset.episodeId = newId;
        
        newEpisode.innerHTML = `
            <div class="episode-header">
                <div class="episode-number">${episodeCount}</div>
                <button type="button" class="remove-episode" data-episode-id="${newId}">
                    <i class="fas fa-trash"></i> Remove
                </button>
            </div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Episode Title</label>
                    <input type="text" name="episodes[${newIndex}][title]" class="form-input" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Video URL</label>
                    <input type="url" name="episodes[${newIndex}][video_url]" class="form-input episode-video-url" required>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="episodes[${newIndex}][description]" class="form-input" rows="2"></textarea>
            </div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Duration</label>
                    <div class="duration-display">0:00:00</div>
                    <input type="hidden" name="episodes[${newIndex}][duration]" value="0">
                </div>
            </div>
            
            <input type="hidden" name="episodes[${newIndex}][episode_number]" value="${episodeCount}">
            <input type="hidden" name="episodes[${newIndex}][id]" value="${newId}">
        `;
        
        episodesContainer.appendChild(newEpisode);
        updateTotalEpisodesCount();
        
        // Add event listener for the new remove button
        newEpisode.querySelector('.remove-episode').addEventListener('click', function() {
            showConfirmationModal(newId);
        });
        
        // Add event listener for video URL change to calculate duration
        newEpisode.querySelector('.episode-video-url').addEventListener('change', function() {
            calculateVideoDuration(this);
        });
    });
    
    // Function to update episode numbers after reordering or deletion
    function updateEpisodeNumbers() {
        const episodes = Array.from(document.querySelectorAll('.episode-editor'));
        episodes.forEach((episode, index) => {
            const episodeNumber = index + 1;
            episode.dataset.index = index;
            episode.querySelector('.episode-number').textContent = episodeNumber;
            
            // Update all input names to reflect new index
            episode.querySelectorAll('input, textarea').forEach(input => {
                const name = input.name.replace(/episodes\[\d+\]/, `episodes[${index}]`);
                input.name = name;
            });
            
            // Update episode number in hidden field
            const episodeNumberInput = episode.querySelector('input[name$="[episode_number]"]');
            if (episodeNumberInput) {
                episodeNumberInput.value = episodeNumber;
            }
        });
    }
    
    // Function to update the total episodes count
    function updateTotalEpisodesCount() {
        const totalEpisodes = document.querySelectorAll('.episode-editor').length;
        document.querySelector('input[name="noEpisodes"]').value = totalEpisodes;
        episodeCount = totalEpisodes;
    }
    
    // Function to calculate video duration when URL changes
    function calculateVideoDuration(inputElement) {
        const episodeForm = inputElement.closest('.episode-editor');
        const durationDisplay = episodeForm.querySelector('.duration-display');
        const durationInput = episodeForm.querySelector('input[name$="[duration]"]');
        
        if (!durationDisplay || !durationInput) return;
        
        durationDisplay.textContent = 'Calculating...';
        durationInput.value = '0';
        
        // In a real implementation, you would fetch the actual duration from the video URL
        // This is a mock implementation that simulates the process
        setTimeout(() => {
            const durationInSeconds = Math.floor(Math.random() * 1800) + 60; // Random duration between 1-30 mins
            durationDisplay.textContent = new Date(durationInSeconds * 1000).toISOString().substr(11, 8);
            durationInput.value = durationInSeconds;
            calculateTotalDuration();
        }, 1000);
    }
    
    // Function to calculate total duration of all episodes
    function calculateTotalDuration() {
        let totalSeconds = 0;
        const durationInputs = document.querySelectorAll('input[name$="[duration]"]');
        
        durationInputs.forEach(input => {
            totalSeconds += parseInt(input.value) || 0;
        });
        
        document.querySelector('input[name="total_duration"]').value = totalSeconds;
        document.querySelector('.duration-display').textContent = new Date(totalSeconds * 1000).toISOString().substr(11, 8);
    }
    
    // Add event listeners to all remove buttons
    document.querySelectorAll('.remove-episode').forEach(button => {
        button.addEventListener('click', function() {
            const episodeId = this.dataset.episodeId;
            showConfirmationModal(episodeId);
        });
    });
    
    // Add event listeners to all video URL inputs for duration calculation
    document.querySelectorAll('.episode-video-url').forEach(input => {
        input.addEventListener('change', function() {
            calculateVideoDuration(this);
        });
    });
    
    // Make episodes sortable
    if (typeof Sortable !== 'undefined') {
        new Sortable(episodesContainer, {
            animation: 150,
            handle: '.episode-header',
            onEnd: function() {
                updateEpisodeNumbers();
            }
        });
    } else {
        console.error('SortableJS library not loaded');
        // Fallback behavior if Sortable fails to load
        document.querySelectorAll('.episode-editor .episode-header').forEach(header => {
            header.style.cursor = 'default';
        });
    }
    
    // Form submission handler to prevent duplicate submissions
    const form = document.getElementById('course-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
            }
        });
    }
});
</script>
@endsection