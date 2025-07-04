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