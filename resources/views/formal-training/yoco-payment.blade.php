<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enroll in {{ $course->title }} - Technospeak</title>
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
        .course-details { background: #f8f9fa; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; }
    </style>
</head>
<body>
<div class="container">
    <h2>Enroll in {{ $course->title }}</h2>

    <div class="course-details">
        <p><strong>Training:</strong> {{ $course->title }}</p>
        <p><strong>Price:</strong> R{{ number_format($course->price, 2) }}</p>
        <p><strong>Level:</strong> {{ $course->level }}</p>
        <p><strong>Duration:</strong> {{ $course->formatted_duration }}</p>
    </div>

    <form id="yoco-payment-form" method="POST" action="{{ route('formal.training.yoco.process') }}">
        @csrf
        <input type="hidden" name="course_id" value="{{ $course->id }}">
        <input type="hidden" name="token" id="yoco-token">

        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" name="name" id="name" value="{{ $client->name }} {{ $client->surname }}" required readonly>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ $client->email }}" required readonly>
        </div>

        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required>
        </div>

        <button type="button" id="pay-button" class="submit-btn">Pay Now - R{{ number_format($course->price, 2) }}</button>
    </form>
</div>

<script>
    const yoco = new window.YocoSDK({
        publicKey: "{{ env('YOCO_TEST_PUBLIC_KEY') }}"
    });

    document.getElementById("pay-button").addEventListener("click", function () {
        const amount = {{ $course->price * 100 }};
        yoco.showPopup({
            amountInCents: amount,
            currency: "ZAR",
            name: "{{ $course->title }}",
            description: "Formal Training Enrollment",
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