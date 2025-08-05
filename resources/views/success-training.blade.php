<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Training Enrollment Success</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('style/home.css') }}" type="text/css">
    <link rel="icon" href="{{ asset('/images/icon.png') }}" type="image/x-icon">
    <style>
        :root {
            --success: #4CAF50;
            --lightGray: #f3f4f6;
            --textDark: #374151;
            --primary: #2196F3;
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
            <div class="success-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                </svg>
            </div>
            <h2>Training Enrollment Confirmed!</h2>
            
            <p>Thank you for enrolling in <strong class="for_this">{{ $trainingSession->title }}</strong></p>
            
            <div class="session-details">
                <p><strong>Training Type:</strong> {{ $trainingSession->type->name }}</p>
                <p><strong>Amount Paid:</strong> R{{ number_format($payment->amount, 2) }}</p>
                <p><strong>Transaction ID:</strong> {{ $payment->transaction_id }}</p>
                <p><strong>Scheduled Date:</strong> {{ $trainingSession->scheduled_for->format('F j, Y') }}</p>
                <p><strong>Duration:</strong> {{ $trainingSession->formatted_duration }}</p>
            </div>

            <div class="confirmation-message">
                <p>A confirmation email has been sent to <strong>{{ auth()->user()->email }}</strong></p>
                <p>Please check your email for further instructions and meeting links.</p>
            </div>

            <a href="{{ route('dashboard') }}" class="back-to-dashboard">Go to Dashboard</a>
        </div>
    </div>
</body>
</html>