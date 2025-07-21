<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Client</th>
            <th>Category</th>
            <th>Urgency</th>
            <th>Status</th>
            <th>Submitted</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($issues as $issue)
        <tr class="issue-{{ $issue->status }}">
            <td>#{{ $issue->id }}</td>
            <td>{{ $issue->title }}</td>
            <td>{{ $issue->client->name }} {{ $issue->client->surname }}</td>
            <td>{{ ucfirst($issue->category) }}</td>
            <td>
                <span class="badge badge-{{ $issue->urgency }}">
                    {{ ucfirst($issue->urgency) }}
                </span>
            </td>
            <td>
                <span class="badge badge-{{ $issue->status }}">
                    {{ ucfirst($issue->status) }}
                </span>
            </td>
            <td>{{ $issue->created_at->diffForHumans() }}</td>
            <td>
                <a href="{{ route('admin.issues.show', $issue) }}" class="btn btn-sm btn-primary">View</a>
                @if($issue->status === 'open')
                <button class="btn btn-sm btn-success assign-btn" 
                        data-issue-id="{{ $issue->id }}"
                        data-toggle="modal" 
                        data-target="#assignModal">
                    Assign
                </button>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Assign Modal -->
<div class="modal fade" id="assignModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="assignForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Assign Issue</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="instructor_id">Select Instructor</label>
                        <select name="instructor_id" id="instructor_id" class="form-control" required>
                            @foreach($instructors as $instructor)
                            <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="admin_notes">Notes (Optional)</label>
                        <textarea name="admin_notes" id="admin_notes" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Assign</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const assignModal = document.getElementById('assignModal');
    const assignForm = document.getElementById('assignForm');
    
    assignModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const issueId = button.getAttribute('data-issue-id');
        assignForm.action = `/admin/issues/${issueId}/assign`;
    });
});
</script>