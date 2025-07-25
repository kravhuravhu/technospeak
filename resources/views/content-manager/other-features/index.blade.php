@extends('layouts.admin')

@section('title', 'Other Features')

@section('content')
<style>
    .tab-container {
        margin-bottom: 2rem;
    }
    
    .tab-buttons {
        display: flex;
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 1.5rem;
    }
    
    .tab-button {
        padding: 0.75rem 1.5rem;
        background: none;
        border: none;
        cursor: pointer;
        font-weight: 500;
        color: #64748b;
        position: relative;
        transition: all 0.2s;
    }
    
    .tab-button.active {
        color: var(--skBlue);
    }
    
    .tab-button.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
        height: 2px;
        background-color: var(--skBlue);
    }
    
    .tab-button:hover:not(.active) {
        color: #475569;
    }
    
    .tab-content {
        display: none;
    }
    
    .tab-content.active {
        display: block;
    }
    
    .data-table {
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        overflow: hidden;
        margin-bottom: 2rem;
    }
    
    .data-table-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .data-table-title h3 {
        margin: 0;
        font-size: 1.25rem;
        color: var(--skBlue);
    }
    
    .table-actions {
        display: flex;
        gap: 0.75rem;
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
    }
    
    th {
        background-color: #f8fafc;
        padding: 0.75rem 1rem;
        text-align: left;
        font-weight: 600;
        color: #475569;
        border-bottom: 1px solid #e2e8f0;
    }
    
    td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    
    tr:last-child td {
        border-bottom: none;
    }
    
    tr:hover td {
        background-color: #f8fafc;
    }
    
    .btn-group {
        display: flex;
        gap: 0.5rem;
    }
    
    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .status-active {
        background-color: rgba(56, 161, 105, 0.1);
        color: var(--success);
    }
    
    .status-inactive {
        background-color: rgba(226, 232, 240, 0.5);
        color: #64748b;
    }
    
    .empty-state {
        padding: 2rem;
        text-align: center;
        color: #64748b;
    }
    
    .empty-state i {
        font-size: 2rem;
        margin-bottom: 1rem;
        color: #cbd5e1;
    }
    
    .data-table-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: center;
    }
    
    .admin-header {
        margin-bottom: 2rem;
    }
</style>

<div class="admin-header">
    <div class="page-title">
        <h1>Other Features</h1>
        <p>Manage instructors • Categories • Resources • Trainings</p>
    </div>
    <div class="user-menu">
        <button id="createNewBtn" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create New
        </button>
    </div>
</div>

<div class="tab-container">
    <div class="tab-buttons">
        <button class="tab-button active" data-tab="instructors">Instructors</button>
        <button class="tab-button" data-tab="categories">Course Categories</button>
        <button class="tab-button" data-tab="resource-types">Resource Types</button>
        <button class="tab-button" data-tab="training-types">Training Types</button>
    </div>
    
    <!-- Instructors Tab -->
    <div class="tab-content active" id="instructors-tab">
        <div class="data-table">
            <div class="data-table-header">
                <div class="data-table-title">
                    <h3>All Instructors</h3>
                </div>
                <div class="table-actions">
                    <div class="search-box">
                        <input type="text" placeholder="Search instructors..." class="form-control" id="instructors-search">
                    </div>
                </div>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Assigned Issues</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($instructors as $instructor)
                    <tr>
                        <td>{{ $instructor->name }}</td>
                        <td>{{ $instructor->email }}</td>
                        <td>{{ $instructor->assignedIssues->count() }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('content-manager.other-features.instructors.edit', $instructor) }}" class="btn btn-outline btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('content-manager.other-features.instructors.destroy', $instructor) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="empty-state">
                            <i class="fas fa-user-tie"></i>
                            <p>No instructors found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="data-table-footer">
                {{ $instructors->links() }}
            </div>
        </div>
    </div>
    
    <!-- Course Categories Tab -->
    <div class="tab-content" id="categories-tab">
        <div class="data-table">
            <div class="data-table-header">
                <div class="data-table-title">
                    <h3>Course Categories</h3>
                </div>
                <div class="table-actions">
                    <div class="search-box">
                        <input type="text" placeholder="Search categories..." class="form-control" id="categories-search">
                    </div>
                </div>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Courses</th>
                        <th>Total Duration</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->courses->count() }}</td>
                        <td>{{ $category->formatted_total_duration }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('content-manager.other-features.categories.edit', $category) }}" class="btn btn-outline btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('content-manager.other-features.categories.destroy', $category) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure? This will affect all associated courses.')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="empty-state">
                            <i class="fas fa-layer-group"></i>
                            <p>No categories found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="data-table-footer">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
    
    <!-- Resource Types Tab -->
    <div class="tab-content" id="resource-types-tab">
        <div class="data-table">
            <div class="data-table-header">
                <div class="data-table-title">
                    <h3>Resource Types</h3>
                </div>
                <div class="table-actions">
                    <div class="search-box">
                        <input type="text" placeholder="Search resource types..." class="form-control" id="resource-types-search">
                    </div>
                </div>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Used In Resources</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($resourceTypes as $type)
                    <tr>
                        <td>{{ $type->name }}</td>
                        <td>{{ $type->resources->count() }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('content-manager.other-features.resource-types.edit', $type) }}" class="btn btn-outline btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('content-manager.other-features.resource-types.destroy', $type) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure? This will affect all associated resources.')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="empty-state">
                            <i class="fas fa-paperclip"></i>
                            <p>No resource types found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="data-table-footer">
                {{ $resourceTypes->links() }}
            </div>
        </div>
    </div>
    
    <!-- Training Types Tab -->
    <div class="tab-content" id="training-types-tab">
        <div class="data-table">
            <div class="data-table-header">
                <div class="data-table-title">
                    <h3>Training Types</h3>
                </div>
                <div class="table-actions">
                    <div class="search-box">
                        <input type="text" placeholder="Search training types..." class="form-control" id="training-types-search">
                    </div>
                </div>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Group Session</th>
                        <th>Student Price</th>
                        <th>Professional Price</th>
                        <th>Sessions</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trainingTypes as $type)
                    <tr>
                        <td>{{ $type->name }}</td>
                        <td>
                            @if($type->is_group_session)
                                <span class="status-badge status-active">Yes</span>
                            @else
                                <span class="status-badge status-inactive">No</span>
                            @endif
                        </td>
                        <td>R{{ number_format($type->student_price, 2) }}</td>
                        <td>R{{ number_format($type->professional_price, 2) }}</td>
                        <td>{{ $type->sessions->count() }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('content-manager.other-features.training-types.edit', $type) }}" class="btn btn-outline btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('content-manager.other-features.training-types.destroy', $type) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure? This will affect all associated sessions.')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            <i class="fas fa-graduation-cap"></i>
                            <p>No training types found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="data-table-footer">
                {{ $trainingTypes->links() }}
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching functionality
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all buttons and contents
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Add active class to clicked button and corresponding content
            button.classList.add('active');
            const tabId = button.getAttribute('data-tab');
            document.getElementById(`${tabId}-tab`).classList.add('active');
            
            // Update create button link
            updateCreateButtonLink(tabId);
        });
    });
    
    // Create button functionality
    const createNewBtn = document.getElementById('createNewBtn');
    
    function updateCreateButtonLink(tabId) {
        let route;
        switch(tabId) {
            case 'instructors':
                route = "{{ route('content-manager.other-features.instructors.create') }}";
                break;
            case 'categories':
                route = "{{ route('content-manager.other-features.categories.create') }}";
                break;
            case 'resource-types':
                route = "{{ route('content-manager.other-features.resource-types.create') }}";
                break;
            case 'training-types':
                route = "{{ route('content-manager.other-features.training-types.create') }}";
                break;
            default:
                route = "#";
        }
        
        if (createNewBtn.tagName === 'A') {
            createNewBtn.href = route;
        } else {
            // Convert button to link if not already
            const link = document.createElement('a');
            link.href = route;
            link.className = createNewBtn.className;
            link.innerHTML = createNewBtn.innerHTML;
            createNewBtn.parentNode.replaceChild(link, createNewBtn);
        }
    }
    
    // Initialize with first tab
    updateCreateButtonLink('instructors');
    
    // Search functionality for each table
    function setupTableSearch(inputId, tableIndex) {
        const searchInput = document.getElementById(inputId);
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const filter = this.value.toLowerCase();
                const rows = document.querySelectorAll(`.tab-content:nth-child(${tableIndex + 1}) table tbody tr`);
                
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(filter) ? '' : 'none';
                });
            });
        }
    }
    
    setupTableSearch('instructors-search', 1);
    setupTableSearch('categories-search', 2);
    setupTableSearch('resource-types-search', 3);
    setupTableSearch('training-types-search', 4);
});
</script>
@endsection