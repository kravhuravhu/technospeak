@extends('layouts.admin')

@section('title', 'Training Sessions')

@section('content')
<div class="admin-header">
    <div class="page-title">
        <h1>Training Sessions</h1>
        <p>Manage all training sessions</p>
    </div>
    <div class="user-menu">
        <a href="{{ route('content-manager.trainings.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> New Session
        </a>
    </div>
</div>

<div class="data-table">
    <div class="data-table-header">
        <div class="data-table-title">
            <h3>All Sessions</h3>
        </div>
        <div class="table-actions">
            <div class="search-box">
                <input type="text" placeholder="Search sessions..." class="form-control">
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
                <th>Type</th>
                <th>Scheduled</th>
                <th>Duration</th>
                <th>Instructor</th>
                <th>Participants</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sessions as $session)
            <tr>
                <td>
                    <strong>{{ $session->title }}</strong>
                </td>
                <td>{{ $session->type->name }}</td>
                <td>
                    {{ $session->scheduled_for->format('M d, Y') }}
                </td>
                <td>{{ $session->formatted_duration }}</td>
                <td>{{ $session->instructor ? $session->instructor->name : 'Not assigned' }}</td>
                <td>
                    {{ $session->registrations_count }} / {{ $session->max_participants ?? '∞' }}
                </td>
                <td>
                    @if($session->scheduled_for->isPast())
                        <span class="status-badge status-inactive">Completed</span>
                    @else
                        <span class="status-badge status-active">Upcoming</span>
                    @endif
                </td>
                <td>
                    <div class="btn-group">
                        <a href="{{ route('content-manager.trainings.show', $session) }}" class="btn btn-outline btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('content-manager.trainings.edit', $session) }}" class="btn btn-outline btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('content-manager.trainings.destroy', $session) }}" method="POST" style="display:inline;">
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
                        Showing <span class="font-medium">{{ $sessions->firstItem() }}</span> to 
                        <span class="font-medium">{{ $sessions->lastItem() }}</span> of 
                        <span class="font-medium">{{ $sessions->total() }}</span> results
                    </p>
                </div>

                <!-- Pagination Links (Page numbers) -->
                <div class="pagination-links flex items-center space-x-2">
                    <!-- Previous Button -->
                    @if ($sessions->onFirstPage())
                        <span class="page-prev disabled">« Previous</span>
                    @else
                        <a href="{{ $sessions->previousPageUrl() }}" class="page-prev">« Previous</a>
                    @endif

                    <!-- Page Numbers -->
                    @foreach ($sessions->getUrlRange(1, $sessions->lastPage()) as $page => $url)
                        @if ($page == $sessions->currentPage())
                            <span class="page-number active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="page-number">{{ $page }}</a>
                        @endif
                    @endforeach

                    <!-- Next Button -->
                    @if ($sessions->hasMorePages())
                        <a href="{{ $sessions->nextPageUrl() }}" class="page-next">Next »</a>
                    @else
                        <span class="page-next disabled">Next »</span>
                    @endif
                </div>
            </div>
        </nav>
    </div>
</div>
@endsection