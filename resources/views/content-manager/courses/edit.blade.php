@extends('layouts.admin')

@section('title', 'Edit Course: ' . $course->title)

@section('content')
<style>
    .section-title {
        color: var(--skBlue);
        margin-bottom: 1.5rem;
        font-size: 1.25rem;
        font-weight: 600;
    }
    .episode-form {
        padding: 1rem;
        margin-bottom: 1.5rem;
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        & > .form-row {
            margin-bottom: 0;
            & > .form-group {
                & > .form-label {
                    &.episode_id {
                        font-weight: 600;
                        font-size: 1.15em;
                        color: #253f6b;
                    }
                }
                &.fr_remove_episode {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    width: fit-content;
                    flex: none;
                    & > button {
                        margin-top: 16px;
                    }
                }
            }
        }
    }
    .old-value {
        color: #666;
        font-size: 0.9rem;
        margin-top: 0.25rem;
        font-style: italic;
        opacity: 0.8;
    }
    input::placeholder,
    textarea::placeholder,
    select::placeholder {
        color: #888;
        opacity: .3; 
    }
    input:focus::placeholder,
    textarea:focus::placeholder {
        color: #bbb;
    }
    input[disabled],
    input[readonly],
    textarea[disabled],
    textarea[readonly],
    select[disabled] {
        background-color: #f5f5f5;
        color: #999;
        cursor: not-allowed;
        opacity: 0.7;
    }
    input[disabled]:focus,
    input[readonly]:focus,
    textarea[disabled]:focus,
    textarea[readonly]:focus,
    select[disabled]:focus {
        border: none;
    }
    .form-control {
        &.episode-description {
            min-height: auto;
            padding: 0.2rem 1rem;
            resize: both;
        }
    }
    .calculating {
        color: var(--skBlue);
        font-style: italic;
    }
</style>

<div class="admin-header">
    <div class="page-title">
        <h1>Edit Course: {{ $course->title }}</h1>
        <p>Update course details and content | CourseID • {{ $course->id }}</p>
    </div>
    <div class="user-menu">
        <a href="{{ route('content-manager.courses.show', $course->id) }}" class="btn btn-outline">
            <i class="fas fa-eye"></i> Preview
        </a>
        <form action="{{ route('content-manager.courses.destroy', $course->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                <i class="fas fa-trash"></i> Delete Course
            </button>
        </form>
    </div>
</div>

<form action="{{ route('content-manager.courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <!-- Course Details Section -->
    <div class="form-card" style="border-left: 4px solid var(--skBlue);">
        <h3 class="section-title">Course Details</h3>   
        <div class="form-row">
            <div class="form-group">
                <label for="title" class="form-label">Course Title</label>
                <input type="text" id="title" name="title" class="form-control" 
                    value="{{ old('title', $course->title) }}" 
                    placeholder="Google Cloud Fundamentals" required>
                <div class="old-value">Current: {{ $course->title }}</div>
            </div>
            <div class="form-group">
                <label for="catch_phrase" class="form-label">Catch Phrase <span style="font-weight: normal;font-style:italic;">(50–90 characters)</span></label>
                <input type="text" id="catch_phrase" name="catch_phrase" class="form-control"
                    value="{{ old('catch_phrase', $course->catch_phrase) }}"
                    minlength="50" maxlength="90"
                    placeholder="Jumpstart your career with Google Workspace essentials" required>
                <div class="old-value">Current: {{ $course->catch_phrase }}</div>
                @error('catch_phrase')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="description" class="form-label">Course Description</label>
                <textarea id="description" name="description" class="form-control" rows="5"
                    placeholder="Briefly describe what the course covers, who it's for, and key takeaways." required>{{ old('description', $course->description) }}</textarea>
                <div class="old-value">Current: {{ Str::limit($course->description, 100) }}</div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="category_id" class="form-label">Category</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $course->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <div class="old-value">Current: {{ $course->category->name }}</div>
            </div>
            <div class="form-group">
                <label for="instructor_id" class="form-label">Instructor</label>
                <select id="instructor_id" name="instructor_id" class="form-control" required>
                    <option value="">Select Instructor</option>
                    @foreach($instructors as $instructor)
                        <option value="{{ $instructor->id }}" {{ old('instructor_id', $course->instructor_id) == $instructor->id ? 'selected' : '' }}>
                            {{ $instructor->name }}
                        </option>
                    @endforeach
                </select>
                <div class="old-value">Current: {{ $course->instructor->name }}</div>
            </div>
            <div class="form-group">
                <label for="plan_type" class="form-label">Plan Type</label>
                <select id="plan_type" name="plan_type" class="form-control" required>
                    <option value="free" {{ old('plan_type', $course->plan_type) == 'free' ? 'selected' : '' }}>Free</option>
                    <option value="paid" {{ old('plan_type', $course->plan_type) == 'paid' ? 'selected' : '' }}>Paid</option>
                </select>
                <div class="old-value">Current: {{ ucfirst($course->plan_type) }}</div>
            </div>
            <div class="form-group">
                <label for="level" class="form-label">Level</label>
                <select id="level" name="level" class="form-control" required>
                    @foreach(['beginner', 'intermediate', 'advanced', 'expert', 'all levels'] as $lvl)
                        <option value="{{ $lvl }}" {{ old('level', $course->level) == $lvl ? 'selected' : '' }}>
                            {{ ucfirst($lvl) }}
                        </option>
                    @endforeach
                </select>
                <div class="old-value">Current: {{ ucfirst($course->level) }}</div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="thumbnail" class="form-label">Thumbnail URL</label>
                <input type="url" id="thumbnail" name="thumbnail" class="form-control" 
                    value="{{ old('thumbnail', $course->thumbnail) }}" 
                    placeholder="https://example.com/thumbnail.jpg" required>
                <div class="old-value">Current: <a href="{{ $course->thumbnail }}" target="_blank">View Thumbnail</a></div>
            </div>
            <div class="form-group">
                <label for="software_app_icon" class="form-label">Software/App Icon URL</label>
                <input type="url" id="software_app_icon" name="software_app_icon" class="form-control" 
                    value="{{ old('software_app_icon', $course->software_app_icon) }}" 
                    placeholder="https://example.com/icon.png" required>
                <div class="old-value">Current: <a href="{{ $course->software_app_icon }}" target="_blank">View Icon</a></div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="total_episodes" class="form-label">Total Episodes</label>
                <input type="number" id="total_episodes" name="noEpisodes" class="form-control" 
                    value="{{ old('noEpisodes', $course->episodes->count()) }}" readonly>
                <div class="old-value">Current: {{ $course->episodes->count() }} episodes</div>
            </div>
            <div class="form-group">
                <label class="form-label">Total Duration</label>
                <input type="hidden" id="total_duration_seconds" name="total_duration" 
                    value="{{ old('total_duration', $course->total_duration) }}">
                <div class="form-control" style="background-color: #f8f9fa; cursor: not-allowed;">
                    <span id="total_duration_display">
                        @php
                            $hours = floor($course->total_duration / 3600);
                            $minutes = floor(($course->total_duration % 3600) / 60);
                            $seconds = $course->total_duration % 60;
                            
                            if ($hours > 0) {
                                echo "{$hours}h {$minutes}m {$seconds}s";
                            } elseif ($minutes > 0) {
                                echo "{$minutes}m {$seconds}s";
                            } else {
                                echo "{$seconds}s";
                            }
                        @endphp
                    </span>
                </div>
                <div class="old-value">Current: {{ gmdate('H:i:s', $course->total_duration) }}</div>
            </div>
        </div>
    </div>

    <!-- Episodes Section -->
    <div class="form-card" style="background-color: #f3f3f3; border-left: 4px solid var(--skBlue);">
        <h3 class="section-title">Course Episodes</h3>

        <template id="episodeTemplate">
            <div class="episode-form" data-episode-index="__INDEX__">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label episode_id">Episode #<span class="episode-number">__NUMBER__</span></label>
                        <input type="hidden" name="episodes[__INDEX__][episode_number]" value="__NUMBER__">
                        <input type="hidden" name="episodes[__INDEX__][id]" value="__ID__">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Episode Title</label>
                        <input type="text" name="episodes[__INDEX__][title]" class="form-control" placeholder="Introduction to Google Cloud" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Episode Description <span style="font-weight: normal;font-style:italic;">(optional)</span></label>
                        <textarea name="episodes[__INDEX__][description]" class="form-control episode-description" rows="2"
                            placeholder="Brief summary of what this episode covers."></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Video URL</label>
                        <input type="url" name="episodes[__INDEX__][video_url]" class="form-control episode-video-url"
                            placeholder="https://example.com/episode1.mp4" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Duration (seconds)</label>
                        <input type="number" name="episodes[__INDEX__][duration]" class="form-control episode-duration" 
                            placeholder="Auto-calculated" readonly>
                        <div class="calculating" style="display: none;">Calculating duration...</div>
                    </div>
                    <div class="form-group fr_remove_episode">
                        <button type="button" class="remove-episode-btn btn btn-danger btn-sm mt-2">Remove</button>
                    </div>
                </div>
            </div>
        </template>

        <div id="episodesContainer">
            @foreach($course->episodes as $index => $episode)
                <div class="episode-form" data-episode-index="{{ $index }}">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label episode_id">Episode #<span class="episode-number">{{ $episode->episode_number }}</span></label>
                            <input type="hidden" name="episodes[{{ $index }}][episode_number]" value="{{ $episode->episode_number }}">
                            <input type="hidden" name="episodes[{{ $index }}][id]" value="{{ $episode->id }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Episode Title</label>
                            <input type="text" name="episodes[{{ $index }}][title]" class="form-control" 
                                value="{{ old("episodes.$index.title", $episode->title) }}" 
                                placeholder="Introduction to Google Cloud" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Episode Description <span style="font-weight: normal;font-style:italic;">(optional)</span></label>
                            <textarea name="episodes[{{ $index }}][description]" class="form-control episode-description" rows="2"
                                placeholder="Brief summary of what this episode covers.">{{ old("episodes.$index.description", $episode->description) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Video URL</label>
                            <input type="url" name="episodes[{{ $index }}][video_url]" class="form-control episode-video-url"
                                value="{{ old("episodes.$index.video_url", $episode->video_url) }}"
                                placeholder="https://example.com/episode1.mp4" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Duration <span style="font-weight: normal;font-style:italic;">(seconds)</span></label>
                            <input type="number" name="episodes[{{ $index }}][duration]" class="form-control episode-duration" 
                                value="{{ old("episodes.$index.duration", $episode->duration) }}"
                                placeholder="Auto-calculated" readonly>
                            <div class="calculating" style="display: none;">Calculating duration...</div>
                        </div>
                        <div class="form-group fr_remove_episode">
                            <button type="button" class="remove-episode-btn btn btn-danger btn-sm mt-2">Remove</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="button" id="addEpisodeBtn" class="btn btn-outline mt-3">
            <i class="fas fa-plus"></i> Add Another Episode
        </button>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="{{ route('content-manager.courses.show', $course->id) }}" class="btn btn-outline">Cancel</a>
    </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let episodeCount = {{ $course->episodes->count() }};
        let nextNewEpisodeId = -1; 

        function init() {
            bindAddEpisodeButton();
            bindVideoUrlChange();
            bindRemoveEpisode();
            updateEpisodeStats();
            
            Sortable.create(document.getElementById('episodesContainer'), {
                handle: '.episode_id',
                animation: 150,
                onEnd: function () {
                    reorderEpisodes();
                    updateEpisodeStats();
                }
            });
            
            // Check for duplicate titles
            document.addEventListener('input', function (e) {
                if (e.target.matches('.form-control[name*="[title]"]')) {
                    checkDuplicateTitles();
                }
            });

            document.querySelectorAll('.episode-video-url').forEach(input => {
                if (input.value) {
                    calculateDuration(input);
                }
            });
        }

        function bindAddEpisodeButton() {
            const btn = document.getElementById('addEpisodeBtn');
            if (btn) {
                btn.addEventListener('click', () => {
                    addEpisode();
                    setTimeout(updateEpisodeStats, 100);
                });
            }
        }

        function bindVideoUrlChange() {
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('episode-video-url')) {
                    calculateDuration(e.target);
                }
            });
        }

        function calculateDuration(videoUrlInput) {
            const episodeForm = videoUrlInput.closest('.episode-form');
            const durationField = episodeForm.querySelector('.episode-duration');
            const calculatingText = episodeForm.querySelector('.calculating');
            const videoUrl = videoUrlInput.value.trim();

            if (!videoUrl) {
                durationField.value = '';
                return;
            }

            calculatingText.style.display = 'block';
            durationField.value = '';

            const video = document.createElement('video');
            video.preload = 'metadata';
            video.src = videoUrl;
            
            video.onloadedmetadata = function() {
                const duration = Math.floor(video.duration);
                durationField.value = duration;
                calculatingText.style.display = 'none';
                updateEpisodeStats();
            };
            
            video.onerror = function() {
                calculatingText.style.display = 'none';
                durationField.value = '0';
                updateEpisodeStats();
            };
        }

        function addEpisode() {
            episodeCount++;
            nextNewEpisodeId--;
            
            const template = document.getElementById('episodeTemplate');
            const newEpisode = template.content.firstElementChild.cloneNode(true);
            
            // Replace all placeholders
            const newEpisodeHtml = newEpisode.outerHTML
                .replace(/__INDEX__/g, episodeCount)
                .replace(/__NUMBER__/g, episodeCount)
                .replace(/__ID__/g, nextNewEpisodeId);
            
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = newEpisodeHtml;
            const finalNewEpisode = tempDiv.firstChild;
            
            // Set up event listeners
            const videoUrlInput = finalNewEpisode.querySelector('.episode-video-url');
            videoUrlInput.addEventListener('change', function() {
                calculateDuration(this);
            });
            
            const removeBtn = finalNewEpisode.querySelector('.remove-episode-btn');
            removeBtn.addEventListener('click', function() {
                finalNewEpisode.remove();
                updateEpisodeStats();
            });
            
            document.getElementById('episodesContainer').appendChild(finalNewEpisode);
        }

        function bindRemoveEpisode() {
            document.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-episode-btn')) {
                    const form = e.target.closest('.episode-form');
                    form.remove();
                    updateEpisodeStats();
                }
            });
        }

        function updateEpisodeStats() {
            const forms = document.querySelectorAll('.episode-form');
            const totalEpisodes = forms.length;
            let totalSeconds = 0;

            forms.forEach(form => {
                const durField = form.querySelector('.episode-duration');
                if (durField && durField.value) {
                    totalSeconds += parseInt(durField.value) || 0;
                }
            });

            document.getElementById('total_episodes').value = totalEpisodes;
            document.getElementById('total_duration_seconds').value = totalSeconds;
            document.getElementById('total_duration_display').textContent = formatDurationForDisplay(totalSeconds);
        }

        function formatDurationForDisplay(totalSeconds) {
            totalSeconds = Math.floor(totalSeconds);
            const h = Math.floor(totalSeconds / 3600);
            const m = Math.floor((totalSeconds % 3600) / 60);
            const s = totalSeconds % 60;
            
            let parts = [];
            if (h > 0) parts.push(`${h}h`);
            if (m > 0) parts.push(`${m}m`);
            if (s > 0 || parts.length === 0) parts.push(`${s}s`);
            
            return parts.join(' ');
        }

        function reorderEpisodes() {
            const forms = document.querySelectorAll('.episode-form');
            forms.forEach((form, index) => {
                const newNumber = index + 1;
                form.querySelector('.episode-number').textContent = newNumber;
                form.querySelector('input[name$="[episode_number]"]').value = newNumber;

                form.querySelectorAll('input, textarea, select').forEach(input => {
                    const name = input.name.replace(/episodes\[\d+\]/, `episodes[${index}]`);
                    input.name = name;
                });
            });
        }

        function checkDuplicateTitles() {
            const titles = [];
            const fields = document.querySelectorAll('input[name*="[title]"]');
            fields.forEach(field => {
                const val = field.value.trim().toLowerCase();
                if (titles.includes(val)) {
                    field.setCustomValidity('Duplicate episode title.');
                } else {
                    field.setCustomValidity('');
                    if (val) titles.push(val);
                }
            });
        }
        
        init();
    });
</script>
@endsection