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


// Professional Pricing Section
function togglePricing(type) {
    // Update toggle buttons
    document.querySelectorAll('.pricing-toggle button').forEach(button => {
        button.classList.remove('active');
    });
    event.target.classList.add('active');
    
    // Show/hide appropriate pricing
    if (type === 'student') {
        document.querySelectorAll('.student-price').forEach(el => {
            el.classList.add('active');
        });
        document.querySelectorAll('.professional-price').forEach(el => {
            el.classList.remove('active');
        });
    } else {
        document.querySelectorAll('.student-price').forEach(el => {
            el.classList.remove('active');
        });
        document.querySelectorAll('.professional-price').forEach(el => {
            el.classList.add('active');
        });
    }
}