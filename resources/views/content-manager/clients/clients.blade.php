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
                <th>User Type</th>
                <th>Courses Enrolled</th>
                <th>Preferred Trainings</th>
                <th>Verified</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
            <tr>
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
    
    <div class="data-table-footer">
        {{ $clients->links() }}
    </div>
</div>
@endsection