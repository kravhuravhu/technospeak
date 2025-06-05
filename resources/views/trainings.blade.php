<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Technospeak - Trainings</title>
        <meta name="author" content="TechnoSpeak">
        <meta property="og:type" content="website">
        <link rel="icon" href="IMAGES/icon/png" type="image/x-icon">
        <link rel="stylesheet" href="style/trainings.css">
        <link rel="stylesheet" href="style/home.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Alegreya:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Schoolbell&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>
    <body>
        {{-- Include the navbar --}}
        @include('layouts.navbar', ['whiteBg' => $whiteBg ?? false])

        <!-- Main Content Section -->
        <main class="main-container">

            <!-- Trainings Landing Page - Video section -->
            <section class="content">
                <div class="video-main">
                    <div class="video-player">
                        <iframe src="../images/masteringAI-PoweredLearning.png"/ frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                    </div>
                    <div class="video-meta">
                        <div class="video-title">Mastering AI-Powered Learning</div>
                        <div class="video-stats">
                            <span class="date"><i class="far fa-calendar-alt"></i> June 15, 2023</span>
                            <span class="date"><i class="far fa-calendar-alt"></i> 10 mins</span>
                        </div>
                        <div class="video-description">
                            <p>Video desciption here.. We use AI to help you create a personalized and tailored learning plan that considers your unique needs and provides the most relevant content.</p>
                        </div>
                        <div class="video-actions">
                            <button class="btn like-btn"><i class="far fa-thumbs-up"></i> Like</button>
                            <button class="btn share-btn"><i class="fas fa-share"></i> Share</button>
                        </div>
                    </div>
                </div>

                <aside class="sidebar">
                    <div class="sidebar-section latest-videos">
                        <h3>Latest Videos</h3>
                        <div class="video-list">
                            <div class="video-item">
                                <div class="thumbnail">
                                    <img src="../images/AdvancedAITechniques.png"/>
                                </div>
                                <div class="video-info">
                                    <h4>AI Learning Fundamentals</h4>
                                    <p class="duration">Duration: 12:30 min</p>
                                    <p class="description">We use AI to help you create a personalized plan</p>
                                    <p class="price">Price: <span>R120</span> (Once off)</p>
                                </div>
                            </div>
                            <div class="video-item">
                                <div class="thumbnail">
                                    <img src="../images/CompleteAILearningCourse.png"/>
                                </div>
                                <div class="video-info">
                                    <h4>Personalized Learning Plans</h4>
                                    <p class="duration">Duration: 25:15 min</p>
                                    <p class="description">We use AI to help you create a personalized plan</p>
                                    <p class="price">Price: <span>R150</span> (Once off)</p>
                                </div>
                            </div>
                            <div class="video-item">
                                <div class="thumbnail">
                                    <img src="../images/PersonalizedLearningPlans.png"/>
                                </div>
                                <div class="video-info">
                                    <h4>Advanced AI Techniques</h4>
                                    <p class="duration">Duration: 18:42 min</p>
                                    <p class="description">We use AI to help you create a personalized plan</p>
                                    <p class="price">Price: <span>R200</span> (Once off)</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="sidebar-section recommended-training">
                        <h3>Recommended Training</h3>
                        <div class="training-item">
                            <div class="thumbnail">
                                <img src="../images/master-AIcompletecourse.jpg"/>
                            </div>
                            <div class="training-info">
                                <h4>Complete AI Learning Course</h4>
                                <p class="duration">Duration: 2 hours</p>
                                <p class="description">Comprehensive course covering all AI learning techniques</p>
                                <p class="price">Price: <span>R350</span> (Once off)</p>
                                <button class="btn enroll-btn">Enroll Now</button>
                            </div>
                        </div>
                    </div>
                </aside>
            </section>


            <!-- Quick Tips & Tricks Section -->
            <section class="tips-container">
                <div class="section-header">
                    <h2 class="section-title">Quick Tips & Tricks</h2>
                    <p class="section-subtitle">Boost your productivity with these expert-curated resources</p>
                </div>
                <div class="tips-grid">
                    <div class="tip-card">
                        <div class="tip-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#00aaff">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                            </svg>
                        </div>
                        <h3>Create a personalized learning plan with AI</h3>
                        <p>We use AI to help you create a personalized and tailored learning plan that considers your unique needs and provides the most relevant content.</p>
                        <button class="tip-btn">Watch Tutorial <span>&rarr;</span></button>
                    </div>
                    <div class="tip-card">
                        <div class="tip-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#00aaff">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
                            </svg>
                        </div>
                        <h3>Look for hiring companies using AI</h3>
                        <p>We use AI to help you create a personalized and tailored learning plan that considers your unique needs and provides the most relevant content.</p>
                        <button class="tip-btn">Watch Demo <span>&rarr;</span></button>
                    </div>
                    <div class="tip-card">
                        <div class="tip-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#00aaff">
                                <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                            </svg>
                        </div>
                        <h3>Edit PDF files with iLovePDF.com</h3>
                        <p>We use AI to help you create a personalized and tailored learning plan that considers your unique needs and provides the most relevant content.</p>
                        <button class="tip-btn">View Guide <span>&rarr;</span></button>
                    </div>
                    <div class="tip-card">
                        <div class="tip-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#00aaff">
                                <path d="M9.4 16.6L4.8 12l4.6-4.6L8 6l-6 6 6 6 1.4-1.4zm5.2 0l4.6-4.6-4.6-4.6L16 6l6 6-6 6-1.4-1.4z"/>
                            </svg>
                        </div>
                        <h3>Coding</h3>
                        <p>We use AI to help you create a personalized and tailored learning plan that considers your unique needs and provides the most relevant content.</p>
                        <button class="tip-btn">View Tips <span>&rarr;</span></button>
                    </div>
                    <div class="tip-card">
                        <div class="tip-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#00aaff">
                                <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                            </svg>
                        </div>
                        <h3>Edit a PDF file using Ilovepdf.com </h3>
                        <p>We use AI to help you create a personalized and tailored learning plan that considers your unique needs and provides the most relevant content.</p>
                        <button class="tip-btn">Learn More <span>&rarr;</span></button>
                    </div>
                    <div class="tip-card">
                        <div class="tip-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#00aaff">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                            </svg>
                        </div>
                        <h3>Coding</h3>
                        <p>We use AI to help you create a personalized and tailored learning plan that considers your unique needs and provides the most relevant content.</p>
                        <button class="tip-btn">View Strategies <span>&rarr;</span></button>
                    </div>
                </div>
            </section>


            <!-- Upcoming Live Sessions & Webinars Section -->
            <section class="webinars-section">
                <div class="section-header">
                    <h2 class="webinars-title">Upcoming Live Sessions & Webinars</h2>
                    <p class="webinars-subtitle">
                        Join our interactive workshops and engage with industry experts in real-time.<br>
                        Expand your knowledge and network with professionals worldwide.
                    </p>
                </div>

                <div class="webinars-container">
                    <!-- Card 1 -->
                    <div class="webinar-card">
                        <div class="card-header">
                            <div class="icon-container" style="background-color: rgba(33, 150, 243, 0.1);">
                                <i class="fas fa-calendar-check icon"></i>
                            </div>
                            <div class="date-badge">
                                <span class="date-day">01</span>
                                <span class="date-month">MAY</span>
                            </div>
                        </div>
                        <div class="card-content">
                            <h3 class="webinar-title">AI for Administrative Work</h3>
                            <p class="webinar-description">Learn how AI tools can automate repetitive tasks and boost your productivity by 40% or more.</p>
                            <div class="webinar-meta">
                                <div class="meta-item">
                                    <i class="fas fa-clock"></i>
                                    <span>7:00 PM GMT</span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-user-tie"></i>
                                    <span>Mr. NO Sithebe</span>
                                </div>
                            </div>
                            <button class="webinar-button">
                                <span>Reserve Your Spot</span>
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="webinar-card featured">
                        <div class="featured-badge">Popular</div>
                        <div class="card-header">
                            <div class="icon-container" style="background-color: rgba(0, 47, 95, 0.1);">
                                <i class="fas fa-comments icon dark"></i>
                            </div>
                            <div class="recurring-badge">
                                <i class="fas fa-sync-alt"></i>
                                <span>Weekly</span>
                            </div>
                        </div>
                        <div class="card-content">
                            <h3 class="webinar-title">Live Q&A Fridays</h3>
                            <p class="webinar-description">Get your questions answered by our expert panel in this interactive weekly session.</p>
                            <div class="webinar-meta">
                                <div class="meta-item">
                                    <i class="fas fa-clock"></i>
                                    <span>3:00 PM GMT</span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-users"></i>
                                    <span>Panel Discussion</span>
                                </div>
                            </div>
                            <button class="webinar-button">
                                <span>Join Live Session</span>
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="view-all-container">
                    <a href="#" class="view-all-link">
                        View all upcoming events
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            </section>


            <!-- Cheatsheet Section -->
            <section class="cheatsheet-section">
                <div class="cheatsheet-container">
                    <div class="cheatsheet-header">
                        <h2 class="title">
                            Cheatsheet of the Week
                            <span class="lock-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 1C8.14 1 5 4.14 5 8v1H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V11c0-1.1-.9-2-2-2h-1V8c0-3.86-3.14-7-7-7zm0 2c2.76 0 5 2.24 5 5v1H7V8c0-2.76 2.24-5 5-5zm6 10.5c0 .83-.67 1.5-1.5 1.5h-9c-.83 0-1.5-.67-1.5-1.5v-5c0-.83.67-1.5 1.5-1.5h9c.83 0 1.5.67 1.5 1.5v5z"/>
                                </svg>
                            </span>
                        </h2>
                        <p class="subtitle">
                            Boost your skills with quick, downloadable guides. Every week we release a powerful cheatsheet to save you time and help you work smarter.
                        </p>
                    </div>
                    
                    <div class="cheatsheet-preview">
                        <div class="preview-header">
                            <div class="dots">
                                <span class="dot red"></span>
                                <span class="dot yellow"></span>
                                <span class="dot green"></span>
                            </div>
                            <span class="file-name">weekly-cheatsheet.pdf</span>
                        </div>
                        <div class="preview-content">
                            <div class="blurred-content">
                                <div class="blurred-line long"></div>
                                <div class="blurred-line medium"></div>
                                <div class="blurred-line short"></div>
                                <div class="blurred-line long"></div>
                                <div class="blurred-line medium"></div>
                            </div>
                            <div class="watermark">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 3c-4.97 0-9 3.19-9 7 0 2.38 1.19 4.47 3 5.74V17c0 .55.45 1 1 1h1v2c0 .55.45 1 1 1h2v-2h4v2h2c.55 0 1-.45 1-1v-2h1c.55 0 1-.45 1-1v-1.26c1.81-1.27 3-3.36 3-5.74 0-3.81-4.03-7-9-7zm-5 7c0-.55.45-1 1-1s1 .45 1 1-.45 1-1 1-1-.45-1-1zm8 0c0 .55-.45 1-1 1s-1-.45-1-1 .45-1 1-1 1 .45 1 1zm-4 0c0 .55-.45 1-1 1s-1-.45-1-1 .45-1 1-1 1 .45 1 1z"/>
                                </svg>
                                <span>Premium Content</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="cta-container">
                        <button class="unlock-btn">
                            <span>Unlock This Cheatsheet</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 3c-4.97 0-9 3.19-9 7 0 2.38 1.19 4.47 3 5.74V17c0 .55.45 1 1 1h1v2c0 .55.45 1 1 1h2v-2h4v2h2c.55 0 1-.45 1-1v-2h1c.55 0 1-.45 1-1v-1.26c1.81-1.27 3-3.36 3-5.74 0-3.81-4.03-7-9-7zm2.85 11.1l-2.13 2.13c-.39.39-1.03.39-1.42 0l-2.13-2.13c-.39-.39-.39-1.03 0-1.42.39-.39 1.03-.39 1.42 0l.71.71V9c0-.55.45-1 1-1s1 .45 1 1v4.39l.71-.71c.39-.39 1.03-.39 1.42 0 .39.39.39 1.03 0 1.42z"/>
                            </svg>
                        </button>
                        <p class="note">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 15c-.55 0-1-.45-1-1v-4c0-.55.45-1 1-1s1 .45 1 1v4c0 .55-.45 1-1 1zm1-8h-2V7h2v2z"/>
                            </svg>
                            Sign up or join a course to access full content
                        </p>
                    </div>
                </div>
            </section>

            <!-- Newsletter Section -->
            <section class="newsletter-section">
                <div class="newsletter-container">
                    <div class="newsletter-header">
                        <div class="newsletter-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                        </div>
                        <h2 class="newsletter-title">Stay Updated With Our Newsletter</h2>
                        <p class="newsletter-description">
                            Join our community and get exclusive access to:<br>
                            <span class="highlight">Workshop invites • Course updates • Expert tips • Special offers</span>
                        </p>
                    </div>

                    <form class="newsletter-form" id="newsletterForm" action="">
                        <div class="form-group">
                            <div class="input-container">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                </svg>
                                <input type="email" id="email" name="email" placeholder="Enter your email" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-container">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17 2H7c-1.1 0-2 .9-2 2v16c0 1.1.9 1.99 2 1.99L17 22c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-5 3c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm4 14H8v-1c0-1.33 2.67-2 4-2s4 .67 4 2v1zm-1-5h-6V9h6v5z"/>
                                </svg>
                                <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required />
                            </div>
                        </div>

                        <button type="submit" class="submit-btn">
                            <span>Subscribe Now</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
                            </svg>
                        </button>

                        <div class="privacy-note">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/>
                            </svg>
                            <span>We respect your privacy. Unsubscribe at any time.</span>
                        </div>
                    </form>
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

        <!-- Capture current date -->
        <script>
            document.getElementById('current-year').textContent = new Date().getFullYear();
        </script>

        <script src="script/trainings.js"></script>
        
    </body>
</html>
