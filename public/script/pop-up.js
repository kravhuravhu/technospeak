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

// Contact section form submission
document.getElementById('styledSubmitBtn').addEventListener('click', function(e) {
    e.preventDefault();
    
    // Get values from styled inputs
    const email = document.getElementById('styledEmail').value;
    const question = document.getElementById('styledQuestion').value;
    
    // Validate inputs
    if (!email || !question) {
        openModal({
            title: "Missing Information",
            body: "Please fill in both your email and question.",
            confirmText: "OK",
            onConfirm: function() {
                // Focus on the first empty field
                if (!email) {
                    document.getElementById('styledEmail').focus();
                } else {
                    document.getElementById('styledQuestion').focus();
                }
            }
        });
        return;
    }
    
    // Set values in hidden form
    document.getElementById('formEmail').value = email;
    document.getElementById('formQuestion').value = question;
    
    // Submit the form via AJAX to maintain page state
    fetch(document.getElementById('questionForm').action, {
        method: 'POST',
        body: new FormData(document.getElementById('questionForm')),
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            openModal({
                title: "Success!",
                body: "Your question has been submitted successfully.",
                confirmText: "Great!",
                onConfirm: function() {
                    // Clear the fields
                    document.getElementById('styledEmail').value = '';
                    document.getElementById('styledQuestion').value = '';
                }
            });
        } else {
            openModal({
                title: "Error",
                body: "There was an error submitting your question. Please try again.",
                confirmText: "OK"
            });
        }
    })
    .catch(error => {
        openModal({
            title: "Error",
            body: "There was a network error. Please check your connection and try again.",
            confirmText: "OK"
        });
    });
});