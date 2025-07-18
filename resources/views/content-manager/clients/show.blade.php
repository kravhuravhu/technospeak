@extends('layouts.admin')

@section('title', $client->full_name)

@section('content')
<div class="admin-header">
    <div class="page-title">
        <h1>{{ $client->full_name }}</h1>
        <p>Client ID: {{ $client->id }} • Registered: {{ $client->registered_date->format('M d, Y') }}  {{ $client->registered_time }}</p>
    </div>
    <div class="user-menu">
        <a href="{{ route('content-manager.clients.edit', $client) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit Client
        </a>
        <form action="{{ route('content-manager.clients.destroy', $client->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                <i class="fas fa-trash"></i> Delete Client
            </button>
        </form>
    </div>
</div>

<div class="form-row">
    <div class="form-card" style="flex: 1;">
        <h3 style="margin-bottom: 1.5rem;">Client Details</h3>
        
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Email</label>
                <p>{{ $client->email }}
                    <span>&nbsp•&nbsp
                    @if($client->email_verified_at)
                        <span class="status-badge status-active"><i>&nbspVerified</i></span>
                    @else
                        <span class="status-badge status-inactive"><i>Not Verified</i></span>
                    @endif
                    </span>
                </p>
            </div>
            
            <div class="form-group">
                <label class="form-label">Preferred Category</label>
                <p>{{ $client->preferredCategory->name ?? 'None' }}</p>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Subscription Type</label>
                <p>{{ $client->subscription_type ?? 'None' }}</p>
            </div>
            
            <div class="form-group">
                <label class="form-label">Subscription Expiry</label>
                <p>{{ $client->subscription_expiry ? $client->subscription_expiry->format('M d, Y') : 'None' }}</p>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">User Type</label>
                <p>{{ $client->userType ?? 'None' }}</p>
            </div>
        </div>
    </div>
    
    <div class="form-card" style="flex: 1;">
        <h3 style="margin-bottom: 1.5rem;">Quick Actions</h3>
        
        <form action="{{ route('content-manager.clients.enroll-course', $client) }}" method="POST" class="mb-4">
            @csrf
            <div class="form-group">
                <label for="course_id" class="form-label">Enroll in Course</label>
                <select name="course_id" id="course_id" class="form-control" required>
                    <option value="">Select Course</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <select name="payment_status" class="form-control" required>
                    <option value="free">Free Enrollment</option>
                    <option value="paid">Paid Enrollment</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-book"></i> Enroll
            </button>
        </form>
        
        <form action="{{ route('content-manager.clients.register-training', $client) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="session_id" class="form-label">Register for Training</label>
                <select name="session_id" id="session_id" class="form-control" required>
                    <option value="">Select Training Session</option>
                    @foreach($trainingSessions as $training)
                        <option value="{{ $training->id }}">
                            {{ $training->title }} ({{ $training->scheduled_for->format('M d') }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <select name="payment_status" class="form-control" required>
                    <option value="pending">Pending Payment</option>
                    <option value="paid">Paid</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-calendar-check"></i> Register
            </button>
        </form>
    </div>
</div>

<div class="tabs" style="margin-top: 2rem;">
    <div class="tab-header">
        <button class="tab-btn active" data-tab="courses">Courses ({{ $client->courseSubscriptions->count() }})</button>
        <button class="tab-btn" data-tab="trainings">Trainings ({{ $client->trainingRegistrations->count() }})</button>
        <button class="tab-btn" data-tab="payments">Payments ({{ $client->payments->count() }})</button>
    </div>
    
    <div class="tab-content active" id="courses-tab">
        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Category</th>
                        <th>Enrolled</th>
                        <th>Status</th>
                        <th>Progress</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($client->courseSubscriptions as $subscription)
                    <tr>
                        <td>{{ $subscription->course->title }}</td>
                        <td>{{ $subscription->course->category->name }}</td>
                        <td>{{ $subscription->subscribed_at->format('M d, Y') }}</td>
                        <td>
                            <span class="status-badge status-{{ $subscription->payment_status === 'paid' ? 'active' : 'pending' }}">
                                {{ ucfirst($subscription->payment_status) }}
                            </span>
                        </td>
                        <td>
                            @if($subscription->completed)
                                <span class="status-badge status-active">Completed</span>
                            @else
                                <div class="progress-bar">
                                    <div class="progress" style="width: {{ $subscription->progress_percent }}%"></div>
                                    <span>{{ $subscription->progress_percent }}%</span>
                                </div>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('content-manager.courses.show', $subscription->course) }}" 
                               class="btn btn-outline btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('content-manager.client-courses.destroy') }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="subscription_id" value="{{ $subscription->id }}">
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Remove this enrollment?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="tab-content" id="trainings-tab">
        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th>Training</th>
                        <th>Type</th>
                        <th>Scheduled</th>
                        <th>Status</th>
                        <th>Attendance</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($client->trainingRegistrations as $registration)
                    <tr>
                        <td>{{ $registration->session->title }}</td>
                        <td>{{ $registration->session->type->name }}</td>
                        <td>{{ $registration->session->scheduled_for->format('M d, Y') }}</td>
                        <td>
                            <span class="status-badge status-{{ $registration->payment_status === 'paid' ? 'active' : 'pending' }}">
                                {{ ucfirst($registration->payment_status) }}
                            </span>
                        </td>
                        <td>
                            @if($registration->attended)
                                <span class="status-badge status-active">Attended</span>
                            @elseif($registration->session->scheduled_for->isPast())
                                <span class="status-badge status-inactive">Missed</span>
                            @else
                                <span class="status-badge status-pending">Pending</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('content-manager.trainings.show', $registration->session) }}" 
                               class="btn btn-outline btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="tab-content" id="payments-tab">
        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>For</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th>Item</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($client->payments->sortByDesc('created_at') as $payment)
                    <tr>
                        <td>{{ $payment->created_at->format('M d, Y') }}</td>
                        <td>R{{ number_format($payment->amount, 2) }}</td>
                        <td>
                            @php
                                $service = $payment->detailed_service_name;
                            @endphp
                            
                            @isset($service['title'])
                                {{ $service['title'] }}
                            @endisset
                        </td>
                        <td>{{ ucfirst($payment->payment_method) }}</td>
                        <td>
                            <span class="status-badge status-{{ $payment->status }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('content-manager.clients.show', $payment->client->id) }}" class="btn btn-outline btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .tabs {
        margin-bottom: 2rem;
    }
    
    .tab-header {
        display: flex;
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 1rem;
    }
    
    .tab-btn {
        padding: 0.75rem 1.5rem;
        background: none;
        border: none;
        cursor: pointer;
        font-weight: 500;
        color: #718096;
        position: relative;
    }
    
    .tab-btn.active {
        color: var(--skBlue);
    }
    
    .tab-btn.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
        height: 2px;
        background-color: var(--skBlue);
    }
    
    .tab-content {
        display: none;
    }
    
    .tab-content.active {
        display: block;
    }
    
    .progress-bar {
        height: 20px;
        background-color: #edf2f7;
        border-radius: 4px;
        position: relative;
        width: 100%;
    }
    
    .progress {
        height: 100%;
        background-color: var(--skBlue);
        border-radius: 4px;
    }
    
    .progress-bar span {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        font-size: 0.7rem;
        color: white;
        font-weight: bold;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabBtns = document.querySelectorAll('.tab-btn');
        
        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all buttons and content
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Show corresponding content
                const tabId = this.getAttribute('data-tab');
                document.getElementById(`${tabId}-tab`).classList.add('active');
            });
        });
    });
</script>
@endsection