const allPlans = [
    {
        id: 1,
        title: "Free Subscription",
        price: "Free",
        description: "Perfect for beginners who want to explore our content",
        features: [
            "Access to clickbait videos on social media",
            "Ask questions in comments",
            "Basic community support"
        ],
        isCurrent: true
    },
    {
        id: 2,
        title: "Premium Subscription",
        price: "R350/quarterly",
        description: "Full access to all resources for committed learners",
        features: [
            "All clickbait-style videos",
            "Downloadable resources",
            "Monthly tech tips newsletter",
            "Priority support"
        ],
        isCurrent: true
    },
    {
        id: 3,
        title: "Personal Guide",
        price: "From R110/hour",
        description: "Personalized one-on-one sessions tailored to your needs",
        features: [
            "Custom video/chat sessions",
            "Submit requests in advance",
            "Flexible scheduling",
            "Additional hours available"
        ],
        isCurrent: false
    },
    {
        id: 4,
        title: "Formal Training",
        price: "From R1500/training",
        description: "Structured learning with professional instructors",
        features: [
            "Comprehensive EUC training",
            "Web development courses",
            "Portfolio building",
            "Certificate of completion"
        ],
        isCurrent: false
    },
    {
        id: 5,
        title: "Task Assistance ",
        price: "From R100/hour",
        description: "Get help with specific challenges or tasks",
        features: [
            "Tutoring and consultations",
            "Task-specific help",
            "Flexible payment options",
            "Quality guaranteed"
        ],
        isCurrent: false
    },
    {
        id: 6,
        title: "Task Assistance",
        price: "From R1000/task",
        description: "Professional help with complex projects",
        features: [
            "Hands-on coding help",
            "Web development support",
            "Pay-per-task model",
            "Fast turnaround"
        ],
        isCurrent: false
    }
];

// User current plan IDs
let userPlanIds = [1, 2];

function renderUserPlans() {
    const container = document.getElementById("userPlans");
    container.innerHTML = "";
    
    allPlans.forEach(plan => {
        if (userPlanIds.includes(plan.id)) {
            const card = document.createElement("div");
            card.className = "plan-card current-plan";
            card.innerHTML = `
                <span class="plan-badge">Active</span>
                <h3>${plan.title}</h3>
                <div class="plan-price">${plan.price}</div>
                <p class="plan-description">${plan.description}</p>
                <ul class="plan-features">
                    ${plan.features.map(feature => `<li>${feature}</li>`).join('')}
                </ul>
                <div class="plan-actions">
                    <button class="details-btn" onclick="showPlanDetails(${plan.id})">
                        <i class="fas fa-info-circle"></i> Details
                    </button>
                    <button class="unsubscribe-btn" onclick="unsubscribe(${plan.id})">
                        <i class="fas fa-times"></i> Unsubscribe
                    </button>
                </div>
            `;
            container.appendChild(card);
        }
    });
}

function renderOtherPlans() {
    const container = document.getElementById("otherPlans");
    container.innerHTML = "";
    
    allPlans.forEach(plan => {
        if (!userPlanIds.includes(plan.id)) {
            const card = document.createElement("div");
            card.className = "plan-card";
            card.innerHTML = `
                <h3>${plan.title}</h3>
                <div class="plan-price">${plan.price}</div>
                <p class="plan-description">${plan.description}</p>
                <ul class="plan-features">
                    ${plan.features.slice(0, 3).map(feature => `<li>${feature}</li>`).join('')}
                    ${plan.features.length > 3 ? '<li>+ more benefits</li>' : ''}
                </ul>
                <div class="plan-actions">
                    <button class="details-btn" onclick="showPlanDetails(${plan.id})">
                        <i class="fas fa-info-circle"></i> Details
                    </button>
                    <button class="subscribe-btn" onclick="subscribe(${plan.id})">
                        <i class="fas fa-check"></i> Subscribe
                    </button>
                </div>
            `;
            container.appendChild(card);
        }
    });
}

function showPlanDetails(planId) {
    const plan = allPlans.find(p => p.id === planId);
    openModal({
        title: `Details for ${plan.title}`,
        body: `
            <p><strong>Description:<br></strong> ${plan.description}</p>
            <p><strong><br>Features:</strong></p>
            ${plan.features.map(feature => `• ${feature}<br>`).join('')}<br>
        `,
        confirmText: "Close",
        onConfirm: function() {
            closeModal();
        }
    });
}

function unsubscribe(planId) {
    openModal({
        title: "Unsubscribe Confirmation",
        body: `
            Are you sure you want to unsubscribe from this plan? This action cannot be undone.
            <br><br>
        `,
        confirmText: "Yes, Unsubscribe",
        cancelText: "No, Keep Subscription",
        onConfirm: function() {
            userPlanIds = userPlanIds.filter(id => id !== planId);
            renderUserPlans();
            renderOtherPlans();
            console.log(`Plan ${planId} unsubscribed.`);
        },
        onCancel: function() {
            console.log("Unsubscribe action cancelled.");
        }
    });
}

function subscribe(planId) {
    userPlanIds.push(planId);
    renderUserPlans();
    renderOtherPlans();
    openModal({
        title: "Subscription Updated",
        body: `You have successfully subscribed to the ${allPlans.find(plan => plan.id === planId).title} plan.<br>`,
        confirmText: "Awesome!",
        onConfirm: function() {
            closeModal();
        }
    });
}

// Initial render
renderUserPlans();
renderOtherPlans();