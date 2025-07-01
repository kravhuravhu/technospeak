@extends('layouts.admin')

@section('title', 'Edit Course')

@section('content')
<div class="admin-header">
    <div class="page-title">
        <h1>Edit Course: {{ $course->title }}</h1>
        <p>Update course details and manage episodes</p>
    </div>
</div>

<div class="course-edit-container">
    <!-- Course Edit Form -->
    <form action="{{ route('content-manager.courses.update', $course->id) }}" method="POST" enctype="multipart/form-data" class="course-form">
        @csrf
        @method('PUT')
        @include('content-manager.components.form')
    </form>

    <!-- Episodes Section -->
    <div class="episodes-section">
        <div class="section-header">
            <h3>Course Episodes</h3>
            <button type="button" id="addEpisodeBtn" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Episode
            </button>
        </div>

        @if($course->episodes->count() > 0)
        <div class="episodes-table">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Duration</th>
                        <th>Free</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($course->episodes as $episode)
                    <tr>
                        <td>{{ $episode->episode_number }}</td>
                        <td>{{ $episode->title }}</td>
                        <td>{{ $episode->duration }} min</td>
                        <td>{{ $episode->is_free ? 'Yes' : 'No' }}</td>
                        <td>
                            <a href="{{ route('content-manager.courses.episodes.edit', [$course, $episode]) }}" class="btn btn-sm btn-outline">Edit</a>
                            <form action="{{ route('content-manager.courses.episodes.destroy', [$course, $episode]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="no-episodes">
            <p>No episodes added yet.</p>
        </div>
        @endif
    </div>
</div>

<!-- Add Episode Modal -->
<div id="episodeModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Add New Episode</h2>
        <form id="episodeForm">
            @csrf
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            
            <div class="form-group">
                <label for="modal_title">Title *</label>
                <input type="text" id="modal_title" name="title" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="modal_episode_number">Episode Number *</label>
                <input type="number" id="modal_episode_number" name="episode_number" class="form-control" 
                       min="1" max="{{ $course->noEpisodes }}" required>
            </div>
            
            <div class="form-group">
                <label for="modal_video_url">Video URL *</label>
                <input type="url" id="modal_video_url" name="video_url" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="modal_duration">Duration (minutes) *</label>
                <input type="number" id="modal_duration" name="duration" class="form-control" min="1" required>
            </div>
            
            <div class="form-group">
                <label for="modal_description">Description</label>
                <textarea id="modal_description" name="description" class="form-control" rows="3"></textarea>
            </div>
            
            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" id="modal_is_free" name="is_free" class="form-check-input" value="1">
                    <label for="modal_is_free" class="form-check-label">Free Episode</label>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Add Episode</button>
                <button type="button" class="btn btn-outline" id="cancelEpisodeBtn">Cancel</button>
            </div>
        </form>
    </div>
</div>

<style>
/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1050;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    border-radius: 8px;
    width: 50%;
    max-width: 600px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
}

/* Episodes Table Styles */
.episodes-section {
    margin-top: 2rem;
    padding: 1.5rem;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.episodes-table table {
    width: 100%;
    border-collapse: collapse;
}

.episodes-table th, 
.episodes-table td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #e0e0e0;
}

.episodes-table th {
    background-color: #f8f9fa;
    font-weight: 600;
}

.no-episodes {
    padding: 2rem;
    text-align: center;
    color: #6c757d;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal elements
    const modal = document.getElementById('episodeModal');
    const addBtn = document.getElementById('addEpisodeBtn');
    const closeBtn = document.querySelector('.close');
    const cancelBtn = document.getElementById('cancelEpisodeBtn');
    
    // Show modal when Add Episode button is clicked
    if (addBtn) {
        addBtn.addEventListener('click', function() {
            if (modal) modal.style.display = 'block';
        });
    }
    
    // Close modal when X is clicked
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            if (modal) modal.style.display = 'none';
        });
    }
    
    // Close modal when Cancel button is clicked
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function() {
            if (modal) modal.style.display = 'none';
        });
    }
    
    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
    
document.getElementById('episodeForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    try {
        const formData = new FormData(this);
        const response = await fetch("{{ route('content-manager.courses.episodes.store', $course) }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: formData
        });

        const data = await response.json();
        
        if (!response.ok) {
            if (response.status === 422 && data.errors) {
                // Display validation errors
                let errorMessages = [];
                for (const [field, errors] of Object.entries(data.errors)) {
                    errorMessages.push(...errors);
                }
                alert('Validation errors:\n' + errorMessages.join('\n'));
                return;
            }
            throw new Error(data.message || 'Unknown error occurred');
        }

        if (data.success) {
            window.location.reload();
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred: ' + error.message);
    }
});
});
</script>
@endsection