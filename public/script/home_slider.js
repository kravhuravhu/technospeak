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
  
    let index = 2;
  
    function updateView() {
        cards.forEach((card, i) => {
            card.classList.remove("prev", "next", "active");
            if (i === index - 1) card.classList.add("prev");
            else if (i === index + 1) card.classList.add("next");
            else if (i === index) card.classList.add("active");
        });
    
        const cardWidth = cards[0].offsetWidth;
        const margin = 75 * 2;
        const scrollX = (cardWidth + margin) * index;
        cardsContainer.style.transform = `translateX(calc(50% - ${scrollX}px))`;
    
        // Disable buttons if at edges
        prevBtn.disabled = index === 0;
        nextBtn.disabled = index === cards.length - 1;
    }
  
    function goToIndex(i) {
        if (i < 0 || i >= cards.length) return;
        index = i;
        updateView();
    }
  
    prevBtn.addEventListener("click", () => {
        if (index > 0) {
            index--;
            updateView();
        }
    });
  
    nextBtn.addEventListener("click", () => {
        if (index < cards.length - 1) {
            index++;
            updateView();
        }
    });
  
    // Clicking on side cards
    cards.forEach((card, i) => {
        card.addEventListener("click", () => {
            if (i === index - 1 || i === index + 1) {
            goToIndex(i);
            }
        });
    });

    updateView();
});
  