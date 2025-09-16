<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful - Technospeak</title>
    <style>
        :root {
            --primary-color: #38b6ff;
            --primary-dark: #2a9ce8;
            --secondary-color: #15415a;
            --success-color: #38a169;
            --text-color: #333;
            --light-gray: #f8f9fa;
            --white: #fff;
            --border-radius: 12px;
            --box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body { 
            font-family: Arial, sans-serif; 
            background: #f0f2f5; 
            padding: 1rem; 
            text-align: center;
            line-height: 1.6;
            color: var(--text-color);
        }
        
        .container { 
            max-width: 600px; 
            margin: auto; 
            background: var(--white); 
            padding: 1.5rem;
            border-radius: var(--border-radius); 
            box-shadow: var(--box-shadow);
        }
        
        .success-icon { 
            color: var(--success-color); 
            font-size: 3rem; 
            margin-bottom: 1rem; 
        }
        
        h2 { 
            color: var(--secondary-color); 
            margin-bottom: 1rem; 
            font-size: 1.5rem;
        }
        
        p {
            margin-bottom: 1rem;
        }
        
        .details { 
            text-align: left; 
            background: var(--light-gray); 
            padding: 1rem; 
            border-radius: 8px; 
            margin: 1rem 0; 
        }
        
        .details p {
            margin-bottom: 0.5rem;
        }
        
        .btn { 
            background: var(--primary-color); 
            color: var(--white); 
            padding: 0.875rem 1.25rem; 
            text-decoration: none; 
            border-radius: 8px; 
            display: inline-block; 
            margin: 0.5rem;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        
        .btn:hover { 
            background: var(--primary-dark); 
        }
        
        .btn-gray {
            background: #6c757d;
        }
        
        .btn-gray:hover {
            background: #5a6268;
        }
        
        /* Responsive adjustments */
        @media (max-width: 576px) {
            body {
                padding: 0.75rem;
            }
            
            .container {
                padding: 1.25rem;
            }
            
            .success-icon {
                font-size: 2.5rem;
            }
            
            h2 {
                font-size: 1.35rem;
            }
            
            .details {
                padding: 0.875rem;
            }
            
            .btn {
                display: block;
                margin: 0.5rem auto;
                width: 100%;
                max-width: 250px;
            }
        }
        
        @media (max-width: 400px) {
            .container {
                padding: 1rem;
            }
            
            h2 {
                font-size: 1.25rem;
            }
            
            .success-icon {
                font-size: 2rem;
            }
            
            .details {
                padding: 0.75rem;
                font-size: 0.9rem;
            }
        }
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
    <a href="{{ route('dashboard') }}" class="btn btn-gray">Back to Dashboard</a>
</div>
</body>
</html>