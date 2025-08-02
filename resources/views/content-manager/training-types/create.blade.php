@extends('layouts.admin')

@section('title', 'Create Training Type')

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
</style>

<div class="admin-header">
    <div class="page-title">
        <h1>Create Training Type</h1>
        <p>Define a new type of training session</p>
    </div>
</div>

<form action="{{ route('content-manager.other-features.training-types.store') }}" method="POST">
    @csrf
    
    <div class="form-card">
        <div class="form-row">
            <div class="form-group">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" name="name" class="form-control" required>
                <small class="text-muted">e.g. Private Tutoring, Group Workshop, etc.</small>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-control" rows="3"></textarea>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" id="is_group_session" name="is_group_session" value="1">
                    <label for="is_group_session" class="form-label checkbox-label">Group Session</label>
                </div>
                <small class="text-muted">Check if this is a group training session</small>
            </div>
            
            <div class="form-group" id="max-participants-group" style="display: none;">
                <label for="max_participants" class="form-label">Maximum Participants</label>
                <input type="number" id="max_participants" name="max_participants" class="form-control" min="1">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="student_price" class="form-label">Student Price</label>
                <div class="currency-prefix">
                    <span class="currency-symbol">R</span>
                    <input type="number" id="student_price" name="student_price" class="form-control currency-input" step="0.01" min="0" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="professional_price" class="form-label">Professional Price</label>
                <div class="currency-prefix">
                    <span class="currency-symbol">R</span>
                    <input type="number" id="professional_price" name="professional_price" class="form-control currency-input" step="0.01" min="0" required>
                </div>
            </div>
        </div>
    </div>
    
    <div class="form-actions">
        <a href="{{ route('content-manager.other-features.training-types.index') }}" class="btn btn-outline">Cancel</a>
        <button type="submit" class="btn btn-primary">Create Training Type</button>
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