@extends('layouts.admin')

@section('title', 'Manage Courses')
@stack('head')
@section('content')
<div class="admin-header">
    <div class="page-title">
        <h1>Courses</h1>
        <p>Manage all available courses</p>
    </div>
    <div class="user-menu">
        <a href="{{ route('content-manager.courses.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> New Course
        </a>
    </div>
</div>

<div class="data-table">
    <div class="data-table-header">
        <div class="data-table-title">
            <h3>All Courses</h3>
        </div>
        <div class="table-actions">
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Search by title..." class="form-control search-control">
            </div>
            <button id="filterBtn" class="btn btn-outline filter-btn">
                <i class="fas fa-filter"></i> Filter
            </button>
        </div>
    </div>
    
    <div id="filterOptions" class="form-card filter-options" style="display: none;">
        <div class="form-row">
            <div class="form-group">
                <label for="categoryFilter" class="form-label">Category</label>
                <select id="categoryFilter" class="form-control">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="planFilter" class="form-label">Plan Type</label>
                <select id="planFilter" class="form-control">
                    <option value="">Select Plan Type</option>
                    <option value="paid">Premium Plan</option>
                    <option value="free">Free Plan</option>
                </select>
            </div>
            <div class="form-group" style="display:flex;align-items:flex-end;justify-content:flex-start;">
                <button id="applyFilterBtn" class="btn btn-primary">Apply Filter</button>
            </div>
        </div>
    </div>

    <table id="coursesTable">
        <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Students</th>
                <th>Subscription</th>
                <th>No Episodes</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
            <tr data-category="{{ $course->category->id }}" data-plan="{{ $course->plan_type }}">
                <td>
                    <strong>{{ $course->title }}</strong>
                </td>
                <td>{{ $course->category->name }}</td>
                <td>{!! $course->students_count ?? '<i>None enrolled </i>' !!}</td>
                <td>
                    @if($course->plan_type == 'paid')
                        <span class="status-badge status-active">Premium Plan</span>
                    @else
                        <span class="status-badge status-inactive">Free Plan</span>
                    @endif
                </td>
                <td>{{ $course->noEpisodes }} Episodes</td>
                <td>{{ $course->created_at->format('M d, Y') }}</td>
                <td>
                    <div class="btn-group">
                        <a href="{{ route('content-manager.courses.edit', $course->id) }}" class="btn btn-outline btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('content-manager.courses.show', $course->id) }}" class="btn btn-outline btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form action="{{ route('content-manager.courses.destroy', $course->id) }}" method="POST" style="display:inline;">
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
    
    <div id="noResultsMessage" style="display:none;" class="no-results-message">No Courses match your criteria. Try a different search or use filter button.</div>

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
                            Showing <span class="font-medium">{{ $courses->firstItem() }}</span> to 
                            <span class="font-medium">{{ $courses->lastItem() }}</span> of 
                            <span class="font-medium">{{ $courses->total() }}</span> results
                        </p>
                    </div>

                    <!-- Pagination Links (Page numbers) -->
                    <div class="pagination-links flex items-center space-x-2">
                        <!-- Previous Button -->
                        @if ($courses->onFirstPage())
                            <span class="page-prev disabled">« Previous</span>
                        @else
                            <a href="{{ $courses->previousPageUrl() }}" class="page-prev">« Previous</a>
                        @endif

                        <!-- Page Numbers -->
                        @foreach ($courses->getUrlRange(1, $courses->lastPage()) as $page => $url)
                            @if ($page == $courses->currentPage())
                                <span class="page-number active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="page-number">{{ $page }}</a>
                            @endif
                        @endforeach

                        <!-- Next Button -->
                        @if ($courses->hasMorePages())
                            <a href="{{ $courses->nextPageUrl() }}" class="page-next">Next »</a>
                        @else
                            <span class="page-next disabled">Next »</span>
                        @endif
                    </div>
                </div>
            </nav>
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
        const coursesTable = document.getElementById('coursesTable');
        const noResultsMessage = document.getElementById('noResultsMessage');
        
        // Toggle filter options
        filterBtn.addEventListener('click', function() {
            filterOptions.style.display = filterOptions.style.display === 'none' ? 'block' : 'none';
        });

        // Apply filter
        applyFilterBtn.addEventListener('click', function() {
            const categoryFilter = document.getElementById('categoryFilter').value;
            const planFilter = document.getElementById('planFilter').value;
            
            const rows = Array.from(coursesTable.querySelectorAll('tbody tr'));
            let visibleCount = 0;

            rows.forEach(row => {
                const matchesCategory = categoryFilter ? row.getAttribute('data-category') === categoryFilter : true;
                const matchesPlan = planFilter ? row.getAttribute('data-plan') === planFilter : true;

                if (matchesCategory && matchesPlan) {
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
            const rows = Array.from(coursesTable.querySelectorAll('tbody tr'));
            let visibleCount = 0;

            rows.forEach(row => {
                const title = row.querySelector('td:nth-child(1)').innerText.toLowerCase();
                
                if (title.includes(searchTerm)) {
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
