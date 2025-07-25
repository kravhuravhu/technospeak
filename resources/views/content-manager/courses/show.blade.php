@extends('layouts.admin')

@section('title', $course->title)

@section('content')
<style>
    /* Modern Card Styles */
    .card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        margin-bottom: 2rem;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .card-header {
        padding: 1.5rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #f8fafc;
    }
    
    .card-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--skBlue);
        margin: 0;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    /* Course Header */
    .course-header {
        display: flex;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        border-left: 4px solid var(--skBlue);
    }
    
    .course-thumbnail {
        width: 340px;
        height: 200px;
        border-radius: 8px;
        object-fit: cover;
        margin-right: 2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .course-meta {
        display: flex;
        gap: 1.5rem;
        margin-top: 1rem;
        flex-wrap: wrap;
    }
    
    .meta-item {
        display: flex;
        align-items: center;
        font-size: 0.9rem;
        color: #4a5568;
    }
    
    .meta-item i {
        margin-right: 0.5rem;
        color: var(--skBlue);
    }
    
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.35rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 500;
        margin-right: 0.5rem;
    }
    
    .badge-free {
        background-color: rgba(56, 161, 105, 0.1);
        color: var(--success);
    }
    
    .badge-paid {
        background-color: rgba(56, 182, 255, 0.1);
        color: var(--skBlue);
    }
    
    .badge-level {
        background-color: rgba(160, 174, 192, 0.1);
        color: #4a5568;
    }
    
    /* Modern Episode List */
    .episode-list {
        display: grid;
        gap: 1rem;
    }
    
    .episode-card {
        display: flex;
        align-items: center;
        padding: 1.25rem;
        transition: all 0.3s ease;
        border-radius: 8px;
        background: white;
    }
    
    .episode-card:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(56, 182, 255, 0.1);
    }
    
    .episode-number {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--skBlue), var(--powBlue));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        margin-right: 1.5rem;
        flex-shrink: 0;
        font-size: 1.1rem;
    }
    
    .episode-content {
        flex: 1;
        min-width: 0;
    }
    
    .episode-title {
        font-weight: 500;
        margin-bottom: 0.25rem;
        color: var(--darkBlue);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .episode-description {
        color: #718096;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .episode-meta {
        display: flex;
        gap: 1.5rem;
        font-size: 0.85rem;
        color: #a0aec0;
    }
    
    .episode-actions {
        display: flex;
        gap: 0.5rem;
        margin-left: 1rem;
    }
    
    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f7fafc;
        color: #4a5568;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .action-btn:hover {
        background-color: var(--skBlue);
        color: white;
    }
    
    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }
    
    .stat-card {
        padding: 1.5rem;
        border-radius: 12px;
        background: white;
        text-align: center;
        box-shadow: 0 4px 6px rgb(0 0 0 / 23%);
    }
    
    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--skBlue);
        margin-bottom: 0.5rem;
        line-height: 1;
    }
    
    .stat-label {
        font-size: 0.85rem;
        color: #718096;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    /* Video Preview */
    .video-container {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
        overflow: hidden;
        border-radius: 8px;
        margin-top: 1rem;
        background: #000;
    }
    
    .video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
    }
    
    /* Resource List */
    .resource-list {
        display: grid;
        gap: 1rem;
    }
    
    .resource-card {
        display: flex;
        align-items: center;
        padding: 1.25rem;
        border-radius: 8px;
        background: white;
        border-left: 3px solid var(--skGreen);
    }
    
    .resource-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background-color: rgba(56, 161, 105, 0.1);
        color: var(--skGreen);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1.5rem;
        flex-shrink: 0;
        font-size: 1.1rem;
    }
    
    .resource-content {
        flex: 1;
    }
    
    .resource-title {
        font-weight: 500;
        margin-bottom: 0.25rem;
        color: var(--darkBlue);
    }
    
    .resource-meta {
        display: flex;
        gap: 1rem;
        font-size: 0.85rem;
        color: #a0aec0;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .course-header {
            flex-direction: column;
        }
        
        .course-thumbnail {
            width: 100%;
            height: auto;
            max-height: 200px;
            margin-right: 0;
            margin-bottom: 1.5rem;
        }
        
        .course-meta {
            justify-content: flex-start;
        }
        
        .episode-card {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .episode-number {
            margin-right: 0;
            margin-bottom: 1rem;
        }
        
        .episode-actions {
            margin-left: 0;
            margin-top: 1rem;
            width: 100%;
            justify-content: flex-end;
        }
    }
</style>

<div class="admin-header">
    <div class="page-title">
        <h1>Course Overview: {{ $course->title }}</h1>
        <p>Detailed information | CourseID • {{ $course->id }}</p>
    </div>
    <div class="user-menu">
        <a href="{{ route('content-manager.courses.edit', $course->id) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit Course
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

<div class="course-header">
    <img src="{{ $course->thumbnail }}" alt="Course thumbnail" class="course-thumbnail" onerror="this.src='https://via.placeholder.com/340x200?text=Thumbnail+Not+Available'">
    <div>
        <h2>{{ $course->title }}</h2>
        <p class="text-muted">{{ $course->catch_phrase }}</p>
        
        <div class="course-meta">
            <span class="meta-item">
                <i class="fas fa-user-tie"></i> {{ $course->instructor->name }}
            </span>
            <span class="meta-item">
                <i class="fas fa-layer-group"></i> {{ $course->category->name }}
            </span>
            <span class="badge {{ $course->plan_type === 'free' ? 'badge-free' : 'badge-paid' }}">
                <i class="fas {{ $course->plan_type === 'free' ? 'fa-unlock-alt' : 'fa-lock' }}"></i>&nbsp
                {{ ucfirst($course->plan_type) }}
            </span>
            <span class="badge badge-level">
                <i class="fas fa-signal"></i>&nbsp
                {{ ucfirst($course->level) }}
            </span>
            <span class="meta-item">
                <i class="fas fa-calendar-alt"></i> {{ $course->created_at->format('M d, Y') }}
            </span>
        </div>
        
        <div class="mt-3">
            <img src="{{ $course->software_app_icon }}" alt="Software icon" style="width: 32px; height: 32px; margin-right: 0.5rem;" onerror="this.style.display='none'">
            <span class="text-sm text-gray-600">Associated Software/App</span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Course Description</h3>
                <i class="fas fa-align-left text-gray-400"></i>
            </div>
            <div class="card-body">
                <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $course->description }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Course Statistics</h3>
                <i class="fas fa-chart-line text-gray-400"></i>
            </div>
            <div class="card-body">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-value">{{ $course->episodes->count() }}</div>
                        <div class="stat-label">Episodes</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">
                            @php
                                $totalSeconds = $course->total_duration;
                                $hours = floor($totalSeconds / 3600);
                                $minutes = floor(($totalSeconds % 3600) / 60);
                                $seconds = $totalSeconds % 60;

                                if ($hours > 0) {
                                    echo "{$hours}h {$minutes}m";
                                } elseif ($minutes > 0) {
                                    echo "{$minutes}m {$seconds}s";
                                } else {
                                    echo "{$seconds}s";
                                }
                            @endphp
                        </div>
                        <div class="stat-label">Duration</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">0</div>
                        <div class="stat-label">Students</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">
                            @if($course->episodes->count() > 0)
                                <span style="color: var(--success);">Active</span>
                            @else
                                <span style="color: var(--danger);">Draft</span>
                            @endif
                        </div>
                        <div class="stat-label">Status</div>
                    </div>
                </div>
            </div>
        </div>
        
        @if($course->resources->count() > 0)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Course Resources ({{ $course->resources->count() }})</h3>
                <i class="fas fa-paperclip text-gray-400"></i>
            </div>
            <div class="card-body">
                <div class="resource-list">
                    @foreach($course->resources as $resource)
                    <div class="resource-card">
                        <div class="resource-icon">
                            @if($resource->resourceType)
                                <i class="{{ $resource->resourceType->icon }}"></i>
                            @else
                                <i class="fas fa-file"></i>
                            @endif
                        </div>
                        <div class="resource-content">
                            <h4 class="resource-title">{{ $resource->title }}</h4>
                            <div class="resource-meta">
                                <span><i class="fas fa-file"></i> {{ $resource->file_type ?: 'Unknown' }}</span>
                                <span><i class="fas fa-database"></i> {{ $resource->file_size }}</span>
                                @if($resource->description)
                                <span><i class="fas fa-info-circle"></i> {{ Str::limit($resource->description, 40) }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="episode-actions">
                            <a href="{{ $resource->file_url }}" target="_blank" class="action-btn" title="Download">
                                <i class="fas fa-download"></i>
                            </a>
                            <form action="{{ route('content-manager.resource.destroy', [$course->id, $resource->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn" title="Delete" onclick="return confirm('Are you sure you want to delete this resource?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>

    <div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Course Episodes ({{ $course->episodes->count() }})</h3>
                <i class="fas fa-list-ol text-gray-400"></i>
            </div>
            <div class="card-body">
                @if($course->episodes->count() > 0)
                <div class="episode-list">
                    @foreach($course->episodes as $episode)
                    <div class="episode-card">
                        <div class="episode-number">{{ $episode->episode_number }}</div>
                        <div class="episode-content">
                            <h4 class="episode-title">{{ $episode->title }}</h4>
                            @if($episode->description)
                            <p class="episode-description">{{ $episode->description }}</p>
                            @endif
                            <div class="episode-meta">
                                <span><i class="far fa-clock"></i> {{ gmdate('i:s', $episode->duration) }}</span>
                                <span><i class="fas fa-eye"></i> 0 views</span>
                            </div>
                        </div>
                        <div class="episode-actions">
                            <a href="{{ route('content-manager.courses.edit', $course->id) }}#episode-{{ $episode->id }}" class="action-btn" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('content-manager.courses.episodes.destroy', [$course->id, $episode->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn" title="Delete" onclick="return confirm('Are you sure you want to delete this episode?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-4 text-gray-500">
                    <i class="fas fa-video-slash fa-2x mb-2"></i>
                    <p>No episodes added yet</p>
                    <a href="{{ route('content-manager.courses.edit', $course->id) }}" class="btn btn-sm btn-primary mt-2">
                        <i class="fas fa-plus"></i> Add Episodes
                    </a>
                </div>
                @endif
            </div>
        </div>

        @if($course->episodes->count() > 0)
            <div class="card mt-6">
                <div class="card-header">
                    <h3 class="card-title">Featured Episode</h3>
                    <i class="fas fa-play-circle text-gray-400"></i>
                </div>
                <div class="card-body">
                    <h4 class="font-medium text-gray-800 mb-2">{{ $course->episodes->first()->title }}</h4>
                    <div class="video-container">
                        <iframe src="{{ $course->episodes->first()->video_url }}" allowfullscreen></iframe>
                    </div>
                    <div class="mt-3 text-sm text-gray-600">
                        <p><strong>Duration:</strong> {{ gmdate('i:s', $course->episodes->first()->duration) }}</p>
                        @if($course->episodes->first()->description)
                        <p class="mt-1">{{ $course->episodes->first()->description }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<div class="mt-6 flex justify-between">
    <a href="{{ route('content-manager.courses.index') }}" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Back to All Courses
    </a>
    <div>
        <a href="{{ route('content-manager.courses.edit', $course->id) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit Course
        </a>
    </div>
</div>

@endsection