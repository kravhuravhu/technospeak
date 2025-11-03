document.addEventListener('DOMContentLoaded', function() {
    function filterCourses(searchInput, filterSelect, container, moreContainer, noResultsElement) {
        const searchTerm = searchInput.value.trim().toLowerCase();
        const filterValue = filterSelect.value.toLowerCase();

        let allCards = [];

        if (container) allCards = Array.from(container.querySelectorAll('.training-card'));
        if (moreContainer && !moreContainer.classList.contains('hidden')) {
            allCards = allCards.concat(Array.from(moreContainer.querySelectorAll('.training-card')));
        }

        let visibleCount = 0;

        allCards.forEach(card => {
            const title = card.getAttribute('data-title').toLowerCase();
            const description = card.getAttribute('data-description').toLowerCase();
            const category = card.getAttribute('data-category').toLowerCase();

            const cleanText = (text) => text.replace(/[\s\W_]+/g, '');

            const cleanTitle = cleanText(title);
            const cleanDescription = cleanText(description);

            const searchWords = searchTerm.split(/\s+/).filter(Boolean);

            const matchesSearch = searchWords.every(word => {
                const cleaned = cleanText(word);
                const regex = new RegExp(cleaned.split('').join('.*?'), 'i');
                return regex.test(cleanTitle) || regex.test(cleanDescription);
            });

            const matchesFilter = !filterValue || category === filterValue;

            card.style.display = (searchTerm === '' || matchesSearch) && matchesFilter ? 'block' : 'none';
            if ((searchTerm === '' || matchesSearch) && matchesFilter) visibleCount++;
        });

        if (noResultsElement) {
            noResultsElement.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }

    const sections = [
        {
            search: document.getElementById('tipsSearchInput'),
            filter: document.getElementById('tipsFilterSelect'),
            container: document.getElementById('tips-trainings'),
            moreContainer: null,
            noResults: document.getElementById('courseNoResultsMessageTips')
        },
        {
            search: document.getElementById('formalSearchInput'),
            filter: document.getElementById('formalFilterSelect'),
            container: document.getElementById('formal-trainings'),
            moreContainer: null,
            noResults: document.getElementById('courseNoResultsMessageFormal')
        }
    ];

    sections.forEach(section => {
        if (section.search && section.filter) {
            section.search.addEventListener('input', () => {
                filterCourses(section.search, section.filter, section.container, section.moreContainer, section.noResults);
            });
            section.filter.addEventListener('change', () => {
                filterCourses(section.search, section.filter, section.container, section.moreContainer, section.noResults);
            });

            filterCourses(section.search, section.filter, section.container, section.moreContainer, section.noResults);
        }
    });

    const toggleButtons = [
        { buttonId: 'toggle-free', containerId: 'more-free-trainings' },
        { buttonId: 'toggle-paid', containerId: 'more-paid-trainings' },
        { buttonId: 'toggle-formal', containerId: 'more-formal-trainings' }
    ];

    toggleButtons.forEach(toggle => {
        const btn = document.getElementById(toggle.buttonId);
        const moreContainer = document.getElementById(toggle.containerId);

        if (btn && moreContainer) {
            btn.addEventListener('click', function() {
                moreContainer.classList.toggle('hidden');
                this.textContent = moreContainer.classList.contains('hidden') ? 'More Trainings' : 'Show Less';
            });
        }
    });
});
