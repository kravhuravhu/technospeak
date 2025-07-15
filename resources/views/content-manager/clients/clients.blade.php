@extends('layouts.admin')

@section('title', 'Manage Clients')

@push('styles')
<style>
    .no-results-message {
        padding: 20px;
        text-align: center;
        color: #718096;
        background: #f8fafc;
        border-radius: 8px;
        margin: 20px;
        font-style: italic;
    }
    .filter-options {
        display: none;
        background-color: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-top: 1rem;
    }
</style>
@endpush

@section('content')
<div class="admin-header">
    <div class="page-title">
        <h1>Clients</h1>
        <p>Manage all registered clients</p>
    </div>
    <div class="user-menu">
        <div class="search-box">
            <input type="text" id="clientSearchInput" placeholder="Search clients..." class="form-control">
        </div>
    </div>
</div>

<div class="data-table">
    <div class="data-table-header">
        <div class="data-table-title">
            <h3>All Clients</h3>
        </div>
        <div class="table-actions">
            <button class="btn btn-outline">
                <i class="fas fa-filter"></i> Filter
            </button>
        </div>
    </div>
    <div id="clientFilterOptions" class="form-card filter-options" style="display: none;">
        <div class="form-row">
            <div class="form-group">
                <label for="userTypeFilter" class="form-label">User Type</label>
                <select id="userTypeFilter" class="form-control">
                    <option value="">All Types</option>
                    <option value="Professional">Professional</option>
                    <option value="Student">Student</option>
                    <option value="Unknown">Unknown</option>
                </select>
            </div>

            <div class="form-group">
                <label for="verifiedFilter" class="form-label">Verification</label>
                <select id="verifiedFilter" class="form-control">
                    <option value="">Any</option>
                    <option value="1">Verified</option>
                    <option value="0">Unverified</option>
                </select>
            </div>

            <div class="form-group" style="display:flex;align-items:flex-end;justify-content:flex-start;">
                <button id="applyClientFilterBtn" class="btn btn-primary">Apply Filter</button>
            </div>
        </div>
    </div>
    
    <table id="clientsTable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>User Type</th>
                <th>Courses Enrolled</th>
                <th>Preferred Trainings</th>
                <th>Verified</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
            <tr data-user-type="{{ $client->userType ?? 'unknown' }}" data-verified="{{ $client->email_verified_at ? '1' : '0' }}">
                <td>
                    <div style="display: flex; align-items: center;">
                        <img src="{{ $client->avatar ?? asset('images/icons/circle-user-solid.svg') }}" 
                             alt="{{ $client->name }}" 
                             style="width: 32px; height: 32px; border-radius: 50%; margin-right: 10px;opacity: .75;filter:brightness(50%);">
                        {{ $client->surname }}, {{ $client->name }}
                    </div>
                </td>
                <td>{{ $client->email }}</td>
                <td>{{ $client->userType ?? 'Unknown' }}</td>
                <td>{{ $client->courses_count }}</td>
                <td>{{ $client->preferredCategory ? $client->preferredCategory->name : 'Unset' }}</td>
                <td>
                    @if($client->email_verified_at)
                        <span class="status-badge status-active">Active</span>
                    @else
                        <span class="status-badge status-inactive">Inactive</span>
                    @endif
                </td>
                <td>
                    <div class="btn-group">
                        <a href="{{ route('content-manager.clients.show', $client->id) }}" class="btn btn-outline btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('content-manager.clients.edit', $client->id) }}" class="btn btn-outline btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('content-manager.clients.destroy', $client->id) }}" method="POST" style="display:inline;">
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
    <div id="clientNoResultsMessage" style="display:none;" class="no-results-message">
        No clients match your criteria. Try a different search or filter.
    </div>

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
                        Showing <span class="font-medium">{{ $clients->firstItem() }}</span> to 
                        <span class="font-medium">{{ $clients->lastItem() }}</span> of 
                        <span class="font-medium">{{ $clients->total() }}</span> results
                    </p>
                </div>

                <!-- Pagination Links (Page numbers) -->
                <div class="pagination-links flex items-center space-x-2">
                    <!-- Previous Button -->
                    @if ($clients->onFirstPage())
                        <span class="page-prev disabled">« Previous</span>
                    @else
                        <a href="{{ $clients->previousPageUrl() }}" class="page-prev">« Previous</a>
                    @endif

                    <!-- Page Numbers -->
                    @foreach ($clients->getUrlRange(1, $clients->lastPage()) as $page => $url)
                        @if ($page == $clients->currentPage())
                            <span class="page-number active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="page-number">{{ $page }}</a>
                        @endif
                    @endforeach

                    <!-- Next Button -->
                    @if ($clients->hasMorePages())
                        <a href="{{ $courses->nextPageUrl() }}" class="page-next">Next »</a>
                    @else
                        <span class="page-next disabled">Next »</span>
                    @endif
                </div>
            </div>
        </nav>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('clientSearchInput');
        const clientsTable = document.getElementById('clientsTable');
        const filterBtn = document.querySelector('.table-actions .btn-outline i.fa-filter').closest('button');
        const filterOptions = document.getElementById('clientFilterOptions');
        const applyFilterBtn = document.getElementById('applyClientFilterBtn');
        const noResultsMessage = document.getElementById('clientNoResultsMessage');

        // Toggle filter panel
        filterBtn.addEventListener('click', function () {
            filterOptions.style.display = (filterOptions.style.display === 'none' || filterOptions.style.display === '') ? 'block' : 'none';
        });

        function filterClients() {
            const searchTerm = searchInput.value.toLowerCase();
            const userType = document.getElementById('userTypeFilter').value;
            const verified = document.getElementById('verifiedFilter').value;

            const rows = Array.from(clientsTable.querySelectorAll('tbody tr'));
            let visibleCount = 0;

            rows.forEach(row => {
                const name = row.querySelector('td:nth-child(1)').innerText.toLowerCase();
                const email = row.querySelector('td:nth-child(2)').innerText.toLowerCase();
                const typeMatch = userType ? row.getAttribute('data-user-type') === userType : true;
                const verifiedMatch = verified ? row.getAttribute('data-verified') === verified : true;
                const searchMatch = name.includes(searchTerm) || email.includes(searchTerm);

                if (searchMatch && typeMatch && verifiedMatch) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            noResultsMessage.style.display = visibleCount === 0 ? 'block' : 'none';
        }

        searchInput.addEventListener('input', filterClients);
        applyFilterBtn.addEventListener('click', filterClients);
    });
</script>
@endpush

@endsection