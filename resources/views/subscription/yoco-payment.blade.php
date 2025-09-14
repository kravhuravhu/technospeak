<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Premium Subscription Payment</title>
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
        .plan-details { background: #f8f9fa; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; }
    </style>
</head>
<body>
<div class="container">

    @if(session('success'))
        <div class="message success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="message error">{{ session('error') }}</div>
    @endif

    <h2>Subscribe to Premium Plan</h2>

    <div class="plan-details">
        <p><strong>Plan:</strong> {{ $plan->name }}</p>
        <p><strong>Description:</strong> {{ $plan->description }}</p>
        <p><strong>Duration:</strong> 3 Months</p>
        <p class="price"><strong>Price:</strong> R{{ number_format($price, 2) }}</p>
        <p><strong>User Type:</strong> {{ $client->userType ?? 'Professional' }}</p>
    </div>

    @if(\App\Http\Controllers\SubscriptionController::hasActiveSubscription($client->id, $plan->id))
        <div class="message error">
            You already have an active Premium subscription. You cannot make duplicate payments.
        </div>
        <a href="{{ route('dashboard') }}" class="submit-btn">Return to Dashboard</a>
    @else
        <form id="yoco-payment-form" method="POST" action="{{ route('subscription.yoco.process') }}">
            @csrf
            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
            <input type="hidden" name="token" id="yoco-token">

            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" name="name" id="name" value="{{ $client->name }}" required readonly>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ $client->email }}" required readonly>
            </div>

            <button type="button" id="pay-button" class="submit-btn">Subscribe Now - R{{ number_format($price, 2) }}</button>
        </form>
    @endif

</div>

<script>
    const yoco = new window.YocoSDK({
        publicKey: "{{ env('YOCO_TEST_PUBLIC_KEY') }}"
    });

    document.getElementById("pay-button")?.addEventListener("click", function () {
        const amount = {{ $price * 100 }};
        yoco.showPopup({
            amountInCents: amount,
            currency: "ZAR",
            name: "Premium Subscription",
            description: "Quarterly Premium Access",
            callback: function (result) {
                if (result.error) {
                    alert("Error: " + result.error.message);
                } else {
                    document.getElementById("yoco-token").value = result.id;
                    document.getElementById("yoco-payment-form").submit();
                }
            }
        });
    });

    // Add this script to your payment form
    document.addEventListener('DOMContentLoaded', function() {
        const planId = {{ $plan->id }};
        const payButton = document.getElementById('pay-button');
        
        if (!payButton) return;
        
        // Check subscription status on page load
        fetch(`/api/check-subscription-status/${planId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.active) {
                payButton.disabled = true;
                payButton.textContent = 'Already Subscribed';
                payButton.style.backgroundColor = '#6c757d';
                
                // Show message
                const messageDiv = document.createElement('div');
                messageDiv.className = 'message error';
                messageDiv.textContent = data.message;
                document.querySelector('.container').prepend(messageDiv);
            }
        })
        .catch(error => {
            console.error('Error checking subscription status:', error);
        });
    });
</script>
</body>
</html>