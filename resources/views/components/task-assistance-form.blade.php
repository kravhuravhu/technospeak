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
                            <input type="text" id="firstName-task" name="firstName" required>
                        </div>
                        <div class="form-group half-width">
                            <label for="lastName-task">Last Name:</label>
                            <input type="text" id="lastName-task" name="lastName" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email-task">Email Address:</label>
                        <input type="email" id="email-task" name="email" required>
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
                    </div>
                    <div class="form-group fm-g-rw">
                        <label for="goal-task">What's the main goal or outcome you want to achieve?</label>
                        <textarea id="goal-task" name="goal" rows="1"></textarea>
                    </div>
                    <div class="form-group fm-g-rw">
                        <label for="taskDescription-task">Task Description:</label>
                        <textarea id="taskDescription-task" name="taskDescription" rows="1" placeholder="---"></textarea>
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
                <button type="submit" class="submit-btn">Submit Request</button>
            </form>
        </div>
    </div>
</div>

<!-- Assistance/Guide Submit function -->
<script src="@secureAsset('/script/sendMail/support_assistance.js')"></script>