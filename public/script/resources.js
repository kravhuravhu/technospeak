let allResources = [];
let userSubscriptionType = null;
let isFreeUser = false;

function fetchUserDataAndRenderResources() {
    const container = document.getElementById('resourceGrid');
    const loader = document.getElementById('loader');
    const freeUserMessage = document.getElementById('freeUserMessage');

    loader.style.display = 'block';
    container.innerHTML = '';

    // user subscription info
    fetch('/api/user/data')
        .then(res => res.json())
        .then(userData => {
            userSubscriptionType = userData.subscription_type;
            
            isFreeUser = !userSubscriptionType || ['free', 'Free', null].includes(userSubscriptionType);

            freeUserMessage.style.display = isFreeUser ? 'block' : 'none';

            return fetch('/api/resources/all');
        })
        .then(res => res.json())
        .then(resources => {
            allResources = resources;
            renderAllResources();
            loader.style.display = 'none';
        })
        .catch(error => {
            console.error('Error fetching resources:', error);
            loader.style.display = 'none';
            freeUserMessage.style.display = 'block';
        });
}

// all resources
function renderAllResources() {
    const container = document.getElementById('resourceGrid');
    container.innerHTML = '';

    if (!allResources || allResources.length === 0) {
        container.innerHTML = `
            <div style="text-align:center; padding:40px; grid-column: 1 / -1;">
                <i class="fas fa-paperclip" style="max-width:150px; opacity:0.6;font-size:3em;"></i>
                <h3 style="color:#666; margin-top:20px;">No Resources Found</h3>
                <p style="color:#999;">There are currently no resources available.</p>
            </div>
        `;
        return;
    }

    allResources.forEach(resource => {
        const isLocked = isFreeUser;

        const card = document.createElement('div');
        card.className = 'resource-card';
        if (isLocked) card.classList.add('locked');

        card.innerHTML = `
            <div class="resource-thumbnail">
                <img src="${resource.thumbnail_url}" alt="${resource.title}">
                ${isLocked ? '<div class="resource-lock-indicator"><i class="fas fa-lock"></i></div>' : ''}
            </div>

            <div class="resource-content">
                <span class="resource-category">${resource.category?.name || 'Course Resource'}</span>
                <h3>${resource.title}</h3>
                <p>${resource.description}</p>
                <div class="resource-meta">
                    <span><i class="fas fa-file-alt"></i> ${resource.file_type.toUpperCase()}</span>
                </div>
                ${isLocked ? 
                    `<button class="upgrade-button" onclick="showUpgradeModal()">
                        <i class="fas fa-lock"></i> Upgrade to Access
                    </button>` : 
                    `<button class="view-button" onclick="window.open('${resource.file_url}', '_blank')">View →</button>`
                }
            </div>
        `;

        container.appendChild(card);
    });
}

// upgrade modal
function showUpgradeModal() {
    document.getElementById('upgradeModal').style.display = 'flex';
}

// upgrade modal
function closeUpgradeModal() {
    document.getElementById('upgradeModal').style.display = 'none';
}

// clicking outside modal
window.addEventListener('click', function(event) {
    const modal = document.getElementById('upgradeModal');
    if (event.target === modal) {
        closeUpgradeModal();
    }
});


// Search
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

    if (existingMessage) existingMessage.remove();

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

document.addEventListener('DOMContentLoaded', fetchUserDataAndRenderResources);