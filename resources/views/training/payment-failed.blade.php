<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training Payment Failed - Technospeak</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background: #f0f2f5; 
            padding: 2rem; 
            text-align: center; 
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container { 
            max-width: 600px; 
            margin: auto; 
            background: white; 
            padding: 2rem; 
            border-radius: 12px; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); 
        }
        .error-icon { 
            color: #e53e3e; 
            font-size: 4rem; 
            margin-bottom: 1rem; 
        }
        h2 { 
            color: #15415a; 
            margin-bottom: 1rem; 
            font-size: 1.8rem;
        }
        p {
            color: #4a5568;
            line-height: 1.6;
            margin-bottom: 1rem;
        }
        .training-details {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin: 1rem 0;
            text-align: left;
        }
        .btn { 
            background: #38b6ff; 
            color: white; 
            padding: 0.75rem 1.5rem; 
            text-decoration: none; 
            border-radius: 8px; 
            display: inline-block; 
            margin: 0.5rem;
            font-weight: 500;
            transition: background-color 0.2s;
            border: none;
            cursor: pointer;
        }
        .btn:hover { 
            background: #2a9ce8; 
        }
        .btn-secondary {
            background: #6c757d;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
        .support-info {
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
            font-size: 0.9rem;
            color: #718096;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="error-icon">✗</div>
    <h2>Training Payment Failed</h2>
    <p>We're sorry, but your training registration payment could not be processed.</p>
    
    @if(isset($session))
    <div class="training-details">
        <h4>Training Details:</h4>
        <p><strong>Session:</strong> {{ $session->title }}</p>
        <p><strong>Date:</strong> {{ $session->scheduled_for->format('M d, Y') }}</p>
        <p><strong>Time:</strong> {{ $session->scheduled_for->format('h:i A') }}</p>
        <p><strong>Amount:</strong> R{{ number_format($payment->amount, 2) }}</p>
    </div>
    @endif
    
    <p>Please try again or contact our support team if the problem persists.</p>
    
    <div>
        @if(isset($session))
        <a href="{{ route('training.register.form', ['session' => $session->id]) }}" class="btn">Try Again</a>
        @endif
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
    </div>
    
    <div class="support-info">
        <p>Need help? Contact our support team at <strong>technospeakmails@gmail.com</strong> or call <strong>+27 861 777 372</strong></p>
        @if(isset($payment) && $payment->metadata)
            <p>Reference: {{ $payment->transaction_id }}</p>
        @endif
    </div>
</div>
</body>
</html>