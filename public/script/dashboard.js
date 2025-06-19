document.querySelectorAll('.card button').forEach(button => {
  button.addEventListener('click', () => {
    alert('You have enrolled in this course!');
  });
});


// Share Your Issue Section
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('issueForm');
  const confirmation = document.getElementById('confirmation');
  const backBtn = document.querySelector('.back-btn');
  
  form.addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Simple form validation
    const title = document.getElementById('issueTitle').value.trim();
    const description = document.getElementById('issueDescription').value.trim();
    const category = document.getElementById('issueCategory').value;
    
    if (!title || !description || !category) {
      alert('Please fill in all required fields');
      return;
    }
    
    // Show loading state
    const submitBtn = form.querySelector('.submit-btn');
    submitBtn.innerHTML = '<span>Processing...</span><i class="fas fa-spinner fa-spin"></i>';
    submitBtn.disabled = true;
    
    // Simulate API call
    setTimeout(() => {
      form.style.display = 'none';
      confirmation.style.display = 'block';
      
      // Scroll to confirmation
      confirmation.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }, 1500);
  });
  
  backBtn.addEventListener('click', function() {
    confirmation.style.display = 'none';
    form.style.display = 'block';
    form.reset();
    
    // Reset submit button
    const submitBtn = form.querySelector('.submit-btn');
    submitBtn.innerHTML = '<span>Get Help Now</span><i class="fas fa-paper-plane"></i>';
    submitBtn.disabled = false;
    
    // Scroll back to form
    form.scrollIntoView({ behavior: 'smooth', block: 'start' });
  });
  
  // Add animation to form elements when they come into view
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