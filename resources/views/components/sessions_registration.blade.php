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
            
            <form class="registration-form" method="POST" action="{{ route('training.register') }}">
                @csrf
                <input type="hidden" name="session_id" value="{{ $latestSession->id }}">
                
                <div class="form-group">
                    <label for="name-{{ $typeId }}">Full Name</label>
                    <input type="text" id="name-{{ $typeId }}" name="name" 
                        value="{{ auth()->user() ? auth()->user()->name : '' }}" required>
                </div>
                
                <div class="form-group">
                    <label for="email-{{ $typeId }}">Email</label>
                    <input type="email" id="email-{{ $typeId }}" name="email" 
                        value="{{ auth()->user() ? auth()->user()->email : '' }}" required>
                </div>
                
                <div class="form-group">
                    <label for="phone-{{ $typeId }}">Phone Number</label>
                    <input type="tel" id="phone-{{ $typeId }}" name="phone" required>
                    <div class="phone-validation-message" id="phone-validation-{{ $typeId }}" style="display: none; color: var(--danger); font-size: 0.85rem; margin-top: 0.5rem;"></div>
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
        const triggers = document.querySelectorAll('.registration-trigger[data-type-id="{{ $typeId }}"]');
        const modal = document.getElementById('session-registration-modal-{{ $typeId }}');
        const closeModalBtn = modal ? modal.querySelector('.close-modal') : null;
        const modalOverlay = modal ? modal.querySelector('.modal-overlay') : null;

        if (triggers.length && modal) {
            triggers.forEach(trigger => {
                trigger.addEventListener('click', function(e) {
                    e.preventDefault();
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

        // Phone number validation
        const phoneInput = document.getElementById('phone-{{ $typeId }}');
        const submitBtn = document.getElementById('submit-btn-{{ $typeId }}');
        const validationMessage = document.getElementById('phone-validation-{{ $typeId }}');

        if (phoneInput && submitBtn) {
            phoneInput.addEventListener('input', function() {
                validatePhoneNumber(this.value);
            });

            phoneInput.addEventListener('blur', function() {
                validatePhoneNumber(this.value);
            });
        }

        function validatePhoneNumber(phone) {
            // Clear previous validation message
            validationMessage.style.display = 'none';
            validationMessage.textContent = '';
            
            // Remove any non-digit characters
            const cleanPhone = phone.replace(/\D/g, '');
            
            // South African phone number validation
            // Valid formats: 
            // - 10 digits starting with 0 (e.g., 0123456789)
            // - 11 digits starting with 27 (e.g., 27123456789)
            // - 9 digits starting without 0 (e.g., 123456789)
            
            let isValid = false;
            let message = '';
            
            if (cleanPhone.length === 0) {
                message = 'Phone number is required';
            } else if (cleanPhone.length === 9 && !cleanPhone.startsWith('0')) {
                // 9 digits without leading 0
                isValid = true;
            } else if (cleanPhone.length === 10 && cleanPhone.startsWith('0')) {
                // 10 digits starting with 0
                isValid = true;
            } else if (cleanPhone.length === 11 && cleanPhone.startsWith('27')) {
                // 11 digits starting with 27 (country code)
                isValid = true;
            } else {
                message = 'Please enter a valid South African phone number (e.g., 0123456789 or 27123456789)';
            }
            
            // Update UI based on validation
            if (isValid) {
                phoneInput.style.borderColor = 'var(--success)';
                submitBtn.disabled = false;
                submitBtn.style.opacity = '1';
                submitBtn.style.cursor = 'pointer';
            } else {
                phoneInput.style.borderColor = 'var(--danger)';
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.6';
                submitBtn.style.cursor = 'not-allowed';
                
                if (message) {
                    validationMessage.textContent = message;
                    validationMessage.style.display = 'block';
                }
            }
            
            return isValid;
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
        transition: all 0.3s;
    }

    .session-registration-modal .submit-btn:hover {
        background-color: #2a9ce8;
    }

    .session-registration-modal .submit-btn:disabled {
        background-color: #cccccc;
        cursor: not-allowed;
        opacity: 0.6;
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
</style>