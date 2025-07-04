<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Technospeak - About us</title>
        <meta name="author" content="TechnoSpeak">
        <meta property="og:type" content="website">
        <link rel="icon" href="{{ asset('/images/icon.png') }}" type="image/x-icon">
        <link rel="stylesheet" href="style/about.css">
        <link rel="stylesheet" href="style/home.css">
        <link rel="stylesheet" href="style/footer.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Alegreya:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Schoolbell&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    </head>
    <body>
        {{-- Include the navbar --}}
        @include('layouts.navbar', ['whiteBg' => $whiteBg ?? true])

        <main>
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-container">
                <img src="../images/techBackground.jpg" alt="Technology background"/>
                <div class="overlay"></div>
                <div class="hero-content">
                    <h1>Empowering Through Technology</h1>
                    <p>Discover our mission to make tech accessible for everyone</p>
                    <a href="#vision-mission" class="cta-button">Learn More</a>
                </div>
            </div>
        </section>

        <!-- Vision & Mission Section -->
        <section id="vision-mission" class="vision-mission-section">
            <div class="section-header">
                <h2>Our Purpose</h2>
                <p>Driving technological empowerment across Africa</p>
            </div>
            
            <div class="vision-mission-cards">
                <div class="vision-card card">
                    <div class="icon"><i class="fas fa-eye"></i></div>
                    <h3>Our Vision</h3>
                    <p>To become Africa's leading provider of accessible, practical technology education that transforms lives and businesses.</p>
                </div>
                
                <div class="mission-card card">
                    <div class="icon"><i class="fas fa-bullseye"></i></div>
                    <h3>Our Mission</h3>
                    <p>To demystify technology through hands-on training, personalised support, and community-driven learning experiences.</p>
                </div>
            </div>
        </section>

        <!-- Why Choose Us Section -->
        <section class="why-choose-us">
            <div class="container">
                <div class="text-content">
                    <h2 class="section-title">Why Technospeak?</h2>
                    <h3 class="tagline">Small Team. Big Vision. Global Impact.</h3>
                    <p class="description">We're not just building another helpdesk — we're building a movement to make tech simple for students, small businesses, and everyday users. Here's how we're making a difference:</p>
                    
                    <div class="features-grid">
                        <div class="feature">
                            <div class="feature-icon">
                                <i class="fas fa-bolt"></i>
                            </div>
                            <h4>Focused Training</h4>
                            <p>Practical, results-driven courses tailored to real-world needs</p>
                        </div>
                        
                        <div class="feature">
                            <div class="feature-icon">
                                <i class="fas fa-globe-africa"></i>
                            </div>
                            <h4>Global Reach</h4>
                            <p>Solutions designed for both local and international challenges</p>
                        </div>
                        
                        <div class="feature">
                            <div class="feature-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h4>Community Support</h4>
                            <p>Learning powered by peer networks and expert guidance</p>
                        </div>
                    </div>
                    
                    <div class="mission-footer">
                        <p>🎯 On a Mission to be #1 in Helpdesk Support 🎯</p>
                    </div>
                </div>
                
                <div class="image-content">
                    <div class="image-wrapper">
                        <img src="images/teamCollaborative.avif" alt="Technospeak team collaborating">
                        <div class="image-overlay">
                            <span>Quality</span>
                            <span>Efficiency</span>
                            <span>Service</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section class="team-section">
            <div class="section-header">
                <h2>Meet Our Team</h2>
                <p>The passionate professionals behind Technospeak</p>
            </div>
            
        <div class="slider-container swiper">
            <div class="slider-wrapper">
                <ul class="team-list swiper-wrapper">
                    <li class="team swiper-slide">
                        <img src="images/tsTeam/Norris.jpg" alt="Team1" class="team-image">
                        <h3 class="name">Norris Dzotizeyi</h3>
                        <i class="description">TS - Trainer & IT Team</i>
                    </li>
                    <li class="team swiper-slide">
                        <img src="images/tsTeam/omega.jpg" alt="Team2" class="team-image">
                        <h3 class="name">Nkosingiphile Omega Sithebe</h3>
                        <i class="description">TS - Project Manager</i>
                    </li>
                    <li class="team swiper-slide">
                        <img src="images/tsTeam/hloks.jpeg" alt="Team3" class="team-image">
                        <h3 class="name">Lehlogonolo Chauke</h3>
                        <i class="description">TS - Content Creation</i>
                    </li>
                    <li class="team swiper-slide">
                        <img src="images/tsTeam/rose.jpeg" alt="Team4" class="team-image">
                        <h3 class="name">Rose Tebogo Ndhlovu</h3>
                        <i class="description">TS - Marketing Team</i>
                    </li>
                    <li class="team swiper-slide">
                        <img src="images/tsTeam/zinhle.jpeg" alt="Team5" class="team-image">
                        <h3 class="name">Zinhle Bridgette Ngobeni</h3>
                        <i class="description">TS - Marketing Team</i>
                    </li>
                    <li class="team swiper-slide">
                        <img src="images/tsTeam/junior.jpg" alt="Khuliso J. Ravhuravhu" class="team-image">
                        <h3 class="name">Khuliso J. Ravhuravhu</h3>
                        <i class="description">TS - Business Manager</i>
                    </li>
                    <li class="team swiper-slide">
                        <img src="images/tsTeam/phuti.jpeg" alt="Team7" class="team-image">
                        <h3 class="name">Phuti Palesa Rammutla</h3>
                        <i class="description">TS - Analysis & Sales Team</i>
                    </li>
                    <li class="team swiper-slide">
                        <img src="images/tsTeam/faith.jpeg" alt="Team10" class="team-image">
                        <h3 class="name">Faith Maswangayi</h3>
                        <i class="description">TS - Sales Team</i>
                    </li>
                </ul>

                <div class="swiper-pagination"></div>
                <div class="swiper-slide-button swiper-button-prev"></div>
                <div class="swiper-slide-button swiper-button-next"></div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="testimonials-section">
            <div class="section-header">
                <h2>What Our Clients Say</h2>
                <p>Success stories from our community</p>
            </div>
            
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="quote-icon">"</div>
                    <p class="testimonial-text">Technospeak transformed how we handle IT support. Their training saved us countless hours and improved our service quality dramatically.</p>
                    <div class="client-info">
                        <img src="images/EstherBotha.jpg" alt="Client">
                        <!-- <img src="https://randomuser.me/api/portraits/women/63.jpg" alt="Client"> -->
                        <div>
                            <h4>Esther Botha</h4>
                            <p>Small Business Owner</p>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-card">
                    <div class="quote-icon">"</div>
                    <p class="testimonial-text">The hands-on approach made complex concepts easy to understand. I've implemented what I learned immediately with great results.</p>
                    <div class="client-info">
                        <img src="images/JamesWilson.jpg" alt="Client">
                        <!-- <img src="https://randomuser.me/api/portraits/men/81.jpg" alt="Client"> -->
                        <div>
                            <h4>James Wilson</h4>
                            <p>IT Student/Graduate</p>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-card">
                    <div class="quote-icon">"</div>
                    <p class="testimonial-text">As a non-technical person, I was intimidated by tech. Technospeak's patient instructors and practical approach gave me confidence.</p>
                    <div class="client-info">
                        <img src="images/DavidMbeki.jpg" alt="Client">
                        <div>
                            <h4>David Mbeki</h4>
                            <p>Administrative Professional</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer Section -->
        {{-- Include the footer --}}
        @include('layouts.footer')
        </main>

        <!-- Linking Swiper script -->
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

        <script>
            // Initialize Swiper if Swiper is available
            if (typeof Swiper !== 'undefined') {
                const swiper = new Swiper('.slider-wrapper', {
                    loop: true,
                    grabCursor: true,
                    spaceBetween: 25,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                        dynamicBullets: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    breakpoints: {
                        0: { slidesPerView: 1 },
                        768: { slidesPerView: 2 },
                        1024: { slidesPerView: 3 },
                    }
                });
            }
        </script>    
        
    </body>
</html>