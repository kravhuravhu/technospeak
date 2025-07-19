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
      // Prepare form data
      const formData = {
        issueTitle: title,
        issueDescription: description,
        issueCategory: category,
        urgency: urgency,
        _token: document.querySelector('meta[name="csrf-token"]').content
      };

      // Submit via AJAX
      const response = await fetch('/submit-issue', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': formData._token
        },
        body: JSON.stringify(formData)
      });

      const data = await response.json();

      if (!response.ok) {
        throw new Error(data.message || 'Server returned an error');
      }

      if (data.success) {
        // Show success message
        form.style.display = 'none';
        confirmation.style.display = 'block';
        confirmation.scrollIntoView({ behavior: 'smooth', block: 'start' });
      } else {
        throw new Error(data.message || 'There was an error submitting your issue');
      }
    } catch (error) {
      console.error('Full error details:', error);
      let errorMessage = error.message;
      
      // Try to get more detailed error message from response
      if (error.response) {
        try {
          const errorData = await error.response.json();
          errorMessage = errorData.message || errorMessage;
        } catch (e) {
          // Couldn't parse JSON error response
        }
      }
      
      alert(`Error: ${errorMessage}\n\nPlease check the console for more details.`);
      submitBtn.innerHTML = originalBtnText;
      submitBtn.disabled = false;
    }
  });
  
  backBtn.addEventListener('click', function() {
    confirmation.style.display = 'none';
    form.style.display = 'block';
    form.reset();
    
    const submitBtn = form.querySelector('.submit-btn');
    submitBtn.innerHTML = '<span>Get Help Now</span><i class="fas fa-paper-plane"></i>';
    submitBtn.disabled = false;
    
    form.scrollIntoView({ behavior: 'smooth', block: 'start' });
  });

  // Animation observer (keep your existing code)
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('animate-in');
      }
    });
  }, { threshold: 0.1 });
  
  document.querySelectorAll('.step, .form-group').forEach(el => {
    observer.observe(el);
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