<!-- resources/views/components/subscription_modal.blade.php -->
<div class="session-registration-modal" id="subscription-modal-{{ $planId }}" style="display: none;">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <button class="close-modal">&times;</button>
        
        <h3>Subscribe to {{ $planName }}</h3>
        <div class="session-details">
            <p><strong>Plan Includes:</strong></p>
            <ul>
                <li>Full video access</li>
                <li>Downloadable resources</li>
                <li>Monthly tech newsletters</li>
                <li>Cheatsheets & guides</li>
            </ul>
        </div>
        
        <form class="registration-form" method="POST" action="{{ route('subscription.subscribe') }}" id="subscription-form-{{ $planId }}">
            @csrf
            <input type="hidden" name="plan_id" value="{{ $planId }}">
            
            <div class="form-group">
                <label for="name-{{ $planId }}">Full Name</label>
                <input type="text" id="name-{{ $planId }}" name="name" 
                    value="{{ auth()->user() ? auth()->user()->name : '' }}" required>
            </div>
            
            <div class="form-group">
                <label for="email-{{ $planId }}">Email</label>
                <input type="email" id="email-{{ $planId }}" name="email" 
                    value="{{ auth()->user() ? auth()->user()->email : '' }}" required>
            </div>
            
            <div class="payment-summary">
                <h4>Payment Summary</h4>
                <div class="price-display">
                    <span>Price:</span>
                    <span class="price-amount">
                        @if(auth()->user() && auth()->user()->userType === 'Student')
                            R{{ number_format($plan->rate_student, 2) }}
                        @else
                            R{{ number_format($plan->rate_business, 2) }}
                        @endif
                    </span>
                </div>
                
                <input type="hidden" name="amount" 
                    value="{{ auth()->user() && auth()->user()->userType === 'Student' ? $plan->rate_student : $plan->rate_business }}">

                <p class="price-note">
                    @if(auth()->user() && auth()->user()->userType === 'Student')
                        (Student Price Applied - Quarterly)
                    @else
                        (Professional Price - Quarterly)
                    @endif
                </p>
            </div>
            
            <button type="submit" class="submit-btn">Proceed to Payment</button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('subscription-modal-{{ $planId }}');
    const form = document.getElementById('subscription-form-{{ $planId }}');
    
    // Handle modal triggers
    document.querySelectorAll('.subscription-trigger[data-plan-id="{{ $planId }}"]').forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
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
    }

    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Here you would typically send the form via AJAX or let it submit normally
        // For Stripe integration, you would:
        // 1. Send the data to your backend
        // 2. Get the Stripe checkout URL
        // 3. Redirect to that URL
        
        // For now, we'll just submit the form normally
        this.submit();
    });
});
</script>