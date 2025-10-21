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
                    <div class="form-row responsive-row">
                        <div class="form-group full-width-mobile">
                            <label for="firstName-guide">First Name:</label>
                            <input type="text" id="firstName-guide" name="firstName" required
                                   value="{{ old('firstName', Auth::check() ? Auth::user()->name : '') }}">
                        </div>
                        <div class="form-group full-width-mobile">
                            <label for="lastName-guide">Last Name:</label>
                            <input type="text" id="lastName-guide" name="lastName" required
                                   value="{{ old('lastName', Auth::check() ? (Auth::user()->surname ?? '') : '') }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group full-width">
                            <label for="email-guide">Email Address:</label>
                            <input type="email" id="email-guide" name="email" required
                                   value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}">
                        </div>
                    </div>
                    <div class="form-group full-width">
                        <div class="form-group fm-g-rw">
                            <label>Preferred Method:</label>
                            <div class="checkbox-group responsive-checkbox-group">
                                <label class="checkbox-container responsive-checkbox">
                                    <input type="radio" name="preferredMethod" value="zoom">
                                    <span class="checkmark"></span>
                                    Zoom
                                </label>
                                <label class="checkbox-container responsive-checkbox">
                                    <input type="radio" name="preferredMethod" value="gmeet">
                                    <span class="checkmark"></span>
                                    Google Meet
                                </label>
                                <label class="checkbox-container responsive-checkbox">
                                    <input type="radio" name="preferredMethod" value="teams">
                                    <span class="checkmark"></span>
                                    Microsoft Teams
                                </label>
                                <label class="checkbox-container responsive-checkbox">
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
                    <div class="form-group full-width">
                        <label for="guideType-guide">What Kind Of Guidance You Need Help With?</label>
                        <input type="text" id="guideType-guide" name="guide_type" required>
                        <div class="error-message" id="guideType-error-guide" style="color: red; display: none; font-size: 12px; margin-top: 5px;"></div>
                    </div>
                    <div class="form-group full-width">
                        <div class="form-group fm-g-rw">
                            <label>Your Current Skill Level In This Task:</label>
                            <div class="checkbox-group responsive-checkbox-group">
                                <label class="checkbox-container responsive-checkbox">
                                    <input type="radio" name="skillLevel" value="beginner">
                                    <span class="checkmark"></span>
                                    Beginner
                                </label>
                                <label class="checkbox-container responsive-checkbox">
                                    <input type="radio" name="skillLevel" value="intermediate">
                                    <span class="checkmark"></span>
                                    Intermediate
                                </label>
                                <label class="checkbox-container responsive-checkbox">
                                    <input type="radio" name="skillLevel" value="advanced">
                                    <span class="checkmark"></span>
                                    Advanced
                                </label>
                            </div>
                            <div class="error-message" id="skillLevel-error-guide" style="color: red; display: none; font-size: 12px; margin-top: 5px;"></div>
                        </div>
                    </div>
                    <div class="form-group full-width">
                        <div class="form-group fm-g-rw">
                            <label for="goal-guide">Task Guide Description:</label>
                            <textarea id="goal-guide" name="goal" rows="3" class="responsive-textarea"></textarea>
                            <div class="error-message" id="goal-error-guide" style="color: red; display: none; font-size: 12px; margin-top: 5px;"></div>
                        </div>
                    </div>
                </div>
                <div class="form-section">
                    <h2 class="form-section-title">MORE DETAILS <i>(ATTACHMENTS OPTIONAL)</i></h2>
                    <div class="form-group full-width">
                        <div class="form-group fm-g-rw">
                            <label for="additionalInfo-guide">Any other specifics you'd like to add:</label>
                            <textarea id="additionalInfo-guide" name="additionalInfo" rows="3" class="responsive-textarea"></textarea>
                        </div>
                    </div>
                    <div class="form-group full-width">
                        <div class="form-group fm-g-rw">
                            <label for="fileUpload-guide" class="file-upload-label responsive-file-upload">
                                <i class="fas fa-paperclip"></i> Attach Files
                            </label>
                            <input type="file" id="fileUpload-guide" name="fileUpload" multiple style="display: none;">
                            <div id="fileList-guide" class="file-list responsive-file-list"></div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="submit-btn responsive-submit-btn" id="submit-btn-guide">Submit Request</button>
            </form>
        </div>
    </div>
</div>

<style>
/* Responsive Styles for Personal Guide Form */
.assistance-form {
    width: 100%;
    max-width: 100%;
    margin: 0 auto;
    padding: 0 15px;
}

.form-section {
    margin-bottom: 2rem;
    width: 100%;
}

.form-row {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1rem;
    width: 100%;
}

.responsive-row {
    flex-direction: row;
}

.form-group {
    flex: 1;
    min-width: 0;
    margin-bottom: 1rem;
}

.full-width {
    flex: 1 1 100%;
}

.full-width-mobile {
    flex: 1 1 100%;
}

.half-width {
    flex: 1 1 calc(50% - 0.5rem);
}

.checkbox-group {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.responsive-checkbox-group {
    flex-direction: row;
    justify-content: flex-start;
}

.responsive-checkbox {
    flex: 1 1 calc(25% - 1rem);
    min-width: 120px;
}

.responsive-textarea {
    width: 100%;
    min-height: 100px;
    resize: vertical;
}

.responsive-file-upload {
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

.responsive-file-list {
    margin-top: 0.5rem;
    font-size: 0.875rem;
}

.responsive-submit-btn {
    width: 100%;
    padding: 1rem 2rem;
    font-size: 1.1rem;
    margin-top: 1.5rem;
}

/* Mobile First Approach */
@media (max-width: 768px) {
    .assistance-form {
        padding: 0 10px;
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
    
    .half-width {
        flex: 1 1 100%;
    }
    
    .checkbox-group {
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .responsive-checkbox-group {
        flex-direction: column;
    }
    
    .responsive-checkbox {
        flex: 1 1 100%;
        min-width: auto;
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
    
    .section-header .title h1 {
        font-size: 1.5rem;
        text-align: center;
    }
    
    .section-header .title .subtitle {
        font-size: 0.9rem;
        text-align: center;
    }
    
    .form-section-title {
        font-size: 1.1rem;
        text-align: center;
    }
}

@media (max-width: 480px) {
    .assistance-form {
        padding: 0 5px;
    }
    
    .form-section {
        margin-bottom: 1.5rem;
    }
    
    .responsive-textarea {
        min-height: 100px;
        font-size: 14px;
    }
    
    .responsive-submit-btn {
        padding: 1rem 1.5rem;
        font-size: 1.1rem;
    }
    
    .checkbox-container {
        font-size: 0.9rem;
    }
    
    label {
        font-size: 0.9rem;
    }
    
    input[type="text"],
    input[type="email"] {
        font-size: 14px;
        padding: 0.75rem;
    }
}

/* Tablet Styles */
@media (min-width: 769px) and (max-width: 1024px) {
    .assistance-form {
        max-width: 90%;
    }
    
    .responsive-checkbox {
        flex: 1 1 calc(50% - 1rem);
    }
    
    .form-row {
        gap: 1.5rem;
    }
}

/* Large Desktop Styles */
@media (min-width: 1025px) {
    .assistance-form {
        max-width: 800px;
    }
}

/* Modal specific responsive styles */
.assistanceTP_form_modal .task_modal-content {
    width: 95%;
    max-width: 900px;
    margin: 2% auto;
    max-height: 95vh;
    overflow-y: auto;
}

@media (max-width: 768px) {
    .assistanceTP_form_modal .task_modal-content {
        width: 98%;
        margin: 1% auto;
        max-height: 98vh;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('personalGuideForm');
    // Check if form exists on this page
    if (!form) return;

    const preferredMethod = document.querySelectorAll('input[name="preferredMethod"]');
    const guideType = document.getElementById('guideType-guide');
    const skillLevel = document.querySelectorAll('input[name="skillLevel"]');
    const goal = document.getElementById('goal-guide');
    const submitBtn = document.getElementById('submit-btn-guide');

    // Check if all required elements exist
    if (!guideType || !goal || !submitBtn) return;

    // Track validation state - ONLY for fields that need validation
    let isPreferredMethodValid = false;
    let isGuideTypeValid = false;
    let isSkillLevelValid = false;
    let isGoalValid = false;

    // Validation functions for required fields only
    function validatePreferredMethod() {
        const isChecked = Array.from(preferredMethod).some(radio => radio.checked);
        const errorElement = document.getElementById('preferredMethod-error-guide');
        
        if (!isChecked) {
            if (errorElement) {
                errorElement.textContent = 'Please select a preferred method';
                errorElement.style.display = 'block';
            }
            isPreferredMethodValid = false;
            return false;
        } else {
            if (errorElement) {
                errorElement.style.display = 'none';
            }
            isPreferredMethodValid = true;
            return true;
        }
    }

    function validateGuideType() {
        const value = guideType.value.trim();
        const errorElement = document.getElementById('guideType-error-guide');
        
        if (!value) {
            if (errorElement) {
                errorElement.textContent = 'Please specify what kind of guidance you need';
                errorElement.style.display = 'block';
            }
            isGuideTypeValid = false;
            return false;
        } else if (value.length < 5) {
            if (errorElement) {
                errorElement.textContent = 'Please provide more details about the guidance needed';
                errorElement.style.display = 'block';
            }
            isGuideTypeValid = false;
            return false;
        } else {
            if (errorElement) {
                errorElement.style.display = 'none';
            }
            isGuideTypeValid = true;
            return true;
        }
    }

    function validateSkillLevel() {
        const isChecked = Array.from(skillLevel).some(radio => radio.checked);
        const errorElement = document.getElementById('skillLevel-error-guide');
        
        if (!isChecked) {
            if (errorElement) {
                errorElement.textContent = 'Please select your skill level';
                errorElement.style.display = 'block';
            }
            isSkillLevelValid = false;
            return false;
        } else {
            if (errorElement) {
                errorElement.style.display = 'none';
            }
            isSkillLevelValid = true;
            return true;
        }
    }

    function validateGoal() {
        const value = goal.value.trim();
        const errorElement = document.getElementById('goal-error-guide');
        
        if (!value) {
            if (errorElement) {
                errorElement.textContent = 'Please describe your task guide';
                errorElement.style.display = 'block';
            }
            isGoalValid = false;
            return false;
        } else if (value.length < 10) {
            if (errorElement) {
                errorElement.textContent = 'Please provide a more detailed description (at least 10 characters)';
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

    function updateSubmitButton() {
        // Add null check for submitBtn
        if (!submitBtn) return;
        
        // Only check the fields that require validation
        if (isPreferredMethodValid && isGuideTypeValid && isSkillLevelValid && isGoalValid) {
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
    if (preferredMethod.length > 0) {
        preferredMethod.forEach(radio => {
            radio.addEventListener('change', function() {
                validatePreferredMethod();
                updateSubmitButton();
            });
        });
    }
    
    if (guideType) {
        guideType.addEventListener('input', function() {
            validateGuideType();
            updateSubmitButton();
        });
        guideType.addEventListener('blur', function() {
            validateGuideType();
            updateSubmitButton();
        });
    }
    
    if (skillLevel.length > 0) {
        skillLevel.forEach(radio => {
            radio.addEventListener('change', function() {
                validateSkillLevel();
                updateSubmitButton();
            });
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

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const validations = [
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

    // Initialize only if submit button exists
    if (submitBtn) {
        // Initialize validation and button state
        validatePreferredMethod();
        validateGuideType();
        validateSkillLevel();
        validateGoal();
        updateSubmitButton();
    }
});
</script>