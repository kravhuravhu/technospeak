<div class="content-section assistance_content" id="usr_taskAssistance">
    <div class="assistance">
        <div class="container">
            <div class="section-header">
                <div class="title">
                    <h1>Task Assistance Request</h1>
                    <p class="subtitle">Please fill out this form so we can better understand your needs and provide the right assistance.</p>
                </div>
            </div>
            <form id="taskAssistanceForm" class="task-assistance-form responsive-form">
                <div class="form-section">
                    <h2 class="form-section-title">PERSONAL INFO</h2>
                    <div class="form-row responsive-row">
                        <div class="form-group full-width-mobile">
                            <label for="firstName-task">First Name:</label>
                            <input type="text" id="firstName-task" name="firstName" required
                                   value="{{ old('firstName', Auth::check() ? Auth::user()->name : '') }}">
                        </div>
                        <div class="form-group full-width-mobile">
                            <label for="lastName-task">Last Name:</label>
                            <input type="text" id="lastName-task" name="lastName" required
                                   value="{{ old('lastName', Auth::check() ? (Auth::user()->surname ?? '') : '') }}">
                        </div>
                    </div>
                    <div class="form-group full-width">
                        <label for="email-task">Email Address:</label>
                        <input type="email" id="email-task" name="email" required
                               value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}">
                    </div>
                    <div class="error-message" id="email-error-task" style="color: red; display: none; font-size: 12px; margin-top: 5px;"></div>
                </div>
                <div class="form-section">
                    <h2 class="form-section-title">TASK OBJECTIVE</h2>
                    <div class="form-group full-width">
                        <div class="form-group fm-g-rw">
                            <label>Type of Task:</label>
                            <div class="checkbox-group responsive-checkbox-group task-type-group">
                                <label class="checkbox-container responsive-checkbox task-type-option">
                                    <input type="radio" name="taskType" value="administrative">
                                    <span class="checkmark"></span>
                                    Administrative (e.g. emails, scheduling, data-entry)
                                </label>
                                <label class="checkbox-container responsive-checkbox task-type-option">
                                    <input type="radio" name="taskType" value="research">
                                    <span class="checkmark"></span>
                                    Research (e.g. internet research, data gathering, analysis, etc)
                                </label>
                                <label class="checkbox-container responsive-checkbox task-type-option">
                                    <input type="radio" name="taskType" value="writing">
                                    <span class="checkmark"></span>
                                    Writing (e.g. copywriting, reports, articles, etc)
                                </label>
                                <label class="checkbox-container responsive-checkbox task-type-option">
                                    <input type="radio" name="taskType" value="technical">
                                    <span class="checkmark"></span>
                                    Technical Assistance (e.g. IT Support, software help, etc.)
                                </label>
                                <label class="checkbox-container responsive-checkbox task-type-option other-option full-width-other">
                                    <div class="other-option-content">
                                        <input type="radio" name="taskType" value="other" id="otherTaskType-task">
                                        <span class="checkmark"></span>
                                        Other
                                    </div>
                                    <input type="text" id="otherTaskTypeInput-task" class="other-input responsive-other-input" placeholder="Specify other task type">
                                </label>
                            </div>
                            <div class="error-message" id="taskType-error-task" style="color: red; display: none; font-size: 12px; margin-top: 5px;"></div>
                        </div>
                    </div>
                    <div class="form-group full-width">
                        <div class="form-group fm-g-rw">
                            <label for="goal-task">What's the main goal or outcome you want to achieve?</label>
                            <textarea id="goal-task" name="goal" rows="3" class="responsive-textarea"></textarea>
                            <div class="error-message" id="goal-error-task" style="color: red; display: none; font-size: 12px; margin-top: 5px;"></div>
                        </div>
                    </div>
                    <div class="form-group full-width">
                        <div class="form-group fm-g-rw">
                            <label for="taskDescription-task">Task Description:</label>
                            <textarea id="taskDescription-task" name="taskDescription" rows="3" class="responsive-textarea" placeholder="---"></textarea>
                            <div class="error-message" id="taskDescription-error-task" style="color: red; display: none; font-size: 12px; margin-top: 5px;"></div>
                        </div>
                    </div>
                </div>
                <div class="form-section">
                    <h2 class="form-section-title">MORE DETAILS <i>(ATTACHMENTS OPTIONAL)</i></h2>
                    <div class="form-group full-width">
                        <div class="form-group fm-g-rw">
                            <label for="additionalInfo-task">Any other specifics you'd like to add:</label>
                            <textarea id="additionalInfo-task" name="additionalInfo" rows="3" class="responsive-textarea"></textarea>
                        </div>
                    </div>
                    <div class="form-group full-width">
                        <div class="form-group fm-g-rw">
                            <label for="fileUpload-task" class="file-upload-label responsive-file-upload">
                                <i class="fas fa-paperclip"></i> Attach Files
                            </label>
                            <input type="file" id="fileUpload-task" name="fileUpload" multiple style="display: none;">
                            <div id="fileList-task" class="file-list responsive-file-list"></div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="submit-btn responsive-submit-btn" id="submit-btn-task">Submit Request</button>
            </form>
        </div>
    </div>
</div>

<style>
/* Responsive Styles for Task Assistance Form */
.task-assistance-form.responsive-form {
    width: 100%;
    max-width: 100%;
    margin: 0 auto;
    padding: 0 15px;
}

.task-type-group {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.task-type-option {
    flex: 1 1 calc(50% - 1rem);
    min-width: 250px;
}

.full-width-other {
    flex: 1 1 100%;
}

.other-option-content {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
}

.responsive-other-input {
    width: 100%;
    margin-top: 0.5rem;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 0.375rem;
    font-size: 0.9rem;
}

/* Mobile First Approach for Task Assistance Form */
@media (max-width: 768px) {
    .task-assistance-form.responsive-form {
        padding: 0 10px;
    }
    
    .task-type-group {
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .task-type-option {
        flex: 1 1 100%;
        min-width: auto;
    }
    
    .full-width-other {
        flex: 1 1 100%;
    }
    
    .other-option-content {
        margin-bottom: 0.75rem;
    }
    
    .responsive-other-input {
        margin-top: 0.75rem;
        padding: 1rem;
    }
    
    .form-row {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .responsive-row {
        flex-direction: column;
    }
    
    .full-width-mobile {
        flex: 1 1 100%;
    }
    
    .responsive-textarea {
        min-height: 120px;
    }
    
    .responsive-file-upload {
        padding: 1rem;
        font-size: 0.9rem;
    }
    
    .responsive-submit-btn {
        padding: 1.25rem 2rem;
        font-size: 1.2rem;
    }
}

@media (max-width: 480px) {
    .task-assistance-form.responsive-form {
        padding: 0 5px;
    }
    
    .task-type-option {
        font-size: 0.9rem;
        padding: 0.75rem;
    }
    
    .responsive-other-input {
        font-size: 14px;
        padding: 0.75rem;
    }
    
    .responsive-textarea {
        min-height: 100px;
        font-size: 14px;
    }
    
    input[type="text"],
    input[type="email"] {
        font-size: 14px;
        padding: 0.75rem;
    }
}

/* Tablet Styles for Task Assistance Form */
@media (min-width: 769px) and (max-width: 1024px) {
    .task-assistance-form.responsive-form {
        max-width: 90%;
    }
    
    .task-type-option {
        flex: 1 1 calc(50% - 1rem);
    }
}

/* Large Desktop Styles for Task Assistance Form */
@media (min-width: 1025px) {
    .task-assistance-form.responsive-form {
        max-width: 800px;
    }
    
    .task-type-option {
        flex: 1 1 calc(50% - 1rem);
    }
}

/* Ensure consistent styling across both forms */
.responsive-form .form-section {
    margin-bottom: 2rem;
    width: 100%;
}

.responsive-form .form-row {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1rem;
    width: 100%;
}

.responsive-form .form-group {
    flex: 1;
    min-width: 0;
    margin-bottom: 1rem;
}

.responsive-form .full-width {
    flex: 1 1 100%;
}

.responsive-form .checkbox-group {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.responsive-form .responsive-checkbox-group {
    flex-direction: row;
    justify-content: flex-start;
}

.responsive-form .responsive-checkbox {
    flex: 1 1 calc(25% - 1rem);
    min-width: 120px;
}

.responsive-form .responsive-textarea {
    width: 100%;
    min-height: 100px;
    resize: vertical;
}

.responsive-form .responsive-file-upload {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    background: #f8f9fa;
    border: 2px dashed #dee2e6;
    border-radius: 0.375rem;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
    justify-content: center;
}

.responsive-form .responsive-file-list {
    margin-top: 0.5rem;
    font-size: 0.875rem;
}

.responsive-form .responsive-submit-btn {
    width: 100%;
    padding: 1rem 2rem;
    font-size: 1.1rem;
    margin-top: 1.5rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('taskAssistanceForm');
    // Check if form exists on this page
    if (!form) return;

    const taskType = document.querySelectorAll('input[name="taskType"]');
    const otherTaskTypeInput = document.getElementById('otherTaskTypeInput-task');
    const goal = document.getElementById('goal-task');
    const taskDescription = document.getElementById('taskDescription-task');
    const submitBtn = document.getElementById('submit-btn-task');

    // Check if all required elements exist
    if (!goal || !taskDescription || !submitBtn) return;

    // Track validation state - ONLY for fields that need validation
    let isTaskTypeValid = false;
    let isGoalValid = false;
    let isTaskDescriptionValid = false;

    // Validation functions for required fields only
    function validateTaskType() {
        const isChecked = Array.from(taskType).some(radio => radio.checked);
        const errorElement = document.getElementById('taskType-error-task');
        
        // Check if "Other" is selected but no value provided
        const otherRadio = document.getElementById('otherTaskType-task');
        const otherInputValue = otherTaskTypeInput ? otherTaskTypeInput.value.trim() : '';
        
        if (otherRadio && otherRadio.checked && !otherInputValue) {
            if (errorElement) {
                errorElement.textContent = 'Please specify the other task type';
                errorElement.style.display = 'block';
            }
            isTaskTypeValid = false;
            return false;
        }
        
        if (!isChecked) {
            if (errorElement) {
                errorElement.textContent = 'Please select a task type';
                errorElement.style.display = 'block';
            }
            isTaskTypeValid = false;
            return false;
        } else {
            if (errorElement) {
                errorElement.style.display = 'none';
            }
            isTaskTypeValid = true;
            return true;
        }
    }

    function validateGoal() {
        const value = goal.value.trim();
        const errorElement = document.getElementById('goal-error-task');
        
        if (!value) {
            if (errorElement) {
                errorElement.textContent = 'Please describe your main goal';
                errorElement.style.display = 'block';
            }
            isGoalValid = false;
            return false;
        } else if (value.length < 10) {
            if (errorElement) {
                errorElement.textContent = 'Please provide a more detailed goal (at least 10 characters)';
                errorElement.style.display = 'block';
            }
            isGoalValid = false;
            return false;
        } else {
            if (errorElement) {
                errorElement.style.display = 'none';
            }
            isGoalValid = true;
            return true;
        }
    }

    function validateTaskDescription() {
        const value = taskDescription.value.trim();
        const errorElement = document.getElementById('taskDescription-error-task');
        
        if (!value) {
            if (errorElement) {
                errorElement.textContent = 'Please provide a task description';
                errorElement.style.display = 'block';
            }
            isTaskDescriptionValid = false;
            return false;
        } else if (value.length < 15) {
            if (errorElement) {
                errorElement.textContent = 'Please provide a more detailed task description (at least 15 characters)';
                errorElement.style.display = 'block';
            }
            isTaskDescriptionValid = false;
            return false;
        } else {
            if (errorElement) {
                errorElement.style.display = 'none';
            }
            isTaskDescriptionValid = true;
            return true;
        }
    }

    function updateSubmitButton() {
        // Add null check for submitBtn
        if (!submitBtn) return;
        
        if (isTaskTypeValid && isGoalValid && isTaskDescriptionValid && isEmailValid) {
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
            submitBtn.style.cursor = 'pointer';
        } else {
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.6';
            submitBtn.style.cursor = 'not-allowed';
        }
    }

    // Real-time validation with null checks - ONLY for fields that need validation
    if (taskType.length > 0) {
        taskType.forEach(radio => {
            radio.addEventListener('change', function() {
                validateTaskType();
                updateSubmitButton();
            });
        });
    }
    
    if (otherTaskTypeInput) {
        otherTaskTypeInput.addEventListener('input', function() {
            validateTaskType();
            updateSubmitButton();
        });
        otherTaskTypeInput.addEventListener('blur', function() {
            validateTaskType();
            updateSubmitButton();
        });
    }
    
    if (goal) {
        goal.addEventListener('input', function() {
            validateGoal();
            updateSubmitButton();
        });
        goal.addEventListener('blur', function() {
            validateGoal();
            updateSubmitButton();
        });
    }
    
    if (taskDescription) {
        taskDescription.addEventListener('input', function() {
            validateTaskDescription();
            updateSubmitButton();
        });
        taskDescription.addEventListener('blur', function() {
            validateTaskDescription();
            updateSubmitButton();
        });
    }

    const email = document.getElementById('email-task');
    let isEmailValid = false;

    function validateEmail() {
        const value = email.value.trim();
        const errorElement = document.getElementById('email-error-task');

        // Simple email regex
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!value) {
            if (errorElement) {
                errorElement.textContent = 'Please enter your email address';
                errorElement.style.display = 'block';
            }
            isEmailValid = false;
            return false;
        } else if (!emailRegex.test(value)) {
            if (errorElement) {
                errorElement.textContent = 'Please enter a valid email address';
                errorElement.style.display = 'block';
            }
            isEmailValid = false;
            return false;
        } else {
            if (errorElement) {
                errorElement.style.display = 'none';
            }
            isEmailValid = true;
            return true;
        }
    }

    // Real-time validation
    if (email) {
        email.addEventListener('input', () => {
            validateEmail();
            updateSubmitButton();
        });
        email.addEventListener('blur', () => {
            validateEmail();
            updateSubmitButton();
        });
    }

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const validations = [
            validateTaskType(),
            validateGoal(),
            validateTaskDescription()
        ];
        
        if (validations.every(valid => valid)) {
            // Form is valid, you can submit it here
            // alert('Form submitted successfully!');
            // form.submit(); // Uncomment this to actually submit the form
        } else {
            const firstError = document.querySelector('.error-message[style*="display: block"]');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            alert('Please fix all validation errors before submitting.');
        }
    });

    // Initialize only if submit button exists
    if (submitBtn) {
        // Initialize validation and button state
        validateTaskType();
        validateGoal();
        validateTaskDescription();
        updateSubmitButton();
    }
});
</script>