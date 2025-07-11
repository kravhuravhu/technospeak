@extends('layouts.admin')

@section('title', $training->title . ' - Registrations')

@section('content')
<div class="admin-header">
    <div class="page-title">
        <h1>{{ $training->title }}</h1>
        <p>Manage session registrations</p>
        <p class="session-info">
            <strong>Scheduled:</strong> {{ $training->scheduled_for->format('M d, Y H:i') }} •
            <strong>Duration:</strong> {{ $training->duration }} •
            <strong>Instructor:</strong> {{ $training->instructor ? $training->instructor->name : 'Not assigned' }}
        </p>
    </div>
    <div class="user-menu">
        <span class="badge" style="background: var(--skBlue); color: white; padding: 0.5rem 1rem;">
            {{ $registrations->total() }} Registrations
        </span>
    </div>
</div>

<div class="data-table">
    <div class="data-table-header">
        <div class="data-table-title">
            <h3>All Registrations</h3>
        </div>
        <div class="table-actions">
            <form method="POST" action="{{ route('content-manager.trainings.mark-attendance', $training) }}">
                @csrf
                <button type="submit" class="btn btn-primary" id="mark-attendance-btn" disabled>
                    <i class="fas fa-check-circle"></i> Mark Selected as Attended
                </button>
            </form>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th width="50px"><input type="checkbox" id="select-all"></th>
                <th>Client</th>
                <th>Email</th>
                <th>Registered At</th>
                <th>Payment Status</th>
                <th>Attendance</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registrations as $registration)
            <tr>
                <td>
                    @if(!$registration->attended)
                    <input type="checkbox" name="registration_ids[]" 
                           value="{{ $registration->id }}" class="registration-checkbox">
                    @endif
                </td>
                <td>{{ $registration->client->name }}</td>
                <td>{{ $registration->client->email }}</td>
                <td>{{ $registration->registered_at->format('M d, Y H:i') }}</td>
                <td>
                    <span class="status-badge status-{{ $registration->payment_status === 'paid' ? 'active' : 'pending' }}">
                        {{ ucfirst($registration->payment_status) }}
                    </span>
                </td>
                <td>
                    @if($registration->attended)
                        <span class="status-badge status-active">Attended</span>
                    @else
                        <span class="status-badge status-pending">Pending</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="data-table-footer">
        {{ $registrations->links() }}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('.registration-checkbox');
        const markAttendanceBtn = document.getElementById('mark-attendance-btn');
        
        selectAll.addEventListener('change', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
            updateMarkAttendanceBtn();
        });
        
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateMarkAttendanceBtn);
        });
        
        function updateMarkAttendanceBtn() {
            const checked = document.querySelectorAll('.registration-checkbox:checked');
            markAttendanceBtn.disabled = checked.length === 0;
        }
    });
</script>

<style>
    .session-info {
        margin-top: 0.5rem;
        font-size: 0.9rem;
        color: #666;
    }
    .session-info strong {
        color: var(--textDark);
    }
</style>
@endsection