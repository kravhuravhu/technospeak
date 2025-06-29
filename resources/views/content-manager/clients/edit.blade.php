@extends('layouts.admin')

@section('title', 'Edit ' . $client->full_name)

@section('content')
<div class="admin-header">
    <div class="page-title">
        <h1>Edit {{ $client->full_name }}</h1>
        <p>Update client details</p>
    </div>
</div>

<form action="{{ route('content-manager.clients.update', $client) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="form-card">
        <div class="form-row">
            <div class="form-group">
                <label for="name" class="form-label">First Name</label>
                <input type="text" id="name" name="name" class="form-control" 
                       value="{{ old('name', $client->name) }}" required>
            </div>
            
            <div class="form-group">
                <label for="surname" class="form-label">Last Name</label>
                <input type="text" id="surname" name="surname" class="form-control" 
                       value="{{ old('surname', $client->surname) }}" required>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" 
                       value="{{ old('email', $client->email) }}" required>
            </div>
            
            <div class="form-group">
                <label for="preferred_category_id" class="form-label">Preferred Category</label>
                <select id="preferred_category_id" name="preferred_category_id" class="form-control">
                    <option value="">None</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" 
                            {{ old('preferred_category_id', $client->preferred_category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="password" class="form-label">New Password</label>
                <input type="password" id="password" name="password" class="form-control">
                <small class="text-muted">Leave blank to keep current password</small>
            </div>
            
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="subscription_type" class="form-label">Subscription Type</label>
                <input type="text" id="subscription_type" name="subscription_type" class="form-control" 
                       value="{{ old('subscription_type', $client->subscription_type) }}">
            </div>
            
            <div class="form-group">
                <label for="subscription_expiry" class="form-label">Subscription Expiry</label>
                <input type="date" id="subscription_expiry" name="subscription_expiry" class="form-control" 
                       value="{{ old('subscription_expiry', $client->subscription_expiry ? $client->subscription_expiry->format('Y-m-d') : '') }}">
            </div>
        </div>
        
        <div class="form-group" style="margin-top: 1.5rem;">
            <button type="submit" class="btn btn-primary">
                Update Client
            </button>
            <a href="{{ route('content-manager.clients.show', $client) }}" class="btn btn-outline">
                Cancel
            </a>
        </div>
    </div>
</form>
@endsection