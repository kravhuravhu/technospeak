document.addEventListener("DOMContentLoaded", function () {
    const container = document.querySelector(".main_block");
    const slides = Array.from(container.children);
    const slideCount = slides.length;
    const slideWidth = container.clientWidth;

    const dotContainer = document.querySelector(".dot_container");
    const dots = dotContainer.querySelectorAll(".dot");

    const firstSlideClone = slides[0].cloneNode(true);
    container.appendChild(firstSlideClone);
    slides.push(firstSlideClone);

    let index = 0;

    function updateDots(activeIndex) {
        dots.forEach((dot, i) => {
            dot.classList.toggle("active", i === activeIndex);
        });
    }

    updateDots(index);
    animateHeaderText(slides[index]);

    // Auto scroll
    setInterval(() => {
        index++;
        container.scrollTo({
            left: slideWidth * index,
            behavior: 'smooth'
        });
    
        if (index === slideCount) {
            setTimeout(() => {
                container.scrollTo({
                    left: 0,
                    behavior: 'instant'
                });
                index = 0;
                updateDots(index);
                resetAllHeaderAnimations();
                animateHeaderText(slides[index]);
            }, 500);
        } else {
            updateDots(index);
            resetAllHeaderAnimations();
            animateHeaderText(slides[index]);
        }
    
    }, 5000);  
    
    // Make dots clickable
    dots.forEach((dot, dotIndex) => {
        dot.addEventListener('click', () => {
            index = dotIndex;
            container.scrollTo({
                left: slideWidth * index,
                behavior: 'smooth'
            });
            updateDots(index);
            resetAllHeaderAnimations();
            animateHeaderText(slides[index]);
        });
    });
    
    // Sync on manual scroll
    container.addEventListener("scroll", () => {
        let scrollLeft = container.scrollLeft;
        let currentSlide = Math.round(scrollLeft / slideWidth);
        if (currentSlide === slideCount) {
            updateDots(0);
            animateHeaderText(slides[0]);
        } else {
            updateDots(currentSlide);
            animateHeaderText(slides[currentSlide]);
            index = currentSlide;
        }
    });

    // make the text drop-in work for each slide
    function animateHeaderText(slide) {
        const ani_header = slide.querySelector('.header h3');
        if (!ani_header || ani_header.dataset.animated === "true") return;

        const ani_text = ani_header.textContent;
        ani_header.textContent = '';
        ani_header.dataset.animated = "true";

        ani_text.split('').forEach((char, i) => {
            const span = document.createElement('span');
            span.textContent = char === ' ' ? '\u00A0' : char;
            span.style.display = 'inline-block';
            span.style.animation = 'ani_header_drop 0.5s ease forwards';
            span.style.animationDelay = `${i * 0.1}s`;
            ani_header.appendChild(span);
        });
    }

    // reset the slides header animation
    function resetAllHeaderAnimations() {
        slides.forEach(slide => {
            const header = slide.querySelector('.header h3');
            if (header) header.removeAttribute('data-animated');
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const cardsContainer = document.querySelector(".cards");
    const cards = Array.from(cardsContainer.children);
    const wrapper = document.querySelector(".cards-wrapper");
    const prevBtn = document.querySelector(".arrow-btn-prev");
    const nextBtn = document.querySelector(".arrow-btn-next");
    
    const centerPosition = Math.floor(cards.length / 2);
    let currentIndex = centerPosition;
    
    function updateView() {
        const card = cards[0];
        const cardWidth = card.offsetWidth;
        const cardMargin = window.innerWidth <= 768 ? 20 : 55;
        const totalWidth = cardWidth + cardMargin * 2;
        
        // Adjust the percentage for mobile
        const translatePercentage = window.innerWidth <= 768 ? 50 : 47.65;
        const transformValue = `translateX(calc(${translatePercentage}% - ${totalWidth * currentIndex + cardWidth/2}px))`;
        cardsContainer.style.transform = transformValue;
        
        cards.forEach((card, index) => {
            card.classList.remove("prev", "next", "active");
            
            if (index === currentIndex - 1) card.classList.add("prev");
            else if (index === currentIndex + 1) card.classList.add("next");
            else if (index === currentIndex) card.classList.add("active");
        });
        
        prevBtn.disabled = currentIndex === 0;
        nextBtn.disabled = currentIndex === cards.length - 1;
    }
    
    // Handle window resize
    window.addEventListener('resize', updateView);
    
    prevBtn.addEventListener("click", () => {
        if (currentIndex > 0) {
            currentIndex--;
            updateView();
        }
    });
    
    nextBtn.addEventListener("click", () => {
        if (currentIndex < cards.length - 1) {
            currentIndex++;
            updateView();
        }
    });
    
    // Clicking on side cards
    cards.forEach((card, index) => {
        card.addEventListener("click", () => {
            if (index === currentIndex - 1 || index === currentIndex + 1) {
                currentIndex = index;
                updateView();
            }
        });
    });
    
    // Initialize
    updateView();
});