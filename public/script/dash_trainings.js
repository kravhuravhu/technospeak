document.addEventListener('DOMContentLoaded', function () {
    const trainingCards = document.querySelectorAll('.training-card');
    const modal = document.getElementById('training-modal');
    const closeBtn = document.querySelector('.close-btn');
    const episodeList = document.getElementById('episode-list');
    const modalTitle = document.getElementById('modal-title-cs');
    const modalPrice = document.getElementById('modal-price');
    const modalImage = document.getElementById('modal-image');
    const modalDescription = document.getElementById('modal-description');
    const modalDuration = document.getElementById('modal-duration');
    const modalLevel = document.getElementById('modal-level');
    const modalInstructor = document.getElementById('modal-instructor');
    const modalCategory = document.getElementById('modal-category');
    const modalEnrollBtn = document.getElementById('enroll-btn');

    // Handle card click to open modal
    trainingCards.forEach(function (card) {
        card.addEventListener('click', function (e) {
            e.preventDefault();

            // Course data
            const courseId = card.dataset.courseId;
            const planType = card.dataset.trainingType;
            const isFormal = planType === 'frml_training';
            const isTips = !isFormal;

            const title = card.dataset.title;
            const description = card.dataset.description;
            const image = card.dataset.image;
            const duration = card.dataset.duration;
            const level = card.dataset.level;
            const instructor = card.dataset.instructor;
            const category = card.dataset.category;
            const price = card.dataset.price;
            const isEnrolled = card.dataset.enrolled === 'true';
            const showLink = card.dataset.showLink || '';
            const watchLink = card.dataset.watchLink || `/enrolled-courses/${courseId}`;

            // Episodes
            let episodes = [];
            try {
                episodes = JSON.parse(card.dataset.episodes || '[]');
            } catch (_) {
                episodes = [];
            }

            // Modal content
            modalTitle.textContent = title;
            modalPrice.textContent = isFormal ? `R${price || ''}` : 'Tips & Tricks';
            modalImage.src = image;
            modalImage.alt = title;
            modalDescription.textContent = description;
            modalDuration.textContent = duration;
            modalLevel.textContent = level;
            modalInstructor.textContent = instructor;
            modalCategory.textContent = category;

            // Episodes list
            episodeList.innerHTML = '';
            episodes.forEach(function (episode) {
                const li = document.createElement('li');
                li.className = 'episode-item';
                li.innerHTML = `
                    <span class="episode-number">${episode.number}</span>
                    <span class="episode-name">${episode.name}</span>
                    <span class="episode-duration">${episode.duration}</span>
                `;
                episodeList.appendChild(li);
            });

            // Modal button state
            if (isEnrolled && showLink) {
                modalEnrollBtn.textContent = isTips ? 'Continue Watching' : 'Open →';
                modalEnrollBtn.href = showLink;
                modalEnrollBtn.classList.add('open-btn');
                modalEnrollBtn.style.backgroundColor = '#062644';
                modalEnrollBtn.removeAttribute('data-enroll');
                modalEnrollBtn.style.cursor = 'pointer';
            } else {
                modalEnrollBtn.textContent = isTips ? 'Watch Now' : 'Enroll Now';
                modalEnrollBtn.href = '#';
                modalEnrollBtn.classList.remove('open-btn');
                modalEnrollBtn.style.backgroundColor = '#38b6ff';
                modalEnrollBtn.setAttribute('data-enroll', 'true');
            }

            // Modal dataset
            modal.setAttribute('data-course-id', courseId);
            modal.setAttribute('data-plan-type', planType);
            modal.setAttribute('data-is-enrolled', String(isEnrolled));
            modal.setAttribute('data-show-link', showLink);

            // Show modal
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        });
    });

    // Close modal
    closeBtn.addEventListener('click', closeModal);
    window.addEventListener('click', function (e) {
        if (e.target === modal) closeModal();
    });

    function closeModal() {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // Modal enroll/watch button
    if (modalEnrollBtn) {
        modalEnrollBtn.addEventListener('click', function (e) {
            const courseId = modal.getAttribute('data-course-id');
            if (!courseId) return console.error('No course ID found');

            const planType = modal.getAttribute('data-plan-type');
            const isFormal = planType === 'frml_training';
            const isEnrolled = modal.getAttribute('data-is-enrolled') === 'true';

            e.preventDefault();

            // processing spinner
            const originalText = modalEnrollBtn.textContent;
            modalEnrollBtn.innerHTML = `Processing <i class="fas fa-spinner fa-spin"></i>`;
            modalEnrollBtn.disabled = true;
            modalEnrollBtn.style.cursor = 'not-allowed';

            enrollInCourse(courseId, modalEnrollBtn, originalText);
        });
    }

    // Card label clicks
    document.querySelectorAll('.thmb_enrll label').forEach(function (labelBtn) {
        labelBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            const card = this.closest('.training-card');
            if (!card) return;

            const courseId = card.dataset.courseId;
            const planType = card.dataset.trainingType;
            const isFormal = planType === 'frml_training';
            const isEnrolled = card.dataset.enrolled === 'true';
            const showLink = card.dataset.showLink || '';
            const watchLink = card.dataset.watchLink || `/enrolled-courses/${courseId}`;

            // formal enroll
            if (isFormal) {
                if (isEnrolled && showLink) {
                    window.location.href = showLink;
                    return;
                }

                // spinner
                labelBtn.disabled = true;
                const originalText = labelBtn.textContent;
                labelBtn.innerHTML = `Processing <i class="fas fa-spinner fa-spin"></i>`;
                labelBtn.style.cursor = 'not-allowed';

                enrollInCourse(courseId, labelBtn, originalText);
                return;
            }

            // tips & Tricks enroll
            if (!isEnrolled) {
                labelBtn.disabled = true;
                const originalText = labelBtn.textContent;
                labelBtn.innerHTML = `Processing <i class="fas fa-spinner fa-spin"></i>`;
                labelBtn.style.cursor = 'not-allowed';

                enrollInCourse(courseId, labelBtn, originalText);
            } else {
                window.location.href = showLink || watchLink;
            }
        });
    });
});

function showSwalNotification(type, title, message) {
    Swal.fire({
        icon: type,
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

// Enroll for all courses
function enrollInCourse(courseId, buttonElement = null, originalText = 'Enroll Now') {
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
        if (response.ok && data.success) {
            showSwalNotification('success', 'Success', data.message || 'Successfully enrolled! Redirecting now...');
            updateEnrollmentUI(courseId, data.open_url);
            closeModal();
            refreshMyTrainings();
            // redirect
            const openRedirectUrl = data.open_url;
            if (openRedirectUrl) {
                setTimeout(() => {
                    window.location.href = openRedirectUrl;
                }, 100);
            }
        } else {
            const openUrl = data.open_url;
            if (openUrl) {
                showSwalNotification('info', 'Already Enrolled', 'Redirecting...');
                setTimeout(() => {
                    window.location.href = openUrl;
                }, 100);
                return;
            }
            showSwalNotification('error', 'Error', data.message || 'Could not enroll');
            if (buttonElement) {
                buttonElement.disabled = false;
                buttonElement.innerHTML = originalText;
                buttonElement.style.cursor = 'pointer';
            }
        }
    })
    .catch(() => {
        showSwalNotification('error', 'Error', 'An error occurred during enrollment');
        if (buttonElement) {
            buttonElement.disabled = false;
            buttonElement.innerHTML = originalText;
            buttonElement.style.cursor = 'pointer';
        }
    });
}

// Refresh My Trainings section
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
        .catch(() => {
            showSwalNotification('error', 'Error', 'Could not refresh trainings.');
        });
}

// update UI after enrollment (modal + card label)
function updateEnrollmentUI(courseId, openUrlFromServer) {
    const courseUUID = courseId;
    const card = document.querySelector(`.training-card[data-course-id="${courseUUID}"]`);
    if (!card) return;

    const openUrl = openUrlFromServer || `/enrolled-courses/${courseUUID}`;
    card.dataset.enrolled = 'true';
    card.dataset.showLink = openUrl;

    const labelBtn = card.querySelector('.thmb_enrll label');
    if (labelBtn) {
        labelBtn.textContent = 'Open →';
        labelBtn.classList.add('open-btn');
        labelBtn.disabled = false;
        labelBtn.style.cursor = 'pointer';

        const newLabelBtn = labelBtn.cloneNode(true);
        labelBtn.parentNode.replaceChild(newLabelBtn, labelBtn);
        newLabelBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            window.location.href = openUrl;
        });
    }

    const modal = document.getElementById('training-modal');
    if (modal.getAttribute('data-course-id') === courseUUID) {
        const modalEnrollBtn = document.getElementById('enroll-btn');
        if (modalEnrollBtn) {
            modalEnrollBtn.textContent = 'Continue Watching';
            modalEnrollBtn.href = openUrl;
            modalEnrollBtn.removeAttribute('data-enroll');
            modalEnrollBtn.classList.add('open-btn');
            modalEnrollBtn.style.backgroundColor = '#062644';
            modalEnrollBtn.style.cursor = 'pointer';
            modalEnrollBtn.disabled = false;
        }
        modal.setAttribute('data-is-enrolled', 'true');
        modal.setAttribute('data-show-link', openUrl);
    }
}