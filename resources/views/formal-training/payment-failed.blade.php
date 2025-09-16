<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed - Technospeak</title>
    <style>
        :root {
            --primary-color: #38b6ff;
            --primary-dark: #2a9ce8;
            --secondary-color: #15415a;
            --error-color: #e53e3e;
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
        
        .error-icon { 
            color: var(--error-color); 
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
            
            .error-icon {
                font-size: 2.5rem;
            }
            
            h2 {
                font-size: 1.35rem;
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
            
            .error-icon {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="error-icon">✗</div>
    <h2>Payment Failed</h2>
    <p>We're sorry, but your payment could not be processed.</p>
    <p>Please try again or contact support if the problem persists.</p>
    <p>Need help? Contact our support team at <strong>technospeakmails@gmail.com</strong> or call <strong>+27 861 777 372</strong></p>
    
    <a href="{{ route('dashboard') }}" class="btn">Back to Dashboard</a>
    <a href="javascript:history.back()" class="btn btn-gray">Try Again</a>
</div>
</body>
</html>