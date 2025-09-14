<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Failed - Technospeak</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f2f5; padding: 2rem; text-align: center; }
        .container { max-width: 600px; margin: auto; background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .error-icon { color: #e53e3e; font-size: 4rem; margin-bottom: 1rem; }
        h2 { color: #15415a; margin-bottom: 1rem; }
        .btn { background: #38b6ff; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 8px; display: inline-block; margin-top: 1rem; }
        .btn:hover { background: #2a9ce8; }
    </style>
</head>
<body>
<div class="container">
    <div class="error-icon">✗</div>
    <h2>Payment Failed</h2>
    <p>We're sorry, but your payment could not be processed.</p>
    <p>Please try again or contact support if the problem persists.</p>
    
    <a href="{{ route('dashboard') }}" class="btn">Back to Dashboard</a>
    <a href="javascript:history.back()" class="btn" style="background: #6c757d;">Try Again</a>
</div>
</body>
</html>