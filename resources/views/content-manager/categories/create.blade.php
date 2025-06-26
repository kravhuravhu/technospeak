@extends('layouts.admin')

@section('title', 'Create Category')

@section('content')
<div class="admin-header">
    <div class="page-title">
        <h1>Create Category</h1>
        <p>Add a new course category</p>
    </div>
</div>

<form action="{{ route('content-manager.categories.store') }}" method="POST">
    @csrf
    
    <div class="form-card">
        <div class="form-group">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" id="name" name="name" class="form-control" required>
            @error('name')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group" style="margin-top: 1.5rem;">
            <button type="submit" class="btn btn-primary">
                Create Category
            </button>
            <a href="{{ route('content-manager.categories.index') }}" class="btn btn-outline">
                Cancel
            </a>
        </div>
    </div>
</form>
@endsection