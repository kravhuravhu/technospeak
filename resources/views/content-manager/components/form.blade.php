<!-- Course Details Section -->
<div class="form-card" style="border-left: 4px solid var(--skBlue);">
    <h3 class="section-title">Course Details</h3>   
    <div class="form-row">
        <div class="form-group">
            <label for="title" class="form-label">Course Title</label>
            <input type="text" id="title" name="title" class="form-control" placeholder="Google Cloud Fundamentals" required>
        </div>
        <div class="form-group">
                <label for="catch_phrase" class="form-label">Catch Phrase <span style="font-weight: normal;font-style:italic;">(50–90 characters)</span></label>
            <input type="text" id="catch_phrase" name="catch_phrase" class="form-control"
                value="{{ old('catch_phrase', $course->catch_phrase ?? '') }}"
                minlength="50" maxlength="90"
                placeholder="Jumpstart your career with Google Workspace essentials" required>
            @error('catch_phrase')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="form-row">
        <div class="form-group">
            <label for="description" class="form-label">Course Description</label>
            <textarea id="description" name="description" class="form-control" rows="5"
                placeholder="Briefly describe what the course covers, who it's for, and key takeaways." required></textarea>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group">
            <label for="category_id" class="form-label">Category</label>
            <select id="category_id" name="category_id" class="form-control" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="instructor_id" class="form-label">Instructor</label>
            <select id="instructor_id" name="instructor_id" class="form-control" required>
                <option value="">Select Instructor</option>
                @foreach($instructors as $instructor)
                    <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="plan_type" class="form-label">Plan Type</label>
            <select id="plan_type" name="plan_type" class="form-control" required>
                <option value="free">Free</option>
                <option value="paid">Paid</option>
                <option value="frml_training">Formal Training</option>
            </select>
        </div>
        <div class="form-group">
            <label for="level" class="form-label">Level</label>
            <select id="level" name="level" class="form-control" required>
                @foreach(['beginner', 'intermediate', 'advanced', 'expert', 'all levels'] as $lvl)
                    <option value="{{ $lvl }}">{{ ucfirst($lvl) }}</option>
                @endforeach
            </select>
        </div>
        <!-- price appears only if plan is formal-->
        <div class="form-group" id="price-group" style="display:none;">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" id="price" name="price" class="form-control" placeholder="Rands">
        </div>
    </div>
    <div class="form-row" style="padding:20px 0">
        <label for="has_certificate" class="form-label">
            <input type="checkbox" id="has_certificate" name="has_certificate" value="1"
                {{ old('has_certificate', $course->has_certificate ?? false) ? 'checked' : '' }}>
            Course has certificate?
        </label>
    </div>
    <div class="form-row">
        <div class="form-group">
            <label for="thumbnail" class="form-label">Thumbnail URL</label>
            <input type="url" id="thumbnail" name="thumbnail" class="form-control" placeholder="https://example.com/thumbnail.jpg | drag & drop" required ondrop="handleImageDrop(event, 'thumbnail')" ondragover="event.preventDefault();">
            <img id="thumbnailPreview" src="" alt="Thumbnail Preview" style="margin-top: 0.5rem; max-width: 120px; display: none; border-radius: 4px; border: 1px solid #ccc;">
        </div>
        <div class="form-group">
            <label for="software_app_icon" class="form-label">Software/App Icon URL</label>
            <input type="url" id="software_app_icon" name="software_app_icon" class="form-control" placeholder="https://example.com/icon.png | drag & drop" required ondrop="handleImageDrop(event, 'software_app_icon')" ondragover="event.preventDefault();">
            <img id="iconPreview" src="" alt="Icon Preview" style="margin-top: 0.5rem; max-width: 48px; display: none; border-radius: 4px; border: 1px solid #ccc;">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group">
            <label for="total_episodes" class="form-label">Total Episodes</label>
            <input type="number" id="total_episodes" name="noEpisodes" class="form-control" value="0" readonly>
        </div>
        <div class="form-group">
            <label class="form-label">Total Duration</label>
            <input type="hidden" id="total_duration_seconds" name="total_duration" value="0">
            <div class="form-control" style="background-color: #f8f9fa; cursor: not-allowed;">
                <span id="total_duration_display">0 s</span>
            </div>
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
                    <label class="form-label">Duration <span style="font-weight: normal;font-style:italic;">(seconds)</span></label>
                    <input type="text" name="episodes[__INDEX__][duration]" class="form-control episode-duration" style="cursor: not-allowed;" readonly>
                </div>
                <div class="form-group">
                    <label class="form-label">Video Preview</label>
                    <iframe class="episode-video-preview" width="100%" height="70" style="display:none;border:1px solid #ccc;border-radius:6px;"></iframe>
                </div>
                <div class="form-group fr_remove_episode">
                    <button type="button" class="remove-episode-btn btn btn-danger btn-sm mt-2">Remove</button>
                </div>
            </div>
        </div>
    </template>

    <div id="episodesContainer"></div>

    <button type="button" id="addEpisodeBtn" class="btn btn-outline mt-3">
        <i class="fas fa-plus"></i> Add Another Episode
    </button>
</div>

<!-- Resources Section -->
<div class="form-card" style="border-left: 4px solid var(--skGreen);">
    <h3 class="section-title">Course Resources <i>(optional)</i></h3>
    
    <template id="resourceTemplate">
        <div class="resource-form" data-resource-index="__INDEX__">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Resource Title</label>
                    <input type="text" name="resources[__INDEX__][title]" class="form-control" placeholder="Course Workbook PDF">
                </div>
                <div class="form-group">
                    <label class="form-label">File URL</label>
                    <input type="url" name="resources[__INDEX__][file_url]" class="form-control resource-file-url" 
                           placeholder="https://example.com/resource.pdf" 
                           ondrop="handleResourceDrop(event, this)" 
                           ondragover="event.preventDefault();">
                    <input type="hidden" name="resources[__INDEX__][file_size]" value="0">
                    <div class="file-info" style="margin-top: 5px;">
                        <small>Type: <span class="file-type">Not detected</span> | Size: <span class="file-size">0 Bytes</span></small>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Resource Type</label>
                    <select name="resources[__INDEX__][resource_type_id]" class="form-control resource-type">
                        <option value="">Select Type</option>
                        @foreach($resourceTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Thumbnail URL <i>(optional)</i></label>
                    <input type="url" name="resources[__INDEX__][thumbnail_url]" class="form-control" placeholder="https://example.com/thumbnail.jpg">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="resources[__INDEX__][description]" class="form-control" rows="2" placeholder="Brief description of this resource"></textarea>
                </div>
            </div>
            <button type="button" class="remove-resource-btn btn btn-danger btn-sm mt-2">Remove Resource</button>
            <hr>
        </div>
    </template>

    <div id="resourcesContainer"></div>

    <button type="button" id="addResourceBtn" class="btn btn-outline mt-3">
        <i class="fas fa-plus"></i> Add Resource
    </button>
</div>

<div class="form-actions">
    <button type="submit" class="btn btn-primary">Create Course</button>
    <a href="{{ route('content-manager.courses.index') }}" class="btn btn-outline">Cancel</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let episodeCount = 0;
        let resourceCount = 0;

        function init() {
            initImagePreview();
            initImageDrop();
            bindAddEpisodeButton();
            bindDurationInput();
            handleVideoUrlChange();
            bindRemoveEpisode();
            addEpisode(); 
            bindAddResourceButton();
            Sortable.create(document.getElementById('episodesContainer'), {
                handle: '.episode_id',
                animation: 150,
                onEnd: function () {
                    reorderEpisodes();
                    updateEpisodeStats();
                }
            });
            document.addEventListener('input', function (e) {
                if (e.target.matches('.form-control[name*="[title]"]')) {
                    checkDuplicateTitles();
                }
            });
            // Update the video duration handler:
            document.addEventListener('change', function(e) {
                if (!e.target.classList.contains('episode-video-url')) return;

                const videoUrl = e.target.value;
                const episodeForm = e.target.closest('.episode-form');
                const durationField = episodeForm.querySelector('.episode-duration');

                if (!durationField || !videoUrl) return;

                durationField.value = 'Calculating...';

                getVideoDurationFromUrl(videoUrl, function(duration) {
                    if (duration) {
                        durationField.value = Math.floor(duration);
                        updateEpisodeStats();
                    } else {
                        durationField.value = '0:00';
                    }
                });
            });
            // add price if type is formal trainings
            document.getElementById('plan_type').addEventListener('change', function() {
                let priceGroup = document.getElementById('price-group');
                if (this.value === 'frml_training') {
                    priceGroup.style.display = 'block';
                } else {
                    priceGroup.style.display = 'none';
                    document.getElementById('price').value = '';
                }
            });
        }

        function initImagePreview() {
            const thumbnailInput = document.getElementById('thumbnail');
            const thumbnailPreview = document.getElementById('thumbnailPreview');
            const iconInput = document.getElementById('software_app_icon');
            const iconPreview = document.getElementById('iconPreview');

            function showPreview(input, preview) {
                const url = input.value.trim();
                if (url.startsWith('http://') || url.startsWith('https://')) {
                    preview.src = url;
                    preview.style.display = 'block';
                } else {
                    preview.src = '';
                    preview.style.display = 'none';
                }
            }

            thumbnailInput?.addEventListener('input', () => showPreview(thumbnailInput, thumbnailPreview));
            iconInput?.addEventListener('input', () => showPreview(iconInput, iconPreview));

            showPreview(thumbnailInput, thumbnailPreview);
            showPreview(iconInput, iconPreview);
        }

        function initImageDrop() {
            window.handleImageDrop = function (event, inputId) {
                event.preventDefault();
                const input = document.getElementById(inputId);
                const previewId = inputId === 'thumbnail' ? 'thumbnailPreview' : 'iconPreview';
                const preview = document.getElementById(previewId);
                const data = event.dataTransfer.getData('text/uri-list') || event.dataTransfer.getData('text/plain');

                if (data.startsWith('http://') || data.startsWith('https://')) {
                    input.value = data;
                    preview.src = data;
                    preview.style.display = 'block';
                }
            }
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

        function addEpisode() {
            episodeCount++;
            
            const template = document.getElementById('episodeTemplate');
            const newEpisode = template.content.firstElementChild.cloneNode(true);
            
            // Use the current episodeCount as the index (not episodeCount - 1)
            newEpisode.dataset.episodeIndex = episodeCount;
            
            newEpisode.querySelectorAll('input, textarea').forEach(input => {
                // Use the current count as the index
                input.name = input.name.replace(/__INDEX__/g, episodeCount);
                if (input.classList.contains('episode-video-url') || input.classList.contains('episode-duration')) {
                    input.value = '';
                }
            });
            
            newEpisode.querySelector('.episode-number').textContent = episodeCount;
            newEpisode.querySelector('input[name$="[episode_number]"]').value = episodeCount;
            
            const removeBtn = newEpisode.querySelector('.remove-episode-btn');
            if (episodeCount === 1) {
                removeBtn.style.display = 'none';
            } else {
                removeBtn.style.display = 'inline-block';
                removeBtn.addEventListener('click', function() {
                    newEpisode.remove();
                    updateEpisodeStats();
                });
            }
            
            document.getElementById('episodesContainer').appendChild(newEpisode);
            updateEpisodeStats();
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
                if (!durField) return;

                const value = durField.value.trim();
                const seconds = Number(value);

                if (!isNaN(seconds) && seconds > 0) {
                    totalSeconds += seconds;
                }
            });

            document.getElementById('total_episodes').value = totalEpisodes;
            document.getElementById('total_duration_seconds').value = totalSeconds;
            document.getElementById('total_duration_display').textContent = formatDurationForDisplay(totalSeconds);
        }

        // format duration display
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

        function formatDuration(totalSeconds) {
            totalSeconds = Math.floor(totalSeconds);
            const m = Math.floor(totalSeconds / 60);
            const s = totalSeconds % 60;
            return `${m}:${s.toString().padStart(2, '0')}`;
        }

        function bindDurationInput() {
            document.addEventListener('input', function (e) {
                if (e.target.classList.contains('episode-duration')) {
                    updateEpisodeStats();
                }
            });

            document.addEventListener('change', function (e) {
                if (e.target.classList.contains('episode-video-url')) {
                    const durField = e.target.closest('.episode-form')?.querySelector('.episode-duration');
                    if (!durField) return;
                    const observer = new MutationObserver(updateEpisodeStats);
                    observer.observe(durField, { attributes: true, childList: true, subtree: true });
                    setTimeout(updateEpisodeStats, 1000);
                }
            });
        }

        function handleVideoUrlChange() {
            document.addEventListener('change', function (e) {
                if (!e.target.classList.contains('episode-video-url')) return;

                const videoUrl = e.target.value;
                const episodeForm = e.target.closest('.episode-form');
                const previewFrame = episodeForm.querySelector('.episode-video-preview');

                if (previewFrame && videoUrl) {
                    previewFrame.src = videoUrl;
                    previewFrame.style.display = 'block';
                } else if (previewFrame) {
                    previewFrame.style.display = 'none';
                    previewFrame.src = '';
                }
            });
        }

        function reorderEpisodes() {
            const forms = document.querySelectorAll('.episode-form');
            forms.forEach((form, index) => {
                form.querySelector('.episode-number').textContent = index + 1;
                form.querySelector('input[name$="[episode_number]"]').value = index + 1;

                form.querySelectorAll('input, textarea, select').forEach(input => {
                    input.name = input.name.replace(/episodes\[\d+\]/, `episodes[${index}]`);
                });

                const removeBtn = form.querySelector('.remove-episode-btn');
                removeBtn.style.display = index === 0 ? 'none' : 'inline-block';
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

        function getVideoDurationFromUrl(url, callback) {
            const video = document.createElement('video');
            video.preload = 'metadata';
            video.src = url;
            video.onloadedmetadata = function() {
                const duration = video.duration;
                callback(duration);
            };
            video.onerror = function() {
                callback(null);
            };
        }

        // resourse handle
        function bindAddResourceButton() {
            const btn = document.getElementById('addResourceBtn');
            if (btn) {
                btn.addEventListener('click', () => {
                    addResource();
                });
            }
        }

        function addResource() {
            resourceCount++;
            
            const template = document.getElementById('resourceTemplate');
            const newResource = template.content.firstElementChild.cloneNode(true);
            
            newResource.dataset.resourceIndex = resourceCount;
            
            newResource.querySelectorAll('input, textarea, select').forEach(input => {
                input.name = input.name.replace(/__INDEX__/g, resourceCount);
            });
            
            const removeBtn = newResource.querySelector('.remove-resource-btn');
            removeBtn.addEventListener('click', function() {
                newResource.remove();
            });

            const fileUrlInput = newResource.querySelector('.resource-file-url');
            fileUrlInput.addEventListener('change', function() {
                const fileInfo = newResource.querySelector('.file-info');
                if (this.value) {
                    getFileInfoFromUrl(this.value, function(info) {
                        if (info) {
                            newResource.querySelector('.file-type').textContent = info.type || 'Unknown';
                            newResource.querySelector('.file-size').textContent = formatFileSize(info.size);

                            let sizeInput = newResource.querySelector('input[name$="[file_size]"]');
                            if (!sizeInput) {
                                sizeInput = document.createElement('input');
                                sizeInput.type = 'hidden';
                                sizeInput.name = this.name.replace('file_url', 'file_size');
                                newResource.appendChild(sizeInput);
                            }
                            sizeInput.value = info.size;
                        }
                    });
                }
            });
            
            document.getElementById('resourcesContainer').appendChild(newResource);
        }

        function getFileInfoFromUrl(url, callback) {
            fetch(url, { method: 'HEAD' })
                .then(response => {
                    if (response.ok) {
                        const contentType = response.headers.get('content-type');
                        const contentLength = response.headers.get('content-length');
                        
                        if (contentLength) {
                            callback({
                                type: contentType || getFileExtensionFromUrl(url),
                                size: parseInt(contentLength)
                            });
                            return;
                        }
                    }
                    
                    fetch(url)
                        .then(response => response.blob())
                        .then(blob => {
                            callback({
                                type: blob.type || getFileExtensionFromUrl(url),
                                size: blob.size
                            });
                        })
                        .catch(() => {
                            callback({
                                type: getFileExtensionFromUrl(url),
                                size: 0
                            });
                        });
                })
                .catch(() => {
                    fetch(url)
                        .then(response => response.blob())
                        .then(blob => {
                            callback({
                                type: blob.type || getFileExtensionFromUrl(url),
                                size: blob.size
                            });
                        })
                        .catch(() => {
                            callback({
                                type: getFileExtensionFromUrl(url),
                                size: 0
                            });
                        });
                });
        }

        function getFileExtensionFromUrl(url) {
            const filename = url.split('/').pop();
            const extension = filename.split('.').pop();
            return extension ? `.${extension}` : 'Unknown';
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function handleResourceDrop(event, inputElement) {
            event.preventDefault();
            const data = event.dataTransfer.getData('text/uri-list') || event.dataTransfer.getData('text/plain');
            
            if (data.startsWith('http://') || data.startsWith('https://')) {
                inputElement.value = data;
                const event = new Event('change');
                inputElement.dispatchEvent(event);
            }
        }
        
        init();
    });
</script>