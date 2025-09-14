<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Successful - Technospeak</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f2f5; padding: 2rem; text-align: center; }
        .container { max-width: 600px; margin: auto; background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .success-icon { color: #38a169; font-size: 4rem; margin-bottom: 1rem; }
        h2 { color: #15415a; margin-bottom: 1rem; }
        .btn { background: #38b6ff; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 8px; display: inline-block; margin-top: 1rem; }
        .btn:hover { background: #2a9ce8; }
        .details { text-align: left; background: #f8f9fa; padding: 1rem; border-radius: 8px; margin: 1rem 0; }
    </style>
</head>
<body>
<div class="container">
    <div class="success-icon">✓</div>
    <h2>Payment Successful!</h2>
    <p>Thank you for enrolling in {{ $course->title }}.</p>
    
    <div class="details">
        <p><strong>Transaction ID:</strong> {{ $payment->transaction_id }}</p>
        <p><strong>Amount Paid:</strong> R{{ number_format($payment->amount, 2) }}</p>
        <p><strong>Date:</strong> {{ $payment->created_at->format('F j, Y g:i A') }}</p>
    </div>
    
    <p>You can now access your training from your dashboard.</p>
    
    <a href="{{ route('enrolled-courses.show', $course->uuid) }}" class="btn">Start Learning</a>
    <a href="{{ route('dashboard') }}" class="btn" style="background: #6c757d;">Back to Dashboard</a>
</div>
</body>
</html>