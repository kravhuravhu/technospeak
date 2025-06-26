@extends('layouts.admin')

@section('title', 'Payment Management')

@section('content')
<div class="admin-header">
    <div class="page-title">
        <h1>Payments</h1>
        <p>Manage all payment transactions</p>
    </div>
    <div class="user-menu">
        <button class="btn btn-primary">
            <i class="fas fa-download"></i> Export Report
        </button>
    </div>
</div>

<div class="data-table">
    <div class="data-table-header">
        <div class="data-table-title">
            <h3>Payment History</h3>
        </div>
        <div class="table-actions">
            <div class="date-filter">
                <input type="date" class="form-control">
                <span>to</span>
                <input type="date" class="form-control">
                <button class="btn btn-outline">
                    <i class="fas fa-filter"></i> Apply
                </button>
            </div>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Client</th>
                <th>Course</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
            <tr>
                <td>#{{ $payment->transaction_id }}</td>
                <td>{{ $payment->client->name }}</td>
                <td>{{ $payment->course->title }}</td>
                <td>${{ number_format($payment->amount, 2) }}</td>
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
                        <button class="btn btn-outline btn-sm">
                            <i class="fas fa-eye"></i>
                        </button>
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
    
    <div class="data-table-footer">
        {{ $payments->links() }}
        
        <div class="summary">
            <strong>Total: ${{ number_format($totalRevenue, 2) }}</strong>
            <span>Pending: ${{ number_format($pendingAmount, 2) }}</span>
        </div>
    </div>
</div>
@endsection