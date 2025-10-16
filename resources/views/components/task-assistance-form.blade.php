<div class="content-section assistance_content" id="usr_taskAssistance">
    <div class="assistance">
        <div class="container">
            <div class="section-header">
                <div class="title">
                    <h1>Task Assistance Request</h1>
                    <p class="subtitle">Please fill out this form so we can better understand your needs and provide the right assistance.</p>
                </div>
            </div>
            <form id="taskAssistanceForm" class="task-assistance-form">
                <div class="form-section">
                    <h2 class="form-section-title">PERSONAL INFO</h2>
                    <div class="form-row">
                        <div class="form-group half-width">
                            <label for="firstName-task">First Name:</label>
                            <input type="text" id="firstName-task" name="firstName" required
                                   value="{{ old('firstName', Auth::check() ? Auth::user()->name : '') }}">
                            <div class="error-message" id="firstName-error-task" style="color: red; display: none; font-size: 12px; margin-top: 5px;"></div>
                        </div>
                        <div class="form-group half-width">
                            <label for="lastName-task">Last Name:</label>
                            <input type="text" id="lastName-task" name="lastName" required
                                   value="{{ old('lastName', Auth::check() ? (Auth::user()->surname ?? '') : '') }}">
                            <div class="error-message" id="lastName-error-task" style="color: red; display: none; font-size: 12px; margin-top: 5px;"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email-task">Email Address:</label>
                        <input type="email" id="email-task" name="email" required
                               value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}">
                        <div class="error-message" id="email-error-task" style="color: red; display: none; font-size: 12px; margin-top: 5px;"></div>
                    </div>
                </div>
                <div class="form-section">
                    <h2 class="form-section-title">TASK OBJECTIVE</h2>
                    <div class="form-group fm-g-rw">
                        <label>Type of Task:</label>
                        <div class="checkbox-group">
                            <label class="checkbox-container">
                                <input type="radio" name="taskType" value="administrative">
                                <span class="checkmark"></span>
                                Administrative (e.g. emails, scheduling, data-entry)
                            </label>
                            <label class="checkbox-container">
                                <input type="radio" name="taskType" value="research">
                                <span class="checkmark"></span>
                                Research (e.g. internet research, data gathering, analysis, etc)
                            </label>
                            <label class="checkbox-container">
                                <input type="radio" name="taskType" value="writing">
                                <span class="checkmark"></span>
                                Writing (e.g. copywriting, reports, articles, etc)
                            </label>
                            <label class="checkbox-container">
                                <input type="radio" name="taskType" value="technical">
                                <span class="checkmark"></span>
                                Technical Assistance (e.g. IT Support, software help, etc.)
                            </label>
                            <label class="checkbox-container other-option">
                                <input type="radio" name="taskType" value="other" id="otherTaskType-task">
                                <span class="checkmark"></span>
                                Other
                                <input type="text" id="otherTaskTypeInput-task" class="other-input" placeholder="Specify other task type">
                            </label>
                        </div>
                        <div class="error-message" id="taskType-error-task" style="color: red; display: none; font-size: 12px; margin-top: 5px;"></div>
                    </div>
                    <div class="form-group fm-g-rw">
                        <label for="goal-task">What's the main goal or outcome you want to achieve?</label>
                        <textarea id="goal-task" name="goal" rows="1"></textarea>
                        <div class="error-message" id="goal-error-task" style="color: red; display: none; font-size: 12px; margin-top: 5px;"></div>
                    </div>
                    <div class="form-group fm-g-rw">
                        <label for="taskDescription-task">Task Description:</label>
                        <textarea id="taskDescription-task" name="taskDescription" rows="1" placeholder="---"></textarea>
                        <div class="error-message" id="taskDescription-error-task" style="color: red; display: none; font-size: 12px; margin-top: 5px;"></div>
                    </div>
                </div>
                <div class="form-section">
                    <h2 class="form-section-title">MORE DETAILS <i>(ATTACHMENTS OPTIONAL)</i></h2>
                    <div class="form-group fm-g-rw">
                        <label for="additionalInfo-task">Any other specifics you'd like to add:</label>
                        <textarea id="additionalInfo-task" name="additionalInfo" rows="1"></textarea>
                    </div>
                    <div class="form-group fm-g-rw">
                        <label for="fileUpload-task" class="file-upload-label">
                            <i class="fas fa-paperclip"></i> Attach Files
                        </label>
                        <input type="file" id="fileUpload-task" name="fileUpload" multiple style="display: none;">
                        <div id="fileList-task" class="file-list"></div>
                    </div>
                </div>
                <button type="submit" class="submit-btn" id="submit-btn-task">Submit Request</button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('taskAssistanceForm');
    const firstName = document.getElementById('firstName-task');
    const lastName = document.getElementById('lastName-task');
    const email = document.getElementById('email-task');
    const taskType = document.querySelectorAll('input[name="taskType"]');
    const otherTaskTypeInput = document.getElementById('otherTaskTypeInput-task');
    const goal = document.getElementById('goal-task');
    const taskDescription = document.getElementById('taskDescription-task');
    const submitBtn = document.getElementById('submit-btn-task');

    // Track validation state
    let isFirstNameValid = false;
    let isLastNameValid = false;
    let isEmailValid = false;
    let isTaskTypeValid = false;
    let isGoalValid = false;
    let isTaskDescriptionValid = false;

    // Validation functions (reusing similar functions from personal guide form)
    function validateFirstName() {
        const value = firstName.value.trim();
        const error = document.getElementById('firstName-error-task');
        
        error.style.display = 'none';
        firstName.style.borderColor = '';
        
        if (!value) {
            error.textContent = 'First name is required';
            error.style.display = 'block';
            firstName.style.borderColor = 'red';
            isFirstNameValid = false;
            updateSubmitButton();
            return false;
        }
        
        if (value.length < 2) {
            error.textContent = 'First name must be at least 2 characters';
            error.style.display = 'block';
            firstName.style.borderColor = 'red';
            isFirstNameValid = false;
            updateSubmitButton();
            return false;
        }
        
        if (!/^[a-zA-Z\s\-']+$/.test(value)) {
            error.textContent = 'First name can only contain letters, spaces, hyphens, and apostrophes';
            error.style.display = 'block';
            firstName.style.borderColor = 'red';
            isFirstNameValid = false;
            updateSubmitButton();
            return false;
        }
        
        firstName.style.borderColor = 'green';
        isFirstNameValid = true;
        updateSubmitButton();
        return true;
    }

    function validateLastName() {
        const value = lastName.value.trim();
        const error = document.getElementById('lastName-error-task');
        
        error.style.display = 'none';
        lastName.style.borderColor = '';
        
        if (!value) {
            error.textContent = 'Last name is required';
            error.style.display = 'block';
            lastName.style.borderColor = 'red';
            isLastNameValid = false;
            updateSubmitButton();
            return false;
        }
        
        if (value.length < 2) {
            error.textContent = 'Last name must be at least 2 characters';
            error.style.display = 'block';
            lastName.style.borderColor = 'red';
            isLastNameValid = false;
            updateSubmitButton();
            return false;
        }
        
        if (!/^[a-zA-Z\s\-']+$/.test(value)) {
            error.textContent = 'Last name can only contain letters, spaces, hyphens, and apostrophes';
            error.style.display = 'block';
            lastName.style.borderColor = 'red';
            isLastNameValid = false;
            updateSubmitButton();
            return false;
        }
        
        lastName.style.borderColor = 'green';
        isLastNameValid = true;
        updateSubmitButton();
        return true;
    }

    function validateEmail() {
        const value = email.value.trim();
        const error = document.getElementById('email-error-task');
        
        error.style.display = 'none';
        email.style.borderColor = '';
        
        if (!value) {
            error.textContent = 'Email address is required';
            error.style.display = 'block';
            email.style.borderColor = 'red';
            isEmailValid = false;
            updateSubmitButton();
            return false;
        }
        
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
        if (!emailRegex.test(value)) {
            error.textContent = 'Please enter a valid email address';
            error.style.display = 'block';
            email.style.borderColor = 'red';
            isEmailValid = false;
            updateSubmitButton();
            return false;
        }
        
        const domainPart = value.split('@')[1];
        if (!domainPart.includes('.')) {
            error.textContent = 'Please enter a valid email address';
            error.style.display = 'block';
            email.style.borderColor = 'red';
            isEmailValid = false;
            updateSubmitButton();
            return false;
        }
        
        const invalidDomains = ['test', 'example', 'localhost', 'invalid'];
        const domain = domainPart.toLowerCase();
        const hasInvalidDomain = invalidDomains.some(invalid => domain.includes(invalid));
        
        if (hasInvalidDomain) {
            error.textContent = 'Please use a valid email address';
            error.style.display = 'block';
            email.style.borderColor = 'red';
            isEmailValid = false;
            updateSubmitButton();
            return false;
        }
        
        email.style.borderColor = 'green';
        isEmailValid = true;
        updateSubmitButton();
        return true;
    }

    function validateTaskType() {
        const error = document.getElementById('taskType-error-task');
        error.style.display = 'none';
        
        const isChecked = Array.from(taskType).some(radio => radio.checked);
        
        if (!isChecked) {
            error.textContent = 'Please select a task type';
            error.style.display = 'block';
            isTaskTypeValid = false;
            updateSubmitButton();
            return false;
        }
        
        // If "Other" is selected, validate the other input
        const otherRadio = document.getElementById('otherTaskType-task');
        if (otherRadio.checked) {
            const otherValue = otherTaskTypeInput.value.trim();
            if (!otherValue) {
                error.textContent = 'Please specify the other task type';
                error.style.display = 'block';
                isTaskTypeValid = false;
                updateSubmitButton();
                return false;
            }
            
            if (otherValue.length < 3) {
                error.textContent = 'Other task type must be at least 3 characters';
                error.style.display = 'block';
                isTaskTypeValid = false;
                updateSubmitButton();
                return false;
            }
        }
        
        isTaskTypeValid = true;
        updateSubmitButton();
        return true;
    }

    function validateGoal() {
        const value = goal.value.trim();
        const error = document.getElementById('goal-error-task');
        
        error.style.display = 'none';
        goal.style.borderColor = '';
        
        if (!value) {
            error.textContent = 'Goal description is required';
            error.style.display = 'block';
            goal.style.borderColor = 'red';
            isGoalValid = false;
            updateSubmitButton();
            return false;
        }
        
        if (value.length < 10) {
            error.textContent = 'Please provide a more detailed goal description (at least 10 characters)';
            error.style.display = 'block';
            goal.style.borderColor = 'red';
            isGoalValid = false;
            updateSubmitButton();
            return false;
        }
        
        goal.style.borderColor = 'green';
        isGoalValid = true;
        updateSubmitButton();
        return true;
    }

    function validateTaskDescription() {
        const value = taskDescription.value.trim();
        const error = document.getElementById('taskDescription-error-task');
        
        error.style.display = 'none';
        taskDescription.style.borderColor = '';
        
        if (!value) {
            error.textContent = 'Task description is required';
            error.style.display = 'block';
            taskDescription.style.borderColor = 'red';
            isTaskDescriptionValid = false;
            updateSubmitButton();
            return false;
        }
        
        if (value.length < 10) {
            error.textContent = 'Please provide a more detailed task description (at least 10 characters)';
            error.style.display = 'block';
            taskDescription.style.borderColor = 'red';
            isTaskDescriptionValid = false;
            updateSubmitButton();
            return false;
        }
        
        taskDescription.style.borderColor = 'green';
        isTaskDescriptionValid = true;
        updateSubmitButton();
        return true;
    }

    function updateSubmitButton() {
        if (isFirstNameValid && isLastNameValid && isEmailValid && isTaskTypeValid && 
            isGoalValid && isTaskDescriptionValid) {
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
            submitBtn.style.cursor = 'pointer';
        } else {
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.6';
            submitBtn.style.cursor = 'not-allowed';
        }
    }

    // Real-time validation
    firstName.addEventListener('input', validateFirstName);
    firstName.addEventListener('blur', validateFirstName);
    
    lastName.addEventListener('input', validateLastName);
    lastName.addEventListener('blur', validateLastName);
    
    email.addEventListener('input', validateEmail);
    email.addEventListener('blur', validateEmail);
    
    taskType.forEach(radio => {
        radio.addEventListener('change', validateTaskType);
    });
    
    otherTaskTypeInput.addEventListener('input', validateTaskType);
    otherTaskTypeInput.addEventListener('blur', validateTaskType);
    
    goal.addEventListener('input', validateGoal);
    goal.addEventListener('blur', validateGoal);
    
    taskDescription.addEventListener('input', validateTaskDescription);
    taskDescription.addEventListener('blur', validateTaskDescription);

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const validations = [
            validateFirstName(),
            validateLastName(),
            validateEmail(),
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

    // Initialize
    updateSubmitButton();
});
</script>