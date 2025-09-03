<div class="service-assistance-modal" id="serviceAssistanceModal">
    <div class="modal-content">
        <span class="close" id="closeServiceAssistanceModal">&times;</span>
        <h2>Get Assistance with <span id="serviceCategoryTitle">Service</span></h2>
        
        <form id="serviceAssistanceForm" action="/service-request" method="POST">
            @csrf
            <input type="hidden" name="service_type" id="serviceTypeInput">
            
            <div class="form-group">
                <label for="name">Full Name *</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email Address *</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="service_needs">What do you need help with? *</label>
                <textarea id="service_needs" name="service_needs" rows="3" placeholder="Please describe your requirements..." required></textarea>
            </div>
            
            <div class="form-group">
                <label for="timeline">When do you need this completed?</label>
                <select id="timeline" name="timeline">
                    <option value="">Select timeline</option>
                    <option value="ASAP">As soon as possible</option>
                    <option value="1 week">Within 1 week</option>
                    <option value="2 weeks">Within 2 weeks</option>
                    <option value="1 month">Within 1 month</option>
                    <option value="flexible">Flexible timeline</option>
                </select>
            </div>
            
            <button type="submit" class="submit-btn">Submit Request</button>
        </form>
    </div>
</div>