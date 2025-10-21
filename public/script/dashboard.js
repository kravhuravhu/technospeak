
// Issue section 
// document.addEventListener('DOMContentLoaded', function() {
//     const form = document.getElementById('issueForm');
//     const confirmation = document.getElementById('confirmation');
//     const backBtn = document.querySelector('.back-btn');

//     form.addEventListener('submit', async function(e) {
//         e.preventDefault();
        
//         // Form validation
//         const title = document.getElementById('issueTitle').value.trim();
//         const description = document.getElementById('issueDescription').value.trim();
//         const category = document.getElementById('issueCategory').value;
//         const urgency = document.querySelector('input[name="urgency"]:checked')?.value;
        
//         if (!title || !description || !category || !urgency) {
//             alert('Please fill in all required fields');
//             return;
//         }

//         const submitBtn = form.querySelector('.submit-btn');
//         const originalBtnText = submitBtn.innerHTML;
        
//         // Show loading state
//         submitBtn.innerHTML = '<span>Processing...</span><i class="fas fa-spinner fa-spin"></i>';
//         submitBtn.disabled = true;

//         try {
//             // Get CSRF token from meta tag
//             const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            
//             const response = await fetch('/issues', {
//                 method: 'POST',
//                 headers: {
//                     'Content-Type': 'application/json',
//                     'Accept': 'application/json',
//                     'X-Requested-With': 'XMLHttpRequest',
//                     'X-CSRF-TOKEN': csrfToken
//                 },
//                 body: JSON.stringify({
//                     issueTitle: title,
//                     issueDescription: description,
//                     issueCategory: category,
//                     urgency: urgency
//                 })
//             });

//             const data = await response.json();

//             if (!response.ok) {
//                 throw new Error(data.message || 'Server returned an error');
//             }

//             if (data.success) {
//                 form.style.display = 'none';
//                 confirmation.style.display = 'block';
//                 confirmation.scrollIntoView({ behavior: 'smooth', block: 'start' });
//             } else {
//                 throw new Error(data.message || 'There was an error submitting your issue');
//             }
//         } catch (error) {
//             console.error('Error:', error);
//             alert(`Error: ${error.message}`);
//             submitBtn.innerHTML = originalBtnText;
//             submitBtn.disabled = false;
//         }
//     });
    
//     backBtn.addEventListener('click', function() {
//         confirmation.style.display = 'none';
//         form.style.display = 'block';
//         form.reset();
//         form.scrollIntoView({ behavior: 'smooth', block: 'start' });
//     });
// });

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


// Prevent duplicate form submissions
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                
                // Re-enable after 5 seconds in case of error
                setTimeout(() => {
                    submitButton.disabled = false;
                    submitButton.innerHTML = 'Submit';
                }, 5000);
            }
        });
    });
    
    // Check registration status before showing modals
    document.querySelectorAll('.registration-trigger').forEach(trigger => {
        trigger.addEventListener('click', async function(e) {
            e.preventDefault();
            
            const typeId = this.dataset.typeId;
            const sessionId = this.dataset.sessionId;
            
            try {
                const response = await fetch(`/api/check-registration/${typeId}`);
                const data = await response.json();
                
                if (data.registered) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Already Registered',
                        text: 'You have already registered for this type of session.',
                        timer: 3000
                    });
                } else {
                    // Show the registration modal
                    const modalId = typeId == 4 ? 'modal-qa' : 'modal-consult';
                    document.getElementById(modalId).style.display = 'flex';
                    document.body.classList.add('no-scroll');
                }
            } catch (error) {
                console.error('Error checking registration:', error);
                // Fallback: show modal anyway
                const modalId = typeId == 4 ? 'modal-qa' : 'modal-consult';
                document.getElementById(modalId).style.display = 'flex';
                document.body.classList.add('no-scroll');
            }
        });
    });
});


// Tips & tricks script
document.addEventListener('DOMContentLoaded', function() {
    // Function to get URL parameters
    function getUrlParameter(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }

    // Function to handle category parameter on page load
    function handleCategoryParameter() {
        const categoryParam = getUrlParameter('category');
        
        if (categoryParam) {
            console.log('Category parameter found:', categoryParam);
            
            // Auto-select the category in the filter dropdown
            const filterSelect = document.getElementById('tipsFilterSelect');
            if (filterSelect) {
                filterSelect.value = categoryParam;
                console.log('Filter select value set to:', categoryParam);
            }
            
            // Ensure tips & tricks section is active
            setTimeout(() => {
                const allTricksSection = document.getElementById('usr_alltricks');
                if (allTricksSection) {
                    console.log('Switching to tips & tricks section');
                    
                    // Use your existing switchToSection function
                    if (typeof window.switchToSection === 'function') {
                        window.switchToSection('usr_alltricks');
                    } else {
                        // Fallback: manually activate the section
                        document.querySelectorAll('.content-section').forEach(section => {
                            section.classList.remove('active');
                        });
                        document.querySelectorAll('.nav-item').forEach(item => {
                            item.classList.remove('active');
                        });
                        
                        allTricksSection.classList.add('active');
                        const navItem = document.querySelector('.nav-item[data-section="usr_alltricks"]');
                        if (navItem) navItem.classList.add('active');
                    }
                }
            }, 500); // Increased delay to ensure DOM is ready
        }
    }

    // Call this function when DOM is loaded
    handleCategoryParameter();
});

// Also call it when hash changes (in case user navigates)
window.addEventListener('hashchange', handleCategoryParameter);