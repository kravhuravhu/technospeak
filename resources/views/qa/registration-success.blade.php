@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Registration Successful</div>

                <div class="card-body">
                    <div class="alert alert-success">
                        <h4>Thank you for your payment!</h4>
                        <p>Your registration for "{{ $session->title }}" has been confirmed.</p>
                    </div>

                    <h5>Session Details</h5>
                    <ul>
                        <li><strong>Date:</strong> {{ $session->scheduled_for->format('F j, Y') }}</li>
                        <li><strong>Time:</strong> {{ $session->scheduled_for->format('g:i A') }}</li>
                        <li><strong>Amount Paid:</strong> R{{ number_format($registration->amount, 2) }}</li>
                    </ul>

                    <p>A confirmation email has been sent to {{ $registration->email }}.</p>

                    <a href="{{ url('/') }}" class="btn btn-primary">Return to Home</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection