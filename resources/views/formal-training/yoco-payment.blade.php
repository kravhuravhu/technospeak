<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enroll in {{ $course->title }} - Technospeak</title>
    <script src="https://js.yoco.com/sdk/v1/yoco-sdk-web.js"></script>
    <style>
        :root {
            --primary-color: #38b6ff;
            --primary-dark: #2a9ce8;
            --secondary-color: #15415a;
            --success-color: #38a169;
            --error-color: #e53e3e;
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
        }
        
        .submit-btn:hover { 
            background: var(--primary-dark); 
        }
        
        .submit-btn:disabled { 
            background: #6c757d; 
            cursor: not-allowed; 
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
        
        .course-details { 
            background: var(--light-gray); 
            padding: 1rem; 
            border-radius: var(--border-radius); 
            margin-bottom: 1.5rem;
        }
        
        .course-details p {
            margin-bottom: 0.5rem;
        }
        
        /* Responsive adjustments */
        @media (max-width: 576px) {
            body {
                padding: 0.5rem;
            }
            
            .container {
                padding: 1.25rem;
            }
            
            h2 {
                font-size: 1.35rem;
            }
            
            input, .submit-btn {
                padding: 0.875rem;
            }
            
            .course-details {
                padding: 0.875rem;
            }
        }
        
        @media (max-width: 400px) {
            .container {
                padding: 1rem;
            }
            
            h2 {
                font-size: 1.25rem;
            }
            
            .course-details {
                padding: 0.75rem;
                font-size: 0.9rem;
            }
            
            .price {
                font-size: 1.15rem;
            }
        }
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