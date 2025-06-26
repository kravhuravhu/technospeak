@extends('layouts.admin')

@section('title', 'Manage Clients')

@section('content')
<div class="admin-header">
    <div class="page-title">
        <h1>Clients</h1>
        <p>Manage all registered clients</p>
    </div>
    <div class="user-menu">
        <div class="search-box">
            <input type="text" placeholder="Search clients..." class="form-control">
            <button class="btn btn-outline">
                <i class="fas fa-search"></i>
            </button>
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
                <i class="fas fa-download"></i> Export
            </button>
            <button class="btn btn-outline">
                <i class="fas fa-filter"></i> Filter
            </button>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Courses</th>
                <th>Last Active</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
            <tr>
                <td>
                    <div style="display: flex; align-items: center;">
                        <img src="{{ $client->avatar ?? asset('images/default-avatar.png') }}" 
                             alt="{{ $client->name }}" 
                             style="width: 32px; height: 32px; border-radius: 50%; margin-right: 10px;">
                        {{ $client->name }}
                    </div>
                </td>
                <td>{{ $client->email }}</td>
                <td>{{ $client->courses_count }}</td>
                <td>{{ $client->last_active_at ? $client->last_active_at->diffForHumans() : 'Never' }}</td>
                <td>
                    @if($client->is_active)
                        <span class="status-badge status-active">Active</span>
                    @else
                        <span class="status-badge status-inactive">Inactive</span>
                    @endif
                </td>
                <td>
                    <div class="btn-group">
                        <a href="{{ route('admin.clients.show', $client->id) }}" class="btn btn-outline btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.clients.edit', $client->id) }}" class="btn btn-outline btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.clients.destroy', $client->id) }}" method="POST" style="display:inline;">
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
        {{ $clients->links() }}
    </div>
</div>
@endsection