@php
// Get the latest upcoming session of the specified type
$latestSession = \App\Models\TrainingSession::where('type_id', $typeId)
    ->where('scheduled_for', '>', now())
    ->orderBy('scheduled_for', 'desc')
    ->first();
@endphp

{{-- if already registered --}}
@if(session('success') || session('error'))
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            showPopUp(
                '{{ session('success') ? 'Success' : 'Error' }}',
                '{{ session('success') ?? session('error') }}',
                '{{ session('success') ? 'success' : 'error' }}'
            );
        });
    </script>
@endif

<div class="session-registration-modal" id="session-registration-modal-{{ $typeId }}" style="display: none;">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <button class="close-modal">&times;</button>
        
        @if($latestSession)
            <h3>Register for {{ $latestSession->title }}</h3>
            <div class="session-details">
                <p><strong>Date & Time:</strong> {{ $latestSession->scheduled_for->format('F j, Y g:i A') }}</p>
                <p><strong>Duration:</strong> {{ $latestSession->formatted_duration }}</p>
                <p><strong>Instructor:</strong> {{ $latestSession->instructor->name ?? 'TBA' }}</p>
                <p><strong>Available Spots:</strong> 
                    {{ $latestSession->available_spots ?? 'Unlimited' }}
                </p>
            </div>
            
            <form class="registration-form" method="POST" action="{{ route('training.register') }}" id="session-form-{{ $typeId }}">
                @csrf
                <input type="hidden" name="session_id" value="{{ $latestSession->id }}">
                
                <div class="form-group">
                    <label for="name-{{ $typeId }}">Full Name</label>
                    <input type="text" id="name-{{ $typeId }}" name="name" 
                        value="{{ auth()->user() ? auth()->user()->name : '' }}" required>
                </div>
                
                <div class="form-group">
                    <label for="email-{{ $typeId }}">Email Address</label>
                    <input type="email" id="email-{{ $typeId }}" name="email" 
                        value="{{ auth()->user() ? auth()->user()->email : '' }}" required>
                    <div class="error-message" id="email-error-{{ $typeId }}" style="color: red; display: none; font-size: 12px; margin-top: 5px;"></div>
                </div>
                
                <div class="form-group">
                    <label for="phone-{{ $typeId }}">Phone Number</label>
                    <input type="tel" id="phone-{{ $typeId }}" name="phone" 
                        value="{{ auth()->user() && auth()->user()->phone ? auth()->user()->phone : '' }}"
                        placeholder="(e.g., 0123456789)" required>
                    <div class="error-message" id="phone-error-{{ $typeId }}" style="color: red; display: none; font-size: 12px; margin-top: 5px;"></div>
                </div>
                
                <div class="payment-summary">
                    <h4>Payment Summary</h4>
                    <div class="price-display">
                        <span>Price:</span>
                        <span class="price-amount">
                            @if(auth()->user())
                                R{{ number_format($latestSession->type->getPriceForUserType(auth()->user()->userType), 2) }}
                            @else
                                R{{ number_format($latestSession->type->professional_price, 2) }}
                            @endif
                        </span>
                    </div>
                    <p class="price-note">
                        @if(auth()->user() && (auth()->user()->userType === 'Student'))
                            (Student Price Applied)
                        @else
                            (Professional Price)
                        @endif
                    </p>
                </div>
                
                <button type="submit" class="submit-btn" id="submit-btn-{{ $typeId }}" disabled>Proceed to Payment</button>
            </form>
        @else
            <div class="no-session">
                <h3>No Upcoming Sessions Scheduled</h3>
                <p>There are currently no upcoming {{ $typeName }} sessions scheduled.</p>
                <p>Please check back later or contact us for more information.</p>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('session-registration-modal-{{ $typeId }}');
    
    if (!modal) return;

    const form = document.getElementById('session-form-{{ $typeId }}');
    const emailInput = document.getElementById('email-{{ $typeId }}');
    const phoneInput = document.getElementById('phone-{{ $typeId }}');
    const emailError = document.getElementById('email-error-{{ $typeId }}');
    const phoneError = document.getElementById('phone-error-{{ $typeId }}');
    const submitBtn = document.getElementById('submit-btn-{{ $typeId }}');

    // Track validation state - start with both invalid
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
        
        // STRICT validation: EXACTLY 10 digits and starts with 0
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
        // Only enable button when BOTH email and phone are valid
        if (isEmailValid && isPhoneValid) {
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
            submitBtn.style.cursor = 'pointer';
            submitBtn.textContent = 'Proceed to Payment';
            submitBtn.style.backgroundColor = ''; // Reset to default
        } else {
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.5';
            submitBtn.style.cursor = 'not-allowed';
            submitBtn.textContent = 'Please fix errors above';
            submitBtn.style.backgroundColor = '#ccc';
        }
    }

    // Real-time validation on every input
    if (emailInput) {
        emailInput.addEventListener('input', function() {
            validateEmail();
        });

        emailInput.addEventListener('blur', function() {
            validateEmail();
        });
    }

    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            // Auto-format while typing but don't interfere with validation
            let phone = phoneInput.value.replace(/\D/g, '');
            
            // Limit to 10 digits - user can't type more than 10
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
    }

    // Handle form submission - ADD EXTRA SAFETY CHECK
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // FINAL VALIDATION - Double check everything
            const finalEmailCheck = validateEmail();
            const finalPhoneCheck = validatePhone();
            
            // If anything is invalid, STOP here
            if (!finalEmailCheck || !finalPhoneCheck) {
                e.preventDefault();
                e.stopPropagation();
                
                // Show which field has error
                if (!finalEmailCheck) {
                    emailInput.focus();
                } else {
                    phoneInput.focus();
                }
                
                alert('Please fix all validation errors before proceeding to payment.');
                return false;
            }
            
            // Only proceed if BOTH are valid - submit the form normally
            if (isEmailValid && isPhoneValid) {
                form.submit();
            }
        });
    }

    // Initialize submit button as disabled
    updateSubmitButton();
});

// Modal trigger functionality
document.addEventListener('DOMContentLoaded', function() {
    const triggers = document.querySelectorAll('.registration-trigger[data-type-id="{{ $typeId }}"]');
    const modal = document.getElementById('session-registration-modal-{{ $typeId }}');

    if (triggers.length && modal) {
        triggers.forEach(trigger => {
            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Reset validation state when opening modal
                const emailInput = document.getElementById('email-{{ $typeId }}');
                const phoneInput = document.getElementById('phone-{{ $typeId }}');
                const emailError = document.getElementById('email-error-{{ $typeId }}');
                const phoneError = document.getElementById('phone-error-{{ $typeId }}');
                const submitBtn = document.getElementById('submit-btn-{{ $typeId }}');
                
                if (emailInput) emailInput.style.borderColor = '';
                if (phoneInput) phoneInput.style.borderColor = '';
                if (emailError) emailError.style.display = 'none';
                if (phoneError) phoneError.style.display = 'none';
                
                // Reset validation state
                if (window.isEmailValid !== undefined) window.isEmailValid = false;
                if (window.isPhoneValid !== undefined) window.isPhoneValid = false;
                
                // Disable submit button
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.style.opacity = '0.5';
                    submitBtn.style.cursor = 'not-allowed';
                    submitBtn.textContent = 'Please fix errors above';
                    submitBtn.style.backgroundColor = '#ccc';
                }
                
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });
        });
        
        modal.querySelector('.close-modal').addEventListener('click', function() {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        });

        modal.querySelector('.modal-overlay').addEventListener('click', function() {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        });
    }
});

function showPopUp(title, message, type = 'success') {
    let existingPopup = document.querySelector('.popup');
    if (existingPopup) existingPopup.remove();

    const popup = document.createElement('div');
    popup.className = `popup ${type}`;
    popup.innerHTML = `
        <h3>${title}</h3>
        <p>${message}</p>
    `;

    popup.style.position = 'fixed';
    popup.style.top = '20px';
    popup.style.right = '20px';
    popup.style.padding = '20px';
    popup.style.backgroundColor = type === 'error' ? '#ffebee' : '#e8f5e9';
    popup.style.border = type === 'error' ? '1px solid #ef9a9a' : '1px solid #a5d6a7';
    popup.style.borderRadius = '5px';
    popup.style.zIndex = '1000';
    popup.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';

    document.body.appendChild(popup);

    setTimeout(() => popup.remove(), 10000);
}
</script>

<style>
    :root {
        --skBlue: #38b6ff;
        --darkBlue: #062644;
        --powBlue: #15415a;
        --lightGray: #f8fafc;
        --textDark: #2d3748;
        --textLight: #e2e8f0;
        --danger: #e53e3e;
        --warning: #dd6b20;
        --success: #38a169;
    }
    .session-registration-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1000;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .session-registration-modal .modal-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(5px);
    }

    .session-registration-modal .modal-content {
        position: relative;
        background-color: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        max-width: 520px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        z-index: 1001;
        color: var(--textDark);
        font-family: 'Roboto', sans-serif;
    }

    .session-registration-modal .close-modal {
        position: absolute;
        top: 1rem;
        right: 1rem;
        font-size: 1.5rem;
        background: none;
        border: none;
        cursor: pointer;
        color: var(--darkBlue);
    }

    .session-registration-modal .modal-content h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--darkBlue);
    }

    .session-registration-modal .session-details {
        margin: 1.5rem 0;
        padding: 1rem 1.25rem;
        background-color: var(--darkBlue);
        border-radius: 12px;
        font-size: 0.95rem;
    }

    .session-registration-modal .session-details p {
        margin-bottom: 0.75rem;
        line-height: 1.5;
        color: var(--textLight); 
    }

    .session-registration-modal .form-group {
        margin-bottom: 1.5rem;
    }

    .session-registration-modal .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--skBlue);
        font-size: 1rem;
    }

    .session-registration-modal .form-group input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid rgba(56, 182, 255, 0.2);
        border-radius: 8px;
        font-size: 1rem;
        outline: none;
        transition: all 0.3s ease-in-out;
    }

    .session-registration-modal .form-group input::placeholder {
        color: #1d1d1d;
        font-size: .9em;
    }

    .session-registration-modal .form-group input:focus {
        border-color: var(--skBlue);
        box-shadow: 0 0 0 3px rgba(56, 182, 255, 0.2);
    }

    .session-registration-modal .submit-btn {
        background-color: var(--skBlue);
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 9999px;
        cursor: pointer;
        font-weight: 600;
        font-size: 1rem;
        width: 100%;
        transition: background-color 0.3s;
    }

    .session-registration-modal .submit-btn:hover {
        background-color: #2a9ce8;
    }

    .session-registration-modal .submit-btn:disabled {
        background-color: #ccc;
        cursor: not-allowed;
        opacity: 0.5;
    }

    .session-registration-modal .no-session {
        text-align: center;
        padding: 2rem 0;
    }

    .session-registration-modal .no-session h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--danger);
    }

    .session-registration-modal .no-session p {
        color: #4a5568;
        font-size: 0.95rem;
        margin-top: 0.5rem;
    }

    .session-registration-modal .payment-summary {
        margin: 1.5rem 0;
        padding: 1rem;
        background-color: var(--lightGray);
        border-radius: 8px;
    }

    .session-registration-modal .payment-summary h4 {
        margin-bottom: 0.75rem;
        color: var(--darkBlue);
        font-size: 1.1rem;
    }

    .session-registration-modal .price-display {
        display: flex;
        justify-content: space-between;
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--darkBlue);
    }

    .session-registration-modal .price-note {
        margin-top: 0.5rem;
        font-size: 0.85rem;
        color: var(--powBlue);
        text-align: right;
    }

    .error-message {
        color: red;
        font-size: 12px;
        margin-top: 5px;
        display: none;
    }
</style>