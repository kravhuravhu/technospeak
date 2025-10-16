<div class="content-section assistance_content" id="usr_guide">
    <div class="assistance">
        <div class="container">
            <div class="section-header">
                <div class="title">
                    <h1>Personal Guide Request Form</h1>
                    <p class="subtitle">Please fill in this form so we can guide you step-by-step through your task while you learn to do it yourself.</p>
                </div>
            </div>
            <form id="personalGuideForm" class="assistance-form">
                <div class="form-section">
                    <h2 class="form-section-title">PERSONAL INFO</h2>
                    <div class="form-row">
                        <div class="form-group half-width">
                            <label for="firstName-guide">First Name:</label>
                            <input type="text" id="firstName-guide" name="firstName" required
                                   value="{{ old('firstName', Auth::check() ? Auth::user()->name : '') }}">
                            <div class="error-message" id="firstName-error-guide" style="color: red; display: none; font-size: 12px; margin-top: 5px;"></div>
                        </div>
                        <div class="form-group half-width">
                            <label for="lastName-guide">Last Name:</label>
                            <input type="text" id="lastName-guide" name="lastName" required
                                   value="{{ old('lastName', Auth::check() ? (Auth::user()->surname ?? '') : '') }}">
                            <div class="error-message" id="lastName-error-guide" style="color: red; display: none; font-size: 12px; margin-top: 5px;"></div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group half-width">
                            <label for="email-guide">Email Address:</label>
                            <input type="email" id="email-guide" name="email" required
                                   value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}">
                            <div class="error-message" id="email-error-guide" style="color: red; display: none; font-size: 12px; margin-top: 5px;"></div>
                        </div>
                    </div>
                    <div class="form-group half-width">
                        <div class="form-group fm-g-rw">
                            <label for="preferredMethod-guide">Preferred Method:</label>
                            <div class="checkbox-group">
                                <label class="checkbox-container">
                                    <input type="radio" name="preferredMethod" value="zoom">
                                    <span class="checkmark"></span>
                                    Zoom
                                </label>
                                <label class="checkbox-container">
                                    <input type="radio" name="preferredMethod" value="gmeet">
                                    <span class="checkmark"></span>
                                    Google Meet
                                </label>
                                <label class="checkbox-container">
                                    <input type="radio" name="preferredMethod" value="teams">
                                    <span class="checkmark"></span>
                                    Microsoft Teams
                                </label>
                                <label class="checkbox-container">
                                    <input type="radio" name="preferredMethod" value="whatsapp">
                                    <span class="checkmark"></span>
                                    WhatsApp
                                </label>
                            </div>
                            <div class="error-message" id="preferredMethod-error-guide" style="color: red; display: none; font-size: 12px; margin-top: 5px;"></div>
                        </div>
                    </div>
                </div>
                <div class="form-section">
                    <h2 class="form-section-title">GUIDANCE OBJECTIVE</h2>
                    <div class="form-group">
                        <label for="guideType-guide">What Kind Of Guidance You Need Help With?</label>
                        <input type="text" id="guideType-guide" name="guide_type" required>
                        <div class="error-message" id="guideType-error-guide" style="color: red; display: none; font-size: 12px; margin-top: 5px;"></div>
                    </div>
                    <div class="form-group fm-g-rw">
                        <label>Your Current Skill Level In This Task:</label>
                        <div class="checkbox-group">
                            <label class="checkbox-container">
                                <input type="radio" name="skillLevel" value="beginner">
                                <span class="checkmark"></span>
                                Beginner
                            </label>
                            <label class="checkbox-container">
                                <input type="radio" name="skillLevel" value="intermediate">
                                <span class="checkmark"></span>
                                Intermediate
                            </label>
                            <label class="checkbox-container">
                                <input type="radio" name="skillLevel" value="advanced">
                                <span class="checkmark"></span>
                                Advanced
                            </label>
                        </div>
                        <div class="error-message" id="skillLevel-error-guide" style="color: red; display: none; font-size: 12px; margin-top: 5px;"></div>
                    </div>
                    <div class="form-group fm-g-rw">
                        <label for="goal-guide">Task Guide Description:</label>
                        <textarea id="goal-guide" name="goal" rows="1"></textarea>
                        <div class="error-message" id="goal-error-guide" style="color: red; display: none; font-size: 12px; margin-top: 5px;"></div>
                    </div>
                </div>
                <div class="form-section">
                    <h2 class="form-section-title">MORE DETAILS <i>(ATTACHMENTS OPTIONAL)</i></h2>
                    <div class="form-group fm-g-rw">
                        <label for="additionalInfo-guide">Any other specifics you'd like to add:</label>
                        <textarea id="additionalInfo-guide" name="additionalInfo" rows="1"></textarea>
                    </div>
                    <div class="form-group fm-g-rw">
                        <label for="fileUpload-guide" class="file-upload-label">
                            <i class="fas fa-paperclip"></i> Attach Files
                        </label>
                        <input type="file" id="fileUpload-guide" name="fileUpload" multiple style="display: none;">
                        <div id="fileList-guide" class="file-list"></div>
                    </div>
                </div>
                <button type="submit" class="submit-btn" id="submit-btn-guide">Submit Request</button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('personalGuideForm');
    const firstName = document.getElementById('firstName-guide');
    const lastName = document.getElementById('lastName-guide');
    const email = document.getElementById('email-guide');
    const preferredMethod = document.querySelectorAll('input[name="preferredMethod"]');
    const guideType = document.getElementById('guideType-guide');
    const skillLevel = document.querySelectorAll('input[name="skillLevel"]');
    const goal = document.getElementById('goal-guide');
    const submitBtn = document.getElementById('submit-btn-guide');

    // Track validation state
    let isFirstNameValid = false;
    let isLastNameValid = false;
    let isEmailValid = false;
    let isPreferredMethodValid = false;
    let isGuideTypeValid = false;
    let isSkillLevelValid = false;
    let isGoalValid = false;

    // Validation functions
    function validateFirstName() {
        const value = firstName.value.trim();
        const error = document.getElementById('firstName-error-guide');
        
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
        const error = document.getElementById('lastName-error-guide');
        
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
        const error = document.getElementById('email-error-guide');
        
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

    function validatePreferredMethod() {
        const error = document.getElementById('preferredMethod-error-guide');
        error.style.display = 'none';
        
        const isChecked = Array.from(preferredMethod).some(radio => radio.checked);
        
        if (!isChecked) {
            error.textContent = 'Please select a preferred method';
            error.style.display = 'block';
            isPreferredMethodValid = false;
            updateSubmitButton();
            return false;
        }
        
        isPreferredMethodValid = true;
        updateSubmitButton();
        return true;
    }

    function validateGuideType() {
        const value = guideType.value.trim();
        const error = document.getElementById('guideType-error-guide');
        
        error.style.display = 'none';
        guideType.style.borderColor = '';
        
        if (!value) {
            error.textContent = 'Guidance type is required';
            error.style.display = 'block';
            guideType.style.borderColor = 'red';
            isGuideTypeValid = false;
            updateSubmitButton();
            return false;
        }
        
        if (value.length < 5) {
            error.textContent = 'Please provide a more specific guidance type (at least 5 characters)';
            error.style.display = 'block';
            guideType.style.borderColor = 'red';
            isGuideTypeValid = false;
            updateSubmitButton();
            return false;
        }
        
        guideType.style.borderColor = 'green';
        isGuideTypeValid = true;
        updateSubmitButton();
        return true;
    }

    function validateSkillLevel() {
        const error = document.getElementById('skillLevel-error-guide');
        error.style.display = 'none';
        
        const isChecked = Array.from(skillLevel).some(radio => radio.checked);
        
        if (!isChecked) {
            error.textContent = 'Please select your skill level';
            error.style.display = 'block';
            isSkillLevelValid = false;
            updateSubmitButton();
            return false;
        }
        
        isSkillLevelValid = true;
        updateSubmitButton();
        return true;
    }

    function validateGoal() {
        const value = goal.value.trim();
        const error = document.getElementById('goal-error-guide');
        
        error.style.display = 'none';
        goal.style.borderColor = '';
        
        if (!value) {
            error.textContent = 'Task description is required';
            error.style.display = 'block';
            goal.style.borderColor = 'red';
            isGoalValid = false;
            updateSubmitButton();
            return false;
        }
        
        if (value.length < 10) {
            error.textContent = 'Please provide a more detailed task description (at least 10 characters)';
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

    function updateSubmitButton() {
        if (isFirstNameValid && isLastNameValid && isEmailValid && isPreferredMethodValid && 
            isGuideTypeValid && isSkillLevelValid && isGoalValid) {
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
    
    preferredMethod.forEach(radio => {
        radio.addEventListener('change', validatePreferredMethod);
    });
    
    guideType.addEventListener('input', validateGuideType);
    guideType.addEventListener('blur', validateGuideType);
    
    skillLevel.forEach(radio => {
        radio.addEventListener('change', validateSkillLevel);
    });
    
    goal.addEventListener('input', validateGoal);
    goal.addEventListener('blur', validateGoal);

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const validations = [
            validateFirstName(),
            validateLastName(),
            validateEmail(),
            validatePreferredMethod(),
            validateGuideType(),
            validateSkillLevel(),
            validateGoal()
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