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
                <th>View Client</th>
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
                <td>{{ $registration->created_at->format('M d, Y H:i') }}</td>
                <td>
                    <span class="status-badge status-{{ $registration->payment_status === 'completed' ? 'active' : 'pending' }}">
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
                <td>
                    <div class="btn-group">
                        <a href="{{ route('content-manager.clients.show', $registration->client->id) }}" class="btn btn-outline btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="pagination-footer">    
        <style>
            .pagination-footer {
                padding: 1rem 1.5rem;
                background-color: #f9fafb;
                border-top: 1px solid #e5e7eb;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            }

            .pagination-desktop {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .pagination-info {
                font-size: 0.875rem;
                color: #2d3748;
            }

            .pagination-links {
                display: flex;
                align-items: center;
            }

            .pagination-links a {
                padding: 0.5rem;
                font-size: 0.875rem;
                color: #38b6ff;
                text-decoration: none;
                transition: all 0.3s ease;
            }

            .pagination-links a:hover {
                background-color: #38b6ff;
                color: white;
                border-color: #38b6ff;
            }

            .pagination-links .page-number.active {
                background-color: #2d3748;
                color: white;
                padding: 4px 8px;
                border-radius: 50px;
                margin: 0 4px;
            }
            .pagination-links .page-number:hover {
                border-radius: 50px;
                padding: 4px 8px;
            }

            .pagination-links .page-prev, .pagination-links .page-next {
                background-color: #38b6ff;
                color: white;
                padding: 0.5rem 1rem;
                border: none;
                border-radius: 30px;
            }

            .pagination-links .page-prev.disabled, .pagination-links .page-next.disabled {
                background-color:rgb(233, 233, 233);
                color:rgb(57, 67, 83);
            }

            .pagination-links .page-prev:hover:not(.disabled), .pagination-links .page-next:hover:not(.disabled) {
                background-color:rgb(37, 114, 158);
            }
        </style>
        <nav aria-label="Pagination Navigation">
            <div class="pagination-desktop flex items-center justify-between">
                <div class="pagination-info">
                    <p class="text-sm text-gray-700">
                        Showing <span class="font-medium">{{ $registrations->firstItem() }}</span> to 
                        <span class="font-medium">{{ $registrations->lastItem() }}</span> of 
                        <span class="font-medium">{{ $registrations->total() }}</span> results
                    </p>
                </div>

                <!-- Pagination Links -->
                <div class="pagination-links flex items-center space-x-2">
                    <!-- Previous Button -->
                    @if ($registrations->onFirstPage())
                        <span class="page-prev disabled">« Previous</span>
                    @else
                        <a href="{{ $registrations->previousPageUrl() }}" class="page-prev">« Previous</a>
                    @endif

                    <!-- Page Numbers -->
                    @foreach ($registrations->getUrlRange(1, $registrations->lastPage()) as $page => $url)
                        @if ($page == $registrations->currentPage())
                            <span class="page-number active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="page-number">{{ $page }}</a>
                        @endif
                    @endforeach

                    <!-- Next Button -->
                    @if ($registrations->hasMorePages())
                        <a href="{{ $registrations->nextPageUrl() }}" class="page-next">Next »</a>
                    @else
                        <span class="page-next disabled">Next »</span>
                    @endif
                </div>
            </div>
        </nav>
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