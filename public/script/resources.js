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

// User current plan IDs
let userResourceIds = [1, 2];

function fetchAndRenderUserResources() {
    const container = document.getElementById('resourceGrid');
    const loader = document.getElementById('loader');

    loader.style.display = 'block';
    container.innerHTML = '';

    fetch('/api/user/resources')
        .then(res => res.json())
        .then(resources => {
            loader.style.display = 'none';

            if (resources.length === 0) {
                container.innerHTML = `
                    <div style="text-align:center; padding:40px;">
                        <i class="fas fa-paperclip" style="max-width:150px; opacity:0.6;font-size:3em;"></i>
                        <h3 style="color:#666; margin-top:20px;">No Resources Found</h3>
                        <p style="color:#999;">You're either not enrolled in any courses or your courses don't have resources yet.</p>
                        <a href="/dashboard#usr_alltrainings" style="display:inline-block; margin-top:20px; padding:10px 20px; background:#38b6ff; color:#fff; border-radius:25px; text-decoration:none;">Explore Courses</a>
                    </div>
                `;
                return;
            }

            resources.forEach(resource => {
                const card = document.createElement('div');
                card.className = 'resource-card';

                card.innerHTML = `
                    <div class="resource-thumbnail">
                        <img src="${resource.thumbnail}" alt="${resource.title}">
                    </div>

                    <div class="resource-content">
                        <span class="resource-category">${resource.category}</span>
                        <h3>${resource.title}</h3>
                        <p>${resource.description}</p>
                        <div class="resource-meta">
                            <span><i class="fas fa-file-alt"></i> ${resource.type.toUpperCase()}</span>
                        </div>
                        <button class="view-button" style="margin: 10px 0;background-color: #38b6ff;border: none;padding: 13px 20px;font-size:1em;border-radius: 50px;color: #ffffff;cursor:pointer;" onclick="window.open('${resource.url}', '_blank')">View →</button>
                    </div>
                `;

                container.appendChild(card);
            });
        })
        .catch(error => {
            loader.style.display = 'none';
            console.error('Failed to fetch resources:', error);
            container.innerHTML = '<p>Failed to load resources.</p>';
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
    openModal({
        title: "Upgrade Required",
        body: `
            <p>You need to register for the ${getPlanName(planId)} in order to access this resource.</p>
            <br>
        `,
        confirmText: "Upgrade Now",
        cancelText: "Cancel",
        onConfirm: function() {
            alert(`Redirecting to ${getPlanName(planId)} subscription page...`);
            window.location.href = `/subscribe/${planId}`;
        },
        onCancel: function() {
            console.log("Upgrade action cancelled.");
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    fetchAndRenderUserResources();
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
