@extends('layouts.admin')

@section('title', 'Course Category Details')

@section('content')
<style>
    .profile-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        padding: 2rem;
        margin-bottom: 2rem;
    }
    .profile-header {
        margin-bottom: 2rem;
    }
    .profile-info h2 {
        margin: 0;
        color: var(--skBlue);
    }
    .profile-meta {
        color: #64748b;
        margin-top: 0.5rem;
    }
    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }
    .detail-card {
        background: #f8fafc;
        border-radius: 6px;
        padding: 1.5rem;
    }
    .detail-card h4 {
        margin-top: 0;
        color: #475569;
    }
    .detail-value {
        font-size: 1.1rem;
        color: #1e293b;
    }
    .admin-header {
        margin-bottom: 2rem;
    }
    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }
    .course-list {
        margin-top: 1rem;
    }
    .course-item {
        padding: 1rem;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .course-item:last-child {
        border-bottom: none;
    }
    .timestamp {
        font-size: 0.85rem;
        color: #64748b;
    }
    .badge {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    .badge-primary {
        background-color: rgba(56, 161, 105, 0.1);
        color: var(--success);
    }
</style>

<div class="admin-header">
    <div class="page-title">
        <h1>Course Category Details</h1>
        <p>View and manage category information</p>
    </div>
</div>

<div class="profile-card">
    <div class="profile-header">
        <div class="profile-info">
            <h2>{{ $category->name }}</h2>
            <div class="timestamp">
                Created: {{ $category->created_at->format('M d, Y') }} • 
                Last updated: {{ $category->updated_at->format('M d, Y') }}
            </div>
        </div>
    </div>

    <div class="action-buttons">
        <a href="{{ route('content-manager.other-features.categories.edit', $category) }}" class="btn btn-outline">
            <i class="fas fa-edit"></i> Edit
        </a>
        <form action="{{ route('content-manager.other-features.categories.destroy', $category) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">
                <i class="fas fa-trash"></i> Delete
            </button>
        </form>
    </div>
    
    <div class="details-grid">
        <div class="detail-card">
            <h4>Total Courses</h4>
            <div class="detail-value">{{ $category->courses->count() }}</div>
        </div>
        <div class="detail-card">
            <h4>Total Duration</h4>
            <div class="detail-value">{{ $category->formatted_total_duration }}</div>
        </div>
    </div>
    
    @if($category->courses->count() > 0)
    <div class="detail-card" style="grid-column: 1 / -1;margin:10px 0;">
        <h4>Courses in this Category</h4>
        <div class="course-list">
            @foreach($category->courses as $course)
            <div class="course-item">
                <div>
                    <strong style="color:#38b6ff;">{{ $course->title }}</strong>
                    <div class="timestamp">
                        Duration: {{ $course->formatted_duration }} • 
                        Episodes: {{ $course->episodes_count }}
                        @if($course->is_active)
                            <span class="badge badge-primary ml-2">Active</span>
                        @endif
                    </div>
                </div>
                <a href="{{ route('content-manager.courses.show', $course) }}" class="btn btn-sm btn-outline">
                    View Course
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<div class="action-buttons">
    <a href="{{ route('content-manager.other-features.index') }}" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Back to Categories
    </a>
</div>
@endsection