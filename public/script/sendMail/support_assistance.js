document.addEventListener('DOMContentLoaded', function() {
    const requestType = document.getElementById('requestType');
    const problemFields = document.getElementById('problemFields');
    const feedbackFields = document.getElementById('feedbackFields');

    if (requestType) {
        function toggleFields(type) {
            if (type === 'problem') {
                problemFields.style.display = 'block';
                feedbackFields.style.display = 'none';
                problemFields.querySelectorAll('[data-required]').forEach(el => el.setAttribute('required', 'true'));
                feedbackFields.querySelectorAll('[data-required]').forEach(el => el.removeAttribute('required'));
            } else {
                problemFields.style.display = 'none';
                feedbackFields.style.display = 'block';
                feedbackFields.querySelectorAll('[data-required]').forEach(el => el.setAttribute('required', 'true'));
                problemFields.querySelectorAll('[data-required]').forEach(el => el.removeAttribute('required'));
            }
        }

        requestType.addEventListener('change', function () {
            toggleFields(this.value);
        });
        toggleFields(requestType.value);
    }

    const fileInput = document.getElementById('fileUpload');
    const fileList = document.getElementById('fileList');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            fileList.innerHTML = '';
            Array.from(this.files).forEach(file => {
                const item = document.createElement('div');
                item.className = 'file-item';
                item.textContent = `${file.name} (${(file.size/1024).toFixed(2)} KB)`;
                fileList.appendChild(item);
            });
        });
    }

    const form = document.getElementById('supportForm');
    if (form) {
        const submitBtn = form.querySelector('button[type="submit"]');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            submitBtn.disabled = true;
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = 'Processing ';

            const spinner = document.createElement('span');
            spinner.style.display = 'inline-block';
            spinner.style.width = '14px';
            spinner.style.height = '14px';
            spinner.style.border = '2px solid #f3f3f3';
            spinner.style.borderTop = '2px solid #3498db';
            spinner.style.borderRadius = '50%';
            spinner.style.marginLeft = '8px';
            
            if (!document.querySelector('style[data-spinner]')) {
                const styleSheet = document.createElement("style");
                styleSheet.type = "text/css";
                styleSheet.setAttribute('data-spinner', 'true');
                styleSheet.innerText = `
                    @keyframes spin {
                        0% { transform: rotate(0deg); }
                        100% { transform: rotate(360deg); }
                    }
                    .button-spinner {
                        animation: spin 0.8s linear infinite;
                    }
                `;
                document.head.appendChild(styleSheet);
            }

            // Apply the spinner class
            spinner.classList.add('button-spinner');
            submitBtn.appendChild(spinner);

            const formData = new FormData(form);
            const type = requestType ? requestType.value : 'problem';

            fetch(`/submit-support/${type}`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                submitBtn.disabled = false;
                spinner.remove();
                submitBtn.innerHTML = originalText;

                if (data.success) {
                    Swal.fire('Success', data.message, 'success');
                    form.reset();
                    fileList.innerHTML = '';
                    if (requestType) {
                        requestType.value = 'problem';
                        toggleFields('problem');
                    }
                    submitBtn.innerHTML = 'Submit Request';
                } else {
                    Swal.fire('Error', data.message || 'Something went wrong', 'error');
                }
            })
            .catch(err => {
                submitBtn.disabled = false;
                spinner.remove();
                submitBtn.innerHTML = originalText;
                Swal.fire('Error', 'Network error. Please try again.', 'error');
                submitBtn.innerHTML = 'Try Again ';
            });
        });
    }

    function submitForm(formId, type) {
        const form = document.getElementById(formId);
        if (!form) return;

        const submitBtn = form.querySelector('button[type="submit"]');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            submitBtn.disabled = true;
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = 'Processing';

            const spinner = document.createElement('span');
            spinner.classList.add('button-spinner');
            submitBtn.appendChild(spinner);

            if (!document.querySelector('style[data-spinner]')) {
                const styleSheet = document.createElement("style");
                styleSheet.type = "text/css";
                styleSheet.setAttribute('data-spinner', 'true');
                styleSheet.innerText = `
                    @keyframes spin {
                        0% { transform: rotate(0deg); }
                        100% { transform: rotate(360deg); }
                    }
                    .button-spinner {
                        animation: spin 0.8s linear infinite;
                    }
                `;
                document.head.appendChild(styleSheet);
            }

            const formData = new FormData(form);

            if (formId === 'taskAssistanceForm') {
                const taskType = form.querySelector('input[name="taskType"]:checked');
                if (taskType) {
                    if (taskType.value === 'other') {
                        const otherInput = document.getElementById('otherTaskTypeInput-task');
                        formData.set('taskType', otherInput.value || 'other');
                    } else {
                        formData.set('taskType', taskType.value);
                    }
                }
            }

            const endpoint = (formId === 'supportForm') ? 'submit-support' : 'submit';

            fetch(`/${endpoint}/${type}`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                submitBtn.disabled = false;
                spinner.remove();
                submitBtn.innerHTML = originalText;

                if (data.success) {
                    Swal.fire('Success', data.message, 'success');
                    form.reset();
                    const fileLists = form.querySelectorAll('.file-list');
                    fileLists.forEach(list => list.innerHTML = '');
                    submitBtn.innerHTML = 'Submit Request';
                } else {
                    Swal.fire('Error', data.message || 'Something went wrong', 'error');
                }
            })
            .catch(err => {
                submitBtn.disabled = false;
                spinner.remove();
                submitBtn.innerHTML = 'Try Again';
                Swal.fire('Error', 'Network error. Please try again.', 'error');
                submitBtn.innerHTML = 'Try Again ';
            });
        });
    }

    function setupFileUpload(formId, fileInputId, fileListId) {
        const fileInput = document.getElementById(fileInputId);
        const fileList = document.getElementById(fileListId);

        if (fileInput) {
            fileInput.addEventListener('change', function() {
                fileList.innerHTML = '';
                Array.from(this.files).forEach(file => {
                    const fileItem = document.createElement('div');
                    fileItem.className = 'file-item';
                    fileItem.innerHTML = `
                        <span>${file.name}</span>
                        <span>(${(file.size / 1024).toFixed(2)} KB)</span>
                    `;
                    fileList.appendChild(fileItem);
                });
            });
        }
    }

    setupFileUpload('taskAssistanceForm', 'fileUpload-task', 'fileList-task');
    setupFileUpload('personalGuideForm', 'fileUpload-guide', 'fileList-guide');
    setupFileUpload('supportForm', 'fileUpload', 'fileList');

    submitForm('taskAssistanceForm', 'task');
    submitForm('personalGuideForm', 'guide');
    submitForm('supportForm', 'support');
});
