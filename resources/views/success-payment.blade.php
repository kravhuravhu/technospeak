<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful - Technospeak</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f2f5; padding: 2rem; }
        .container { max-width: 600px; margin: auto; background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center; }
        .success-icon { color: #38a169; font-size: 4rem; margin-bottom: 1rem; }
        h1 { color: #15415a; margin-bottom: 1rem; }
        .details { background: #f8f9fa; padding: 1.5rem; border-radius: 8px; margin: 1.5rem 0; text-align: left; }
        .detail-item { margin-bottom: 0.5rem; }
        .buttons { display: flex; gap: 1rem; justify-content: center; margin-top: 2rem; }
        .btn { padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: bold; }
        .btn-primary { background: #38b6ff; color: white; }
        .btn-secondary { background: #e2e8f0; color: #4a5568; }
        .btn:hover { opacity: 0.9; }
    </style>
</head>
<body>
<div class="container">
    <div class="success-icon">✅</div>
    <h1>Payment Successful!</h1>
    <p>Thank you for your payment. You are now registered for the training session.</p>

    <div class="details">
        <div class="detail-item"><strong>Session:</strong> {{ $trainingSession->title }}</div>
        <div class="detail-item"><strong>Date:</strong> {{ $trainingSession->scheduled_for->format('F j, Y') }}</div>
        <div class="detail-item"><strong>Time:</strong> {{ $trainingSession->scheduled_for->format('g:i A') }}</div>
        <div class="detail-item"><strong>Amount Paid:</strong> R{{ number_format($payment->amount, 2) }}</div>
        <div class="detail-item"><strong>Transaction ID:</strong> {{ $payment->transaction_id }}</div>
        <div class="detail-item"><strong>Payment Method:</strong> {{ ucfirst($payment->payment_method) }}</div>
    </div>

    <p>You will receive a confirmation email shortly with the session details.</p>

    <div class="buttons">
        <a href="{{ route('dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
        <a href="{{ url('/') }}" class="btn btn-secondary">Return Home</a>
    </div>
</div>
</body>
</html>