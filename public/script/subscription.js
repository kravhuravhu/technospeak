let userPlans = [];
let availablePlans = [];
let allPlansData = {}; // This will store all plan details

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // First load all plan details
    loadAllPlanDetails().then(() => {
        // Then fetch user-specific plans
        fetchUserPlans();
    });
});

async function loadAllPlanDetails() {
    try {
        const response = await fetch('/api/plans/details');
        allPlansData = await response.json();
    } catch (error) {
        console.error('Error loading plan details:', error);
        // Fallback to hardcoded data if API fails
        allPlansData = {
            1: { id: 1, title: "Formal Training", price: "From R1500/training", description: "Structured learning with professional instructors", features: ["Comprehensive EUC training", "Web development courses", "Portfolio building", "Certificate of completion"], isFree: false },
            2: { id: 2, title: "Task Assistance", price: "From R100/hour", description: "Get help with specific challenges or tasks", features: ["Tutoring and consultations", "Task-specific help", "Flexible payment options", "Quality guaranteed"], isFree: false },
            3: { id: 3, title: "Personal Guide", price: "From R110/hour", description: "Personalized one-on-one sessions tailored to your needs", features: ["Custom video/chat sessions", "Submit requests in advance", "Flexible scheduling", "Additional hours available"], isFree: false },
            4: { id: 4, title: "Group Session 1", price: "Free", description: "Clients will be able to ask questions on a live Q&A.", features: ["Clients will be able to ask questions on a live Q&A", "Participants remain muted but can submit questions via chat"], isFree: true },
            5: { id: 5, title: "Group Session 2", price: "R130/hr (students) | R200/hr (business)", description: "Clients will receive answers based on the comments they made on the videos.", features: ["Clients will receive answers based on the comments they made on the videos", "Covers various topics, such as programming, cybersecurity, and other tech skill-building sessions", "Clients pose questions and they are answered live"], isFree: false },
            6: { id: 6, title: "Premium Subscription", price: "R350/quarterly", description: "Full access to all resources for committed learners", features: ["All clickbait-style videos", "Downloadable resources", "Monthly tech tips newsletter", "Priority support"], isFree: false },
            7: { id: 7, title: "Tech Teasers", price: "Free", description: "Perfect for beginners who want to explore our content", features: ["Access to clickbait videos on social media", "Ask questions in comments", "Basic community support"], isFree: true }
        };
    }
}

async function fetchUserPlans() {
    try {
        const response = await fetch('/api/user/subscriptions');
        const data = await response.json();
        
        userPlans = data.plans;
        availablePlans = data.available_plans;
        
        renderUserPlans();
        renderOtherPlans();
    } catch (error) {
        console.error('Error fetching user plans:', error);
        userPlans = [7]; // Fallback to free plan
        renderUserPlans();
        renderOtherPlans();
    }
}

function renderUserPlans() {
    const container = document.getElementById("userPlans");
    if (!container) return;
    
    container.innerHTML = "";
    
    userPlans.forEach(planId => {
        const plan = allPlansData[planId];
        if (!plan) {
            console.warn(`Plan details not found for ID: ${planId}`);
            return;
        }
        
        const card = document.createElement("div");
        card.className = `plan-card ${plan.isFree ? 'free-plan' : 'current-plan'}`;
        
        card.innerHTML = `
            <span class="plan-badge ${plan.isFree ? 'free-badge' : ''}">Active</span>
            <h3>${plan.title || plan.name}</h3>
            <div class="plan-price">${plan.price || `R${plan.student_price} (students) | R${plan.professional_price} (business)`}</div>
            <p class="plan-description">${plan.description}</p>
            <ul class="plan-features">
                ${(plan.features || []).map(feature => `<li>${feature}</li>`).join('')}
            </ul>
            <div class="plan-actions">
                <button class="btn details-btn" onclick="showPlanDetails(${plan.id})">
                    <i class="fas fa-info-circle"></i> Details
                </button>
                ${plan.isFree ? '' : `
                <button class="btn unsubscribe-btn" onclick="unsubscribe(${plan.id})">
                    <i class="fas fa-times"></i> Unsubscribe
                </button>`}
            </div>
        `;
        container.appendChild(card);
    });
}

function renderOtherPlans() {
    const container = document.getElementById("otherPlans");
    if (!container) return;
    
    container.innerHTML = "";
    
    availablePlans.forEach(plan => {
        const planDetails = allPlansData[plan.id] || plan;
        
        const card = document.createElement("div");
        card.className = "plan-card other-plan";
        
        card.innerHTML = `
            <h3>${planDetails.name || planDetails.title}</h3>
            <div class="plan-price">${planDetails.price || `R${planDetails.student_price} (students) | R${planDetails.professional_price} (business)`}</div>
            <p class="plan-description">${planDetails.description}</p>
            <ul class="plan-features">
                ${(planDetails.features || []).map(feature => `<li>${feature}</li>`).join('')}
            </ul>
            <div class="plan-actions">
                <button class="btn details-btn" onclick="showPlanDetails(${planDetails.id})">
                    <i class="fas fa-info-circle"></i> Details
                </button>
                <button class="btn subscribe-btn" onclick="subscribe(${planDetails.id})">
                    <i class="fas fa-check"></i> Subscribe
                </button>
            </div>
        `;
        container.appendChild(card);
    });
}