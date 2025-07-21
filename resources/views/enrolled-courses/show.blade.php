<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $course->title }} | Detailed View</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="TechnoSpeak">
    <link rel="icon" href="{{ asset('/images/icon.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .course-show-container {
            max-width: 75%;
            margin: 0 auto;
            padding: 30px;
            font-family: 'Roboto', sans-serif;
        }

        .course-header {
            margin-bottom: 30px;
        }

        .back-btn {
            background-color: #38b6ff;
            border: none;
            color: #ebebebff;
            font-size: 16px;
            cursor: pointer;
            margin-bottom: 15px;
            padding: 15px 20px;
            border-radius: 50px;
            transition: background-color 0.3s;
        }

        .back-btn:hover {
            background-color: #005c91ff;
        }

        .back-btn i {
            margin-right: 8px;
        }

        .course-header h1 {
            font-size: 28px;
            margin-bottom: 10px;
            color: #062644;
        }

        .course-meta {
            display: flex;
            gap: 15px;
            color: #718096;
            font-size: 14px;
        }

        .course-meta i {
            margin-right: 5px;
        }

        .course-content {
            display: flex;
            gap: 30px;
        }

        .course-video {
            flex: 2;
        }

        .course-sidebar {
            flex: 1;
            max-width: 350px;
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
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #fff;
            background: #2d3748;
        }

        .video-placeholder i {
            font-size: 50px;
            margin-bottom: 15px;
            color: #e2e8f0;
        }

        .video-description h3 {
            font-size: 20px;
            margin-bottom: 15px;
            color: #062644;
        }

        .video-description p {
            color: #4a5568;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .instructor-info h4 {
            font-size: 18px;
            margin-bottom: 15px;
            color: #062644;
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
            color: #062644;
        }

        .instructor-text p {
            margin: 5px 0 0;
            font-size: 14px;
            color: #718096;
        }

        .progress-container {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
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
            color: #2d3748;
        }

        .progress-percent {
            font-weight: bold;
            color: #4299e1;
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
            background: #38b6ff;
            border-radius: 4px;
            transition: width 0.3s;
        }

        .progress-actions {
            text-align: center;
        }

        .mark-complete-btn {
            background-color: #38b6ff;
            color: #eefefe;
            border: none;
            padding: 15px 20px;
            border-radius: 50px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .mark-complete-btn:hover {
            background: #3182ce;
        }

        .mark-complete-btn i {
            margin-right: 8px;
        }

        .episodes-list {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .episodes-list h3 {
            margin: 0 0 15px;
            font-size: 18px;
            color: #2d3748;
        }

        #course-episodes-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .episode-item {
            display: flex;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #edf2f7;
            cursor: pointer;
            transition: background 0.2s;
        }

        .episode-item:last-child {
            border-bottom: none;
        }

        .episode-item:hover {
            background: #f7fafc;
        }

        .episode-number {
            width: 30px;
            height: 30px;
            background: #e2e8f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 14px;
            color: #4a5568;
        }

        .episode-info {
            flex: 1;
        }

        .episode-info h4 {
            margin: 0 0 5px;
            font-size: 15px;
            color: #2d3748;
        }

        .episode-info p {
            margin: 0;
            font-size: 13px;
            color: #718096;
        }

        .episode-item.completed .episode-number {
            background: #4299e1;
            color: white;
        }

        .episode-item.completed .episode-info h4 {
            color: #4299e1;
        }

        .episode-item i.fa-check-circle {
            color: #48bb78;
            margin-left: 10px;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .course-content {
                flex-direction: column;
            }
            
            .course-sidebar {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="course-show-container">
        <div class="course-header">
            <button class="back-btn" onclick="window.history.back()">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </button>
            <h1>{{ $course['title'] }}</h1>
            <div class="course-meta">
                <span><i class="fas fa-tag"></i> {{ $course['category'] }}</span>
                <span><i class="fas fa-signal"></i> {{ ucfirst($course['level']) }}</span>
                <span><i class="far fa-clock"></i> {{ $course['duration'] }}</span>
            </div>
        </div>
        
        <div class="course-content">
            <div class="course-video">
                <div class="video-container" id="video-container">
                    <div class="video-placeholder">
                        <i class="fas fa-play-circle"></i>
                        <p>Select an episode to start watching</p>
                    </div>
                </div>
                <div class="video-description">
                    <h3>About This Course</h3>
                    <p>{{ $course['description'] }}</p>
                    
                    <div class="instructor-info">
                        <h4>Instructor</h4>
                        <div class="instructor-details">
                            <div class="instructor-avatar">
                                <img src="{{ asset('images/default-avatar.png') }}" alt="Instructor Avatar">
                            </div>
                            <div class="instructor-text">
                                <h5>{{ $course['instructor'] }}</h5>
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
                        <button class="mark-complete-btn" id="mark-complete-btn">
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
                            data-video-url="{{ $episode['video_url'] }}">
                            <div class="episode-number">{{ $episode['number'] }}</div>
                            <div class="episode-info">
                                <h4>{{ $episode['title'] }}</h4>
                                <p>{{ $episode['duration'] }}</p>
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

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.episode-item').forEach(item => {
                item.addEventListener('click', function() {
                    const videoUrl = this.getAttribute('data-video-url');
                    const episodeId = this.getAttribute('data-episode-id');

                    const videoContainer = document.getElementById('video-container');
                    videoContainer.innerHTML = `
                        <video controls autoplay style="width: 100%; height: 100%">
                            <source src="${videoUrl}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    `;
                    
                    document.querySelectorAll('.episode-item').forEach(ep => {
                        ep.classList.remove('active');
                    });
                    this.classList.add('active');
                    
                    const video = videoContainer.querySelector('video');
                    video.play().catch(e => console.log('Auto-play prevented:', e));
                });
            });
            
            document.getElementById('mark-complete-btn').addEventListener('click', function() {
                const activeEpisode = document.querySelector('.episode-item.active');
                if (!activeEpisode) {
                    alert('Please select an episode first');
                    return;
                }
                
                const episodeId = activeEpisode.getAttribute('data-episode-id');
                const courseId = {{ $course['id'] }};
                
                fetch(`/enrolled-courses/${courseId}/episodes/${episodeId}/complete`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        activeEpisode.classList.add('completed');
                        activeEpisode.innerHTML += '<i class="fas fa-check-circle"></i>';
                        
                        document.querySelector('.progress-percent').textContent = `${data.progress}%`;
                        document.querySelector('.progress-fill').style.width = `${data.progress}%`;
                        
                        alert('Episode marked as completed!');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to mark episode as completed');
                });
            });
        });
    </script>
</body>
@endpush