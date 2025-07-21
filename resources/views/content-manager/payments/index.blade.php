@extends('layouts.admin')

@section('title', 'Payment Management')

@section('content')
<div class="admin-header">
    <div class="page-title">
        <h1>Payments</h1>
        <p>Manage all payment transactions</p>
    </div>
    <div class="user-menu"></div>
</div>

<div class="data-table">
    <div class="data-table-header">
        <div class="data-table-title">
            @if (number_format($pendingAmount, 2) == 0.00)
                <h3>Payment History</h3>
            @else
                <h3>Payment History</h3>
                <span><i>Pending: R{{ number_format($pendingAmount, 2) }}</i></span>
            @endif
        </div>
        <div class="table-actions">
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Search by client..." class="form-control search-control">
            </div>
            <button id="filterBtn" class="btn btn-outline filter-btn">
                <i class="fas fa-filter"></i> Filter
            </button>
        </div>
    </div>
    
    <div id="filterOptions" class="form-card filter-options" style="display: none;">
        <div class="form-row">
            <div class="form-group">
                <label for="statusFilter" class="form-label">Payment Status</label>
                <select id="statusFilter" class="form-control">
                    <option value="">All Statuses</option>
                    <option value="completed">Completed</option>
                    <option value="pending">Pending</option>
                    <option value="failed">Failed</option>
                </select>
            </div>
            <div class="form-group" style="display:flex;align-items:flex-end;justify-content:flex-start;">
                <button id="applyFilterBtn" class="btn btn-primary">Apply Filter</button>
            </div>
        </div>
    </div>

    <table id="paymentsTable">
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Client</th>
                <th>Service</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
            <tr data-status="{{ $payment->status }}" data-client="{{ strtolower($payment->client->name) }}">
                <td>{{ $payment->transaction_id }}</td>
                <td>{{ $payment->client->email }}</td>
                <td>{{ $payment->payment_for }}</td>
                <td>R{{ number_format($payment->amount, 2) }}</td>
                <td>{{ $payment->created_at->format('M d, Y') }}</td>
                <td>
                    @if($payment->status === 'completed')
                        <span class="status-badge status-active">Completed</span>
                    @elseif($payment->status === 'pending')
                        <span class="status-badge status-pending">Pending</span>
                    @else
                        <span class="status-badge status-inactive">Failed</span>
                    @endif
                </td>
                <td>
                    <div class="btn-group">
                        <a href="{{ route('content-manager.payments.show', $payment->id) }}" class="btn btn-outline btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if($payment->status === 'pending')
                        <button class="btn btn-primary btn-sm">
                            <i class="fas fa-check"></i> Approve
                        </button>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div id="noResultsMessage" style="display:none;" class="no-results-message">No payments match your criteria. Try a different search or filter.</div>

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
                        Showing <span class="font-medium">{{ $payments->firstItem() }}</span> to 
                        <span class="font-medium">{{ $payments->lastItem() }}</span> of 
                        <span class="font-medium">{{ $payments->total() }}</span> results
                    </p>
                </div>

                <!-- Pagination Links (Page numbers) -->
                <div class="pagination-links flex items-center space-x-2">
                    <!-- Previous Button -->
                    @if ($payments->onFirstPage())
                        <span class="page-prev disabled">« Previous</span>
                    @else
                        <a href="{{ $payments->previousPageUrl() }}" class="page-prev">« Previous</a>
                    @endif

                    <!-- Page Numbers -->
                    @foreach ($payments->getUrlRange(1, $payments->lastPage()) as $page => $url)
                        @if ($page == $payments->currentPage())
                            <span class="page-number active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="page-number">{{ $page }}</a>
                        @endif
                    @endforeach

                    <!-- Next Button -->
                    @if ($payments->hasMorePages())
                        <a href="{{ $payments->nextPageUrl() }}" class="page-next">Next »</a>
                    @else
                        <span class="page-next disabled">Next »</span>
                    @endif
                </div>
            </div>
        </nav>
        <div class="summary">
            <strong>Total: R{{ number_format($totalRevenue, 2) }}</strong>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .search-control {
        padding: 0.75rem 1rem;
        border-radius: 8px;
        font-size: 1rem;
        border: 2px solid rgba(56, 182, 255, 0.2);
        transition: all 0.3s ease-in-out;
    }
    
    .search-control::placeholder {
        color:rgba(48, 48, 48, 0.63);
    }

    .search-control:focus {
        border-color: var(--skBlue);
        box-shadow: 0 0 0 3px rgba(56, 182, 255, 0.2);
    }

    /* Filter Options Card */
    .filter-options {
        display: none;
        background-color: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-top: 1rem;
    }

    .apply-filter-btn {
        background-color: var(--skBlue);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: bold;
        margin-top: 1rem;
        width: 100%;
    }

    .apply-filter-btn:hover {
        background-color: #39b6ff;
    }

    /* No Results Message */
    .no-results-message {
        padding: 20px;
        text-align: center;
        color: #718096;
        background: #f8fafc;
        border-radius: 8px;
        margin: 20px;
        font-style: italic;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const filterBtn = document.getElementById('filterBtn');
        const filterOptions = document.getElementById('filterOptions');
        const applyFilterBtn = document.getElementById('applyFilterBtn');
        const paymentsTable = document.getElementById('paymentsTable');
        const noResultsMessage = document.getElementById('noResultsMessage');
        
        filterBtn.addEventListener('click', function() {
            filterOptions.style.display = filterOptions.style.display === 'none' ? 'block' : 'none';
        });

        // Apply filter
        applyFilterBtn.addEventListener('click', function() {
            const statusFilter = document.getElementById('statusFilter').value;
            const searchTerm = searchInput.value.toLowerCase();
            
            const rows = Array.from(paymentsTable.querySelectorAll('tbody tr'));
            let visibleCount = 0;

            rows.forEach(row => {
                const matchesStatus = statusFilter ? row.getAttribute('data-status') === statusFilter : true;
                const matchesSearch = searchTerm ? row.getAttribute('data-client').includes(searchTerm) : true;

                if (matchesStatus && matchesSearch) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            
            if (visibleCount === 0) {
                noResultsMessage.style.display = 'block';
            } else {
                noResultsMessage.style.display = 'none';
            }
        });

        // Live search functionality
        searchInput.addEventListener('input', function() {
            const searchTerm = searchInput.value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;
            
            const rows = Array.from(paymentsTable.querySelectorAll('tbody tr'));
            let visibleCount = 0;

            rows.forEach(row => {
                const matchesStatus = statusFilter ? row.getAttribute('data-status') === statusFilter : true;
                const matchesSearch = searchTerm ? row.getAttribute('data-client').includes(searchTerm) : true;
                
                if (matchesStatus && matchesSearch) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            
            if (visibleCount === 0) {
                noResultsMessage.style.display = 'block';
            } else {
                noResultsMessage.style.display = 'none';
            }
        });
    });
</script>
@endpush