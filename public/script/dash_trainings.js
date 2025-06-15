// Sample training data with episodes
const freeTrainings = [
    {
        id: 1,
        title: "Introduction to Digital Marketing",
        description: "Learn the fundamentals of digital marketing including SEO, social media, and content marketing. This comprehensive course will take you from beginner to confident practitioner with hands-on projects and real-world examples.",
        image: "/images/teams/group_lab.jpeg",
        duration: "4 weeks",
        level: "Beginner",
        instructor: "Sarah Johnson",
        category: "Marketing",
        episodes: [
            { number: 1, name: "Introduction to Digital Marketing", duration: "15 min" },
            { number: 2, name: "Understanding SEO Basics", duration: "22 min" },
            { number: 3, name: "Social Media Marketing Strategies", duration: "18 min" },
            { number: 4, name: "Content Marketing Fundamentals", duration: "20 min" },
            { number: 5, name: "Email Marketing Techniques", duration: "16 min" },
            { number: 6, name: "Google Analytics Overview", duration: "25 min" },
            { number: 7, name: "PPC Advertising Basics", duration: "19 min" },
            { number: 8, name: "Creating a Digital Marketing Plan", duration: "30 min" }
        ],
        time: "3h 45min"
    },
    {
        id: 2,
        title: "Python for Beginners",
        description: "Start your programming journey with this comprehensive Python course for absolute beginners. Learn syntax, data structures, and problem-solving techniques through practical exercises.",
        image: "https://source.unsplash.com/random/400x300/?python,code",
        duration: "6 weeks",
        level: "Beginner",
        instructor: "Michael Chen",
        category: "Programming",
        episodes: [
            { number: 1, name: "Python Installation & Setup", duration: "12 min" },
            { number: 2, name: "Variables and Data Types", duration: "18 min" },
            { number: 3, name: "Conditional Statements", duration: "20 min" },
            { number: 4, name: "Loops and Iterations", duration: "25 min" },
            { number: 5, name: "Functions in Python", duration: "22 min" },
            { number: 6, name: "Working with Lists", duration: "15 min" },
            { number: 7, name: "Dictionaries and Tuples", duration: "18 min" },
            { number: 8, name: "File Handling Basics", duration: "20 min" }
        ],
        time: "5h 30min"
    }
];

const paidTrainings = [
    {
        id: 101,
        title: "Advanced Data Science",
        description: "Master machine learning algorithms, data visualization, and statistical analysis with Python. This course includes hands-on projects with real datasets to build your portfolio.",
        image: "https://source.unsplash.com/random/400x300/?data,science",
        duration: "10 weeks",
        level: "Advanced",
        instructor: "Dr. Alan Turing",
        category: "Data Science",
        price: "$199",
        episodes: [
            { number: 1, name: "Advanced Pandas Techniques", duration: "35 min" },
            { number: 2, name: "Data Visualization with Seaborn", duration: "40 min" },
            { number: 3, name: "Statistical Analysis Fundamentals", duration: "45 min" },
            { number: 4, name: "Machine Learning Introduction", duration: "50 min" },
            { number: 5, name: "Supervised Learning Algorithms", duration: "55 min" },
            { number: 6, name: "Unsupervised Learning Techniques", duration: "45 min" },
            { number: 7, name: "Neural Networks Basics", duration: "60 min" },
            { number: 8, name: "Model Evaluation Methods", duration: "40 min" }
        ],
        time: "15h 20min"
    },
    {
        id: 102,
        title: "Complete Web Development Bootcamp",
        description: "Become a full-stack developer with HTML, CSS, JavaScript, React, Node.js and MongoDB. Build 5 real-world projects to showcase in your portfolio.",
        image: "https://source.unsplash.com/random/400x300/?web,development",
        duration: "12 weeks",
        level: "Intermediate",
        instructor: "Angela Yu",
        category: "Web Development",
        price: "$249",
        episodes: [
            { number: 1, name: "HTML5 Fundamentals", duration: "30 min" },
            { number: 2, name: "CSS3 and Responsive Design", duration: "45 min" },
            { number: 3, name: "JavaScript Basics", duration: "50 min" },
            { number: 4, name: "DOM Manipulation", duration: "40 min" },
            { number: 5, name: "React Introduction", duration: "55 min" },
            { number: 6, name: "Node.js and Express", duration: "60 min" },
            { number: 7, name: "MongoDB and Databases", duration: "45 min" },
            { number: 8, name: "Building RESTful APIs", duration: "50 min" }
        ],
        time: "20h 45min"
    }
];

// DOM elements
const freeTrainingsContainer = document.getElementById('free-trainings');
const moreFreeTrainingsContainer = document.getElementById('more-free-trainings');
const paidTrainingsContainer = document.getElementById('paid-trainings');
const morePaidTrainingsContainer = document.getElementById('more-paid-trainings');
const toggleFreeBtn = document.getElementById('toggle-free');
const togglePaidBtn = document.getElementById('toggle-paid');
const modal = document.getElementById('training-modal');
const closeBtn = document.querySelector('.close-btn');
const episodeList = document.getElementById('episode-list');

// Render training cards
function renderTrainings() {
    // Clear containers
    freeTrainingsContainer.innerHTML = '';
    moreFreeTrainingsContainer.innerHTML = '';
    paidTrainingsContainer.innerHTML = '';
    morePaidTrainingsContainer.innerHTML = '';
    
    // Render first 4 free trainings
    freeTrainings.slice(0, 4).forEach(training => {
        freeTrainingsContainer.appendChild(createTrainingCard(training, true));
    });
    
    // Render remaining free trainings
    freeTrainings.slice(4).forEach(training => {
        moreFreeTrainingsContainer.appendChild(createTrainingCard(training, true));
    });
    
    // Render first 4 paid trainings
    paidTrainings.slice(0, 4).forEach(training => {
        paidTrainingsContainer.appendChild(createTrainingCard(training, false));
    });
    
    // Render remaining paid trainings
    paidTrainings.slice(4).forEach(training => {
        morePaidTrainingsContainer.appendChild(createTrainingCard(training, false));
    });
    
    // Hide toggle buttons if there are no more trainings to show
    if (freeTrainings.length <= 4) {
        toggleFreeBtn.style.display = 'none';
    }
    
    if (paidTrainings.length <= 4) {
        togglePaidBtn.style.display = 'none';
    }
}

// Create a training card element
function createTrainingCard(training, isFree) {
    const cardLink = document.createElement('a');
    cardLink.href = '#';
    cardLink.addEventListener('click', (e) => {
        e.preventDefault();
        showTrainingDetails(training, isFree);
    });
    
    cardLink.innerHTML = `
        <div class="card rcmmd_cd">
            <div class="thmbnail thn_rcmm">
                <div class="trnsprnt thmb_img">
                    <img src="${training.image}" alt="${training.title}">
                </div>
            </div>
            <div class="details thmb_dt">
                <div class="title content thmb_cnt">
                    <h1 class="thmb_h1">${training.title}</h1>
                </div>
                <div class="ctprs content thmb_cnt">
                    <p class="thmb_ct">${training.description.substring(0, 60)}...</p>
                </div>
                <div class="thmb_dur_ep_container content thmb_cnt">
                    <div class="cont left-side">
                        <i class="fa-solid fa-stopwatch"></i>
                        <span>${training.time}</span>
                    </div>
                    <div class="cont right-side">
                        <i class="fa-solid fa-video"></i>
                        <span>${training.episodes.length} Episodes</span>
                    </div>
                </div>
                <div class="thmb_enrll content">
                    <label>${isFree ? 'Enroll Free' : training.price}</label>
                </div>
            </div>
        </div>
    `;
    
    return cardLink;
}

// Show training details in modal
function showTrainingDetails(training, isFree) {
    document.getElementById('modal-title').textContent = training.title;
    document.getElementById('modal-price').textContent = isFree ? 'Free' : training.price;
    document.getElementById('modal-image').src = training.image;
    document.getElementById('modal-image').alt = training.title;
    document.getElementById('modal-description').textContent = training.description;
    document.getElementById('modal-duration').textContent = training.duration;
    document.getElementById('modal-level').textContent = training.level;
    document.getElementById('modal-instructor').textContent = training.instructor;
    document.getElementById('modal-category').textContent = training.category;
    
    // Clear previous episodes
    episodeList.innerHTML = '';
    
    // Add episodes to the list
    training.episodes.forEach(episode => {
        const episodeItem = document.createElement('li');
        episodeItem.className = 'episode-item';
        episodeItem.innerHTML = `
            <span class="episode-number">${episode.number}</span>
            <span class="episode-name">${episode.name}</span>
            <span class="episode-duration">${episode.duration}</span>
        `;
        episodeList.appendChild(episodeItem);
    });
    
    // Set enroll button text based on free/paid
    const enrollBtn = document.getElementById('enroll-btn');
    enrollBtn.textContent = isFree ? 'Enroll Now' : 'Buy Now';
    enrollBtn.style.backgroundColor = isFree ? '#38b6ff' : '#2ecc71';
    
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
}

// Close modal
function closeModal() {
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Event listeners
toggleFreeBtn.addEventListener('click', () => {
    moreFreeTrainingsContainer.classList.toggle('hidden');
    toggleFreeBtn.textContent = moreFreeTrainingsContainer.classList.contains('hidden') 
        ? 'More Free Trainings' 
        : 'Show Less';
});

togglePaidBtn.addEventListener('click', () => {
    morePaidTrainingsContainer.classList.toggle('hidden');
    togglePaidBtn.textContent = morePaidTrainingsContainer.classList.contains('hidden') 
        ? 'More Trainings' 
        : 'Show Less';
});

closeBtn.addEventListener('click', closeModal);

// Close modal when clicking outside
window.addEventListener('click', (e) => {
    if (e.target === modal) {
        closeModal();
    }
});

// Initialize the page
renderTrainings();