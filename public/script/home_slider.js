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
    
    }, 13000);  
    
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

        ani_text.split(' ').forEach((word, i) => {
            const wordSpan = document.createElement('span');
            wordSpan.textContent = word;
            wordSpan.style.display = 'inline-block';
            wordSpan.style.transform = 'translateY(-100%)';
            wordSpan.style.opacity = 0;
            wordSpan.style.animation = 'ani_header_drop 0.5s ease forwards';
            wordSpan.style.animationDelay = `${i * 0.2}s`;
            ani_header.appendChild(wordSpan);

            ani_header.appendChild(document.createTextNode(' '));
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

// Product Plans script section
document.addEventListener("DOMContentLoaded", function () {
    const cardsContainer = document.querySelector(".cards");
    if (!cardsContainer) return;

    const cards = Array.from(cardsContainer.children);
    const prevBtn = document.querySelector(".arrow-btn-prev");
    const nextBtn = document.querySelector(".arrow-btn-next");

    // Only proceed if essential elements exist
    if (!prevBtn || !nextBtn) return;

    // Create clones for infinite loop
    const firstCardClone = cards[0].cloneNode(true);
    const lastCardClone = cards[cards.length - 1].cloneNode(true);

    firstCardClone.classList.add('clone-card');
    lastCardClone.classList.add('clone-card');

    cardsContainer.appendChild(firstCardClone);
    cardsContainer.insertBefore(lastCardClone, cards[0]);

    const allCards = Array.from(cardsContainer.children);
    const totalCards = allCards.length;

    let currentIndex = 1;
    let isAnimating = false;
    let autoSlideInterval;
    let startX = 0;
    let currentX = 0;

    function calculateTransform() {
        const card = allCards[0];
        if (!card) return 'translateX(0)';

        const cardWidth = card.offsetWidth;
        const cardMargin = getCardMargin();
        const totalWidth = cardWidth + cardMargin * 2;
        
        // Always center the active card
        const containerWidth = cardsContainer.parentElement.offsetWidth;
        const centerOffset = containerWidth / 2;
        const cardCenter = totalWidth * currentIndex + cardWidth / 2;
        
        return `translateX(calc(50% - ${cardCenter}px))`;
    }

    function getCardMargin() {
        if (window.innerWidth <= 400) return 2;
        if (window.innerWidth <= 480) return 3;
        if (window.innerWidth <= 576) return 4;
        if (window.innerWidth <= 768) return 6;
        if (window.innerWidth <= 992) return 8;
        if (window.innerWidth <= 1200) return 10;
        return 15;
    }

    function updateView(animate = true) {
        if (isAnimating && animate) return;

        const transformValue = calculateTransform();

        if (animate) {
            isAnimating = true;
            cardsContainer.style.transition = "transform 0.6s cubic-bezier(0.25, 0.8, 0.25, 1)";
        } else {
            cardsContainer.style.transition = "none";
        }

        cardsContainer.style.transform = transformValue;

        // Update card classes for styling
        updateCardClasses();
    }

    function updateCardClasses() {
        allCards.forEach((card, index) => {
            if (!card.classList) return;
            
            card.classList.remove("prev", "next", "active");
            
            if (index === currentIndex - 1) {
                card.classList.add("prev");
            } else if (index === currentIndex + 1) {
                card.classList.add("next");
            } else if (index === currentIndex) {
                card.classList.add("active");
            }
        });
    }

    function nextSlide() {
        if (isAnimating) return;
        currentIndex++;
        updateView(true);
    }

    function prevSlide() {
        if (isAnimating) return;
        currentIndex--;
        updateView(true);
    }

    function handleTransitionEnd() {
        // Handle infinite loop
        if (currentIndex === 0) {
            cardsContainer.style.transition = "none";
            currentIndex = totalCards - 2;
            updateView(false);
        } else if (currentIndex === totalCards - 1) {
            cardsContainer.style.transition = "none";
            currentIndex = 1;
            updateView(false);
        }
        isAnimating = false;
    }

    // Touch events for mobile swipe
    function handleTouchStart(e) {
        startX = e.touches[0].clientX;
        currentX = startX;
    }

    function handleTouchMove(e) {
        if (!isAnimating) {
            currentX = e.touches[0].clientX;
        }
    }

    function handleTouchEnd() {
        const diff = startX - currentX;
        const swipeThreshold = 50;

        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                nextSlide();
            } else {
                prevSlide();
            }
            resetAutoSlide();
        }
    }

    // Event listeners
    cardsContainer.addEventListener("transitionend", handleTransitionEnd);
    
    window.addEventListener("resize", () => {
        updateView(false);
    });

    prevBtn.addEventListener("click", () => {
        prevSlide();
        resetAutoSlide();
    });
    
    nextBtn.addEventListener("click", () => {
        nextSlide();
        resetAutoSlide();
    });

    // Card click navigation
    allCards.forEach((card, index) => {
        card.addEventListener("click", (e) => {
            // Prevent triggering when clicking buttons inside cards
            if (e.target.tagName === 'A' || e.target.tagName === 'BUTTON') return;
            
            if (index === currentIndex - 1) prevSlide();
            else if (index === currentIndex + 1) nextSlide();
            resetAutoSlide();
        });
    });

    // Touch events for mobile
    cardsContainer.addEventListener('touchstart', handleTouchStart, { passive: true });
    cardsContainer.addEventListener('touchmove', handleTouchMove, { passive: true });
    cardsContainer.addEventListener('touchend', handleTouchEnd, { passive: true });

    // Keyboard navigation
    document.addEventListener("keydown", (e) => {
        if (e.key === "ArrowLeft") {
            prevSlide();
            resetAutoSlide();
        } else if (e.key === "ArrowRight") {
            nextSlide();
            resetAutoSlide();
        }
    });

    // Auto-slide functionality (optional - commented out by default)
    function startAutoSlide() {
        // Uncomment if you want auto-sliding
        /*
        autoSlideInterval = setInterval(() => {
            nextSlide();
        }, 5000);
        */
    }

    function resetAutoSlide() {
        clearInterval(autoSlideInterval);
        startAutoSlide();
    }

    // Initialize
    updateView(false);
    startAutoSlide();

    // Cleanup function for when the page is unloaded
    window.addEventListener('beforeunload', () => {
        clearInterval(autoSlideInterval);
    });
});

// Service Categories section
const services = {
    design: {
        icon: "🎨",
        title: "Bring Your Ideas to Life with Stunning Designs",
        content: `
            <p>We provide a full spectrum of design services tailored to your business or personal needs. From eye-catching logos, professional business cards, and polished brochures to posters, flyers, and social media graphics, we deliver ready-to-use, high-quality visuals.</p>
            <p>Every design is crafted with your brand and audience in mind—no learning, no trial-and-error. You receive professional results, ready for print or online publication, helping your brand make a lasting impression instantly.</p>
            <p class="highlight">✨ Ready to stand out? Let us create your next masterpiece today!</p>
        `
    },
    ai: {
        icon: "🤖",
        title: "AI Content Creation Made Simple & Effective",
        content: `
            <p>Unlock powerful AI-driven tools for generating blog posts, ad copy, social media captions, and more—customized for your brand's tone and audience. Our AI solutions help you create engaging content that resonates with your target market.</p>
            <p>Save hours of effort while delivering professional, SEO-optimized content at scale. From ideation to publication, we streamline the entire content creation process.</p>
            <p class="highlight">🚀 Transform your content strategy with AI-powered solutions!</p>
        `
    },
    office: {
        icon: "📊",
        title: "Simplify Your Office Admin with Smart ICT Solutions",
        content: `
            <p>We streamline office tasks with comprehensive ICT solutions—document management, automated reporting, efficient data entry, and workflow automation. Our services are designed to reduce manual effort and minimize errors.</p>
            <p>With our office administration support, you can focus on business growth while we handle the operational details. We implement systems that improve productivity and organization.</p>
            <p class="highlight">📈 Boost efficiency with our office automation solutions!</p>
        `
    },
    support: {
        icon: "🔧",
        title: "Reliable Technical Support & Maintenance Services",
        content: `
            <p>From troubleshooting to preventive maintenance, we keep your systems running smoothly. Our technical support covers hardware, software, network issues, and regular system updates.</p>
            <p>We provide reliable IT support that ensures less downtime and more productivity. With proactive monitoring and quick response times, we prevent problems before they affect your business.</p>
            <p class="highlight">🛡️ Keep your systems secure and operational with our expert support!</p>
        `
    },
    web: {
        icon: "💻",
        title: "Custom Web & App Programming Solutions",
        content: `
            <p>We build responsive websites and user-centered applications, tailored to your specific needs. Our development services include front-end and back-end programming, database design, and API integrations.</p>
            <p>Whether you need a simple website, complex web application, or mobile app, we deliver fast, secure, and scalable coding solutions that drive your digital presence forward.</p>
            <p class="highlight">🌐 Create powerful digital experiences with our development expertise!</p>
        `
    },
    network: {
        icon: "🌐",
        title: "Networking & Internet Essentials for Modern Businesses",
        content: `
            <p>Optimize your network with expert setup, configuration, and monitoring services. We ensure secure, fast, and reliable internet connectivity for your business operations.</p>
            <p>Our networking solutions include Wi-Fi setup, router configuration, network security, VPN implementation, and ongoing maintenance to keep your connections stable and secure.</p>
            <p class="highlight">⚡ Experience seamless connectivity with our networking expertise!</p>
        `
    },
    marketing: {
        icon: "📢",
        title: "Digital Marketing & Social Media Strategies That Convert",
        content: `
            <p>Grow your brand online with targeted social campaigns, SEO optimization, email marketing funnels, and analytics-driven strategies that deliver measurable results.</p>
            <p>We develop comprehensive digital marketing plans that increase your visibility, engage your audience, and convert followers into customers. From content strategy to performance analytics, we handle it all.</p>
            <p class="highlight">📈 Drive growth with our result-oriented marketing strategies!</p>
        `
    }
};

// Initialize Service Categories
document.addEventListener('DOMContentLoaded', function() {
    const serviceCards = document.querySelectorAll('.service-card');
    const detailsContainer = document.getElementById('service-details');
    let isMobile = window.innerWidth <= 768;
    
    // Set first service as active by default on desktop
    if (!isMobile && serviceCards.length > 0) {
        activateServiceDesktop(serviceCards[0].dataset.service);
        serviceCards[0].classList.add('active');
    }
    
    // Click event to all service cards
    serviceCards.forEach(card => {
        card.addEventListener('click', function() {
            const serviceType = this.dataset.service;
            
            if (isMobile) {
                // Mobile behavior - toggle accordion
                toggleMobileService(this, serviceType);
            } else {
                // Desktop behavior - update details panel
                serviceCards.forEach(c => c.classList.remove('active'));
                this.classList.add('active');
                activateServiceDesktop(serviceType);
            }
        });
    });
    
    // Function to activate a service on desktop
    function activateServiceDesktop(serviceType) {
        const service = services[serviceType];

        if (service) {
            detailsContainer.innerHTML = `
                <div class="details-content">
                    <div class="details-header">
                        <div class="details-icon">${service.icon}</div>
                        <h3>${service.title}</h3>
                    </div>
                    <div class="details-text">
                        ${service.content}
                    </div>
                </div>
            `;
        }
    }
    
    // Function to toggle mobile service details
    function toggleMobileService(card, serviceType) {
        const service = services[serviceType];
        
        // Check if this card is already active
        const isActive = card.classList.contains('mobile-active');
        
        // Remove active class and hide all details
        document.querySelectorAll('.service-card').forEach(c => {
            c.classList.remove('mobile-active');
        });
        document.querySelectorAll('.mobile-service-details').forEach(detail => {
            detail.remove();
        });
        
        // If it wasn't active, show the details for this card
        if (!isActive) {
            card.classList.add('mobile-active');
            
            // Create details element
            const detailsElement = document.createElement('div');
            detailsElement.className = 'mobile-service-details';
            detailsElement.innerHTML = `
                <div class="details-header">
                    <div class="details-icon">${service.icon}</div>
                    <h3>${service.title}</h3>
                </div>
                <div class="details-text">
                    ${service.content}
                </div>
            `;
            
            // Insert after the card
            card.parentNode.insertBefore(detailsElement, card.nextSibling);
        }
    }
    
    // Handle window resize
    window.addEventListener('resize', function() {
        const newIsMobile = window.innerWidth <= 768;
        
        if (isMobile !== newIsMobile) {
            // Clear any mobile details if switching to desktop
            if (!newIsMobile) {
                document.querySelectorAll('.mobile-service-details').forEach(detail => {
                    detail.remove();
                });
                document.querySelectorAll('.service-card').forEach(card => {
                    card.classList.remove('mobile-active');
                });
                
                // Reset desktop view
                if (serviceCards.length > 0) {
                    activateServiceDesktop(serviceCards[0].dataset.service);
                    serviceCards[0].classList.add('active');
                }
            }
            
            // Update isMobile for next click
            isMobile = newIsMobile;
        }
    });
});

