// Resource data with features
const allResources = [
    {
        id: 1,
        title: "Basic Technical Guides",
        category: "Free Resources",
        description: "Essential guides for beginners covering fundamental concepts",
        thumbnail: "../images/freeResources2.png",
        type: "PDF Guides",
        requiredPlan: 1,
        locked: true
    },
    {
        id: 2,
        title: "Advanced Scripting Cheat Sheets",
        category: "Annual Subscription",
        description: "Comprehensive collection of scripting shortcuts and examples",

        thumbnail: "../images/cheatsheets.png",
        type: "Cheat Sheets",
        requiredPlan: 2,
        locked: true
    },
    {
        id: 3,
        title: "One-on-One Session Notes",
        category: "Personal Guide",
        description: "Personalised notes from your coaching sessions",
        thumbnail: "../images/oneOnOnesessions2.png",
        type: "Session Notes",
        requiredPlan: 3,
        locked: true
    },
    {
        id: 4,
        title: "Web Development Handbook",
        category: "Formal Training",
        description: "Complete guide to modern web development practices",
        thumbnail: "../images/formalTraining.png",
        type: "Handbook",
        requiredPlan: 4,
        locked: true
    },
    {
        id: 5,
        title: "Group Session Recordings",
        category: "Group Sessions",
        description: "Access all past group session recordings and materials",
        thumbnail: "../images/groupSessions.jpg",
        type: "Videos",
        requiredPlan: 5,
        locked: true
    },
    {
        id: 6,
        title: "Troubleshooting Templates",
        category: "Annual Subscription",
        description: "Ready-to-use templates for common technical issues",
        thumbnail: "../images/annualSubscrioption2.png",
        type: "Templates",
        requiredPlan: 2,
        locked: true
    }
];

// User current plan IDs (would come from backend)
let userResourceIds = [1, 2]; // User has Free and Annual Subscription

function renderResources() {
    const container = document.getElementById('resourceGrid');
    container.innerHTML = '';
    
    allResources.forEach(resource => {
        const isLocked = !userResourceIds.includes(resource.requiredPlan);
        
        const card = document.createElement('div');
        card.className = `resource-card ${isLocked ? 'locked' : ''}`;
        card.innerHTML = `
            <div class="resource-thumbnail">
                <img src="${resource.thumbnail}" alt="${resource.title}">
                ${isLocked ? '<div class="resource-lock-indicator"><i class="fas fa-lock"></i></div>' : ''}
            </div>
            
            <div class="resource-content">
                <span class="resource-category">${resource.category}</span>
                <h3>${resource.title}</h3>
                <p>${resource.description}</p>
                
                <ul class="resource-features">
                    ${resource.features.map(feature => `<li>${feature}</li>`).join('')}
                </ul>
                
                <div class="resource-meta">
                    <span><i class="fas fa-file-alt"></i> ${resource.type}</span>
                    <span><i class="fas fa-ruler"></i> ${resource.length}</span>
                </div>
            </div>
            
            ${isLocked ? `<button class="upgrade-button" onclick="showUpgradeOptions(${resource.requiredPlan})">
                <i class="fas fa-unlock-alt"></i> Register
            </button>` : ''}
        `;
        container.appendChild(card);
    });
}

function getPlanName(planId) {
    const plans = {
        1: 'Free Plan',
        2: 'Annual Subscription',
        3: 'Personal Guide',
        4: 'Formal Training',
        5: 'Group Sessions'
    };
    return plans[planId] || 'Premium Plan';
}

function showUpgradeOptions(planId) {
    // Show modal upgrade options
    alert(`Please register to ${getPlanName(planId)} to access this resource. Redirecting to subscriptions...`);
    // Redirect to subscriptions or show a modal
}

// Initialize resources when page loads
document.addEventListener('DOMContentLoaded', function() {
    renderResources();
    
    // Search functionality
    document.querySelector('.resources_content .search-bar input').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        filterResources(searchTerm);
    });
});

function filterResources(searchTerm) {
    const resourceCards = document.querySelectorAll('.resource-card');
    let hasResults = false;
    
    resourceCards.forEach(card => {
        const title = card.querySelector('h3').textContent.toLowerCase();
        const description = card.querySelector('.resource-content p').textContent.toLowerCase();
        const category = card.querySelector('.resource-category').textContent.toLowerCase();
        
        const matches = searchTerm.length === 0 || 
                    title.includes(searchTerm) || 
                    description.includes(searchTerm) || 
                    category.includes(searchTerm);
        
        card.style.display = matches ? 'block' : 'none';
        if (matches) hasResults = true;
    });
    
    showNoResultsMessage(hasResults, searchTerm);
}

function showNoResultsMessage(hasResults, searchTerm) {
    const container = document.getElementById('resourceGrid');
    const existingMessage = container.querySelector('.no-results');
    
    if (existingMessage) {
        existingMessage.remove();
    }
    
    if (!hasResults && searchTerm.length > 0) {
        container.insertAdjacentHTML('beforeend', `
            <div class="no-results" style="grid-column: 1 / -1; text-align: center; padding: 40px;">
                <i class="fas fa-search" style="font-size: 2em; color: #b2bec3; margin-bottom: 15px;"></i>
                <h3 style="color: #636e72; margin-bottom: 10px;">No resources found</h3>
                <p style="color: #636e72;">Try different search terms</p>
            </div>
        `);
    }
}
