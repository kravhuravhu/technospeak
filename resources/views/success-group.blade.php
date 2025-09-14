<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Group Session Booking Success</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="@secureAsset('style/home.css')" type="text/css">
    <link rel="icon" href="@secureAsset('images/icon.png')" type="image/x-icon">
    <style>
        :root {
            --success: #9C27B0;
            --lightGray: #f3f4f6;
            --textDark: #374151;
            --primary: #673AB7;
            --skBlue: #38b6ff;
            --warning: #f59e0b;
            --danger: #ef4444;
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
            max-width: 550px;
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
            font-size: 2rem;
            color: white;
        }

        .success-card h2 {
            color: var(--primary);
            margin-bottom: 1rem;
            font-size: 1.75rem;
        }

        .for_this {
            color: #062644;
        }

        .session-details {
            margin: 1.5rem 0;
            padding: 1.5rem;
            background-color: #f8f9fa;
            border-radius: 8px;
            text-align: left;
            border-left: 4px solid var(--primary);
        }

        .session-details p {
            margin-bottom: 0.75rem;
            color: var(--textDark);
            display: flex;
            justify-content: space-between;
        }

        .session-details strong {
            color: #062644;
            min-width: 120px;
        }

        .confirmation-message {
            margin: 1.5rem 0;
            color: var(--textDark);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .session-benefits {
            background: linear-gradient(135deg, #673AB7, #9C27B0);
            color: white;
            padding: 1.5rem;
            border-radius: 8px;
            margin: 1.5rem 0;
            text-align: left;
        }

        .session-benefits h3 {
            margin-top: 0;
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }

        .session-benefits ul {
            margin: 0;
            padding-left: 1.5rem;
        }

        .session-benefits li {
            margin-bottom: 0.5rem;
        }

        .back-to-dashboard {
            display: inline-block;
            background-color: var(--primary);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            margin: 0.5rem;
        }

        .back-to-dashboard:hover {
            background-color: #5E35B1;
            transform: translateY(-2px);
        }

        .secondary-btn {
            background-color: #6c757d;
        }

        .secondary-btn:hover {
            background-color: #5a6268;
        }

        .info-banner {
            background-color: #e9f5ff;
            border: 1px solid #b3e0ff;
            color: #062644;
            padding: 1rem;
            border-radius: 6px;
            margin: 1rem 0;
            text-align: left;
        }

        .warning-banner {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 1rem;
            border-radius: 6px;
            margin: 1rem 0;
            text-align: left;
        }

        .error-banner {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 1rem;
            border-radius: 6px;
            margin: 1rem 0;
            text-align: left;
        }

        @media (max-width: 576px) {
            .success-card {
                padding: 1.5rem;
                margin: 1rem;
            }
            
            .session-details p {
                flex-direction: column;
            }
            
            .session-details strong {
                margin-bottom: 0.25rem;
            }
        }
    </style>
</head>
<body>
    <div class="payment-success-container">
        <div class="success-card">
            <div class="success-icon">✅</div>
            <h2>Group Session Booked Successfully!</h2>
            
            <!-- Display any success/error messages from session -->
            @if(session('success'))
                <div class="confirmation-message" style="color: var(--success);">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="error-banner">
                    {{ session('error') }}
                </div>
            @endif

            <p>Thank you for booking <strong class="for_this">{{ $service->title }}</strong></p>
            
            <div class="session-details">
                <p><strong>Session:</strong> <span>{{ $service->title }}</span></p>
                <p><strong>Date:</strong> <span>{{ $service->scheduled_for->format('F j, Y') }}</span></p>
                <p><strong>Time:</strong> <span>{{ $service->scheduled_for->format('g:i A') }}</span></p>
                <p><strong>Type:</strong> <span>{{ $service->type->name }}</span></p>
                <p><strong>Amount Paid:</strong> <span>R{{ number_format($payment->amount, 2) }}</span></p>
                <p><strong>Transaction ID:</strong> <span>{{ $payment->transaction_id }}</span></p>
                <p><strong>Customer:</strong> <span>{{ $client->name }} {{ $client->surname }}</span></p>
                <p><strong>Status:</strong> <span style="color: var(--success); font-weight: bold;">CONFIRMED</span></p>
            </div>

            <!-- Session Benefits Section -->
            <div class="session-benefits">
                <h3>🎯 What to Expect from Your Group Session:</h3>
                <ul>
                    <li>Interactive learning with industry experts</li>
                    <li>Q&A opportunity to get your specific questions answered</li>
                    <li>Networking with other participants</li>
                    <li>Recording available after the session (if applicable)</li>
                    <li>Supplementary materials and resources</li>
                </ul>
            </div>

            <div class="confirmation-message">
                <p>A confirmation email has been sent to <strong>{{ $client->email }}</strong></p>
                
                <div class="info-banner">
                    ℹ️ <strong>Important:</strong> You'll receive detailed session information and the meeting link 24 hours before the session starts. Please check your email (and spam folder) for these details.
                </div>
                
                <div class="warning-banner">
                    ⚠️ <strong>Reminder:</strong> Please add this event to your calendar. Sessions are subject to our cancellation policy.
                </div>
            </div>

            <div style="margin-top: 2rem;">
                <a href="{{ route('dashboard') }}" class="back-to-dashboard">
                    📊 Go to Dashboard
                </a>
                <a href="{{ route('my-sessions') }}" class="back-to-dashboard" style="background-color: #9C27B0;">
                    📅 View My Sessions
                </a>
                <a href="{{ url('/') }}" class="back-to-dashboard secondary-btn">
                    🏠 Return to Home
                </a>
            </div>

            <!-- Support Information -->
            <div style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
                <p style="font-size: 0.9rem; color: #6b7280;">
                    Need to reschedule or have questions? Contact support: 
                    <a href="mailto:admin@technospeak.co.za" style="color: var(--primary); text-decoration: none;">
                        admin@technospeak.co.za
                    </a>
                </p>
            </div>
        </div>
    </div>

    <!-- Auto-redirect script -->
    <script>
        // Optional: Auto-redirect to dashboard after 15 seconds
        setTimeout(function() {
            window.location.href = "{{ route('dashboard') }}";
        }, 20000); // 20 seconds

        // Log success to console for debugging
        console.log('Group session booking successful:', {
            session: '{{ $service->title }}',
            date: '{{ $service->scheduled_for->format("F j, Y") }}',
            amount: 'R{{ number_format($payment->amount, 2) }}',
            transactionId: '{{ $payment->transaction_id }}'
        });
    </script>
</body>
</html>