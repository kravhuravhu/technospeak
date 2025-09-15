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
                        </div>
                        <div class="form-group half-width">
                            <label for="lastName-guide">Last Name:</label>
                            <input type="text" id="lastName-guide" name="lastName" required
                                   value="{{ old('lastName', Auth::check() ? (Auth::user()->surname ?? '') : '') }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group half-width">
                            <label for="email-guide">Email Address:</label>
                            <input type="email" id="email-guide" name="email" required
                                   value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}">
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
                        </div>
                    </div>
                </div>
                <div class="form-section">
                    <h2 class="form-section-title">GUIDANCE OBJECTIVE</h2>
                    <div class="form-group">
                        <label for="guideType-guide">What Kind Of Guidance You Need Help With?</label>
                        <input type="text" id="guideType-guide" name="guide_type" required>
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
                    </div>
                    <div class="form-group fm-g-rw">
                        <label for="goal-guide">Task Guide Description:</label>
                        <textarea id="goal-guide" name="goal" rows="1"></textarea>
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
                <button type="submit" class="submit-btn">Submit Request</button>
            </form>
        </div>
    </div>
</div>