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
    
    <div class="data-table-footer">
        {{ $sessions->links() }}
    </div>
</div>
@endsection