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
            </div>
        </section>

        <!-- Brand Identity Section -->
        <section class="branding-section">
            <div class="section-header">
                <h2>Our Branding</h2>
                <p>Our brand is a promise—<strong>clarity, trust, and innovation</strong> in every pixel. We're more than just Colors & Logos.</p>
            </div>

            <!-- Name Meaning Section -->
            <div class="name-meaning-section">
                <div class="section-header">
                    <h2>So Why The Name?</h2>
                    <p>The story behind our name and what it represents</p>
                </div>
                
                <div class="meaning-container">
                    <!-- Name Breakdown -->
                    <div class="meaning-card">
                        <div class="name-visual">
                            <span class="tech-part">TECHNO</span>
                            <span class="speak-part">SPEAK</span>
                        </div>
                        <div class="name-explanation">
                            <h3>Teachnospeak Strategies <small><i>(Our Full Name)</i></small></h3>
                            <p>Born from our mission to <strong>"teach tech speak"</strong> - transforming complex technology into human language.</p>
                        </div>
                    </div>
                    
                    <!-- Philosophy -->
                    <div class="philosophy-grid">
                        <div class="philosophy-item">
                            <div class="icon-circle" style="background-color: #38b6ff20;">
                                <i class="fas fa-universal-access" style="color: #38b6ff;"></i>
                            </div>
                            <h4>Democratizing Tech</h4>
                            <p>We break down barriers between technical jargon and everyday understanding</p>
                        </div>
                        
                        <div class="philosophy-item">
                            <div class="icon-circle" style="background-color: #06264420;">
                                <i class="fas fa-chalkboard-teacher" style="color: #062644;"></i>
                            </div>
                            <h4>Education First</h4>
                            <p>"Teach" is literally in our DNA - we're educators at heart</p>
                        </div>
                        
                        <div class="philosophy-item">
                            <div class="icon-circle" style="background-color: #0d47a120;">
                                <i class="fas fa-comments" style="color: #0d47a1;"></i>
                            </div>
                            <h4>Clear Communication</h4>
                            <p>We translate "tech speak" into actionable knowledge</p>
                        </div>
                    </div>
                    
                    <!-- Evolution -->
                    <div class="evolution-note">
                        <div class="evolution-icon">
                            <i class="fas fa-arrows-alt-h"></i>
                        </div>
                        <p><strong>From Teachnospeak Strategies to TechnoSpeak:</strong> While our legal name reflects our strategic approach, "TechnoSpeak" represents how the world experiences our brand - <span style="color: #38b6ff;">the friendly voice of tech empowerment</span>.</p>
                    </div>
                </div>
            </div>
            
            <!-- Brand Elements -->
            <div class="branding-container">
                <!-- Logo Philosophy -->
                <div class="branding-card logo-card">
                    <div class="brand-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3>Precision in Design</h3>
                    <p>Our logo isn't just a mark—it's a beacon for <strong>simplicity meets expertise</strong>.</p>
                    <div class="logo-display">
                        <div class="logo-variation">
                            <img src="images/brand/logo-primary.png" alt="Technospeak Primary Logo" class="logo-img">
                            <span>For impact</span>
                        </div>
                        <div class="logo-variation dark-bg">
                            <img src="images/brand/logo-navy-cr.png" alt="Technospeak Light Logo" class="logo-img">
                            <span>For elegance</span>
                        </div>
                    </div>
                    <div class="logo-display">
                        <div class="logo-variation dark-bg">
                            <img src="images/brand/logo-white-cr.png" alt="Technospeak Light Logo" class="logo-img">
                        </div>
                        <div class="logo-variation">
                            <img src="images/brand/logo-primary-navy-cr.png" alt="Technospeak Primary Logo" class="logo-img">
                        </div>
                    </div>
                    <div class="brand-note">
                        <i class="fas fa-lightbulb"></i>
                        <p><strong>Rule:</strong> Never distort, recolor, or compromise visibility.</p>
                    </div>
                </div>
                
                <!-- Color Psychology -->
                <div class="branding-card color-card">
                    <div class="brand-icon">
                        <i class="fas fa-palette"></i>
                    </div>
                    <h3>Colors With Intent</h3>
                    <p>Each hue is chosen to reflect our <strong>energy, depth, and approachability</strong>.</p>
                    <div class="color-grid">
                        <div class="color-swatch" style="background: #38b6ff;">
                            <span>Primary Blue</span>
                            <small>Trust · Tech · Energy</small>
                        </div>
                        <div class="color-swatch" style="background: #062644;">
                            <span>Deep Navy</span>
                            <small>Stability · Depth</small>
                        </div>
                        <div class="color-swatch" style="background: #f2f3f4; color:#062644;">
                            <span>Cloud White</span>
                            <small>Clarity · Space</small>
                        </div>
                        <div class="color-swatch" style="background:rgb(255, 255, 255);color:#062644;">
                            <span>Pure White</span>
                            <small>Action · Focus</small>
                        </div>
                    </div>
                    <div class="brand-note">
                        <i class="fas fa-brain"></i>
                        <p><strong>Why it works:</strong> Blue evokes competence, while white keeps it fresh.</p>
                    </div>
                </div>
                
                <!-- Typography Voice -->
                <div class="branding-card typography-card">
                    <div class="brand-icon">
                        <i class="fas fa-font"></i>
                    </div>
                    <h3>Typography That Talks</h3>
                    <p>Clean, modern, and <strong>unapologetically clear</strong>—just like our solutions.</p>
                    <div class="type-examples">
                        <div class="type-sample roboto-bold">
                            <h4>Roboto Bold</h4>
                            <p>"We deliver certainty."</p>
                        </div>
                        <div class="type-sample roboto-regular">
                            <h4>Roboto Regular</h4>
                            <p>"Because tech shouldn't feel like a foreign language."</p>
                        </div>
                        <div class="type-sample schoolbell">
                            <h4>Schoolbell</h4>
                            <p>"Learning made joyful."</p>
                        </div>
                    </div>
                    <div class="brand-note">
                        <i class="fas fa-comment-alt"></i>
                        <p><strong>Golden rule:</strong> If it's not readable, it's not TechnoSpeak.</p>
                    </div>
                </div>
            </div>
            
            <div class="branding-footer">
                <p>Every detail matters. We design for <strong>humans first</strong>, pixels second.</p>
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