function openModal({ 
    title = "Modal Title", 
    body = "", 
    confirmText = "Confirm", 
    cancelText = "Cancel", 
    onConfirm = null, 
    onCancel = null 
}) {

    document.getElementById('modal-title').innerText = title;
    document.getElementById('modal-body').innerHTML = body;
    document.getElementById('modal-confirm-btn').innerText = confirmText;
    document.getElementById('modal-cancel-btn').innerText = cancelText;

    document.getElementById('modal-confirm-btn').onclick = function() {
        if (onConfirm) onConfirm(); 
        closeModal();
    };

    document.getElementById('modal-cancel-btn').onclick = function() {
        if (onCancel) onCancel();
        closeModal(); 
    };

    // Show the modal
    document.getElementById('generic-modal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('generic-modal').style.display = 'none';
}

window.onclick = function(event) {
    if (event.target === document.getElementById('generic-modal')) {
        closeModal();
    }
}


// Coming Soon modal
function openModal({ 
    title = "Modal Title", 
    body = "", 
    confirmText = "Confirm", 
    cancelText = "Cancel", 
    onConfirm = null, 
    onCancel = null 
}) {

    document.getElementById('modal-title').innerText = title;
    document.getElementById('modal-body').innerHTML = body;
    document.getElementById('modal-confirm-btn').innerText = confirmText;
    document.getElementById('modal-cancel-btn').innerText = cancelText;

    document.getElementById('modal-confirm-btn').onclick = function() {
        if (onConfirm) onConfirm(); 
        closeModal();
    };

    document.getElementById('modal-cancel-btn').onclick = function() {
        if (onCancel) onCancel();
        closeModal(); 
    };

    // Show the modal
    document.getElementById('generic-modal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('generic-modal').style.display = 'none';
}

// Function to open the Coming Soon modal
function openComingSoonModal() {
    const modal = document.getElementById('coming-soon-modal');
    if (modal) {
        modal.style.display = 'flex';
    }
}

// Function to open the Group Session 1 modal
function openGroupSession1Modal() {
    const modal = document.getElementById('group-session1-modal');
    if (modal) {
        modal.style.display = 'flex';
    }
}

// Function to open the Group Session 2 modal
function openGroupSession2Modal() {
    const modal = document.getElementById('group-session2-modal');
    if (modal) {
        modal.style.display = 'flex';
    }
}

// Function to scroll to the Get In Touch section
function scrollToContact() {
    // Try to find by ID first
    const contactSection = document.getElementById('contact-section') || document.querySelector('.gtch');
    if (contactSection) {
        contactSection.scrollIntoView({ behavior: 'smooth' });
    }
}

// Set up event listeners when the page loads
document.addEventListener('DOMContentLoaded', function() {
    // Existing modal buttons
    const closeButton = document.getElementById('modal-close-btn');
    const contactButton = document.getElementById('modal-contact-btn');
    
    // Group Session 1 buttons
    const groupSession1CloseBtn = document.getElementById('group-session1-close-btn');
    const groupSession1ContactBtn = document.getElementById('group-session1-contact-btn');
    
    // Group Session 2 buttons
    const groupSession2CloseBtn = document.getElementById('group-session2-close-btn');
    const groupSession2ContactBtn = document.getElementById('group-session2-contact-btn');
    
    // Existing modal event listeners
    if (closeButton) {
        closeButton.addEventListener('click', function() {
            const modal = document.getElementById('coming-soon-modal');
            if (modal) {
                modal.style.display = 'none';
            }
        });
    }
    
    if (contactButton) {
        contactButton.addEventListener('click', function() {
            // Close the modal and scroll to contact section
            const modal = document.getElementById('coming-soon-modal');
            if (modal) {
                modal.style.display = 'none';
            }
            scrollToContact();
        });
    }
    
    // Group Session 1 event listeners
    if (groupSession1CloseBtn) {
        groupSession1CloseBtn.addEventListener('click', function() {
            const modal = document.getElementById('group-session1-modal');
            if (modal) {
                modal.style.display = 'none';
            }
        });
    }
    
    if (groupSession1ContactBtn) {
        groupSession1ContactBtn.addEventListener('click', function() {
            // Close the modal and scroll to contact section
            const modal = document.getElementById('group-session1-modal');
            if (modal) {
                modal.style.display = 'none';
            }
            scrollToContact();
        });
    }
    
    // Group Session 2 event listeners
    if (groupSession2CloseBtn) {
        groupSession2CloseBtn.addEventListener('click', function() {
            const modal = document.getElementById('group-session2-modal');
            if (modal) {
                modal.style.display = 'none';
            }
        });
    }
    
    if (groupSession2ContactBtn) {
        groupSession2ContactBtn.addEventListener('click', function() {
            // Close the modal and scroll to contact section
            const modal = document.getElementById('group-session2-modal');
            if (modal) {
                modal.style.display = 'none';
            }
            scrollToContact();
        });
    }
    
    // Close modal when clicking outside the modal content
    window.addEventListener('click', function(event) {
        const modal1 = document.getElementById('coming-soon-modal');
        const modal2 = document.getElementById('group-session1-modal');
        const modal3 = document.getElementById('group-session2-modal');
        
        if (event.target === modal1) {
            modal1.style.display = 'none';
        }
        if (event.target === modal2) {
            modal2.style.display = 'none';
        }
        if (event.target === modal3) {
            modal3.style.display = 'none';
        }
    });
});

window.onclick = function(event) {
    if (event.target === document.getElementById('generic-modal')) {
        closeModal();
    }
}