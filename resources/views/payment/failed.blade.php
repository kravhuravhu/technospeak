<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9fafb;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .failed-container {
            text-align: center;
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }
        .failed-icon {
            color: #e53e3e;
            font-size: 3rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="failed-container">
        <div class="failed-icon">❌</div>
        <h2>Payment Failed</h2>
        <p>We were unable to process your payment. Please try again.</p>
        <a href="{{ route('subscription.premium') }}" class="btn btn-primary">Try Again</a>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Return to Dashboard</a>
    </div>
</body>
</html>