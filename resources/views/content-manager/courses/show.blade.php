@extends('layouts.admin')

@section('title', $course->title)

@section('content')
<style>
    /* Modern Card Styles */
    .card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        margin-bottom: 2rem;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    
    .card-header {
        padding: 1.5rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .card-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--darkBlue);
        margin: 0;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    /* Course Header (keeping your existing style) */
    .course-header {
        display: flex;
        margin-bottom: 2rem;
        padding: 1rem;
        background: white;
        border-radius: 9px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    
    .course-thumbnail {
        width: 340px;
        border-radius: 8px;
        object-fit: cover;
        margin-right: 2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
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
    
    /* Progress Bar */
    .progress-container {
        margin-top: 2rem;
    }
    
    .progress-label {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        color: #4a5568;
    }
    
    .progress-bar {
        height: 8px;
        border-radius: 4px;
        background-color: #edf2f7;
        overflow: hidden;
    }
    
    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--skBlue), var(--powBlue));
        border-radius: 4px;
        width: 65%; /* Example value */
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .course-header {
            flex-direction: column;
            text-align: center;
        }
        
        .course-thumbnail {
            width: 100%;
            height: auto;
            max-height: 200px;
            margin-right: 0;
            margin-bottom: 1.5rem;
        }
        
        .course-meta {
            justify-content: center;
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
    </div>
</div>

<div class="course-header">
    <img src="{{ $course->thumbnail }}" alt="Course thumbnail" class="course-thumbnail">
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
                {{ ucfirst($course->plan_type) }}
            </span>
            <span class="badge badge-level">
                {{ ucfirst($course->level) }}
            </span>
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
                <p class="text-gray-700 leading-relaxed">{{ $course->description }}</p>
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
                        <div class="stat-value">{{ $course->noEpisodes }}</div>
                        <div class="stat-label">Episodes</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">
                            @php
                                $hours = floor($course->total_duration / 3600);
                                $minutes = floor(($course->total_duration % 3600) / 60);
                                
                                if ($hours > 0) {
                                    echo $hours.'h '.$minutes.'m';
                                } else {
                                    echo $minutes.'m';
                                }
                            @endphp
                        </div>
                        <div class="stat-label">Duration</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">{{ number_format(rand(1000, 10000)) }}</div>
                        <div class="stat-label">Students</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">
                            @if($course->is_active)
                                <span style="color: var(--success);">Active</span>
                            @else
                                <span style="color: var(--danger);">Inactive</span>
                            @endif
                        </div>
                        <div class="stat-label">Status</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
                
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Course Episodes ({{ $course->episodes->count() }})</h3>
                <i class="fas fa-list-ol text-gray-400"></i>
            </div>
            <div class="card-body">
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
                                <span><i class="fas fa-eye"></i> {{ number_format(rand(500, 5000)) }} views</span>
                            </div>
                        </div>
                        <div class="episode-actions">
                            <button class="action-btn" title="Preview">
                                <i class="fas fa-play"></i>
                            </button>
                            <button class="action-btn" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
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
                </div>
            </div>
        @endif
    </div>
</div>

<div class="mt-6">
    <a href="{{ route('content-manager.courses.index') }}" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Back to All Courses
    </a>
</div>
@endsection