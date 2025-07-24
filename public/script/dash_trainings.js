document.addEventListener('DOMContentLoaded', function() {
    const trainingCards = document.querySelectorAll('.training-card');
    const modal = document.getElementById('training-modal');
    const closeBtn = document.querySelector('.close-btn');
    const episodeList = document.getElementById('episode-list');
    
    trainingCards.forEach(card => {
        card.addEventListener('click', function(e) {
            e.preventDefault();
            
            const isFree = this.getAttribute('data-training-type') === 'free';
            const title = this.getAttribute('data-title');
            const description = this.getAttribute('data-description');
            const image = this.getAttribute('data-image');
            const duration = this.getAttribute('data-duration');
            const level = this.getAttribute('data-level');
            const instructor = this.getAttribute('data-instructor');
            const category = this.getAttribute('data-category');
            const price = this.getAttribute('data-price') || 'Free';
            const episodes = JSON.parse(this.getAttribute('data-episodes'));
            
            // Set modal content
            document.getElementById('modal-title-cs').textContent = title;
            document.getElementById('modal-price').textContent = isFree ? 'Free' : price;
            document.getElementById('modal-image').src = image;
            document.getElementById('modal-image').alt = title;
            document.getElementById('modal-description').textContent = description;
            document.getElementById('modal-duration').textContent = duration;
            document.getElementById('modal-level').textContent = level;
            document.getElementById('modal-instructor').textContent = instructor;
            document.getElementById('modal-category').textContent = category;
            
            // Clear and populate episodes
            episodeList.innerHTML = '';
            episodes.forEach(episode => {
                const li = document.createElement('li');
                li.className = 'episode-item';
                li.innerHTML = `
                    <span class="episode-number">${episode.number}</span>
                    <span class="episode-name">${episode.name}</span>
                    <span class="episode-duration">${episode.duration}</span>
                `;
                episodeList.appendChild(li);
            });
            
            // Set enroll button & URL
            const enrollBtn = document.getElementById('enroll-btn');
            const isEnrolled = this.getAttribute('data-enrolled') === 'true';
            const showLink = this.getAttribute('data-show-link');

            if (isEnrolled && showLink) {
                enrollBtn.textContent = 'Open';
                enrollBtn.href = showLink;
                enrollBtn.classList.add('open-btn');
                enrollBtn.removeAttribute('target');
                enrollBtn.removeAttribute('data-enroll');
            } else {
                enrollBtn.textContent = isFree ? 'Enroll Now' : 'Unlock All';
                enrollBtn.href = '#';
                enrollBtn.classList.remove('open-btn');
                enrollBtn.setAttribute('data-enroll', 'true');
            }
            
            // Show modal
            const courseId = this.getAttribute('data-course-id');

            modal.setAttribute('data-course-id', courseId);
            
            modal.style.display = 'block';
            
            document.body.style.overflow = 'hidden';
        });
    });
    
    // Close modal
    closeBtn.addEventListener('click', closeModal);
    window.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });
    
    function closeModal() {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
});

// enroll button click
document.addEventListener('DOMContentLoaded', function() {
    const enrollBtn = document.getElementById('enroll-btn');
    
    if (enrollBtn) {
        enrollBtn.addEventListener('click', function(e) {
            // open link
            if (!this.hasAttribute('data-enroll')) {
                return;
            }

            e.preventDefault();

            if (this.textContent === 'Enrolled') {
                Swal.fire({
                    icon: 'info',
                    title: 'Info',
                    text: 'You are already enrolled in this course',
                    timer: 3000,
                    showConfirmButton: false
                });
                return;
            }

            const modal = document.getElementById('training-modal');
            const courseId = modal.getAttribute('data-course-id');
            
            if (!courseId) {
                console.error('No course ID found');
                return;
            }

            enrollInCourse(courseId);
        });
    }

    document.querySelectorAll('.thmb_enrll label').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const card = this.closest('.training-card');
            if (card) {
                const courseId = card.dataset.courseId;
                enrollInCourse(courseId);
            }
        });
    });
});

function showSwalNotification(type, title, message) {
    const iconMap = {
        'success': 'success',
        'error': 'error',
        'info': 'info',
        'warning': 'warning'
    };

    Swal.fire({
        icon: iconMap[type] || 'info',
        title: title,
        text: message,
        timer: 7000,
        showConfirmButton: false,
        position: 'top-end',
        toast: true,
        background: type === 'error' ? '#ffebee' : '#e8f5e9',
        timerProgressBar: true
    });
}

function enrollInCourse(courseId) {
    fetch('/courses/enroll', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ course_id: courseId })
    })
    .then(async response => {
        const data = await response.json();
        
        if (data.success) {
            showSwalNotification('success', 'Success', data.message);
            updateEnrollmentUI(courseId);
            closeModal();
            refreshMyTrainings();
        } else {
            showSwalNotification('error', 'Error', data.message);
        }
    })
    .catch(error => {
        console.error('Enrollment error:', error);
        showSwalNotification('error', 'Error', 'An error occurred during enrollment');
    });
}

function refreshMyTrainings() {
    fetch('/dashboard')
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newContent = doc.querySelector('.my_learnings');
            if (newContent) {
                document.querySelector('.my_learnings').innerHTML = newContent.innerHTML;
            }
        })
        .catch(error => {
            console.error('Error updating trainings:', error);
            showSwalNotification('error', 'Error', 'Could not refresh trainings.');
        });
}

function updateEnrollmentUI(courseId) {
    document.querySelectorAll(`.training-card[data-course-id="${courseId}"] .thmb_enrll label`).forEach(btn => {
        btn.textContent = 'Enrolled';
        btn.classList.add('enrolled');
        btn.style.backgroundColor = '#062644';
        btn.style.cursor = 'default';
    });

    const modal = document.getElementById('training-modal');
    if (modal && modal.style.display === 'block') {
        const modalCourseId = modal.getAttribute('data-course-id');
        if (modalCourseId === courseId) {
            const modalEnrollBtn = document.getElementById('enroll-btn');
            if (modalEnrollBtn) {
                modalEnrollBtn.textContent = 'Enrolled';
                modalEnrollBtn.style.backgroundColor = '#062644';
                modalEnrollBtn.style.cursor = 'default';
            }
        }
    }
}