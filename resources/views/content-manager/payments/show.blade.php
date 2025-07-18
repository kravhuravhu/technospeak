@extends('layouts.admin')

@section('title', 'Payment Details')

@section('content')
<div class="admin-header">
    <div class="page-title">
        <h1>Payment Details</h1>
        <p>Transaction #{{ $payment->transaction_id }}</p>
    </div>
    <div class="user-menu">
        <a href="{{ route('content-manager.payments.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Back to Payments
        </a>
    </div>
</div>

<div class="payment-details-container">
    <div class="payment-card">
        <div class="payment-header">
            <div class="payment-status-badge status-{{ $payment->status }}">
                {{ ucfirst($payment->status) }}
            </div>
            <div class="payment-amount">
                R{{ number_format($payment->amount, 2) }}
            </div>
        </div>
        
        <div class="payment-body">
            <div class="payment-info">
                <div class="info-row">
                    <span class="info-label">Transaction ID:</span>
                    <span class="info-value">{{ $payment->transaction_id ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Date:</span>
                    <span class="info-value">{{ $payment->created_at->format('M d, Y \a\t h:i A') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Payment Method:</span>
                    <span class="info-value">{{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Client:</span>
                    <span class="info-value">
                        {{ $payment->client->name }} ({{ $payment->client->email }})
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Service:</span>
                    <span class="info-value">
                        @php
                            $service = $payment->detailed_service_name;
                        @endphp
                        
                        @isset($service['title'])
                            {{ $service['title'] }}
                        @endisset
                        - {{ $service['type'] }}
                        
                        @isset($service['category'])
                            <div class="text-sm text-gray-600 mt-1">
                                Category: {{ $service['category'] }}
                            </div>
                        @endisset
                    </span>
                </div>
            </div>
            
            <div class="payment-actions">
                @if($payment->status === 'pending')
                    <form action="{{ route('content-manager.payments.approve', $payment) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check"></i> Approve Payment
                        </button>
                    </form>
                @endif
                
                @if($payment->status === 'completed' && $payment->payment_method === 'stripe')
                    <a href="https://dashboard.stripe.com/payments/{{ $payment->transaction_id }}" 
                       target="_blank" 
                       class="btn btn-outline">
                        <i class="fas fa-external-link-alt"></i> View in Stripe
                    </a>
                @endif
            </div>
        </div>
    </div>
    
    @if($payment->payable)
    <div class="related-item-card">
        <h3>Related {{ ucfirst($payment->payable_type) }}</h3>
        <div class="client-details">
            @if($payment->payable_type === 'training')
                <div class="detail-row">
                    <span class="detail-label">Title:</span>
                    <span class="detail-value">{{ $payment->payable->title }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Type:</span>
                    <span class="detail-value">{{ $payment->payable->type->name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Date:</span>
                    <span class="detail-value">{{ $payment->payable->scheduled_for->format('M d, Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Time:</span>
                    <span class="detail-value">{{ $payment->payable->from_time->format('H:i') }} - {{ $payment->payable->to_time->format('H:i') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Instructor:</span>
                    <span class="detail-value">{{ $payment->payable->instructor->name ?? 'N/A' }}</span>
                </div>
                <a href="{{ route('content-manager.trainings.show', $payment->payable) }}" 
                class="btn btn-outline btn-sm mt-2">
                    View Training Details
                </a>
            @elseif($payment->payable_type === 'course')
                <div class="detail-row">
                    <span class="detail-label">Title:</span>
                    <span class="detail-value">{{ $payment->payable->title }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Category:</span>
                    <span class="detail-value">{{ $payment->payable->category->name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Instructor:</span>
                    <span class="detail-value">{{ $payment->payable->instructor->name ?? 'N/A' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Duration:</span>
                    <span class="detail-value">{{ $payment->payable->formatted_duration }}</span>
                </div>
                <a href="{{ route('content-manager.courses.show', $payment->payable) }}" 
                class="btn btn-outline btn-sm mt-2">
                    View Course Details
                </a>
            @endif
        </div>
    </div>
    @endif
    
    <div class="client-card">
        <h3>Client Information</h3>
        <div class="client-details">
            <div class="detail-row">
                <span class="detail-label">Name:</span>
                <span class="detail-value">{{ $payment->client->name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Email:</span>
                <span class="detail-value">{{ $payment->client->email }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">User Type:</span>
                <span class="detail-value">{{ $payment->client->userType }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Registered:</span>
                <span class="detail-value">{{ $payment->client->registered_date->format('M d, Y') }}</span>
            </div>
            
            <a href="{{ route('content-manager.clients.show', $payment->client) }}" 
               class="btn btn-outline btn-sm mt-2">
                View Client Profile
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.payment-details-container {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
}

@media (min-width: 992px) {
    .payment-details-container {
        grid-template-columns: 2fr 1fr;
    }
}

.payment-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    grid-column: 1 / -1;
}

.payment-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    background-color: var(--darkBlue);
    color: white;
}

.payment-status-badge {
    padding: 0.5rem 1rem;
    border-radius: 9999px;
    font-weight: 600;
    font-size: 0.9rem;
}

.payment-status-badge.status-completed {
    background-color: var(--success);
}

.payment-status-badge.status-pending {
    background-color: var(--warning);
    color: var(--textDark);
}

.payment-status-badge.status-failed {
    background-color: var(--danger);
}

.payment-amount {
    font-size: 1.75rem;
    font-weight: 700;
}

.payment-body {
    padding: 1.5rem;
}

.info-row {
    display: flex;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #eee;
}

.info-label {
    font-weight: 600;
    color: var(--darkBlue);
    width: 180px;
}

.info-value {
    flex: 1;
}

.payment-actions {
    margin-top: 2rem;
    display: flex;
    gap: 1rem;
}

.related-item-card, .client-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    padding: 1.5rem;
}

.related-item-card h3, .client-card h3 {
    margin-bottom: 1.5rem;
    color: var(--darkBlue);
    font-size: 1.25rem;
    border-bottom: 1px solid #eee;
    padding-bottom: 0.75rem;
}

.item-details h4 {
    font-size: 1.1rem;
    margin-bottom: 1rem;
    color: var(--powBlue);
}

.detail-row {
    margin-bottom: 0.75rem;
}

.detail-label {
    font-weight: 600;
    color: var(--darkBlue);
    display: inline-block;
    width: 100px;
}

.detail-value {
    color: var(--textDark);
}
</style>
@endpush