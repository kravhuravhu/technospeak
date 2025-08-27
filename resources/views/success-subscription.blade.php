<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Subscription Success</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="@secureAsset('style/home.css')" type="text/css">
    <link rel="icon" href="@secureAsset('images/icon.png')" type="image/x-icon">
    <style>
        :root {
            --success: #38b000;
            --lightGray: #f3f4f6;
            --textDark: #374151;
            --skBlue: #38b6ff;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9fafb;
            margin: 0;
            padding: 0;
        }


        .payment-success-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            padding: 2rem;
        }

        .success-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            background-color: var(--success);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .success-icon svg {
            width: 40px;
            height: 40px;
            color: white;
        }

        .success-card h2 {
            color: var(--skBlue);
            margin-bottom: 1rem;
            font-size: 1.75rem;
        }

        .for_this {
            color: #062644;
        }

        .session-details {
            margin: 1.5rem 0;
            padding: 1rem;
            background-color: #062644;
            border-radius: 8px;
            text-align: left;
        }

        .session-details p {
            margin-bottom: 0.5rem;
            color: #f9faf9;
        }

        .confirmation-message {
            margin: 1.5rem 0;
            color: var(--textDark);
            font-size: 0.95rem;
        }

        .back-to-dashboard {
            display: inline-block;
            background-color: #38b6ff;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .back-to-dashboard:hover {
            background-color: #2a9ce8;
        }
    </style>
</head>
<body>
    <div class="payment-success-container">
        <div class="success-card">
            <div class="success-icon">✅</div>
            <h2>Payment Successful!</h2>
            
            <p>Thank you for subscribing to <strong class="for_this">{{ $plan->name }}</strong></p>
            
            <div class="session-details">
                <p><strong>Plan Type:</strong> {{ $plan->name }} Subscription</p>
                <p><strong>Amount Paid:</strong> R{{ number_format($payment_amount, 2) }}</p>
                <p><strong>Transaction ID:</strong> {{ $transaction_id ?? 'N/A' }}</p>
                <p><strong>Expiry Date:</strong> {{ now()->addMonths(3)->format('F j, Y') }}</p>
                <p><strong>Customer:</strong> {{ $client->name }} {{ $client->surname }}</p>
            </div>

            <div class="confirmation-message">
                <p>A confirmation email has been sent to <strong>{{ $client->email }}</strong></p>
                <p>Your premium subscription is now active for 3 months.</p>
            </div>

            <div style="margin-top: 2rem;">
                <a href="{{ route('dashboard') }}" class="back-to-dashboard">Go to Dashboard</a>
                <a href="{{ url('/') }}" class="back-to-dashboard" style="background-color: #6c757d; margin-left: 1rem;">
                    Return to Home
                </a>
            </div>
        </div>
    </div>
</body>
</html>