<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $course->title }} | Detailed View</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="TechnoSpeak">
    <meta http-equiv="Content-Security-Policy" content="child-src 'none'">
    <link rel="icon" href="{{ asset('/images/icon.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary-color: #38b6ff;
            --primary-dark: #005c91;
            --danger-color: #e53e3e;
            --danger-dark: #a72828;
            --success-color: #48bb78;
            --text-dark: #062644;
            --text-medium: #2d3748;
            --text-light: #718096;
            --bg-light: #e4f4ff;
            --border-light: #ecf5ff;
            --shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            line-height: 1.6;
            color: var(--text-medium);
            background-color: #f8fafc;
            background-image: url("../images/75xPHEQBmvA2.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            & > .main-cont-enrolled {
                background-color: #ffffffc2;
                height: fit-content;
            }
        }
        
        .course-show-container {
            max-width: 75%;
            margin: 0 auto;
            padding: 30px;
        
            .course-header {
                margin-bottom: 30px;
            }
            
            .course-header-top {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 30px;
                gap: 20px;
                flex-wrap: wrap;
            }
            
            .course-info {
                flex: 1;
                min-width: 300px;
            }
            
            .title-meta-container h1 {
                font-size: 28px;
                margin-bottom: 10px;
                color: var(--text-dark);
            }
            
            .course-meta {
                display: flex;
                gap: 15px;
                color: var(--text-light);
                font-size: 14px;
                flex-wrap: wrap;
            }
            
            .course-meta i {
                margin-right: 5px;
                color: var(--primary-color);
            }
            
            .course-actions {
                display: flex;
                flex-direction: row;
                gap: 10px;
                align-self: end;
                flex-wrap: wrap;
            }
            
            .btn {
                border: none;
                font-size: 16px;
                cursor: pointer;
                padding: 15px 20px;
                border-radius: 50px;
                transition: all 0.3s ease;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                white-space: nowrap;
            }
            
            .btn i {
                margin-right: 8px;
            }
            
            .back-btn {
                background-color: var(--primary-color);
                color: #ebebeb;
            }
            
            .back-btn:hover {
                background-color: var(--primary-dark);
                transform: translateY(-1px);
            }
            
            .unenroll-btn {
                background-color: var(--danger-color);
                color: #fff;
            }
            
            .unenroll-btn:hover {
                background-color: var(--danger-dark);
                transform: translateY(-1px);
            }
            
            .course-content {
                display: flex;
                gap: 30px;
            }
            
            .course-video {
                flex: 2;
                min-width: 0;
            }
            
            .video-container {
                background: #000;
                border-radius: 8px;
                overflow: hidden;
                aspect-ratio: 16/9;
                margin-bottom: 20px;
                position: relative;
            }
            
            .video-placeholder {
                position: relative;
                width: 100%;
                height: 100%;
                animation: fadeIn 0.3s ease-in;
            }
            
            .video-thumb {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block;
            }
            
            .overlay {
                position: absolute;
                inset: 0;
                background: rgba(0, 0, 0, 0.3);
                color: #fff;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align: center;
                cursor: pointer;
                transition: background 0.3s;
            }
            
            .overlay:hover {
                background: rgba(0, 0, 0, 0.5);
            }
            
            .overlay i {
                font-size: 50px;
                margin-bottom: 15px;
                color: #e2e8f0;
                transition: transform 0.3s;
            }
            
            .overlay:hover i {
                transform: scale(1.1);
            }
            
            .video-description h3 {
                font-size: 20px;
                margin-bottom: 15px;
                color: var(--text-dark);
            }
            
            .video-description p {
                color: var(--text-light);
                line-height: 1.6;
                margin-bottom: 25px;
            }
            
            .instructor-info h4 {
                font-size: 18px;
                margin-bottom: 15px;
                color: var(--text-dark);
            }
            
            .instructor-details {
                display: flex;
                align-items: center;
                gap: 15px;
            }
            
            .instructor-avatar img {
                width: 50px;
                height: 50px;
                border-radius: 50%;
                object-fit: cover;
            }
            
            .instructor-text h5 {
                margin: 0;
                font-size: 16px;
                color: var(--text-dark);
            }
            
            .instructor-text p {
                margin: 5px 0 0;
                font-size: 14px;
                color: var(--text-light);
            }
            
            .course-sidebar {
                flex: 1;
                max-width: 350px;
            }
            
            .progress-container, .episodes-list {
                background: #fff;
                border-radius: 8px;
                padding: 20px;
                box-shadow: var(--shadow);
                margin-bottom: 25px;
            }
            
            .progress-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 15px;
            }
            
            .progress-header h3 {
                margin: 0;
                font-size: 18px;
                color: var(--text-medium);
            }
            
            .progress-percent {
                font-weight: bold;
                color: var(--primary-color);
            }
            
            .progress-bar {
                height: 8px;
                background: #e2e8f0;
                border-radius: 4px;
                margin-bottom: 15px;
                overflow: hidden;
            }
            
            .progress-fill {
                height: 100%;
                background: var(--primary-color);
                border-radius: 4px;
                transition: width 0.5s ease-out;
            }
            
            .mark-complete-btn {
                background-color: var(--primary-color);
                color: #eefefe;
                width: 100%;
            }
            
            .mark-complete-btn:hover {
                background-color: var(--primary-dark);
                transform: translateY(-1px);
            }
            
            .episodes-list h3 {
                margin: 0 0 15px;
                font-size: 18px;
                color: var(--text-medium);
            }
            
            #course-episodes-list {
                list-style: none;
                padding: 0;
                margin: 0;
            }
            
            .episode-item {
                display: flex;
                align-items: center;
                padding: 12px 5px;
                border-bottom: 1px solid var(--border-light);
                cursor: pointer;
                transition: all 0.2s ease;
            }
            
            .episode-item:last-child {
                border-bottom: none;
            }
            
            .episode-item:hover {
                background: var(--bg-light);
            }
            
            .episode-item.active {
                background: var(--bg-light);
                border-left: 3px solid var(--primary-color);
                padding-left: 10px;
            }
            
            .episode-item.completed .episode-number {
                background: var(--text-dark);
                color: white;
            }
            
            .episode-item.completed .episode-info h4 {
                color: var(--primary-color);
            }
            
            .episode-number {
                width: 40px;
                height: 40px;
                background-color: var(--primary-color);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-right: 15px;
                font-size: 15px;
                color: #f1f1f1;
                flex-shrink: 0;
                transition: all 0.3s ease;
            }
            
            .episode-info {
                flex: 1;
                min-width: 0;
            }
            
            .episode-info h4 {
                margin: 0 0 5px;
                font-size: 15px;
                color: var(--text-medium);
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            
            .episode-info p {
                margin: 0;
                font-size: 13px;
                color: var(--text-light);
            }
            
            .fa-check-circle {
                color: var(--border-light);
                margin-left: 10px;
                flex-shrink: 0;
            }
            
            @media (max-width: 1024px) {
                .course-show-container {
                    max-width: 90%;
                    padding: 20px;
                }
            }
            
            @media (max-width: 768px) {
                .course-show-container {
                    max-width: 100%;
                    padding: 15px;
                }
                
                .course-content {
                    flex-direction: column;
                }
                
                .course-sidebar {
                    max-width: 100%;
                }
                
                .course-header-top {
                    flex-direction: column;
                    align-items: flex-start;
                }
                
                .course-actions {
                    align-self: flex-start;
                    margin-top: 15px;
                }
            }
            
            .loading-spinner {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 50px;
                height: 50px;
                border: 5px solid rgba(255, 255, 255, 0.3);
                border-radius: 50%;
                border-top-color: var(--primary-color);
                animation: spin 1s ease-in-out infinite;
            }
            
            .toast {
                position: fixed;
                bottom: 20px;
                right: 20px;
                background: var(--text-dark);
                color: white;
                padding: 15px 25px;
                border-radius: 5px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                transform: translateY(100px);
                opacity: 0;
                transition: all 0.3s ease;
                z-index: 1000;
            }
            
            .toast.show {
                transform: translateY(0);
                opacity: 1;
            }
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeOut {
            to {
                opacity: 0;
                visibility: hidden;
                transform: translateY(-10px);
            }
        }
        
        @keyframes spin {
            to { transform: translate(-50%, -50%) rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="main-cont-enrolled">
        <div class="course-show-container">
            <div class="course-header">
                <div class="course-header-top">
                    <div class="course-info">
                        <div class="title-meta-container">
                            <h1>{{ $course->title }}</h1>
                        </div>
                        <div class="course-meta">
                            <span><i class="fas fa-tag"></i> {{ $course->category?->name }}</span>
                            <span><i class="fas fa-signal"></i> {{ $course->level }}</span>
                            <span><i class="far fa-clock"></i> {{ $course->formatted_duration }}</span>
                        </div>
                    </div>
                    <div class="course-actions">
                        <button class="btn back-btn" onclick="window.location.href='/dashboard'">
                            <i class="fas fa-arrow-left"></i> Back to Dashboard
                        </button>
                        <form action="{{ route('enrolled-courses.destroy', $course->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn unenroll-btn" id="unenroll-btn">
                                <i class="fas fa-times-circle"></i> Unenroll Course
                            </button>
                        </form>
                    </div>
                </div>
            </div>        
            <div class="course-content">
                <div class="course-video">
                    <div class="video-container" id="video-container">
                        <div class="video-placeholder" id="video-placeholder">
                            <img src="{{ $course->thumbnail }}" alt="Course Thumbnail" class="video-thumb" />
                            <div class="overlay" id="video-overlay">
                                <i class="fas fa-play-circle"></i>
                                <p>Select an episode to start watching</p>
                            </div>
                        </div>
                    </div>
                    <div class="video-description">
                        <h3>About This Course</h3>
                        <p>{{ $course['description'] }}</p>
                        
                        <div class="instructor-info">
                            <h4>Instructor</h4>
                            <div class="instructor-details">
                                <div class="instructor-avatar">
                                    <img src="{{ asset('images/icons/circle-user-solid.svg') }}" alt="Instructor Avatar">
                                </div>
                                <div class="instructor-text">
                                    <h5>{{ $course->instructor->name }}</h5>
                                    <p>Senior Instructor</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="course-sidebar">
                    <div class="progress-container">
                        <div class="progress-header">
                            <h3>Your Progress</h3>
                            <div class="progress-percent">{{ $course['progress'] }}%</div>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $course['progress'] }}%"></div>
                        </div>
                        <div class="progress-actions">
                            <button class="btn mark-complete-btn" id="mark-complete-btn">
                                <i class="fas fa-check-circle"></i> Mark as Complete
                            </button>
                        </div>
                    </div>
                    
                    <div class="episodes-list">
                        <h3>Course Episodes</h3>
                        <ul id="course-episodes-list">
                            @foreach($course['episodes'] as $episode)
                            <li class="episode-item {{ $episode['completed'] ? 'completed' : '' }}" 
                                data-episode-id="{{ $episode['id'] }}"
                                data-video-url="{{ $episode['video_url'] }}"
                                data-episode-title="{{ $episode['title'] }}">
                                <div class="episode-number">{{ $episode->episode_number }}</div>
                                <div class="episode-info">
                                    <h4>{{ $episode['title'] }}</h4>
                                    <p>{{ $episode->duration_formatted }}</p>
                                </div>
                                @if($episode['completed'])
                                    <i class="fas fa-check-circle"></i>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="toast" id="toast"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toast notification function
            function showToast(message, type = 'success') {
                const toast = document.getElementById('toast');
                toast.textContent = message;
                toast.className = 'toast';
                
                // Add type class if needed (for different styles)
                if (type === 'error') {
                    toast.style.backgroundColor = 'var(--danger-color)';
                } else if (type === 'info') {
                    toast.style.backgroundColor = 'var(--primary-color)';
                } else {
                    toast.style.backgroundColor = 'var(--text-dark)';
                }
                
                toast.classList.add('show');
                
                setTimeout(() => {
                    toast.classList.remove('show');
                }, 3000);
            }
            
            // Handle episode selection
            function handleEpisodeSelection(item) {
                const videoUrl = item.getAttribute('data-video-url');
                const episodeId = item.getAttribute('data-episode-id');
                const episodeTitle = item.getAttribute('data-episode-title');
                
                const videoContainer = document.getElementById('video-container');
                const placeholder = document.getElementById('video-placeholder');
                
                // Show loading state
                videoContainer.innerHTML = '<div class="loading-spinner"></div>';
                
                // Remove active class from all episodes
                document.querySelectorAll('.episode-item').forEach(ep => {
                    ep.classList.remove('active');
                });
                
                // Add active class to selected episode
                item.classList.add('active');
                
                // Load video after a small delay to show loading spinner
                setTimeout(() => {
                    videoContainer.innerHTML = `
                        <video controls autoplay style="width: 100%; height: 100%">
                            <source src="${videoUrl}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    `;
                    
                    const video = videoContainer.querySelector('video');
                    if (video) {
                        video.play().catch(e => {
                            console.log('Auto-play prevented:', e);
                            showToast('Click on the video to start playback', 'info');
                        });
                        
                        // Update video title in the description
                        document.querySelector('.video-description h3').textContent = episodeTitle;
                    }
                }, 500);
            }
            
            // Set up episode click handlers
            document.querySelectorAll('.episode-item').forEach(item => {
                item.addEventListener('click', function() {
                    handleEpisodeSelection(this);
                });
            });
            
            // Set up click handler for video placeholder overlay
            const videoOverlay = document.getElementById('video-overlay');
            if (videoOverlay) {
                videoOverlay.addEventListener('click', function() {
                    const firstEpisode = document.querySelector('.episode-item');
                    if (firstEpisode) {
                        handleEpisodeSelection(firstEpisode);
                    } else {
                        showToast('No episodes available', 'error');
                    }
                });
            }
            
            // Handle mark as complete button
            document.getElementById('mark-complete-btn').addEventListener('click', function() {
                const activeEpisode = document.querySelector('.episode-item.active');
                if (!activeEpisode) {
                    showToast('Please select an episode first', 'error');
                    return;
                }
                
                const episodeId = activeEpisode.getAttribute('data-episode-id');
                const courseId = {{ $course['id'] }};
                
                // Show loading state on button
                const btn = this;
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                btn.disabled = true;
                
                fetch(`/enrolled-courses/${courseId}/episodes/${episodeId}/complete`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        activeEpisode.classList.add('completed');
                        
                        // Add checkmark if not already present
                        if (!activeEpisode.querySelector('.fa-check-circle')) {
                            activeEpisode.innerHTML += '<i class="fas fa-check-circle"></i>';
                        }
                        
                        // Smoothly update progress
                        const progressPercent = document.querySelector('.progress-percent');
                        const progressFill = document.querySelector('.progress-fill');
                        
                        let currentProgress = parseInt(progressPercent.textContent);
                        const targetProgress = data.progress;
                        
                        // Animate progress increase
                        const increment = () => {
                            if (currentProgress < targetProgress) {
                                currentProgress++;
                                progressPercent.textContent = `${currentProgress}%`;
                                progressFill.style.width = `${currentProgress}%`;
                                setTimeout(increment, 20);
                            }
                        };
                        
                        increment();
                        
                        showToast('Episode marked as completed!');
                    } else {
                        showToast(data.message || 'Operation failed', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Failed to mark episode as completed', 'error');
                })
                .finally(() => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                });
            });
            
            // Confirm before unenrolling
            const unenrollBtn = document.getElementById('unenroll-btn');
            if (unenrollBtn) {
                unenrollBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const form = this.closest('form');
                    const courseTitle = document.querySelector('.title-meta-container h1')?.textContent || 'this course';
                    
                    Swal.fire({
                        title: 'Confirm Unenrollment',
                        html: `Are you sure you want to Unenroll from <strong>${courseTitle}</strong>?<br><br>Your progress will be lost.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e53e3e',
                        cancelButtonColor: '#718096',
                        confirmButtonText: 'Yes, Unenroll',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading state
                            Swal.showLoading();
                            
                            fetch(form.action, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    _method: 'DELETE'
                                })
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                window.location.href = '/dashboard';
                            })
                            .catch(error => {
                                Swal.fire(
                                    'Error',
                                    'There was a problem unenrolling from the course. Please try again.',
                                    'error'
                                );
                                console.error('Error:', error);
                            });
                        }
                    });
                });
            }          
            // Keyboard navigation for episodes
            document.addEventListener('keydown', function(e) {
                if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                    const episodes = Array.from(document.querySelectorAll('.episode-item'));
                    const activeIndex = episodes.findIndex(ep => ep.classList.contains('active'));
                    
                    if (activeIndex >= 0) {
                        e.preventDefault();
                        let newIndex;
                        
                        if (e.key === 'ArrowDown' && activeIndex < episodes.length - 1) {
                            newIndex = activeIndex + 1;
                        } else if (e.key === 'ArrowUp' && activeIndex > 0) {
                            newIndex = activeIndex - 1;
                        }
                        
                        if (newIndex !== undefined) {
                            handleEpisodeSelection(episodes[newIndex]);
                            episodes[newIndex].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        }
                    }
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>