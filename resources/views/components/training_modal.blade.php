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
            
            <div class="payment-summary">
                <h4>Payment Summary</h4>
                <div class="price-display">
                    <span>Price:</span>
                    <span class="price-amount" id="training-price"></span>
                </div>
                <p class="price-note" id="price-note"></p>
            </div>
            
            <button type="submit" class="submit-btn">Proceed to Payment</button>
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
    }

    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
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
});
</script>