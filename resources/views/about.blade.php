<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Technospeak - About us</title>
        <meta name="author" content="TechnoSpeak">
        <meta property="og:type" content="website">
        <link rel="icon" href="@secureAsset('images/icon.png')" type="image/x-icon">
        <link rel="stylesheet" href="@secureAsset('style/about.css')">
        <link rel="stylesheet" href="@secureAsset('style/home.css')">
        <link rel="stylesheet" href="@secureAsset('style/footer.css')">
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
                <img src="@secureAsset('images/techBackground.jpg')" alt="Technology background"/>
                <div class="overlay"></div>
                <div class="hero-content">
                    <h1>Empowering Through Technology</h1>
                    <p>We understand the frustration of feeling left behind in a fast-moving digital world. That's why our approach is human-first: we listen, we simplify, and we walk with you every step of the way.</p>
                </div>
            </div>
        </section>

        <!-- Story & Values Section -->
        <section class="story-values-section">
            <div class="container">
                <div class="container">
                    <div class="section-header">
                        <h2>Our Purpose</h2>
                        <p>To drive technological empowerment across Africa by equipping individuals and communities with the skills, confidence, and tools they need to thrive in the digital age.</p>
                    </div>
                </div>

                <div class="story-values-grid">
                    <!-- Story Section -->
                    <div class="story-card">
                        <h2>Our Story</h2>
                        <p>TechnoSpeak began as a grassroots initiative by a group of passionate technologists who saw a growing gap between rapid technological advancement and the everyday person's ability to keep up. Founded in 2024, our journey started with the desire to help people who are struggling understand software with confidence.</p>
                        <p>From those humble beginnings, we've grown into a movement—driven by the belief that everyone deserves access to technology education that is clear, relevant, and empowering.</p>
                    </div>
                    
                    <!-- Values Section -->
                    <div class="values-card">
                        <h2>Our Core Values</h2>
                        <p class="values-intro">The principles that guide everything we do</p>
                        
                        <div class="values-list">
                            <div class="value-item">
                                <div class="value-icon"><i class="fas fa-heart"></i></div>
                                <div class="value-text">
                                    <h3>Empathy</h3>
                                    <p>We meet people where they are, without judgment.</p>
                                </div>
                            </div>
                            
                            <div class="value-item">
                                <div class="value-icon"><i class="fas fa-lightbulb"></i></div>
                                <div class="value-text">
                                    <h3>Clarity</h3>
                                    <p>We simplify the complex and speak in everyday language.</p>
                                </div>
                            </div>
                            
                            <div class="value-item">
                                <div class="value-icon"><i class="fas fa-users"></i></div>
                                <div class="value-text">
                                    <h3>Inclusivity</h3>
                                    <p>We believe tech education should be accessible to all.</p>
                                </div>
                            </div>
                            
                            <div class="value-item">
                                <div class="value-icon"><i class="fas fa-tools"></i></div>
                                <div class="value-text">
                                    <h3>Practicality</h3>
                                    <p>We focus on skills that make a real difference.</p>
                                </div>
                            </div>
                            
                            <div class="value-item">
                                <div class="value-icon"><i class="fas fa-hands-helping"></i></div>
                                <div class="value-text">
                                    <h3>Community</h3>
                                    <p>We grow together, learn together, and rise together.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Vision & Mission Section -->
        <section id="vision-mission" class="vision-mission-section">
            <div class="container">
                <div class="section-header">
                    <h2>Our Vision & Mission</h2>
                    <p>Guiding principles that drive our work</p>
                </div>
                
                <div class="vision-mission-cards">
                    <div class="vision-card card">
                        <div class="icon"><i class="fas fa-eye"></i></div>
                        <h3>Our Vision</h3>
                        <p>To become Africa's leading provider of accessible, practical technology education—transforming lives, businesses, and communities through knowledge, support, and innovation.</p>
                        <p class="highlight-text">We envision a continent where technology is not a barrier but a bridge to opportunity.</p>
                    </div>
                    
                    <div class="mission-card card">
                        <div class="icon"><i class="fas fa-bullseye"></i></div>
                        <h3>Our Mission</h3>
                        <p>To demystify technology through:</p>
                        <ul class="mission-list">
                            <li><i class="fas fa-check-circle"></i> Hands-on training that focuses on real-world applications</li>
                            <li><i class="fas fa-check-circle"></i> Personalized support tailored to individual needs and learning styles</li>
                            <li><i class="fas fa-check-circle"></i> Community-driven learning that fosters collaboration, mentorship, and shared growth</li>
                        </ul>
                        <p class="highlight-text">We don't just teach tech—we build confidence, spark curiosity, and create lasting impact.</p>
                    </div>
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
                        <img src="images/teamCollaborative.avif" alt="Technospeak team collaborating" class="responsive-image">
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
        <div class="techCoach_content">
            <div class="section-header">
                <h2>Meet Our Team</h2>
                <p>The passionate professionals behind Technospeak</p>
            </div>
            <div class="coach-swiper-container">
                <div class="swiper coachSwiper">
                    <div class="swiper-wrapper">
                        @foreach ($instructors as $instructor)
                            <div class="swiper-slide">
                                <div class="coach-header">
                                    <div class="coach-avatar">
                                        <img src="{{ $instructor->thumbnail }}" alt="Coach {{ $instructor->name }}">
                                    </div>
                                    <div class="coach-intro">
                                        <h2>{{ $instructor->name }} {{ $instructor->surname }}</h2>
                                        <p class="coach-tagline">{{ $instructor->job_title }}</p>
                                        <div class="coach-bio">
                                            <p>
                                                <strong>Technite {{ $instructor->name }}</strong>,
                                                {{ $instructor->bio }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                @php
                                    $features = $instructor->features ?? [];
                                @endphp

                                <div class="coach-features">
                                    @foreach ($features as $feature)
                                        <div class="feature-card">
                                            <div class="feature-icon">
                                                <i class="{{ $feature['icon'] ?? '' }}"></i>
                                            </div>
                                            <div class="feature-content">
                                                <h3>{{ $feature['title'] ?? '' }}</h3>
                                                <p>{{ $feature['description'] ?? '' }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>                   
                </div>

                <!-- Swiper Navigation -->
                <div class="swiper-nav-btns">
                    <div class="swiper-pagination"></div>
                </div>

                <!-- Swiper Navigation -->
                <div class="swiper-nav-btns">
                    <button class="swiper-nav-btn swiper-button-prev">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="swiper-nav-btn swiper-button-next">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>

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
        
         <!-- Swiper JS -->
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        
        <!-- Technos/Coaches section-->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize Swiper
                const swiper = new Swiper('.coachSwiper', {
                    slidesPerView: 1,
                    spaceBetween: 30,
                    loop: true,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    // Autoplay
                    autoplay: {
                        delay: 10000,
                        disableOnInteraction: false,
                    },
                });
            });
        </script> 

        <!-- ABout Us script -->
         <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script src="@secureAsset('js/script.js')"></script>
    </body>
</html>