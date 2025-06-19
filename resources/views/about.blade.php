<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Technospeak - About us</title>
        <meta name="author" content="TechnoSpeak">
        <meta property="og:type" content="website">
        <link rel="icon" href="IMAGES/icon/png" type="image/x-icon">
        <link rel="stylesheet" href="style/about.css">
        <link rel="stylesheet" href="style/home.css">
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
        @include('layouts.navbar', ['whiteBg' => $whiteBg ?? false])

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
        <footer class="footer">
            <div class="footer-container">
                <div class="footer-content">
                    <div class="footer-brand">
                        <h3 class="footer-logo">TechnoSpeak</h3>
                        <p class="footer-tagline">Empowering your digital journey</p>
                        <div class="social-links">
                            <a href="https://www.facebook.com/profile.php?id=61567521075043" aria-label="Facebook">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                                </svg>
                            </a>
                            <a href="https://www.youtube.com/@TechnoSpeak-j3f" aria-label="YouTube">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </a>

                            <a href="https://www.tiktok.com/@everything.tips8" aria-label="TikTok">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="footer-links">
                        <div class="links-column">
                            <h4 class="links-title">Resources</h4>
                            <ul>
                                <li><a href="#">Help Center</a></li>
                                <li><a href="#">Tutorials</a></li>
                                <li><a href="#">Webinars</a></li>
                                <li><a href="#">Community</a></li>
                            </ul>
                        </div>

                        <div class="links-column">
                            <h4 class="links-title">Legal</h4>
                            <ul>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Terms of Service</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="footer-contact">
                        <h4 class="contact-title">Contact Us</h4>
                        <div class="contact-details">
                            <!-- Address with Google Maps link -->
                            <div class="contact-item">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                </svg>
                                <a href="https://maps.google.com/?q=3+Georgian+Cres+W,+Bryanston+East,+Johannesburg,+2191" target="_blank" rel="noopener noreferrer">
                                    3 Georgian Cres W, Bryanston East, Johannesburg, 2191
                                </a>
                            </div>
                            
                            <!-- Phone number with tel link -->
                            <div class="contact-item">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56-.35-.12-.74-.03-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z"/>
                                </svg>
                                <a href="tel:0861777372">086 177 7372</a>
                            </div>
                            
                            <!-- Working hours -->
                            <div class="contact-item">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                                </svg>
                                <div class="working-hours">
                                    <div>Thursday-Friday: 8:30 am–5 pm</div>
                                    <div>Saturday-Sunday: Closed</div>
                                    <div>Monday-Wednesday: 8:30 am–5 pm</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="footer-bottom">
                    <p class="copyright-text">&copy; <span id="current-year"></span> TechnoSpeak. All rights reserved.</p>
                    <div class="footer-legal">
                        <a href="#">Privacy Policy</a>
                        <span>•</span>
                        <a href="#">Terms of Service</a>
                    </div>
                </div>
            </div>
        </footer>

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