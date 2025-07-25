<!-- resources/views/components/service_modal.blade.php -->
<div class="session-registration-modal" id="service-modal" style="display: none;">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <button class="close-modal">&times;</button>
        
        <h3 id="service-modal-title">Service Title</h3>
        <div class="session-details" id="service-modal-description"></div>
        
        <form class="registration-form" method="POST" action="{{ route('service.purchase') }}" id="service-form">
            @csrf
            <input type="hidden" name="service_id" id="service-modal-id">
            
            <div class="form-group" id="service-hours-group" style="display: none;">
                <label for="service-hours">Hours Required</label>
                <input type="number" id="service-hours" name="hours" min="1" value="1">
            </div>
            
            <div class="form-group">
                <label for="service-name">Full Name</label>
                <input type="text" id="service-name" name="name" 
                    value="{{ auth()->user() ? auth()->user()->name : '' }}" required>
            </div>
            
            <div class="payment-summary">
                <h4>Payment Summary</h4>
                <div class="price-display">
                    <span>Price:</span>
                    <span class="price-amount" id="service-price"></span>
                </div>
                <p class="price-note" id="price-note"></p>
            </div>
            
            <button type="submit" class="submit-btn">Proceed to Payment</button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const services = {
        @foreach(\App\Models\ServicePlan::whereIn('id', [3,4,5,6,7])->get() as $service)
        {{ $service->id }}: {
            id: {{ $service->id }},
            title: "{{ $service->name }}",
            description: `{!! $service->description !!}`,
            student_price: {{ $service->rate_student }},
            business_price: {{ $service->rate_business }},
            is_hourly: {{ $service->is_hourly ? 'true' : 'false' }}
        },
        @endforeach
    };

    const modal = document.getElementById('service-modal');
    const form = document.getElementById('service-form');

    // Handle service triggers
    document.querySelectorAll('.service-trigger').forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const serviceId = this.dataset.serviceId;
            const service = services[serviceId];
            
            // Update modal content
            document.getElementById('service-modal-title').textContent = service.title;
            document.getElementById('service-modal-description').innerHTML = service.description;
            document.getElementById('service-modal-id').value = service.id;
            
            // Handle pricing
            const isStudent = {{ auth()->user() && auth()->user()->userType === 'Student' ? 'true' : 'false' }};
            const basePrice = isStudent ? service.student_price : service.business_price;
            
            if (service.is_hourly) {
                document.getElementById('service-hours-group').style.display = 'block';
                document.getElementById('service-price').textContent = `R${(basePrice * 1).toFixed(2)}`;
                document.getElementById('service-hours').oninput = function() {
                    document.getElementById('service-price').textContent = `R${(basePrice * this.value).toFixed(2)}`;
                };
            } else {
                document.getElementById('service-hours-group').style.display = 'none';
                document.getElementById('service-price').textContent = `R${basePrice.toFixed(2)}`;
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