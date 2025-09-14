<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register for {{ $session->title }} - Technospeak</title>
    <script src="https://js.yoco.com/sdk/v1/yoco-sdk-web.js"></script>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f2f5; padding: 2rem; }
        .container { max-width: 500px; margin: auto; background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h2 { color: #15415a; margin-bottom: 1rem; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.5rem; color: #38b6ff; }
        input { width: 100%; padding: 0.5rem; border-radius: 6px; border: 1px solid #ccc; }
        .price { margin: 1rem 0; font-weight: bold; font-size: 1.1rem; }
        .submit-btn { background: #38b6ff; color: white; border: none; padding: 0.75rem; width: 100%; border-radius: 8px; cursor: pointer; font-size: 1rem; }
        .submit-btn:hover { background: #2a9ce8; }
        .submit-btn:disabled { background: #6c757d; cursor: not-allowed; }
        .message { margin: 1rem 0; padding: 0.75rem; border-radius: 6px; }
        .success { background: #38a169; color: white; }
        .error { background: #e53e3e; color: white; }
        .session-details { background: #f8f9fa; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; }
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

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required>
            </div>

            <button type="button" id="pay-button" class="submit-btn">Register Now - R{{ number_format($price, 2) }}</button>
        </form>
    @endif

</div>

<script>
    const yoco = new window.YocoSDK({
        publicKey: "{{ env('YOCO_TEST_PUBLIC_KEY') }}" // Changed to TEST key
    });

    document.getElementById("pay-button")?.addEventListener("click", function () {
        const amount = {{ $price * 100 }};
        yoco.showPopup({
            amountInCents: amount,
            currency: "ZAR",
            name: "{{ $session->title }}",
            description: "Training Session Registration",
            callback: function (result) {
                if (result.error) {
                    alert("Error: " . result.error.message);
                } else {
                    document.getElementById("yoco-token").value = result.id;
                    document.getElementById("yoco-payment-form").submit();
                }
            }
        });
    });

    // Add this script to your payment form
    document.addEventListener('DOMContentLoaded', function() {
        const sessionId = {{ $session->id }};
        const payButton = document.getElementById('pay-button');
        
        if (!payButton) return;
        
        // Check payment status on page load
        fetch(`/api/check-session-payment/${sessionId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.paid) {
                payButton.disabled = true;
                payButton.textContent = 'Already Paid';
                payButton.style.backgroundColor = '#6c757d';
                
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