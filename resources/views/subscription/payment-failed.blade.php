<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Payment Failed - Technospeak</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background: #f0f2f5; 
            padding: 1.5rem; 
            text-align: center; 
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container { 
            max-width: 520px; 
            margin: auto; 
            background: white; 
            padding: 1.8rem; 
            border-radius: 10px; 
            box-shadow: 0 3px 5px rgba(0,0,0,0.08); 
        }
        .error-icon { 
            color: #e53e3e; 
            font-size: 3.2rem; 
            margin-bottom: 0.8rem; 
        }
        h2 { 
            color: #15415a; 
            margin-bottom: 0.8rem; 
            font-size: 1.6rem;
        }
        p {
            color: #4a5568;
            line-height: 1.5;
            margin-bottom: 0.8rem;
            font-size: 0.95rem;
        }
        .btn { 
            background: #38b6ff; 
            color: white; 
            padding: 0.65rem 1.3rem; 
            text-decoration: none; 
            border-radius: 6px; 
            display: inline-block; 
            margin: 0.4rem;
            font-weight: 500;
            transition: background-color 0.2s;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
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
            margin-top: 1.2rem;
            padding-top: 0.8rem;
            border-top: 1px solid #e2e8f0;
            font-size: 0.85rem;
            color: #718096;
        }
        .support-info strong {
            font-weight: 600;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="error-icon">✗</div>
    <h2>Subscription Payment Failed</h2>
    <p>We're sorry, but your subscription payment could not be processed.</p>
    <p>Please try again or contact our support team if the problem persists.</p>
    
    <div>
        <!-- Use an existing route or direct URL -->
        <a href="{{ url('/subscription') }}" class="btn">Try Again</a>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
    </div>
    
    <div class="support-info">
        <p>Need help? Contact our support team at <strong>technospeakmails@gmail.com</strong> or call <strong>+27 861 777 372</strong></p>
    </div>
</div>
</body>
</html>