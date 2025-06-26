@extends('layouts.admin')

@section('title', 'Manage Courses')

@section('content')
<div class="admin-header">
    <div class="page-title">
        <h1>Courses</h1>
        <p>Manage all available courses</p>
    </div>
    <div class="user-menu">
        <a href="{{ route('content-manager.courses.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> New Course
        </a>
    </div>
</div>

<div class="data-table">
    <div class="data-table-header">
        <div class="data-table-title">
            <h3>All Courses</h3>
        </div>
        <div class="table-actions">
            <div class="search-box">
                <input type="text" placeholder="Search courses..." class="form-control">
            </div>
            <button class="btn btn-outline">
                <i class="fas fa-filter"></i> Filter
            </button>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Students</th>
                <th>Status</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
            <tr>
                <td>
                    <strong>{{ $course->title }}</strong>
                </td>
                <td>{{ $course->category->name }}</td>
                <td>{{ $course->students_count }}</td>
                <td>
                    @if($course->is_active)
                        <span class="status-badge status-active">Active</span>
                    @else
                        <span class="status-badge status-inactive">Inactive</span>
                    @endif
                </td>
                <td>{{ $course->created_at->format('M d, Y') }}</td>
                <td>
                    <div class="btn-group">
                        <a href="{{ route('content-manager.courses.edit', $course->id) }}" class="btn btn-outline btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-outline btn-sm">
                            <i class="fas fa-eye"></i>
                        </button>
                        <form action="{{ route('content-manager.courses.destroy', $course->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="data-table-footer">
        {{ $courses->links() }}
    </div>
</div>
@endsection