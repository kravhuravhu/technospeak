@php
// Get the latest upcoming session of the specified type
$latestSession = \App\Models\TrainingSession::where('type_id', $typeId)
    ->where('scheduled_for', '>', now())
    ->orderBy('scheduled_for', 'asc')
    ->first();
@endphp

<div class="session-registration-modal" id="session-registration-modal-{{ $typeId }}" style="display: none;">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <button class="close-modal">&times;</button>
        
        @if($latestSession)
            <h3>Register for {{ $latestSession->title }}</h3>
            <div class="session-details">
                <p><strong>Date & Time:</strong> {{ $latestSession->scheduled_for->format('F j, Y g:i A') }}</p>
                <p><strong>Duration:</strong> {{ $latestSession->duration }}</p>
                <p><strong>Instructor:</strong> {{ $latestSession->instructor->name ?? 'TBA' }}</p>
                <p><strong>Available Spots:</strong> 
                    {{ $latestSession->available_spots ?? 'Unlimited' }}
                </p>
            </div>
            
            <form class="registration-form" method="POST" action="{{ route('session.register') }}">
                @csrf
                <input type="hidden" name="qa_session_id" value="{{ $latestSession->id }}">
                
                <div class="form-group">
                    <label for="name-{{ $typeId }}">Full Name</label>
                    <input type="text" id="name-{{ $typeId }}" name="name" 
                        value="{{ Auth::user()->name }}" required>
                </div>
                
                <div class="form-group">
                    <label for="email-{{ $typeId }}">Email</label>
                    <input type="email" id="email-{{ $typeId }}" name="email" 
                        value="{{ Auth::user()->email }}" required>
                </div>
                
                <div class="form-group">
                    <label for="phone-{{ $typeId }}">Phone Number</label>
                    <input type="tel" id="phone-{{ $typeId }}" name="phone"
                        value="{{ Auth::user()->phone }}">
                </div>
                
                <div class="payment-summary">
                    <h4>Payment Summary</h4>
                    <p>Q/A Session: R110.00</p>
                </div>
                
                <button type="submit" class="submit-btn">Proceed to Payment</button>
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
});
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

.modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(5px);
}

.modal-content {
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

.close-modal {
    position: absolute;
    top: 1rem;
    right: 1rem;
    font-size: 1.5rem;
    background: none;
    border: none;
    cursor: pointer;
    color: var(--darkBlue);
}

.modal-content h3 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: var(--darkBlue);
}

.session-details {
    margin: 1.5rem 0;
    padding: 1rem 1.25rem;
    background-color: var(--darkBlue);
    border-radius: 12px;
    font-size: 0.95rem;
}

.session-details p {
    margin-bottom: 0.75rem;
    line-height: 1.5;
    color: var(--textLight); 
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: var(--skBlue);
    font-size: 1rem;
}

.form-group input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid rgba(56, 182, 255, 0.2);
    border-radius: 8px;
    font-size: 1rem;
    outline: none;
    transition: all 0.3s ease-in-out;
}

.form-group input::placeholder {
    color: #1d1d1d;
    font-size: .9em;
}

.form-group input:focus {
    border-color: var(--skBlue);
    box-shadow: 0 0 0 3px rgba(56, 182, 255, 0.2);
}

.submit-btn {
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

.submit-btn:hover {
    background-color: #2a9ce8;
}

.no-session {
    text-align: center;
    padding: 2rem 0;
}

.no-session h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--danger);
}

.no-session p {
    color: #4a5568;
    font-size: 0.95rem;
    margin-top: 0.5rem;
}
</style>
