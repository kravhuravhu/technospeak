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
        const transformValue = `translateX(calc(${translatePercentage}% - ${totalWidth * currentIndex + cardWidth/2}px - 20px))`;
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
  
  // Set first service as active by default
  if (serviceCards.length > 0) {
    activateService(serviceCards[0].dataset.service);
    serviceCards[0].classList.add('active');
  }
  
  // Add click event to all service cards
  serviceCards.forEach(card => {
    card.addEventListener('click', function() {
      const serviceType = this.dataset.service;
      
      // Remove active class from all cards
      serviceCards.forEach(c => c.classList.remove('active'));
      
      // Add active class to clicked card
      this.classList.add('active');
      
      // Update details
      activateService(serviceType);
    });
  });
  
  // Function to activate a service
  function activateService(serviceType) {
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
          <button class="details-btn">
            <span>Need Assistance?</span>
            <div class="btn-arrow">→</div>
          </button>
        </div>
      `;
      
      // Add event listener to the new button
      const newButton = detailsContainer.querySelector('.details-btn');
      if (newButton) {
        newButton.addEventListener('click', function() {
          // Add your button click logic here
          console.log(`Requesting assistance for: ${serviceType}`);
          // You can redirect to a contact form or show a modal
        });
      }
    }
  }
  
  // Add hover effects for desktop
  if (window.innerWidth > 768) {
    serviceCards.forEach(card => {
      card.addEventListener('mouseenter', function() {
        if (!this.classList.contains('active')) {
          this.style.transform = 'translateY(-5px)';
        }
      });
      
      card.addEventListener('mouseleave', function() {
        if (!this.classList.contains('active')) {
          this.style.transform = 'translateY(0)';
        }
      });
    });
  }
});