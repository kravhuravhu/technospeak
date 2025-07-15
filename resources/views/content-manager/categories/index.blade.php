@extends('layouts.admin')

@section('title', 'Course Categories')

@section('content')
<div class="admin-header">
    <div class="page-title">
        <h1>Course Categories</h1>
        <p>Manage all course categories</p>
    </div>
    <div class="user-menu">
        <a href="{{ route('content-manager.categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> New Category
        </a>
    </div>
</div>

<div class="data-table">
    <div class="data-table-header">
        <div class="data-table-title">
            <h3>All Categories</h3>
        </div>
        <div class="table-actions">
            <input type="text" placeholder="Search categories..." class="form-control">
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Courses</th>
                <th>Total Duration</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>
                    <strong>{{ $category->name }}</strong>
                </td>
                <td>{{ $category->courses_count }}</td>
                <td>{{ $category->formatted_total_duration }}</td>
                <td>
                    <div class="btn-group">
                        <a href="{{ route('content-manager.categories.edit', $category) }}" class="btn btn-outline btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('content-manager.categories.destroy', $category) }}" method="POST" style="display:inline;">
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
        {{ $categories->links() }}
    </div>
</div>
@endsection