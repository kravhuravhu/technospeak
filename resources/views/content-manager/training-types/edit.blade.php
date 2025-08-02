@extends('layouts.admin')

@section('title', 'Edit Training Type')

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
    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .checkbox-label {
        margin-bottom: 0;
    }
    .currency-prefix {
        display: flex;
        align-items: center;
    }
    .currency-symbol {
        padding: 0.5rem;
        background-color: #e2e8f0;
        border: 1px solid #e2e8f0;
        border-right: none;
        border-radius: 4px 0 0 4px;
        font-size: 0.875rem;
        color: #64748b;
    }
    .currency-input {
        border-radius: 0 4px 4px 0 !important;
        flex: 1;
    }
    .current-value {
        font-size: 0.875rem;
        color: #64748b;
        margin-top: 0.25rem;
    }
</style>

<div class="admin-header">
    <div class="page-title">
        <h1>Edit Training Type</h1>
        <p>Update training type details</p>
    </div>
</div>

<form action="{{ route('content-manager.other-features.training-types.update', $trainingType) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="form-card">
        <div class="form-row">
            <div class="form-group">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $trainingType->name) }}" required>
                <div class="current-value">Current: {{ $trainingType->name }}</div>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-control" rows="3">{{ old('description', $trainingType->description) }}</textarea>
                <div class="current-value">Current: {{ $trainingType->description ?? 'None' }}</div>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" id="is_group_session" name="is_group_session" value="1" {{ old('is_group_session', $trainingType->is_group_session) ? 'checked' : '' }}>
                    <label for="is_group_session" class="form-label checkbox-label">Group Session</label>
                </div>
                <div class="current-value">Current: {{ $trainingType->is_group_session ? 'Yes' : 'No' }}</div>
            </div>
            
            <div class="form-group" id="max-participants-group" style="{{ old('is_group_session', $trainingType->is_group_session) ? '' : 'display: none;' }}">
                <label for="max_participants" class="form-label">Maximum Participants</label>
                <input type="number" id="max_participants" name="max_participants" class="form-control" 
                       value="{{ old('max_participants', $trainingType->max_participants) }}" min="1"
                       {{ old('is_group_session', $trainingType->is_group_session) ? 'required' : '' }}>
                <div class="current-value">Current: {{ $trainingType->max_participants ?? 'Not set' }}</div>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="student_price" class="form-label">Student Price</label>
                <div class="currency-prefix">
                    <span class="currency-symbol">R</span>
                    <input type="number" id="student_price" name="student_price" class="form-control currency-input" 
                           value="{{ old('student_price', $trainingType->student_price) }}" step="0.01" min="0" required>
                </div>
                <div class="current-value">Current: R{{ number_format($trainingType->student_price, 2) }}</div>
            </div>
            
            <div class="form-group">
                <label for="professional_price" class="form-label">Professional Price</label>
                <div class="currency-prefix">
                    <span class="currency-symbol">R</span>
                    <input type="number" id="professional_price" name="professional_price" class="form-control currency-input" 
                           value="{{ old('professional_price', $trainingType->professional_price) }}" step="0.01" min="0" required>
                </div>
                <div class="current-value">Current: R{{ number_format($trainingType->professional_price, 2) }}</div>
            </div>
        </div>
    </div>
    
    <div class="form-actions">
        <a href="{{ route('content-manager.other-features.training-types.index') }}" class="btn btn-outline">Cancel</a>
        <button type="submit" class="btn btn-primary">Update Training Type</button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const groupSessionCheckbox = document.getElementById('is_group_session');
    const maxParticipantsGroup = document.getElementById('max-participants-group');
    
    groupSessionCheckbox.addEventListener('change', function() {
        if (this.checked) {
            maxParticipantsGroup.style.display = 'block';
            document.getElementById('max_participants').setAttribute('required', 'required');
        } else {
            maxParticipantsGroup.style.display = 'none';
            document.getElementById('max_participants').removeAttribute('required');
        }
    });
});
</script>
@endsection