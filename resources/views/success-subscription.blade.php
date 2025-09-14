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
            padding: 1.5rem;
            background-color: #f8f9fa;
            border-radius: 8px;
            text-align: left;
            border-left: 4px solid var(--skBlue);
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

        .premium-features {
            background: linear-gradient(135deg, #38b6ff, #0066cc);
            color: white;
            padding: 1.5rem;
            border-radius: 8px;
            margin: 1.5rem 0;
            text-align: left;
        }

        .premium-features h3 {
            margin-top: 0;
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }

        .premium-features ul {
            margin: 0;
            padding-left: 1.5rem;
        }

        .premium-features li {
            margin-bottom: 0.5rem;
        }

        .back-to-dashboard {
            display: inline-block;
            background-color: #38b6ff;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            margin: 0.5rem;
        }

        .back-to-dashboard:hover {
            background-color: #2a9ce8;
            transform: translateY(-2px);
        }

        .secondary-btn {
            background-color: #6c757d;
        }

        .secondary-btn:hover {
            background-color: #5a6268;
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
            <h2>Payment Successful!</h2>
            
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

            <p>Thank you for subscribing to <strong class="for_this">{{ $plan->name ?? 'Premium' }}</strong></p>
            
            <div class="session-details">
                <p><strong>Plan Type:</strong> <span>{{ $plan->name ?? 'Premium' }} Subscription</span></p>
                <p><strong>Amount Paid:</strong> <span>R{{ number_format($payment_amount ?? 0, 2) }}</span></p>
                <p><strong>Transaction ID:</strong> <span>{{ $transaction_id ?? ($payment->transaction_id ?? 'N/A') }}</span></p>
                <p><strong>Expiry Date:</strong> <span>
                    @if(isset($client) && $client->subscription_expiry)
                        {{ $client->subscription_expiry->format('F j, Y') }}
                    @else
                        {{ now()->addMonths(3)->format('F j, Y') }}
                    @endif
                </span></p>
                <p><strong>Customer:</strong> <span>
                    @if(isset($client))
                        {{ $client->name }} {{ $client->surname }}
                    @else
                        {{ Auth::user()->name }} {{ Auth::user()->surname }}
                    @endif
                </span></p>
                <p><strong>Status:</strong> <span style="color: var(--success); font-weight: bold;">ACTIVE</span></p>
            </div>

            <!-- Premium Features Section -->
            <div class="premium-features">
                <h3>🎉 Welcome to Premium! Here's what you get:</h3>
                <ul>
                    <li>Full access to all clickbait-style videos</li>
                    <li>Downloadable resources (cheat sheets, scripts, screen grabs)</li>
                    <li>Monthly email newsletters with tech tips and updates</li>
                    <li>Exclusive courses and training materials</li>
                    <li>Priority support</li>
                </ul>
            </div>

            <div class="confirmation-message">
                <p>A confirmation email has been sent to <strong>{{ $client->email ?? Auth::user()->email }}</strong></p>
                <p>Your premium subscription is now active for 3 months.</p>
                
                @if(!($client->subscription_type === 'premium' && $client->subscription_expiry && $client->subscription_expiry->isFuture()))
                <div class="warning-banner">
                    ⚠️ <strong>Note:</strong> It may take a few minutes for your subscription to fully activate. 
                    If you don't see premium content immediately, please refresh the page or wait a moment.
                </div>
                @endif
            </div>

            <div style="margin-top: 2rem;">
                <a href="{{ route('dashboard') }}" class="back-to-dashboard">
                    🚀 Go to Dashboard
                </a>
                <!-- <a href="{{ route('enrolled-courses.show', ['course' => 1]) }}" class="back-to-dashboard" style="background-color: #28a745;">
                    📚 View Courses
                </a> -->
                <a href="{{ url('/') }}" class="back-to-dashboard secondary-btn">
                    🏠 Return to Home
                </a>
            </div>

            <!-- Support Information -->
            <div style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
                <p style="font-size: 0.9rem; color: #6b7280;">
                    Need help? Contact support: 
                    <a href="mailto:admin@technospeak.co.za" style="color: var(--skBlue); text-decoration: none;">
                        admin@technospeak.co.za
                    </a>
                </p>
            </div>
        </div>
    </div>

    <!-- Auto-redirect script -->
    <script>
        // Optional: Auto-redirect to dashboard after 10 seconds
        setTimeout(function() {
            window.location.href = "{{ route('dashboard') }}";
        }, 20000); // 20 seconds

        // Log success to console for debugging
        console.log('Payment successful:', {
            plan: '{{ $plan->name ?? "Premium" }}',
            amount: 'R{{ number_format($payment_amount ?? 0, 2) }}',
            transactionId: '{{ $transaction_id ?? ($payment->transaction_id ?? "N/A") }}'
        });
    </script>
</body>
</html>