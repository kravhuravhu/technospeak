@extends('layouts.admin')

@section('title', 'Edit Resource Type')

@section('content')
<style>
    .form-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    .form-group {
        margin-bottom: 1rem;
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
</style>

<div class="admin-header">
    <div class="page-title">
        <h1>Edit Resource Type</h1>
        <p>Update resource type details</p>
    </div>
</div>

<form action="{{ route('content-manager.other-features.resource-types.update', $resourceType) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="form-card">
        <div class="form-group">
            <label for="name" class="form-label">Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $resourceType->name) }}" required>
            <small class="text-muted">e.g. PDF, Video, Audio, Document, etc.</small>
        </div>
    </div>
    
    <div class="form-actions">
        <a href="{{ route('content-manager.other-features.resource-types.index') }}" class="btn btn-outline">Cancel</a>
        <button type="submit" class="btn btn-primary">Update Resource Type</button>
    </div>
</form>
@endsection