<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Processing - Technospeak</title>
    <style>
        .container { max-width: 500px; margin: 50px auto; padding: 2rem; text-align: center; }
        .spinner { border: 4px solid #f3f3f3; border-top: 4px solid #38b6ff; border-radius: 50%; width: 40px; height: 40px; animation: spin 2s linear infinite; margin: 0 auto 1rem; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body>
    <div class="container">
        <div class="spinner"></div>
        <h3>Processing EFT Payment</h3>
        <p>Your EFT payment is being processed. This may take a few moments...</p>
        <div id="status-message"></div>
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
                        setTimeout(checkPaymentStatus, 3000);
                    }
                });
        }
        
        // Start checking status
        setTimeout(checkPaymentStatus, 2000);
    </script>
</body>
</html>