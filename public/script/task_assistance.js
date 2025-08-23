document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('taskAssistanceForm');
    const fileUpload = document.getElementById('fileUpload');
    const fileList = document.getElementById('fileList');
    const otherTaskTypeRadio = document.getElementById('otherTaskType');
    const otherTaskTypeInput = document.getElementById('otherTaskTypeInput');
    
    fileUpload.addEventListener('change', function() {
        fileList.innerHTML = '';
        
        if (this.files.length > 0) {
            for (let i = 0; i < this.files.length; i++) {
                const file = this.files[i];
                const fileItem = document.createElement('div');
                fileItem.className = 'file-item';
                fileItem.innerHTML = `
                    <span class="file-name">${file.name}</span>
                    <span class="remove-file" data-index="${i}">&times;</span>
                `;
                fileList.appendChild(fileItem);
            }
        }
        
        const removeButtons = document.querySelectorAll('.remove-file');
        removeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const index = parseInt(this.getAttribute('data-index'));
                const dt = new DataTransfer();
                const files = fileUpload.files;
                
                for (let i = 0; i < files.length; i++) {
                    if (i !== index) {
                        dt.items.add(files[i]);
                    }
                }
                
                fileUpload.files = dt.files;
                this.parentElement.remove();
            });
        });
    });
    
    otherTaskTypeInput.disabled = true;
    
    document.querySelectorAll('input[name="taskType"]').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'other') {
                otherTaskTypeInput.disabled = false;
                otherTaskTypeInput.focus();
            } else {
                otherTaskTypeInput.disabled = true;
                otherTaskTypeInput.value = '';
            }
        });
    });
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const firstName = document.getElementById('firstName').value;
        const lastName = document.getElementById('lastName').value;
        const email = document.getElementById('email-task-assistance').value;
        const taskType = document.querySelector('input[name="taskType"]:checked');
        
        if (!firstName || !lastName || !email || !taskType) {
            alert('Please fill in all required fields');
            return;
        }
        
        alert('Task assistance request submitted successfully!');
        form.reset();
        fileList.innerHTML = '';
    });
});