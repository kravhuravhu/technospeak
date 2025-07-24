document.addEventListener('DOMContentLoaded', function() {
    const freeSearchInput = document.getElementById('freeSearchInput');
    const freeFilterSelect = document.getElementById('freeFilterSelect');
    const freeTrainingsContainer = document.getElementById('free-trainings');
    const moreFreeTrainingsContainer = document.getElementById('more-free-trainings');
    const noResultsFree = document.getElementById('courseNoResultsMessageFree');
    
    const paidSearchInput = document.getElementById('paidSearchInput');
    const paidFilterSelect = document.getElementById('paidFilterSelect');
    const paidTrainingsContainer = document.getElementById('paid-trainings');
    const morePaidTrainingsContainer = document.getElementById('more-paid-trainings');
    const noResultsPaid = document.getElementById('courseNoResultsMessagePaid');

    function filterCourses(searchInput, filterSelect, container, moreContainer, noResultsElement) {
        const searchTerm = searchInput.value.toLowerCase();
        const filterValue = filterSelect.value.toLowerCase();
        
        let allCards = [];

        if (container) {
            const cards = container.querySelectorAll('.training-card');
            if (cards.length > 0) {
                allCards = Array.from(cards);
            }
        }
        
        if (moreContainer && !moreContainer.classList.contains('hidden')) {
            const moreCards = moreContainer.querySelectorAll('.training-card');
            if (moreCards.length > 0) {
                allCards = allCards.concat(Array.from(moreCards));
            }
        }
        
        let visibleCount = 0;
        
        allCards.forEach(card => {
            const title = card.getAttribute('data-title').toLowerCase();
            const description = card.getAttribute('data-description').toLowerCase();
            const category = card.getAttribute('data-category').toLowerCase();
            
            const matchesSearch = title.includes(searchTerm) || description.includes(searchTerm);
            const matchesFilter = filterValue === '' || category === filterValue;
            
            if (matchesSearch && matchesFilter) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        if (noResultsElement) {
            noResultsElement.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }

    if (freeSearchInput && freeFilterSelect) {
        freeSearchInput.addEventListener('input', () => {
            filterCourses(freeSearchInput, freeFilterSelect, freeTrainingsContainer, moreFreeTrainingsContainer, noResultsFree);
        });
        
        freeFilterSelect.addEventListener('change', () => {
            filterCourses(freeSearchInput, freeFilterSelect, freeTrainingsContainer, moreFreeTrainingsContainer, noResultsFree);
        });
        
        filterCourses(freeSearchInput, freeFilterSelect, freeTrainingsContainer, moreFreeTrainingsContainer, noResultsFree);
    }

    if (paidSearchInput && paidFilterSelect) {
        paidSearchInput.addEventListener('input', () => {
            filterCourses(paidSearchInput, paidFilterSelect, paidTrainingsContainer, morePaidTrainingsContainer, noResultsPaid);
        });
        
        paidFilterSelect.addEventListener('change', () => {
            filterCourses(paidSearchInput, paidFilterSelect, paidTrainingsContainer, morePaidTrainingsContainer, noResultsPaid);
        });
    }

    const toggleFree = document.getElementById('toggle-free');
    const togglePaid = document.getElementById('toggle-paid');

    if (toggleFree) {
        toggleFree.addEventListener('click', function() {
            const moreFree = document.getElementById('more-free-trainings');
            if (moreFree) {
                moreFree.classList.toggle('hidden');
                this.textContent = moreFree.classList.contains('hidden') ? 'More Free Trainings' : 'Show Less';
            }
        });
    }

    if (togglePaid) {
        togglePaid.addEventListener('click', function() {
            const morePaid = document.getElementById('more-paid-trainings');
            if (morePaid) {
                morePaid.classList.toggle('hidden');
                this.textContent = morePaid.classList.contains('hidden') ? 'More Trainings' : 'Show Less';
            }
        });
    }
});