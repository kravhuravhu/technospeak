<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Technospeak - Trainings</title>
        <meta name="author" content="TechnoSpeak">
        <meta property="og:type" content="website">
        <link rel="icon" href="@secureAsset('images/icon.png')" type="image/x-icon">
        <link rel="stylesheet" href="@secureAsset('style/trainings.css')">
        <link rel="stylesheet" href="@secureAsset('style/home.css')">
        <link rel="stylesheet" href="@secureAsset('style/footer.css')">
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
                <div class="video-card">
                    <div class="video-container">
                        <video poster="@secureAsset('images/teams/two_team.jpeg')">
                        <source src="@secureAsset('vids/intro.mp4')" type="video/mp4">
                        </video>
                        
                        <div class="video-overlay">
                        <button class="play-button">
                            <svg width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M8,5.14V19.14L19,12.14L8,5.14Z"/>
                            </svg>
                        </button>
                        </div>
                        
                        <div class="video-controls">
                        <div class="progress-container">
                            <div class="progress-bar"></div>
                            <div class="hover-time">0:00</div>
                        </div>
                        
                        <div class="controls-bottom">
                            <div class="left-controls">
                            <button class="control-btn play-pause">
                                <svg width="20" height="20" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M8,19V5H12V19H8M14,19V5H18V19H14Z"/>
                                </svg>
                            </button>
                            
                            <div class="volume-control">
                                <button class="control-btn volume-btn">
                                <svg width="20" height="20" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M14,3.23V5.29C16.89,6.15 19,8.83 19,12C19,15.17 16.89,17.85 14,18.71V20.77C18,19.86 21,16.28 21,12C21,7.72 18,4.14 14,3.23M16.5,12C16.5,10.23 15.5,8.71 14,7.97V16C15.5,15.29 16.5,13.76 16.5,12M3,9V15H7L12,20V4L7,9H3Z"/>
                                </svg>
                                </button>
                                <input type="range" class="volume-slider" min="0" max="1" step="0.01" value="1">
                            </div>
                            
                            <div class="time-display">0:00 / 0:00</div>
                            </div>
                            
                            <div class="right-controls">
                            <button class="control-btn fullscreen-btn">
                                <svg width="20" height="20" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M5,5H10V7H7V10H5V5M14,5H19V10H17V7H14V5M17,14H19V19H14V17H17V14M10,17V19H5V14H7V17H10Z"/>
                                </svg>
                            </button>
                            </div>
                        </div>
                        </div>
                    </div>
                    
                    <div class="video-info">
                        <h3 class="video-title">Behind Technospeak Minds</h3>
                        <div class="video-meta">
                        <span class="meta-item">
                            <svg width="14" height="14" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,7H16V17H12V12H7V17H5V7H7V10H12V7Z"/>
                            </svg>
                            1 min
                        </span>
                        </div>
                        
                        <p class="video-description">
                        We use AI to help you create a personalized learning plan that considers your unique needs. 
                        Meet the intelligence behind Technospeak as we share actionable tips for AI-powered education.
                        </p>
                    </div>
                </div>

                <aside class="sidebar">
                    <div class="sidebar-section latest-videos">
                        <h3>Trending Videos</h3>
                        <div class="video-list">
                            @foreach($courses as $course)
                                <a href="{{ route('unenrolled-courses.show', $course->uuid) }}" class="video-item">
                                    <div class="video-item">
                                        <div class="thumbnail">
                                            <img src="{{ $course->thumbnail }}" alt="{{ $course->title }}"/>
                                        </div>
                                        <div class="video-info">
                                            <h4>{{ $course->title }}</h4>
                                            <p class="duration">Duration: {{ $course->formatted_duration }}</p>
                                            <p class="description">{{ $course->description }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="sidebar-section recommended-training">
                        <h3>Recommended Training</h3>
                        @if($recommendedTraining)
                            <div class="training-item">
                                <div class="thumbnail">
                                    <img src="{{ $recommendedTraining->thumbnail }}" alt="{{ $recommendedTraining->title }}"/>
                                </div>
                                <div class="training-info">
                                    <h4>{{ $recommendedTraining->title }}</h4>
                                    <p class="duration">Duration: {{ $recommendedTraining->formatted_duration }}</p>
                                    <p class="description">{{ $recommendedTraining->description }}</p>
                                    <a href="{{ route('unenrolled-courses.show', $recommendedTraining->uuid) }}" class="btn enroll-btn">Check it out</a>
                                </div>
                            </div>
                        @else
                            <p>No recommended course available at the moment.</p>
                        @endif
                    </div>
                </aside>
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
                            Get full access to every cheatsheet with our quarterly Tips & Tricks subscription.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Footer Section -->
            {{-- Include the footer --}}
            @include('layouts.footer')
        </main>

        <!-- Capture current date -->
        <script>
            document.getElementById('current-year').textContent = new Date().getFullYear();
        </script>

        <script src="script/trainings.js"></script>

        <script>

            document.addEventListener('DOMContentLoaded', function() {
  const videoContainer = document.querySelector('.video-container');
  const video = document.querySelector('video');
  const playOverlay = document.querySelector('.video-overlay');
  const playButton = document.querySelector('.play-button');
  const playPauseBtn = document.querySelector('.play-pause');
  const progressBar = document.querySelector('.progress-bar');
  const progressContainer = document.querySelector('.progress-container');
  const hoverTime = document.querySelector('.hover-time');
  const timeDisplay = document.querySelector('.time-display');
  const volumeBtn = document.querySelector('.volume-btn');
  const volumeSlider = document.querySelector('.volume-slider');
  const fullscreenBtn = document.querySelector('.fullscreen-btn');
  
  // Toggle play/pause
  function togglePlay() {
    if (video.paused) {
      video.play();
      videoContainer.classList.add('playing');
      playPauseBtn.innerHTML = `
        <svg width="20" height="20" viewBox="0 0 24 24">
          <path fill="currentColor" d="M14,19H18V5H14M6,19H10V5H6V19Z"/>
        </svg>
      `;
    } else {
      video.pause();
      videoContainer.classList.remove('playing');
      playPauseBtn.innerHTML = `
        <svg width="20" height="20" viewBox="0 0 24 24">
          <path fill="currentColor" d="M8,5.14V19.14L19,12.14L8,5.14Z"/>
        </svg>
      `;
    }
  }
  
  playButton.addEventListener('click', togglePlay);
  playPauseBtn.addEventListener('click', togglePlay);
  video.addEventListener('click', togglePlay);
  
  // Update progress bar
  video.addEventListener('timeupdate', () => {
    const progress = (video.currentTime / video.duration) * 100;
    progressBar.style.width = `${progress}%`;
    
    // Update time display
    const currentTime = formatTime(video.currentTime);
    const duration = formatTime(video.duration);
    timeDisplay.textContent = `${currentTime} / ${duration}`;
  });
  
  // Seek on progress bar click
  progressContainer.addEventListener('click', (e) => {
    const rect = progressContainer.getBoundingClientRect();
    const pos = (e.pageX - rect.left) / progressContainer.offsetWidth;
    video.currentTime = pos * video.duration;
  });
  
  // Hover time preview
  progressContainer.addEventListener('mousemove', (e) => {
    const rect = progressContainer.getBoundingClientRect();
    const pos = (e.pageX - rect.left) / progressContainer.offsetWidth;
    const time = pos * video.duration;
    hoverTime.textContent = formatTime(time);
    hoverTime.style.left = `${e.offsetX}px`;
  });
  
  // Volume controls
  volumeSlider.addEventListener('input', () => {
    video.volume = volumeSlider.value;
    video.muted = volumeSlider.value == 0;
  });
  
  volumeBtn.addEventListener('click', () => {
    video.muted = !video.muted;
    volumeSlider.value = video.muted ? 0 : video.volume;
  });
  
  // Fullscreen
  fullscreenBtn.addEventListener('click', () => {
    if (!document.fullscreenElement) {
      videoContainer.requestFullscreen().catch(err => {
        console.log(`Fullscreen error: ${err.message}`);
      });
    } else {
      document.exitFullscreen();
    }
  });
  
  // Format time as MM:SS
  function formatTime(seconds) {
    const mins = Math.floor(seconds / 60);
    const secs = Math.floor(seconds % 60);
    return `${mins}:${secs < 10 ? '0' : ''}${secs}`;
  }
  
  // Set initial volume
  video.volume = volumeSlider.value;
});
        </script>
        
    </body>
</html>
