<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register for Training Session</title>
    <script src="https://js.yoco.com/sdk/v1/yoco-sdk-web.js"></script>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f2f5; padding: 2rem; }
        .container { max-width: 500px; margin: auto; background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h2 { color: #15415a; margin-bottom: 1rem; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.5rem; color: #38b6ff; }
        input { width: 100%; padding: 0.5rem; border-radius: 6px; border: 1px solid #ccc; }
        .price { margin: 1rem 0; font-weight: bold; font-size: 1.1rem; }
        .submit-btn { background: #38b6ff; color: white; border: none; padding: 0.75rem; width: 100%; border-radius: 8px; cursor: pointer; font-size: 1rem; margin-top: 0.5rem; }
        .submit-btn:hover { background: #2a9ce8; }
        .message { margin: 1rem 0; padding: 0.75rem; border-radius: 6px; }
        .success { background: #38a169; color: white; }
        .error { background: #e53e3e; color: white; }
    </style>
</head>
<body>
<div class="container">

    @if(session('success'))
        <div class="message success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="message error">{{ session('error') }}</div>
    @endif

    @if($latestSession)
        <h2>Register for Training Session</h2>

        <p><strong>Title:</strong> {{ $latestSession->title }}</p>
        <p><strong>Date & Time:</strong> {{ $latestSession->scheduled_for->format('F j, Y g:i A') }}</p>
        <p class="price">
            <strong>Price:</strong>
            R{{ number_format($latestSession->type->getPriceForUserType(Auth::user()->userType), 2) }}
        </p>

        <form id="yoco-payment-form" method="POST" action="{{ route('testing.payment.charge') }}">
            @csrf
            <input type="hidden" name="session_id" value="{{ $latestSession->id }}">
            <input type="hidden" name="token" id="yoco-token">

            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ Auth::user()->email }}" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" name="phone" id="phone">
            </div>

            <!-- Card payment button -->
            <button type="button" id="pay-button" class="submit-btn">Pay with Card</button>

            <!-- EFT button -->
            <button type="submit" formaction="{{ route('testing.payment.eft') }}" class="submit-btn" style="background:#15415a;">
                Pay with EFT
            </button>
        </form>

    @else
        <p>No upcoming sessions available.</p>
    @endif

</div>

<script>
    const yoco = new window.YocoSDK({
        publicKey: "{{ env('YOCO_TEST_PUBLIC_KEY') }}"
    });

    document.getElementById("pay-button").addEventListener("click", function () {
        const amount = {{ $latestSession ? $latestSession->type->getPriceForUserType(Auth::user()->userType) * 100 : 0 }};
        yoco.showPopup({
            amountInCents: amount,
            currency: "ZAR",
            name: "{{ $latestSession->title ?? 'Training Session' }}",
            description: "Training Session Registration",
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
</script>
</body>
</html>
