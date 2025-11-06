
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
            position: relative;
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
            transition: border-color 0.3s ease;
        }
        
        input:focus {
            outline: none;
            border-color: var(--primary-color);
        }
        
        input.error {
            border-color: var(--error-color);
        }
        
        .error-message {
            color: var(--error-color);
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: none;
        }
        
        .error-message.show {
            display: block;
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
        
        .info { 
            background: var(--primary-color); 
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
    <h2>Enroll in {{ $course->title }}</h2>

    <div class="course-details">
        <p><strong>Training:</strong> {{ $course->title }}</p>
        <p><strong>Price:</strong> R{{ number_format($course->price, 2) }}</p>
        <p><strong>Level:</strong> {{ $course->level }}</p>
        <p><strong>Duration:</strong> {{ $course->formatted_duration }}</p>
    </div>

    @if(\App\Http\Controllers\CourseAccessController::hasPaidForCourse($client->id, $course->id))
        <div class="message error">
            You have already purchased this training. You cannot make duplicate payments.
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
                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required 
                           placeholder="e.g., 082 123 4567 or 0821234567">
                    <div class="error-message" id="phone-error">Please enter a valid South African phone number (10 digits)</div>
                </div>

                <button type="button" id="pay-button" class="submit-btn">
                    Pay with Card - R{{ number_format($course->price, 2) }}
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

            <form id="eft-payment-form" method="POST" action="{{ route('formal.training.yoco.eft') }}">
                @csrf
                <input type="hidden" name="course_id" value="{{ $course->id }}">

                <div class="form-group">
                    <label for="eft-name">Full Name</label>
                    <input type="text" id="eft-name" value="{{ $client->name }} {{ $client->surname }}" readonly>
                </div>

                <div class="form-group">
                    <label for="eft-email">Email</label>
                    <input type="email" id="eft-email" value="{{ $client->email }}" readonly>
                </div>

                <div class="form-group">
                    <label for="eft-phone">Phone Number</label>
                    <input type="tel" name="phone" id="eft-phone" value="{{ old('phone') }}" required 
                           placeholder="e.g., 082 123 4567 or 0821234567">
                    <div class="error-message" id="eft-phone-error">Please enter a valid South African phone number (10 digits)</div>
                </div>

                <button type="submit" id="eft-pay-button" class="submit-btn eft">
                    Pay with EFT - R{{ number_format($course->price, 2) }}
                </button>
            </form>
        </div>
    @endif

</div>

<script>
    const yoco = new window.YocoSDK({
        publicKey: "{{ env('YOCO_TEST_PUBLIC_KEY') }}"
    });

    // Phone number validation function for South African numbers
    function validateSouthAfricanPhone(phone) {
        // Remove all non-digit characters
        const cleaned = phone.replace(/\D/g, '');
        
        // Check if it's exactly 10 digits
        if (cleaned.length !== 10) {
            return false;
        }
        
        // Check if it starts with a valid South African mobile prefix
        const validPrefixes = ['060', '061', '062', '063', '064', '065', '066', '067', '068', '069', 
                              '070', '071', '072', '073', '074', '075', '076', '077', '078', '079',
                              '081', '082', '083', '084', '085', '086', '087', '088', '089'];
        
        const prefix = cleaned.substring(0, 3);
        return validPrefixes.includes(prefix);
    }

    // Format phone number as user types
    function formatPhoneNumber(input) {
        let value = input.value.replace(/\D/g, '');
        
        if (value.length > 0) {
            if (value.length <= 3) {
                value = value;
            } else if (value.length <= 6) {
                value = value.substring(0, 3) + ' ' + value.substring(3);
            } else {
                value = value.substring(0, 3) + ' ' + value.substring(3, 6) + ' ' + value.substring(6, 10);
            }
        }
        
        input.value = value;
    }

    // Validate phone number and show error
    function validatePhoneInput(input, errorElement) {
        const phone = input.value;
        const isValid = validateSouthAfricanPhone(phone);
        
        if (isValid) {
            input.classList.remove('error');
            errorElement.classList.remove('show');
            return true;
        } else {
            input.classList.add('error');
            errorElement.classList.add('show');
            return false;
        }
    }

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

    // Phone number formatting and validation for card payment form
    const phoneInput = document.getElementById('phone');
    const phoneError = document.getElementById('phone-error');
    
    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            formatPhoneNumber(this);
            validatePhoneInput(this, phoneError);
        });
        
        phoneInput.addEventListener('blur', function() {
            validatePhoneInput(this, phoneError);
        });
    }

    // Phone number formatting and validation for EFT payment form
    const eftPhoneInput = document.getElementById('eft-phone');
    const eftPhoneError = document.getElementById('eft-phone-error');
    
    if (eftPhoneInput) {
        eftPhoneInput.addEventListener('input', function() {
            formatPhoneNumber(this);
            validatePhoneInput(this, eftPhoneError);
        });
        
        eftPhoneInput.addEventListener('blur', function() {
            validatePhoneInput(this, eftPhoneError);
        });
    }

    // Card payment functionality with validation
    document.getElementById("pay-button")?.addEventListener("click", function () {
        const phoneValid = validatePhoneInput(phoneInput, phoneError);
        
        if (!phoneValid) {
            phoneInput.focus();
            return;
        }

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
                    
                    // Show loading state
                    const button = document.getElementById("pay-button");
                    button.disabled = true;
                    button.textContent = "Processing...";
                }
            }
        });
    });

    // EFT payment form submission with validation
    document.getElementById("eft-payment-form")?.addEventListener("submit", function (e) {
        const phoneValid = validatePhoneInput(eftPhoneInput, eftPhoneError);
        
        if (!phoneValid) {
            e.preventDefault();
            eftPhoneInput.focus();
            return;
        }

        const button = document.getElementById("eft-pay-button");
        button.disabled = true;
        button.textContent = "Redirecting to EFT...";
    });

    // Check payment status on page load
    document.addEventListener('DOMContentLoaded', function() {
        const courseId = {{ $course->id }};
        const payButton = document.getElementById('pay-button');
        const eftButton = document.getElementById('eft-pay-button');
        
        if (!payButton || !eftButton) return;
        
        // Check if already paid
        fetch(`/api/check-course-payment/${courseId}`, {
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
                payButton.textContent = 'Already Purchased';
                payButton.style.backgroundColor = '#6c757d';
                
                eftButton.disabled = true;
                eftButton.textContent = 'Already Purchased';
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