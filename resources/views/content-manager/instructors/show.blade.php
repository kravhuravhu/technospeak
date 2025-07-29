@extends('layouts.admin')

@section('title', 'Instructor Details')

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
        display: flex;
        align-items: center;
        margin-bottom: 2rem;
    }
    .profile-photo {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 2rem;
        border: 4px solid #f1f5f9;
    }
    .profile-info h2 {
        margin: 0 10px;
        color: var(--skBlue);
    }
    .profile-meta {
        color: #64748b;
        margin: 0.5rem 10px;
    }
    .profile-bio {
        margin-top: 1.5rem;
        line-height: 1.6;
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
    .feature-cards {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }
    .feature-card {
        background: white;
        border-radius: 8px;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        border-left: 4px solid var(--skBlue);
    }
    .feature-icon {
        font-size: 1.5rem;
        color: var(--skBlue);
        margin-bottom: 0.5rem;
    }
    .feature-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #1e293b;
    }
    .feature-desc {
        color: #64748b;
        font-size: 0.9rem;
    }
    .timestamp {
        font-size: 0.85rem;
        color: #64748b;
        margin: 0 10px;
    }
</style>

<div class="admin-header">
    <div class="page-title">
        <h1>Instructor Details</h1>
        <p>View and manage instructor information</p>
    </div>
</div>

<div class="profile-card">
    <div class="profile-header">
        <div class="profile-photo-placeholder">
            <div style="width: 150px; height: 150px; background-color: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #64748b; font-size: 3rem;">
                {{ strtoupper(substr($instructor->name, 0, 1)) }}{{ strtoupper(substr($instructor->surname, 0, 1)) }}
            </div>
        </div>
        <div class="profile-info">
            <h2>{{ $instructor->name }} {{ $instructor->surname }}</h2>
            <div class="profile-meta">{{ $instructor->job_title }}</div>
            <div class="profile-meta">{{ $instructor->email }}</div>
            <div class="timestamp">
                Last updated: {{ $instructor->updated_at->format('M d, Y \a\t h:i A') }}
            </div>
        </div>
    </div>

    <div class="action-buttons">
        <a href="{{ route('content-manager.other-features.instructors.edit', $instructor) }}" class="btn btn-outline">
            <i class="fas fa-edit"></i> Edit
        </a>
        <button type="button" class="btn btn-danger" onclick="confirmDelete()">
            <i class="fas fa-trash"></i> Delete
        </button>
        <form id="deleteForm" action="{{ route('content-manager.other-features.instructors.destroy', $instructor) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
    
    @if($instructor->bio)
    <div class="profile-bio">
        <h4>Bio</h4>
        <p>{{ $instructor->bio }}</p>
    </div>
    @endif
    
    <div class="details-grid">
        <div class="detail-card">
            <h4>Assigned Tickets</h4>
            <div class="detail-value">{{ $instructor->assignedIssues->count() }}</div>
        </div>
        
        <div class="detail-card">
            <h4>Created At</h4>
            <div class="detail-value">{{ $instructor->created_at->format('M d, Y') }}</div>
        </div>
    </div>
    
    @if(is_array($instructor->features) && count($instructor->features))
    <div class="detail-card2" style="grid-column: 1 / -1;padding:10px;">
        <h4>Special Features</h4>
        <div class="feature-cards">
            @foreach($instructor->features as $feature)
            <div class="feature-card">
                @if(isset($feature['icon']))
                <div class="feature-icon">
                    <i class="{{ $feature['icon'] }}"></i>
                </div>
                @endif
                @if(isset($feature['title']))
                <div class="feature-title">{{ $feature['title'] }}</div>
                @endif
                @if(isset($feature['description']))
                <div class="feature-desc">{{ $feature['description'] }}</div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<div class="action-buttons">
    <a href="{{ route('content-manager.other-features.index') }}" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Back to Instructors
    </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#38b6ff',
            confirmButtonText: 'Yes, delete it!',
            customClass: {
                popup: 'swal-border'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm').submit();
            }
        });
    }
</script>
@endsection