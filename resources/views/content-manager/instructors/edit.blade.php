@extends('layouts.admin')

@section('title', 'Edit Instructor')

@section('content')

<style>
    .form-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    .form-group {
        flex: 1;
        min-width: 200px;
    }
    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #334155;
    }
    .form-control {
        width: 100%;
        padding: 0.5rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 4px;
        transition: border-color 0.2s;
    }
    .form-control:focus {
        outline: none;
        border-color: var(--skBlue);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        padding: 1rem 0;
    }
    .admin-header {
        margin-bottom: 2rem;
    }
    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }
    .feature-container {
        border: 1px solid #e2e8f0;
        border-radius: 4px;
        padding: 1rem;
        margin-bottom: 1rem;
        background-color: #f8fafc;
        transition: all 0.2s;
    }
    .feature-container:hover {
        border-color: #cbd5e1;
    }
    .feature-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }
    .feature-title {
        font-weight: 500;
        color: #334155;
    }
    .remove-feature {
        color: #ef4444;
        cursor: pointer;
        background: none;
        border: none;
        font-size: 1.2rem;
        padding: 0.25rem;
        border-radius: 4px;
    }
    .remove-feature:hover {
        background-color: #fee2e2;
    }
    .add-feature {
        background-color: #f0fdf4;
        border: 1px dashed #86efac;
        border-radius: 4px;
        padding: 0.75rem;
        text-align: center;
        cursor: pointer;
        margin-bottom: 1rem;
        color: #166534;
        font-weight: 500;
        transition: all 0.2s;
    }
    .add-feature:hover {
        background-color: #dcfce7;
        border-color: #4ade80;
    }
    .icon-prefix {
        display: flex;
        align-items: center;
    }
    .icon-prefix-text {
        padding: 0.5rem;
        background-color: #e2e8f0;
        border: 1px solid #e2e8f0;
        border-right: none;
        border-radius: 4px 0 0 4px;
        font-size: 0.875rem;
        color: #64748b;
    }
    .icon-input {
        border-radius: 0 4px 4px 0 !important;
        flex: 1;
    }
    .preview-icon {
        margin-left: 0.5rem;
        color: #64748b;
    }
    .thumbnail-preview {
        margin-top: 0.5rem;
        max-width: 100px;
        max-height: 100px;
        border-radius: 4px;
        display: none;
    }
    .empty-state {
        color: #64748b;
        text-align: center;
        padding: 1rem;
        border: 1px dashed #e2e8f0;
        border-radius: 4px;
        margin-bottom: 1rem;
        background-color: #f8fafc;
    }
</style>

<div class="admin-header">
    <div class="page-title">
        <h1>Edit Instructor</h1>
        <p>Update instructor details</p>
    </div>
</div>

<form action="{{ route('content-manager.other-features.instructors.update', $instructor) }}" method="POST" id="instructor-form">
    @csrf
    @method('PUT')

    <div class="form-card">
        <div class="form-row">
            <div class="form-group">
                <label for="name" class="form-label">First Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $instructor->name) }}" required>
                <small>Current: {{ $instructor->name }}</small>
            </div>
            <div class="form-group">
                <label for="surname" class="form-label">Last Name</label>
                <input type="text" id="surname" name="surname" class="form-control" value="{{ old('surname', $instructor->surname) }}" required>
                <small>Current: {{ $instructor->surname }}</small>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $instructor->email) }}" required>
                <small>Current: {{ $instructor->email }}</small>
            </div>
            <div class="form-group">
                <label for="job_title" class="form-label">Profession/Job Title</label>
                <input type="text" id="job_title" name="job_title" class="form-control" value="{{ old('job_title', $instructor->job_title) }}" required>
                <small>Current: {{ $instructor->job_title }}</small>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
            </div>
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Repeat password">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="thumbnail" class="form-label">Thumbnail URL</label>
                <input type="url" id="thumbnail" name="thumbnail" class="form-control" value="{{ old('thumbnail', $instructor->thumbnail) }}" placeholder="https://example.com/image.jpg">
                <small class="text-muted">Enter a valid URL for the instructor's thumbnail image</small><br>
                <small>Current: {{ $instructor->thumbnail }}</small>
                @if($instructor->thumbnail)
                <img id="thumbnail-preview" class="thumbnail-preview" src="{{ $instructor->thumbnail }}" alt="Thumbnail preview" style="display:block;">
                @else
                <img id="thumbnail-preview" class="thumbnail-preview" style="display:none;">
                @endif
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="bio" class="form-label">Bio</label>
                <textarea id="bio" name="bio" class="form-control">{{ old('bio', $instructor->bio) }}</textarea>
                <small>Current: {!! nl2br(e($instructor->bio)) !!}</small>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Special Features</label>
                <div id="features-container">
                    <div class="empty-state" id="empty-features-state" style="display:none;">No features added yet</div>
                </div>
                <div class="add-feature" id="add-feature">
                    <i class="fas fa-plus"></i> Add Feature
                </div>
                <input type="hidden" name="features" id="features-input">
                <small class="text-muted">Add the instructor's special features or areas of expertise</small>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('content-manager.other-features.instructors.index') }}" class="btn btn-outline">Cancel</a>
        <button type="submit" class="btn btn-primary">Update Instructor</button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const thumbnailInput = document.getElementById('thumbnail');
        const thumbnailPreview = document.getElementById('thumbnail-preview');

        thumbnailInput.addEventListener('change', function () {
            if (thumbnailInput.value) {
                thumbnailPreview.src = thumbnailInput.value;
                thumbnailPreview.style.display = 'block';
            } else {
                thumbnailPreview.style.display = 'none';
            }
        });

        let oldFeaturesRaw = @json(old('features', $instructor->features ?? []));
        let oldFeatures = [];

        try {
            if (typeof oldFeaturesRaw === 'string') {
                oldFeatures = JSON.parse(oldFeaturesRaw);
            } else {
                oldFeatures = oldFeaturesRaw;
            }
        } catch (e) {
            oldFeatures = [];
        }

        if (oldFeatures.length > 0) {
            oldFeatures.forEach(feature => {
                addFeature(feature.icon, feature.title, feature.description);
            });
            document.getElementById('empty-features-state').style.display = 'none';
        } else {
            document.getElementById('empty-features-state').style.display = 'block';
        }

        document.getElementById('add-feature').addEventListener('click', function () {
            addFeature();
            document.getElementById('empty-features-state').style.display = 'none';
        });

        document.getElementById('instructor-form').addEventListener('submit', function (e) {
            const features = [];
            document.querySelectorAll('.feature-container').forEach(container => {
                const icon = container.querySelector('.icon-input').value;
                const title = container.querySelector('.title-input').value;
                const description = container.querySelector('.description-input').value;

                if (title || description) {
                    features.push({
                        icon: icon ? `fas fa-${icon}` : '',
                        title: title,
                        description: description
                    });
                }
            });

            document.getElementById('features-input').value = JSON.stringify(features);

            if (features.length === 0) {
                document.getElementById('empty-features-state').style.display = 'block';
            }
        });
    });

    function addFeature(icon = '', title = '', description = '') {
        const container = document.getElementById('features-container');
        const featureId = generateUniqueId('feature');
        
        const iconId = generateUniqueId('icon');
        const titleId = generateUniqueId('title');
        const descriptionId = generateUniqueId('description');
        const previewId = generateUniqueId('icon-preview');

        const featureHtml = `
            <div class="feature-container" id="${featureId}">
                <div class="feature-header">
                    <span class="feature-title">Feature #${container.querySelectorAll('.feature-container').length + 1}</span>
                    <button type="button" class="remove-feature" onclick="removeFeature('${featureId}')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="${iconId}" class="form-label">Icon</label>
                        <div class="icon-prefix">
                            <span class="icon-prefix-text">fas fa-</span>
                            <input type="text" id="${iconId}" 
                                class="form-control icon-input" 
                                placeholder="database, chart-line, etc."
                                value="${icon.replace('fas fa-', '')}"
                                oninput="updateIconPreview(this, '${previewId}')">
                            <span class="preview-icon" id="${previewId}"></span>
                        </div>
                        <small class="text-muted">Font Awesome icon name (without "fas fa-")</small>
                    </div>
                    <div class="form-group">
                        <label for="${titleId}" class="form-label">Title</label>
                        <input type="text" id="${titleId}" 
                            class="form-control title-input" 
                            placeholder="Data Management"
                            value="${title}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="${descriptionId}" class="form-label">Description</label>
                        <textarea id="${descriptionId}" 
                                class="form-control description-input" 
                                placeholder="Learn to organize and analyze large datasets effectively">${description}</textarea>
                    </div>
                </div>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', featureHtml);

        if (icon) {
            updateIconPreview(document.getElementById(iconId), previewId);
        }
    }

    function generateUniqueId(prefix) {
        let id;
        do {
            id = prefix + '-' + Date.now() + '-' + Math.floor(Math.random() * 1000);
        } while (document.getElementById(id));
        return id;
    }

    function updateIconPreview(input, previewId) {
        const preview = document.getElementById(previewId);
        if (input.value) {
            preview.className = `preview-icon fas fa-${input.value}`;
        } else {
            preview.className = 'preview-icon';
        }
    }

    function updateIconPreview(input, previewId) {
        const preview = document.getElementById(previewId);
        if (input.value) {
            preview.className = `preview-icon fas fa-${input.value}`;
        } else {
            preview.className = 'preview-icon';
        }
    }
</script>
@endsection
