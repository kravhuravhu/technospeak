<div class="session-registration-modal" id="training-modal" style="display: none;">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <button class="close-modal">&times;</button>
        
        <h3 id="training-modal-title">Training Title</h3>
        <div class="session-details" id="training-modal-description"></div>
        
        <form class="registration-form" method="GET" id="training-form">
            @csrf
            <input type="hidden" name="training_id" id="training-modal-id">
            
            <div class="form-group" id="training-hours-group" style="display: none;">
                <label for="training-hours">Hours Required</label>
                <input type="number" id="training-hours" name="hours" min="1" value="1">
            </div>
            
            <div class="form-group">
                <label for="training-name">Full Name</label>
                <input type="text" id="training-name" name="name" 
                    value="{{ auth()->user() ? auth()->user()->name : '' }}" required>
            </div>
            
            <div class="form-group">
                <label for="training-email">Email Address</label>
                <input type="email" id="training-email" name="email" 
                    value="{{ auth()->user() ? auth()->user()->email : '' }}" required>
                <div class="error-message" id="email-error" style="color: red; display: none; font-size: 12px; margin-top: 5px;"></div>
            </div>
            
            <div class="form-group">
                <label for="training-phone">Phone Number</label>
                <input type="tel" id="training-phone" name="phone" 
                    value="{{ auth()->user() && auth()->user()->phone ? auth()->user()->phone : '' }}" 
                    placeholder="10-digit South African number (e.g., 0123456789)" required>
                <div class="error-message" id="phone-error" style="color: red; display: none; font-size: 12px; margin-top: 5px;"></div>
            </div>
            
            <div class="payment-summary">
                <h4>Payment Summary</h4>
                <div class="price-display">
                    <span>Price:</span>
                    <span class="price-amount" id="training-price"></span>
                </div>
                <p class="price-note" id="price-note"></p>
            </div>
            
            <button type="submit" class="submit-btn" id="submit-btn">Proceed to Payment</button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const trainings = {
        @foreach(\App\Models\TrainingType::whereIn('id', [1,2,3,4,5])->get() as $training)
        {{ $training->id }}: {
            id: {{ $training->id }},
            title: "{{ $training->name }}",
            description: `{!! $training->description !!}`,
            student_price: {{ $training->student_price }},
            professional_price: {{ $training->professional_price }},
            is_hourly: {{ $training->is_group_session ? 'false' : 'true' }}
        },
        @endforeach
    };

    const modal = document.getElementById('training-modal');
    const form = document.getElementById('training-form');
    const emailInput = document.getElementById('training-email');
    const phoneInput = document.getElementById('training-phone');
    const emailError = document.getElementById('email-error');
    const phoneError = document.getElementById('phone-error');
    const submitBtn = document.getElementById('submit-btn');

    // Track validation state
    let isEmailValid = false;
    let isPhoneValid = false;

    // Enhanced validation functions
    function validateEmail() {
        const email = emailInput.value.trim();
        
        // Clear previous error
        emailError.style.display = 'none';
        emailInput.style.borderColor = '';
        
        if (!email) {
            emailError.textContent = 'Email is required';
            emailError.style.display = 'block';
            emailInput.style.borderColor = 'red';
            isEmailValid = false;
            updateSubmitButton();
            return false;
        }
        
        // Check for proper email format with domain and TLD
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
        if (!emailRegex.test(email)) {
            emailError.textContent = 'Please enter a valid email address (e.g., name@company.co.za)';
            emailError.style.display = 'block';
            emailInput.style.borderColor = 'red';
            isEmailValid = false;
            updateSubmitButton();
            return false;
        }
        
        // Check domain part has at least one dot
        const domainPart = email.split('@')[1];
        if (!domainPart.includes('.')) {
            emailError.textContent = 'Email domain must be valid (e.g., gmail.com, company.co.za)';
            emailError.style.display = 'block';
            emailInput.style.borderColor = 'red';
            isEmailValid = false;
            updateSubmitButton();
            return false;
        }
        
        // Check for test/invalid domains
        const invalidDomains = ['test', 'example', 'localhost', 'invalid'];
        const domain = domainPart.toLowerCase();
        const hasInvalidDomain = invalidDomains.some(invalid => 
            domain.includes(invalid) || domain === invalid
        );
        
        if (hasInvalidDomain) {
            emailError.textContent = 'Please use a valid business or personal email address';
            emailError.style.display = 'block';
            emailInput.style.borderColor = 'red';
            isEmailValid = false;
            updateSubmitButton();
            return false;
        }
        
        // Email is valid
        emailInput.style.borderColor = 'green';
        isEmailValid = true;
        updateSubmitButton();
        return true;
    }

    function validatePhone() {
        const phone = phoneInput.value.trim();
        
        // Clear previous error
        phoneError.style.display = 'none';
        phoneInput.style.borderColor = '';
        
        if (!phone) {
            phoneError.textContent = 'Phone number is required';
            phoneError.style.display = 'block';
            phoneInput.style.borderColor = 'red';
            isPhoneValid = false;
            updateSubmitButton();
            return false;
        }
        
        // Remove all non-digit characters
        const cleanPhone = phone.replace(/\D/g, '');
        
        // Check if exactly 10 digits and starts with 0
        if (cleanPhone.length !== 10) {
            phoneError.textContent = 'Phone number must be exactly 10 digits';
            phoneError.style.display = 'block';
            phoneInput.style.borderColor = 'red';
            isPhoneValid = false;
            updateSubmitButton();
            return false;
        }
        
        if (!cleanPhone.startsWith('0')) {
            phoneError.textContent = 'South African phone numbers must start with 0';
            phoneError.style.display = 'block';
            phoneInput.style.borderColor = 'red';
            isPhoneValid = false;
            updateSubmitButton();
            return false;
        }
        
        // Phone is valid
        phoneInput.style.borderColor = 'green';
        isPhoneValid = true;
        updateSubmitButton();
        return true;
    }

    function updateSubmitButton() {
        if (isEmailValid && isPhoneValid) {
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
            submitBtn.style.cursor = 'pointer';
            submitBtn.textContent = 'Proceed to Payment';
        } else {
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.6';
            submitBtn.style.cursor = 'not-allowed';
            submitBtn.textContent = 'Please fix errors above';
        }
    }

    // Real-time validation
    emailInput.addEventListener('input', function() {
        validateEmail();
    });

    emailInput.addEventListener('blur', function() {
        validateEmail();
    });

    phoneInput.addEventListener('input', function() {
        // Auto-format while typing
        let phone = phoneInput.value.replace(/\D/g, '');
        
        // Limit to 10 digits
        if (phone.length > 10) {
            phone = phone.substring(0, 10);
        }
        
        // Format with spaces for better readability
        if (phone.length > 6) {
            phoneInput.value = phone.replace(/(\d{3})(\d{3})(\d{4})/, '$1 $2 $3');
        } else if (phone.length > 3) {
            phoneInput.value = phone.replace(/(\d{3})(\d{0,3})/, '$1 $2');
        } else {
            phoneInput.value = phone;
        }
        
        validatePhone();
    });

    phoneInput.addEventListener('blur', function() {
        validatePhone();
    });

    // Handle training triggers
    document.querySelectorAll('.training-trigger').forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const trainingId = this.dataset.trainingId;
            const training = trainings[trainingId];
            
            // Update modal content
            document.getElementById('training-modal-title').textContent = training.title;
            document.getElementById('training-modal-description').innerHTML = training.description;
            document.getElementById('training-modal-id').value = training.id;
            
            // Handle pricing
            const isStudent = {{ auth()->user() && auth()->user()->userType === 'Student' ? 'true' : 'false' }};
            const basePrice = isStudent ? training.student_price : training.professional_price;
            
            if (training.is_hourly) {
                document.getElementById('training-hours-group').style.display = 'block';
                document.getElementById('training-price').textContent = `R${(basePrice * 1).toFixed(2)}`;
                document.getElementById('training-hours').oninput = function() {
                    document.getElementById('training-price').textContent = `R${(basePrice * this.value).toFixed(2)}`;
                };
            } else {
                document.getElementById('training-hours-group').style.display = 'none';
                document.getElementById('training-price').textContent = `R${basePrice.toFixed(2)}`;
            }
            
            document.getElementById('price-note').textContent = isStudent ? 
                '(Student Price Applied)' : '(Professional Price)';
            
            // Reset validation state
            emailInput.style.borderColor = '';
            phoneInput.style.borderColor = '';
            emailError.style.display = 'none';
            phoneError.style.display = 'none';
            isEmailValid = false;
            isPhoneValid = false;
            updateSubmitButton();
            
            // Show modal
            modal.style.display = 'flex';
            document.body.classList.add('no-scroll');
        });
    });
    
    // Close modal handlers
    modal.querySelector('.close-modal').addEventListener('click', closeModal);
    modal.querySelector('.modal-overlay').addEventListener('click', closeModal);

    function closeModal() {
        modal.style.display = 'none';
        document.body.classList.remove('no-scroll');
        
        // Clear validation errors when closing modal
        emailInput.style.borderColor = '';
        phoneInput.style.borderColor = '';
        emailError.style.display = 'none';
        phoneError.style.display = 'none';
    }

    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Final validation before submission
        const emailValid = validateEmail();
        const phoneValid = validatePhone();
        
        if (!emailValid || !phoneValid) {
            // Show all errors and prevent submission
            if (!emailValid) {
                emailInput.focus();
            } else {
                phoneInput.focus();
            }
            
            // Show alert message
            alert('Please fix the validation errors before proceeding to payment.');
            return;
        }
        
        // If we get here, both validations passed
        const trainingId = document.getElementById('training-modal-id').value;
        const hours = document.getElementById('training-hours')?.value || 1;
        const clientId = {{ auth()->id() ?? 'null' }};
        
        if (!clientId) {
            window.location.href = "{{ route('login') }}";
            return;
        }

        // Construct the checkout URL
        const url = `{{ route('stripe.checkout', ['clientId' => ':clientId', 'planId' => ':planId']) }}`
            .replace(':clientId', clientId)
            .replace(':planId', 'training_' + trainingId);
        
        // Redirect to Stripe checkout
        window.location.href = url;
    });

    // Initialize submit button state
    updateSubmitButton();
});
</script>