// Handle subscription modals
document.addEventListener('DOMContentLoaded', function() {
    // Handle subscription triggers
    document.querySelectorAll('.subscription-trigger').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const planId = this.getAttribute('data-plan-id');
            const modal = document.getElementById(`subscription-modal-${planId}`);
            if (modal) {
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        });
    });
    
    // Close modals
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });
        
        const closeBtn = modal.querySelector('.close-modal');
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            });
        }
    });

    // Handle registration triggers for Group Sessions (types 4 & 5)
    document.querySelectorAll('.registration-trigger[data-type-id="4"]').forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            const modal = document.getElementById('session-registration-modal-4');
            if (modal) {
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        });
    });

    document.querySelectorAll('.registration-trigger[data-type-id="5"]').forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            const modal = document.getElementById('session-registration-modal-5');
            if (modal) {
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        });
    });
});

// This function can be used to show success/error messages
function showPopUp(title, message, type = 'success') {
    let existingPopup = document.querySelector('.popup');
    if (existingPopup) existingPopup.remove();

    const popup = document.createElement('div');
    popup.className = `popup ${type}`;
    popup.innerHTML = `
        <h3>${title}</h3>
        <p>${message}</p>
    `;

    popup.style.position = 'fixed';
    popup.style.top = '20px';
    popup.style.right = '20px';
    popup.style.padding = '20px';
    popup.style.backgroundColor = type === 'error' ? '#ffebee' : '#e8f5e9';
    popup.style.border = type === 'error' ? '1px solid #ef9a9a' : '1px solid #a5d6a7';
    popup.style.borderRadius = '5px';
    popup.style.zIndex = '1000';
    popup.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';

    document.body.appendChild(popup);

    setTimeout(() => popup.remove(), 10000);
}// Handle subscription modals
document.addEventListener('DOMContentLoaded', function() {
    // Handle subscription triggers
    document.querySelectorAll('.subscription-trigger').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const planId = this.getAttribute('data-plan-id');
            const modal = document.getElementById(`subscription-modal-${planId}`);
            if (modal) {
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        });
    });
    
    // Close modals
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });
        
        const closeBtn = modal.querySelector('.close-modal');
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            });
        }
    });

    // Handle registration triggers for Group Sessions (types 4 & 5)
    document.querySelectorAll('.registration-trigger[data-type-id="4"]').forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            const modal = document.getElementById('session-registration-modal-4');
            if (modal) {
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        });
    });

    document.querySelectorAll('.registration-trigger[data-type-id="5"]').forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            const modal = document.getElementById('session-registration-modal-5');
            if (modal) {
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        });
    });
});

// This function can be used to show success/error messages
function showPopUp(title, message, type = 'success') {
    let existingPopup = document.querySelector('.popup');
    if (existingPopup) existingPopup.remove();

    const popup = document.createElement('div');
    popup.className = `popup ${type}`;
    popup.innerHTML = `
        <h3>${title}</h3>
        <p>${message}</p>
    `;

    popup.style.position = 'fixed';
    popup.style.top = '20px';
    popup.style.right = '20px';
    popup.style.padding = '20px';
    popup.style.backgroundColor = type === 'error' ? '#ffebee' : '#e8f5e9';
    popup.style.border = type === 'error' ? '1px solid #ef9a9a' : '1px solid #a5d6a7';
    popup.style.borderRadius = '5px';
    popup.style.zIndex = '1000';
    popup.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';

    document.body.appendChild(popup);

    setTimeout(() => popup.remove(), 10000);
}


// Handle Personal Guide form submission
document.getElementById('personalGuideForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    fetch(this.action, {
        method: 'POST',
        body: new FormData(this),
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('modal-guide-form').style.display = 'none';
            document.getElementById('success-modal').style.display = 'flex';
            this.reset();
        }
    })
    .catch(error => console.error('Error:', error));
});

// Handle Task Assistance form submission
document.getElementById('taskAssistanceForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    fetch(this.action, {
        method: 'POST',
        body: new FormData(this),
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('modal-task-form').style.display = 'none';
            document.getElementById('success-modal').style.display = 'flex';
            this.reset();
        }
    })
    .catch(error => console.error('Error:', error));
});