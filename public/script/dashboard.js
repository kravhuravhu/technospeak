
// Issue section 
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('issueForm');
    const confirmation = document.getElementById('confirmation');
    const backBtn = document.querySelector('.back-btn');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Form validation
        const title = document.getElementById('issueTitle').value.trim();
        const description = document.getElementById('issueDescription').value.trim();
        const category = document.getElementById('issueCategory').value;
        const urgency = document.querySelector('input[name="urgency"]:checked')?.value;
        
        if (!title || !description || !category || !urgency) {
            alert('Please fill in all required fields');
            return;
        }

        const submitBtn = form.querySelector('.submit-btn');
        const originalBtnText = submitBtn.innerHTML;
        
        // Show loading state
        submitBtn.innerHTML = '<span>Processing...</span><i class="fas fa-spinner fa-spin"></i>';
        submitBtn.disabled = true;

        try {
            // Get CSRF token from meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            
            const response = await fetch('/issues', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    issueTitle: title,
                    issueDescription: description,
                    issueCategory: category,
                    urgency: urgency
                })
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Server returned an error');
            }

            if (data.success) {
                form.style.display = 'none';
                confirmation.style.display = 'block';
                confirmation.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } else {
                throw new Error(data.message || 'There was an error submitting your issue');
            }
        } catch (error) {
            console.error('Error:', error);
            alert(`Error: ${error.message}`);
            submitBtn.innerHTML = originalBtnText;
            submitBtn.disabled = false;
        }
    });
    
    backBtn.addEventListener('click', function() {
        confirmation.style.display = 'none';
        form.style.display = 'block';
        form.reset();
        form.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
});

/* script for Support section */
document.addEventListener('DOMContentLoaded', function() {
    const faqQuestions = document.querySelectorAll('.faq-question');
    
    faqQuestions.forEach(question => {
        question.addEventListener('click', () => {
            const faqItem = question.parentElement;
            const faqAnswer = question.nextElementSibling;
            
            if (!faqItem.classList.contains('active')) {
                document.querySelectorAll('.faq-item.active').forEach(item => {
                    item.classList.remove('active');
                    item.querySelector('.faq-question').classList.remove('active');
                    item.querySelector('.faq-answer').classList.remove('active');
                });
            }
            
            faqItem.classList.toggle('active');
            question.classList.toggle('active');
            faqAnswer.classList.toggle('active');
        });
    });

    const faqFilter = document.getElementById('faqFilter');
    if (faqFilter) {
        faqFilter.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const activeTab = document.querySelector('.faq-tab.active');
            const category = activeTab ? activeTab.dataset.category : 'all';
            
            filterFAQs(searchTerm, category);
        });
    }

    const faqTabs = document.querySelectorAll('.faq-tab');
    
    faqTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const category = tab.dataset.category;
            const searchTerm = faqFilter ? faqFilter.value.toLowerCase() : '';

            faqTabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            
            filterFAQs(searchTerm, category);
        });
    });

    function filterFAQs(searchTerm = '', category = 'all') {
        const faqItems = document.querySelectorAll('.faq-item');
        let hasVisibleItems = false;
        
        faqItems.forEach(item => {
            const itemCategory = item.closest('.faq-category').dataset.category;
            const matchesCategory = category === 'all' || itemCategory === category;
            const questionText = item.querySelector('.question-text').textContent.toLowerCase();
            const answerText = item.querySelector('.faq-answer').textContent.toLowerCase();
            const matchesSearch = !searchTerm || 
                                questionText.includes(searchTerm) || 
                                answerText.includes(searchTerm);

            const shouldShow = matchesCategory && matchesSearch;
            item.style.display = shouldShow ? 'block' : 'none';

            if (shouldShow) hasVisibleItems = true;

            const parentCategory = item.closest('.faq-category');
            if (category === 'all') {
                parentCategory.classList.remove('hidden');
            } else {
                parentCategory.classList.toggle('hidden', itemCategory !== category);
            }
        });
        
        // no results msg
        showNoResultsMessage(hasVisibleItems);
    }

    function showNoResultsMessage(hasVisibleItems) {
        let noResultsMsg = document.querySelector('.no-results-message');
        
        if (!hasVisibleItems) {
            if (!noResultsMsg) {
                noResultsMsg = document.createElement('div');
                noResultsMsg.className = 'no-results-message';
                noResultsMsg.textContent = 'No questions match your criteria. Try a different search or category.';
                document.querySelector('.faq-accordion').appendChild(noResultsMsg);
            }
        } else if (noResultsMsg) {
            noResultsMsg.remove();
        }
    }

    // "Was this helpful?" Feedback
    document.querySelectorAll('.helpful-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const isHelpful = this.classList.contains('yes');
            const helpfulSection = this.closest('.faq-helpful');
            
            helpfulSection.innerHTML = `
                <div class="feedback-message" style="color: ${isHelpful ? '#38a169' : '#e53e3e'}">
                    ${isHelpful ? 'Thanks for your feedback!' : 'Sorry to hear that. We\'ll improve this answer.'}
                </div>
            `;
        });
    });

    // All tab active
    filterFAQs('', 'all');
});


// Coaching section
document.addEventListener('DOMContentLoaded', function() {
    // Initialize by checking for upcoming sessions
    checkUpcomingSessions();
    
    // Event delegation for all buttons
    document.querySelector('.coach-recommendations').addEventListener('click', function(e) {
        const btn = e.target.closest('button');
        if (!btn) return;
        
        const card = btn.closest('.recommendation-card');
        
        if (btn.classList.contains('start-btn')) {
            startLearning(card);
        } 
        else if (btn.classList.contains('rsvp-btn')) {
            rsvpToSession(card, btn);
        } 
        else if (btn.classList.contains('watch-btn')) {
            watchTutorial(card);
        }
    });
});

// Check for upcoming sessions from backend
async function checkUpcomingSessions() {
    try {
        const response = await fetch('/api/training-sessions/upcoming');
        const sessions = await response.json();
        
        if (sessions.length === 0) {
            // Hide or disable RSVP section if no sessions
            const rsvpCard = document.querySelector('.recommendation-card .rsvp-btn')?.closest('.recommendation-card');
            if (rsvpCard) {
                rsvpCard.querySelector('.recommendation-content').innerHTML = `
                    <h4><i class="fas fa-users"></i> No Upcoming Sessions</h4>
                    <p class="recommendation-desc">There are currently no upcoming training sessions scheduled.</p>
                    <button class="notify-btn" onclick="requestNotification()">Notify Me When Available</button>
                `;
            }
        } else {
            // Update the DOM with real session data
            updateSessionCards(sessions);
        }
    } catch (error) {
        console.error('Error fetching sessions:', error);
    }
}

// Update session cards with real data from backend
function updateSessionCards(sessions) {
    const sessionCard = document.querySelector('.recommendation-card .rsvp-btn')?.closest('.recommendation-card');
    if (!sessionCard) return;
    
    const session = sessions[0]; // Assuming we show the next upcoming session
    
    // Format date and time
    const scheduledDate = new Date(session.scheduled_for);
    const dateStr = scheduledDate.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
    const timeStr = scheduledDate.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
    
    // Update card content
    sessionCard.dataset.sessionId = session.id;
    sessionCard.querySelector('h4').innerHTML = `<i class="fas fa-users"></i> ${session.title}`;
    sessionCard.querySelector('.recommendation-desc').innerHTML = `
        Live training on <span class="session-date">${dateStr}</span> at 
        <span class="session-time">${timeStr}</span> - ${session.description}
    `;
    sessionCard.querySelector('.full-date').textContent = `${dateStr} ${timeStr}`;
    sessionCard.querySelector('.rsvp-btn').dataset.sessionId = session.id;
}

// Start Learning - Redirect to Training Library
function startLearning(card) {
    window.location.href = '/dashboard/training-library';
}

// RSVP to a session with backend integration
async function rsvpToSession(card, btn) {
    const sessionId = card.dataset.sessionId;
    
    if (!sessionId) {
        alert('No session selected or session data not loaded');
        return;
    }
    
    // Show loading state
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
    btn.disabled = true;
    
    try {
        const response = await fetch('/api/training-sessions/rsvp', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ session_id: sessionId })
        });
        
        const data = await response.json();
        
        if (response.ok) {
            // Update UI on success
            btn.innerHTML = '<i class="fas fa-check"></i> RSVP Confirmed';
            btn.style.backgroundColor = '#4CAF50';
            btn.disabled = true;
            
            // Show success modal
            openModal({
                title: "RSVP Confirmed!",
                body: `You're registered for the session. A confirmation has been sent to your email.`,
                confirmText: "OK"
            });
        } else {
            // Handle errors
            btn.innerHTML = 'RSVP Now';
            btn.disabled = false;
            
            openModal({
                title: "RSVP Failed",
                body: data.message || "Could not complete your RSVP. Please try again.",
                confirmText: "OK"
            });
        }
    } catch (error) {
        console.error('RSVP error:', error);
        btn.innerHTML = 'RSVP Now';
        btn.disabled = false;
        
        openModal({
            title: "Network Error",
            body: "Could not connect to server. Please check your connection and try again.",
            confirmText: "OK"
        });
    }
}

// Watch Tutorial - Redirect to Training Library for now
function watchTutorial(card) {
    window.location.href = '/dashboard/training-library';
}

// Request notification when sessions are available
function requestNotification() {
    openModal({
        title: "Notify Me",
        body: "We'll notify you when new training sessions are scheduled. Please confirm your email:",
        confirmText: "Submit",
        onConfirm: function() {
            const email = prompt("Enter your email address:");
            if (email) {
                // Send to backend
                fetch('/api/notify-me', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ email })
                }).then(response => {
                    if (response.ok) {
                        alert("You'll be notified when new sessions are available!");
                    }
                });
            }
        }
    });
}