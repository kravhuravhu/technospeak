@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="admin-header">
    <div class="page-title">
        <h1>Dashboard</h1>
        <p>Welcome back, {{ Auth::guard('admin')->user()->name }}</p>
    </div>
    <div class="user-menu">
        <div class="user-info">
            <h4>{{ Auth::guard('admin')->user()->name }}</h4>
            <p>Admin</p>
        </div>
        <img src="{{ Auth::user()->avatar ?? asset('images/icons/circle-user-solid.svg') }}" alt="User Avatar">
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card" style="background: var(--skBlue)">
        <div class="icon">
            <i class="fas fa-book"></i>
        </div>
        <h3>Total Courses</h3>
        <div class="value">{{ $coursesCount }}</div>
        <div class="change positive">
            <i class="fas fa-arrow-up"></i> 12% from last month
        </div>
    </div>
    
    <div class="stat-card" style="background: var(--darkBlue)">
        <div class="icon">
            <i class="fas fa-users"></i>
        </div>
        <h3>Active Clients</h3>
        <div class="value">{{ $activeClients }}</div>
        <div class="change positive">
            <i class="fas fa-arrow-up"></i> 5% from last month
        </div>
    </div>
    
    <div class="stat-card" style="background: var(--powBlue)">
        <div class="icon">
            <i class="fas fa-credit-card"></i>
        </div>
        <h3>Pending Payments</h3>
        <div class="value">{{ $pendingPayments }}</div>
        <div class="change negative">
            <i class="fas fa-arrow-down"></i> 3% from last month
        </div>
    </div>
    
    <div class="stat-card" style="background: #38a169;">
        <div class="icon">
            <i class="fas fa-video"></i>
        </div>
        <h3>Training Sessions</h3>
        <div class="value">{{ $trainingSessions }}</div>
        <div class="change positive">
            <i class="fas fa-arrow-up"></i> 8% from last month
        </div>
    </div>
</div>

<div class="form-row">
    <div class="data-table">
        <div class="data-table-header">
            <div class="data-table-title">
                <h3>Recent Clients</h3>
            </div>
            <div class="table-actions">
                <a href="{{ route('content-manager.clients.clients') }}" class="btn btn-outline">
                    View All
                </a>
            </div>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Joined</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentClients as $client)
                <tr>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->registered_date->format('M d, Y') }}</td>
                    <td>
                        @if($client->email_verified_at)
                            <span class="status-badge status-active">Active</span>
                        @else
                            <span class="status-badge status-inactive">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('content-manager.clients.show', $client->id) }}" class="btn btn-outline btn-sm">
                            <i class="fas fa-eye"></i> View
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="activity-feed">
        <h3 class="section-title">Recent Activity</h3>
        <p>Coming up</p>
        {{--
            @foreach($recentActivities as $activity)
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fas fa-{{ $activity->icon }}"></i>
                </div>
                <div class="activity-content">
                    <p class="activity-text">{{ $activity->description }}</p>
                    <span class="activity-time">{{ $activity->created_at->diffForHumans() }}</span>
                </div>
            </div>
            @endforeach
        --}}
        <a href="#" class="btn btn-outline" style="margin-top: 1rem; display: inline-block;">
            View All Activity
        </a>
    </div>
</div>
@endsection