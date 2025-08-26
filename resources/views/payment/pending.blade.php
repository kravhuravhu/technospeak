<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Processing</title>
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
        .processing-container {
            text-align: center;
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #38b6ff;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 0 auto 1.5rem;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="processing-container">
        <div class="spinner"></div>
        <h2>Processing Your Payment</h2>
        <p>Please wait while we verify your payment. This may take a few moments.</p>
        <p>Do not refresh or close this page.</p>
    </div>

    <script>
        function checkPaymentStatus() {
            fetch('{{ $pollingUrl }}')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'completed') {
                        window.location.href = data.redirect;
                    } else if (data.status === 'failed') {
                        window.location.href = data.redirect;
                    } else {
                        // Check again after 3 seconds
                        setTimeout(checkPaymentStatus, 3000);
                    }
                })
                .catch(error => {
                    console.error('Error checking payment status:', error);
                    setTimeout(checkPaymentStatus, 3000);
                });
        }

        // Start checking payment status
        setTimeout(checkPaymentStatus, 3000);
    </script>
</body>
</html>