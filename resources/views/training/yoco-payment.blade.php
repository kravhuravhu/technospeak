<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register for {{ $session->title }} - Technospeak</title>
    <script src="https://js.yoco.com/sdk/v1/yoco-sdk-web.js"></script>
    <style>
        :root {
            --primary-color: #38b6ff;
            --primary-dark: #2a9ce8;
            --secondary-color: #15415a;
            --success-color: #38a169;
            --error-color: #e53e3e;
            --warning-color: #d69e2e;
            --text-color: #333;
            --light-gray: #f8f9fa;
            --medium-gray: #ccc;
            --white: #fff;
            --border-radius: 8px;
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
            color: var(--text-color);
            line-height: 1.6;
        }
        
        .container { 
            max-width: 500px; 
            margin: auto; 
            background: var(--white); 
            padding: 1.5rem;
            border-radius: var(--border-radius); 
            box-shadow: var(--box-shadow);
        }
        
        h2 { 
            color: var(--secondary-color); 
            margin-bottom: 1rem; 
            font-size: 1.5rem;
        }
        
        .form-group { 
            margin-bottom: 1rem; 
        }
        
        label { 
            display: block; 
            margin-bottom: 0.5rem; 
            color: var(--primary-color);
            font-weight: bold;
        }
        
        input { 
            width: 100%; 
            padding: 0.75rem; 
            border-radius: var(--border-radius); 
            border: 1px solid var(--medium-gray);
            font-size: 1rem;
        }
        
        .price { 
            margin: 1rem 0; 
            font-weight: bold; 
            font-size: 1.25rem;
            color: var(--secondary-color);
        }
        
        .submit-btn { 
            background: var(--primary-color); 
            color: var(--white); 
            border: none; 
            padding: 1rem; 
            width: 100%; 
            border-radius: var(--border-radius); 
            cursor: pointer; 
            font-size: 1rem;
            font-weight: bold;
            transition: background 0.3s ease;
            margin-top: 0.5rem;
        }
        
        .submit-btn:hover { 
            background: var(--primary-dark); 
        }
        
        .submit-btn:disabled { 
            background: #6c757d; 
            cursor: not-allowed; 
        }
        
        .submit-btn.eft { 
            background: var(--primary-color); 
        }
        
        .submit-btn.eft:hover { 
            background: var(--primary-dark); 
        }
        
        .message { 
            margin: 1rem 0; 
            padding: 0.75rem; 
            border-radius: var(--border-radius);
            text-align: center;
        }
        
        .success { 
            background: var(--success-color); 
            color: var(--white); 
        }
        
        .error { 
            background: var(--error-color); 
            color: var(--white); 
        }
        
        .session-details { 
            background: var(--light-gray); 
            padding: 1rem; 
            border-radius: var(--border-radius); 
            margin-bottom: 1.5rem;
        }
        
        .session-details p {
            margin-bottom: 0.5rem;
        }
        
        /* Payment Method Tabs */
        .payment-method-tabs {
            display: flex;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid var(--light-gray);
        }
        
        .tab-button {
            flex: 1;
            padding: 1rem;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
            color: var(--medium-gray);
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
        }
        
        .tab-button.active {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .payment-info {
            background: var(--light-gray);
            padding: 1rem;
            border-radius: var(--border-radius);
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }
        
        .payment-info ul {
            margin-left: 1.5rem;
            margin-top: 0.5rem;
        }
        
        .payment-info li {
            margin-bottom: 0.25rem;
        }
        
        /* Responsive adjustments */
        @media (max-width: 576px) {
            body {
                padding: 0.5rem;
            }
            
            .container {
                padding: 1rem;
            }
            
            h2 {
                font-size: 1.35rem;
            }
            
            input, .submit-btn {
                padding: 0.875rem;
            }
            
            .tab-button {
                padding: 0.875rem 0.5rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
<div class="container">

    @if(session('success'))
        <div class="message success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="message error">{{ session('error') }}</div>
    @endif

    <h2>Register for {{ $session->title }}</h2>

    <div class="session-details">
        <p><strong>Session:</strong> {{ $session->title }}</p>
        <p><strong>Date & Time:</strong> {{ $session->scheduled_for->format('F j, Y g:i A') }}</p>
        <p><strong>Price:</strong> R{{ number_format($price, 2) }}</p>
        <p><strong>Type:</strong> {{ $session->type->name }}</p>
    </div>

    @if(\App\Http\Controllers\TrainingRegistrationController::hasPaidForSession($client->id, $session->id))
        <div class="message error">
            You have already paid for this session. You cannot make duplicate payments.
        </div>
        <a href="{{ route('dashboard') }}" class="submit-btn">Return to Dashboard</a>
    @else
        <!-- Payment Method Selection -->
        <div class="payment-method-tabs">
            <button type="button" class="tab-button active" data-tab="card">Credit/Debit Card</button>
            <button type="button" class="tab-button" data-tab="eft">EFT/Bank Transfer</button>
        </div>

        <!-- Card Payment Tab -->
        <div id="card-tab" class="tab-content active">
            <div class="payment-info">
                <strong>Secure Card Payment</strong>
                <p>Pay instantly with your credit or debit card. Your payment will be processed securely through Yoco.</p>
            </div>

            <form id="yoco-payment-form" method="POST" action="{{ route('training.yoco.process') }}">
                @csrf
                <input type="hidden" name="session_id" value="{{ $session->id }}">
                <input type="hidden" name="token" id="yoco-token">

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ $client->name }}" required readonly>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ $client->email }}" required readonly>
                </div>

                <!-- <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required>
                </div> -->

                <button type="button" id="pay-button" class="submit-btn">
                    Register with Card - R{{ number_format($price, 2) }}
                </button>
            </form>
        </div>

        <!-- EFT Payment Tab -->
        <div id="eft-tab" class="tab-content">
            <div class="payment-info">
                <strong>EFT/Bank Transfer</strong>
                <p>Pay via secure EFT transfer. You'll be redirected to Yoco's payment page to complete the transaction.</p>
                <ul>
                    <li>Secure bank-level encryption</li>
                    <li>Instant payment confirmation</li>
                    <li>No card details required</li>
                </ul>
            </div>

            <form id="eft-payment-form" method="POST" action="{{ route('training.yoco.eft') }}">
                @csrf
                <input type="hidden" name="session_id" value="{{ $session->id }}">

                <div class="form-group">
                    <label for="eft-name">Full Name</label>
                    <input type="text" id="eft-name" value="{{ $client->name }}" readonly>
                </div>

                <div class="form-group">
                    <label for="eft-email">Email</label>
                    <input type="email" id="eft-email" value="{{ $client->email }}" readonly>
                </div>

                <!-- <div class="form-group">
                    <label for="eft-phone">Phone Number</label>
                    <input type="tel" name="phone" id="eft-phone" value="{{ old('phone') }}" required>
                </div> -->

                <button type="submit" id="eft-pay-button" class="submit-btn eft">
                    Register with EFT - R{{ number_format($price, 2) }}
                </button>
            </form>
        </div>
    @endif

</div>

<script>
    const yoco = new window.YocoSDK({
        publicKey: "{{ env('YOCO_TEST_PUBLIC_KEY') }}"
    });

    // Tab functionality
    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all tabs and contents
            document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
            
            // Add active class to clicked tab and corresponding content
            this.classList.add('active');
            const tabId = this.getAttribute('data-tab') + '-tab';
            document.getElementById(tabId).classList.add('active');
        });
    });

    // Card payment functionality
    document.getElementById("pay-button")?.addEventListener("click", function () {
        const amount = {{ $price * 100 }};
        yoco.showPopup({
            amountInCents: amount,
            currency: "ZAR",
            name: "{{ $session->title }}",
            description: "Training Session Registration",
            callback: function (result) {
                if (result.error) {
                    alert("Error: " + result.error.message);
                } else {
                    document.getElementById("yoco-token").value = result.id;
                    document.getElementById("yoco-payment-form").submit();
                    
                    // Show loading state
                    const button = document.getElementById("pay-button");
                    button.disabled = true;
                    button.textContent = "Processing...";
                }
            }
        });
    });

    // EFT payment loading state
    document.getElementById("eft-payment-form")?.addEventListener("submit", function (e) {
        const button = document.getElementById("eft-pay-button");
        button.disabled = true;
        button.textContent = "Redirecting to EFT...";
    });

    // Check payment status on page load
    document.addEventListener('DOMContentLoaded', function() {
        const sessionId = {{ $session->id }};
        const payButton = document.getElementById('pay-button');
        const eftButton = document.getElementById('eft-pay-button');
        
        if (!payButton || !eftButton) return;
        
        // Check if already paid
        fetch(`/api/check-session-payment/${sessionId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.paid) {
                // Disable both payment methods
                payButton.disabled = true;
                payButton.textContent = 'Already Paid';
                payButton.style.backgroundColor = '#6c757d';
                
                eftButton.disabled = true;
                eftButton.textContent = 'Already Paid';
                eftButton.style.backgroundColor = '#6c757d';
                
                // Show message
                const messageDiv = document.createElement('div');
                messageDiv.className = 'message error';
                messageDiv.textContent = data.message;
                document.querySelector('.container').prepend(messageDiv);
            }
        })
        .catch(error => {
            console.error('Error checking payment status:', error);
        });
    });
</script>
</body>
</html>