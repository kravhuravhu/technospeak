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
            document.getElementById('modal-title').textContent = title;
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
            
            // Set enroll button
            const enrollBtn = document.getElementById('enroll-btn');
            enrollBtn.textContent = isFree ? 'Enroll Now' : 'Unlock All';
            enrollBtn.style.backgroundColor = isFree ? '#38b6ff' : '#2ecc71';
            
            // Show modal
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

    document.getElementById('toggle-free').addEventListener('click', function() {
        const moreFree = document.getElementById('more-free-trainings');
        moreFree.classList.toggle('hidden');
        this.textContent = moreFree.classList.contains('hidden') ? 'More Free Trainings' : 'Show Less';
    });
    
    document.getElementById('toggle-paid').addEventListener('click', function() {
        const morePaid = document.getElementById('more-paid-trainings');
        morePaid.classList.toggle('hidden');
        this.textContent = morePaid.classList.contains('hidden') ? 'More Trainings' : 'Show Less';
    });
});