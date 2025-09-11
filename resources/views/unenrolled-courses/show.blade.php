<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>{{ $course->title }} | Course Details</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="TechnoSpeak">
        <meta http-equiv="Content-Security-Policy" content="child-src 'none'">
        <link rel="icon" href="@secureAsset('images/icon.png')" type="image/x-icon">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="has-formal-payment" content="{{ $hasFormalPayment ? 'true' : 'false' }}">
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
                background-size: inherit;
                background-repeat: no-repeat;
                background-position: center;
            }
            
            .main-cont-unenrolled {
                background-color: #ffffffc2;
                height: fit-content;
            }
            
            .course-show-container {
                max-width: 85%;
                margin: 0 auto;
                padding: 30px;
            }
            
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
            
            .enroll-btn {
                background-color: #062644;
                color: #fff;
            }
            
            .enroll-btn:hover {
                background-color: #2f855a;
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
            }
            
            .video-thumb {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block;
            }
            
            .video-locked {
                position: absolute;
                inset: 0;
                background: rgba(0, 0, 0, 0.7);
                color: #fff;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align: center;
            }
            
            .video-locked i {
                font-size: 50px;
                margin-bottom: 15px;
                color: #e2e8f0;
            }
            
            .video-description {
                margin-bottom: 30px;
            }
            
            .video-description h3 {
                font-size: 20px;
                margin-bottom: 15px;
                color: var(--text-dark);
            }
            
            .video-description p {
                color: var(--text-light);
                line-height: 1.5;
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
            .course-sidebar > div {
                margin: 10px 0;
            }
            
            .course-details-card {
                background: #fff;
                border-radius: 8px;
                padding: 20px;
                box-shadow: var(--shadow);
                margin-bottom: 25px;
            }
            
            .course-details-card h3 {
                margin: 0 0 15px;
                font-size: 18px;
                color: var(--text-medium);
            }
            
            .detail-item {
                display: flex;
                justify-content: space-between;
                padding: 10px 0;
                border-bottom: 1px solid var(--border-light);
            }
            
            .detail-item:last-child {
                border-bottom: none;
            }
            
            .detail-label {
                color: var(--text-light);
            }
            
            .detail-value {
                color: var(--text-dark);
                font-weight: 500;
            }
            
            .what-you-learn {
                margin-top: 30px;

            }
            
            .learn-list {
                list-style: none;
                padding: 0 0 10px 0;
                margin: 0;
            }
            
            .learn-item {
                display: flex;
                align-items: flex-start;
                flex-direction: column;
                padding: 3px 0;
            }
            
            .learn-item i {
                color: var(--primary-color);
                margin-right: 10px;
                margin-top: 3px;
                font-size: smaller;
            }
            
            .course-tabs {
                display: flex;
                border-bottom: 1px solid var(--border-light);
                margin-bottom: 20px;
            }
            
            .tab-btn {
                padding: 10px 20px;
                background: none;
                border: none;
                border-bottom: 3px solid transparent;
                cursor: pointer;
                font-weight: 500;
                color: var(--text-light);
                transition: all 0.3s ease;
            }
            
            .tab-btn.active {
                color: var(--primary-color);
                border-bottom-color: var(--primary-color);
            }
            
            .tab-content {
                display: none;
            }
            
            .tab-content.active {
                display: block;
            }
            
            .episodes-list {
                background: #fff;
                border-radius: 8px;
                padding: 20px;
                box-shadow: var(--shadow);
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
            }
            
            .episode-item:last-child {
                border-bottom: none;
            }
            
            .episode-number {
                width: 40px;
                height: 40px;
                background-color: var(--border-light);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-right: 15px;
                font-size: 15px;
                color: var(--text-light);
                flex-shrink: 0;
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
            
            .episode-locked {
                color: var(--text-light);
                margin-left: 10px;
                flex-shrink: 0;
            }
            
            .course-rating {
                margin-top: 30px;
                padding: 20px;
                background: white;
                border-radius: 8px;
                box-shadow: var(--shadow);
            }
            
            .rating-display {
                margin-bottom: 20px;
            }
            
            .average-rating {
                margin-bottom: 10px;
                font-size: 16px;
            }
            
            .stars {
                display: inline-flex;
                gap: 2px;
            }
            
            .stars i {
                color: gold;
                font-size: 20px;
            }
            
            .all-reviews-container {
                margin-top: 30px;
                padding-top: 20px;
                border-top: 1px solid var(--border-light);
            }
            
            .review-item {
                margin-bottom: 20px;
                padding: 15px;
                background: #f9f9f9;
                border-radius: 8px;
            }
            
            .review-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 10px;
            }
            
            .review-user {
                display: flex;
                align-items: center;
            }
            
            .review-avatar {
                width: 30px;
                height: 30px;
                border-radius: 50%;
                margin-right: 10px;
                object-fit: cover;
            }
            
            .review-user-name {
                font-weight: 500;
                color: var(--text-dark);
            }
            
            .review-stars {
                color: gold;
            }
            
            .review-date {
                font-size: 12px;
                color: var(--text-light);
                margin-bottom: 10px;
            }
            
            .review-content {
                line-height: 1.5;
                color: var(--text-medium);
            }
            
            .enroll-card {
                background: white;
                padding: 25px;
                border-radius: 8px;
                box-shadow: var(--shadow);
                text-align: center;
            }
            
            .course-price {
                font-size: 28px;
                font-weight: bold;
                color: var(--text-dark);
                margin: 15px 0;
            }
            
            .price-free {
                color: var(--success-color);
            }
            
            .includes-title {
                font-size: 14px;
                color: var(--text-light);
                margin: 10px 0;
            }
            
            .includes-list {
                list-style: none;
                padding: 0;
                margin: 0 0 20px;
                text-align: left;
            }
            
            .includes-item {
                padding: 8px 0;
                display: flex;
                align-items: center;
            }
            
            .includes-item i {
                color: var(--primary-color);
                margin-right: 10px;
            }

            .includes-item .fa-infinity {
                transform: rotate(40deg);
            }
            
            .login-to-enroll {
                margin-top: 20px;
                padding: 15px;
                background: #f8f9fa;
                border-radius: 8px;
                text-align: center;
            }
            
            .login-to-enroll a {
                color: var(--primary-color);
                text-decoration: none;
                font-weight: 500;
            }
            
            .login-to-enroll a:hover {
                text-decoration: underline;
            }
            
            .subscription-required {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                color: var(--danger-color);
                margin: -20px 0 0 0;
                font-size: 14px;
            }

            .upgrade-btn {
                background-color: #ffc107;
                color: #000;
            }

            .upgrade-btn:hover {
                background-color: #e0a800;
                transform: translateY(-1px);
            }

            .enroll-card .upgrade-btn {
                margin-top: 15px;
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
                    order: -1;
                    margin-bottom: 30px;
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
        </style>
    </head>
    <body>
        <div class="main-cont-unenrolled">
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
                            @if ($course->plan_type === 'frml_training')
                                <button class="btn back-btn" onclick="window.location.href='/dashboard#usr_formaltraining'">
                                    <i class="fas fa-arrow-left"></i>
                                    View All Trainings
                                </button>
                            @else
                                <button class="btn back-btn" onclick="window.location.href='/dashboard#usr_alltricks'">
                                    <i class="fas fa-arrow-left"></i>
                                    View All Tips&Tricks
                                </button>
                            @endif
                            @auth
                                <form id="enroll-form" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="course_id" value="{{ $course->uuid }}">
                                    <button type="button" class="btn enroll-btn" id="enroll-btn"
                                        data-course-id="{{ $course->uuid }}"
                                        data-plan-type="{{ $course->plan_type }}"
                                        data-course-price="{{ $course->price }}"
                                        >
                                        <i class="fas fa-plus-circle"></i>
                                        @if ($course->plan_type === 'frml_training')
                                            Checkout (1)
                                        @else 
                                            Watch Now
                                        @endif
                                    </button>
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>

                <div class="course-tabs">
                    <button class="tab-btn active" data-tab="overview">Overview</button>
                    <button class="tab-btn" data-tab="curriculum">Curriculum</button>
                    <button class="tab-btn" data-tab="reviews">Reviews</button>
                </div>

                <div class="tab-content active" id="overview-tab">     
                    <div class="course-content">
                        <div class="course-video">
                            <div class="video-container">
                                <div class="video-placeholder">
                                    <img src="{{ $course->thumbnail }}" alt="Course Thumbnail" class="video-thumb" />
                                    <div class="video-locked">
                                        <i class="fas fa-lock"></i>
                                        @if ($course->plan_type === 'frml_training')
                                            <p>Enroll to unlock this content</p>
                                        @else 
                                            <p>Start watching now & unlock all full series</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="video-description">
                                @if ($course->plan_type === 'frml_training')
                                    <h3>About This Training</h3>
                                @else 
                                    <h3>About These Tips&Tricks</h3>
                                @endif
                                <p>{{ $course->description }}</p>
                                
                                <div class="what-you-learn">
                                    <h3>What You'll Learn</h3>
                                    <div class="learn-list">
                                        @foreach($course['episodes'] as $episode)
                                            <div class="learn-item">
                                                <div style="display: inline-flex;">
                                                    <i class="fas fa-check"></i>
                                                    <p>{{ $episode->title }}</p>
                                                </div>
                                                <div>
                                                    <span style="visibility: hidden;">.......</span><i>{{ $episode->description }}</i>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <div class="instructor-info">
                                    <h4>Technos</h4>
                                    <div class="instructor-details">
                                        <div class="instructor-avatar">
                                            <img src="{{ $course->instructor->thumbnail }}" alt="Instructor Avatar">
                                        </div>
                                        <div class="instructor-text">
                                            <h5>{{ $course->instructor->name }}</h5>
                                            <p>Senior Technite</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="course-sidebar">
                            <div class="enroll-card">
                                <h3>
                                    @if($course->plan_type == 'frml_training')
                                        Enroll in this training
                                    @else 
                                        Start Watching
                                    @endif
                                </h3>
                                @if($course->plan_type == 'free' || $course->plan_type == 'paid')
                                    <div class="course-price price-free">Quartely Subscription</div>
                                @else
                                    <div class="course-price">R{{ $course->price }}</div>
                                    @unless($hasActiveSubscription)
                                        <div class="subscription-required" style="text-align:center;">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <span>Payment required to access this training!</span>
                                        </div>
                                    @endunless
                                @endif                                
                                <div class="includes-title">
                                    @if($course->plan_type == 'frml_training')
                                        This <i>Formal training</i> includes:
                                    @else 
                                        This <i>Tips&Tricks</i> series includes:
                                    @endif
                                </div>
                                <ul class="includes-list">
                                    <li class="includes-item">
                                        <i class="far fa-play-circle"></i>
                                        <span>{{ $course->episodes_count }} trainings on-demand trainings</span>
                                    </li>
                                    <li class="includes-item">
                                        <i class="far fa-file-alt"></i>
                                        <span>{{ $course->resources_count }} downloadable resources</span>
                                    </li>
                                    <li class="includes-item">
                                        <i class="fas fa-infinity"></i>
                                        <span>Full lifetime access</span>
                                    </li>
                                    @if($course->has_certificate)
                                        <li class="includes-item">
                                            <i class="fas fa-certificate"></i>
                                            <span>Certificate of completion</span>
                                        </li>
                                    @endif
                                </ul>
                                
                                @auth
                                    <form id="sidebar-enroll-form">
                                        @csrf
                                        <input type="hidden" name="course_id" value="{{ $course->uuid }}">
                                        <button type="button" class="btn enroll-btn" id="sidebar-enroll-btn"
                                            data-course-id="{{ $course->uuid }}"
                                            data-plan-type="{{ $course->plan_type }}"
                                            data-course-price="{{ $course->price }}"
                                            style="width: 100%;">

                                            <i class="fas fa-plus-circle"></i> Checkout (1)
                                        </button>
                                    </form>
                                @else
                                    <div class="login-to-enroll">
                                        <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}">Log in</a> to enroll in this course
                                    </div>
                                @endauth
                            </div>
                            
                            <div class="course-details-card">
                                @if ($course->plan_type === 'frml_training')
                                    <h3>Training Details</h3>
                                @else 
                                    <h3>Tips&Tricks Details</h3>
                                @endif
                                <div class="detail-item">
                                    <span class="detail-label">Category</span>
                                    <span class="detail-value">{{ $course->category?->name }}</span>
                                </div>
                                @if ($course->plan_type === 'frml_training')
                                    <div class="detail-item">
                                        <span class="detail-label">Level</span>
                                        <span class="detail-value">{{ $course->level }}</span>
                                    </div>
                                @endif
                                <div class="detail-item">
                                    <span class="detail-label">Duration</span>
                                    <span class="detail-value">{{ $course->formatted_duration }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Last Updated</span>
                                    <span class="detail-value">{{ $course->updated_at->format('M d, Y') }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Language</span>
                                    <span class="detail-value">English</span>
                                </div>
                                @if($course->has_certificate)
                                <div class="detail-item">
                                    <span class="detail-label">Certificate</span>
                                    <span class="detail-value">Yes</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-content" id="curriculum-tab" style="display:none;">
                    <div class="episodes-list">
                        @if ($course->plan_type === 'frml_training')
                            <h3>Training Curriculum</h3>
                        @else 
                            <h3>Series Curriculum</h3>
                        @endif
                        <p>Enroll to unlock all videos and resources</p>
                        
                        <ul id="course-episodes-list">
                            @foreach($course->episodes as $episode)
                            <li class="episode-item">
                                <div class="episode-number">{{ $episode->episode_number }}</div>
                                <div class="episode-info">
                                    <h4>{{ $episode->title }}</h4>
                                    <p>{{ $episode->duration_formatted }}</p>
                                </div>
                                <i class="fas fa-lock episode-locked"></i>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="tab-content" id="reviews-tab" style="display:none;">
                    <div class="course-rating">
                        @if ($course->plan_type === 'frml_training')
                            <h3>Training Rating</h3>
                        @else 
                            <h3>Tips&Tricks Rating</h3>
                        @endif
                        <div class="rating-display">
                            <div class="average-rating">
                                <div class="stars" id="average-stars"></div>
                                <span id="average-score">0.0</span> (<span id="rating-count">0</span> ratings)
                            </div>
                        </div>
                        
                        <div class="all-reviews-container" id="reviews-container">
                            <h4>All Reviews</h4>
                            <p>Loading reviews...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Tab switching
                document.querySelectorAll('.tab-btn').forEach(btn => {
                    btn.addEventListener('click', function () {
                        const tabId = this.getAttribute('data-tab');
                        
                        // Toggle tab buttons
                        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                        this.classList.add('active');
                        
                        // Toggle tab content
                        document.querySelectorAll('.tab-content').forEach(content => {
                            content.style.display = 'none';
                        });
                        
                        const target = document.getElementById(`${tabId}-tab`);
                        if (target) {
                            target.style.display = 'block';
                            
                            // Load reviews if reviews tab is selected
                            if (tabId === 'reviews') {
                                loadRatings();
                            }
                        }
                    });
                });
                
                // Enroll button handler
                const enrollBtn = document.getElementById('enroll-btn');
                if (enrollBtn) {
                    enrollBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        
                        const courseTitle = document.querySelector('.title-meta-container h1')?.textContent || 'this course';
                        const courseId = this.dataset.courseId;
                        const planType = this.dataset.planType;
                        const coursePrice = this.dataset.coursePrice;

                        const hasFormalPayment = document.querySelector('meta[name="has-formal-payment"]')?.content === 'true';

                        console.log('hasFormalPayment:', hasFormalPayment);

                        Swal.fire({
                            title: 'Confirm Enrollment',
                            html: `Are you sure you want to enroll in <strong>${courseTitle}</strong>?`,
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#38b6ff',
                            cancelButtonColor: '#718096',
                            confirmButtonText: 'Yes, Enroll',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                if (planType === 'frml_training') {
                                    if (hasFormalPayment) {
                                        window.location.href = `/enrolled-courses/${courseId}`;
                                    } else {
                                        // Sithebe, sithebe
                                        // This is where you'll be working
                                        // After Yoco is successful, 
                                        // Update the PAYMENT table as usual
                                        // also update client_course_subscription->payment_status to 'formal_payment'
                                        // exmaple for the url with the course->price
                                        // window.location.href = `/payment/checkout/${courseId}?amount=${coursePrice}`;
                                    }
                                } else {
                                    enrollInCourse(courseId);
                                }
                            }
                        });
                    });
                }
                
                // Load ratings data
                function loadRatings() {
                    const courseId = {{ $course->id }};
                    
                    fetch(`/api/courses/${courseId}/ratings`)
                        .then(response => {
                            if (!response.ok) throw new Error('Failed to fetch ratings');
                            return response.json();
                        })
                        .then(data => {
                            const averageRating = data.average || 0;
                            document.getElementById('average-score').textContent = Number(averageRating).toFixed(1);
                            document.getElementById('rating-count').textContent = data.count;
                            
                            renderStars(document.getElementById('average-stars'), averageRating, false);
                            
                            const reviewsContainer = document.getElementById('reviews-container');
                            if (reviewsContainer) {
                                if (data.all_ratings && data.all_ratings.length > 0) {
                                    reviewsContainer.innerHTML = '<h4>All Reviews</h4>';
                                    
                                    data.all_ratings.forEach(review => {
                                        const reviewElement = createReviewElement(review);
                                        reviewsContainer.appendChild(reviewElement);
                                    });
                                } else {
                                    reviewsContainer.innerHTML = '<p>No reviews yet</p>';
                                }
                            }
                        })
                        .catch(() => {
                            const reviewsContainer = document.getElementById('reviews-container');
                            if (reviewsContainer) {
                                reviewsContainer.innerHTML = '<p>Could not load reviews</p>';
                            }
                        });
                }
                
                // Create review element
                function createReviewElement(review) {
                    const reviewElement = document.createElement('div');
                    reviewElement.className = 'review-item';
                    
                    const reviewHeader = document.createElement('div');
                    reviewHeader.className = 'review-header';
                    
                    const reviewUser = document.createElement('div');
                    reviewUser.className = 'review-user';
                    
                    const avatar = document.createElement('img');
                    avatar.className = 'review-avatar';
                    
                    const clientData = review.client || {};
                    avatar.src = clientData.avatar || '/images/icons/circle-user-solid.svg';
                    avatar.alt = clientData.name || clientData.surname || 'Anonymous';
                    
                    const userName = document.createElement('span');
                    userName.className = 'review-user-name';
                    
                    userName.textContent = clientData.name && clientData.surname 
                        ? `${clientData.name.substring(0, 3)}${'*'.repeat(clientData.name.length - 3)} ${'*'.repeat(clientData.surname?.length || 0)}`
                        : 'Anonymous';
                    
                    reviewUser.appendChild(avatar);
                    reviewUser.appendChild(userName);
                    
                    const reviewStars = document.createElement('div');
                    reviewStars.className = 'review-stars';
                    reviewStars.innerHTML = renderStarsHTML(review.rating);
                    
                    reviewHeader.appendChild(reviewUser);
                    reviewHeader.appendChild(reviewStars);
                    
                    const reviewDate = document.createElement('div');
                    reviewDate.className = 'review-date';
                    reviewDate.textContent = new Date(review.created_at).toLocaleDateString();
                    
                    const reviewContent = document.createElement('div');
                    reviewContent.className = 'review-content';
                    reviewContent.textContent = review.review || 'No review provided';
                    
                    reviewElement.appendChild(reviewHeader);
                    reviewElement.appendChild(reviewDate);
                    reviewElement.appendChild(reviewContent);
                    
                    return reviewElement;
                }
                
                // function to render stars HTML
                function renderStarsHTML(rating) {
                    let starsHTML = '';
                    const fullStars = Math.floor(rating);
                    const hasHalfStar = rating % 1 >= 0.5;
                    
                    for (let i = 1; i <= 5; i++) {
                        if (i <= fullStars) {
                            starsHTML += '<i class="fas fa-star"></i>';
                        } else if (i === fullStars + 1 && hasHalfStar) {
                            starsHTML += '<i class="fas fa-star-half-alt"></i>';
                        } else {
                            starsHTML += '<i class="far fa-star"></i>';
                        }
                    }
                    return starsHTML;
                }
                
                // Render stars based on rating
                function renderStars(container, rating, interactive = true) {
                    container.innerHTML = '';
                    const fullStars = Math.floor(rating);
                    const hasHalfStar = rating % 1 >= 0.5;
                    
                    for (let i = 1; i <= 5; i++) {
                        const star = document.createElement('i');
                        
                        if (i <= fullStars) {
                            star.className = 'fas fa-star';
                        } else if (i === fullStars + 1 && hasHalfStar) {
                            star.className = 'fas fa-star-half-alt';
                        } else {
                            star.className = 'far fa-star';
                        }
                        
                        container.appendChild(star);
                    }
                }

                // handle paid courses
                document.getElementById('upgrade-btn')?.addEventListener('click', function() {
                    Swal.fire({
                        title: 'Premium Subscription Required',
                        html: `This is a premium course. You need to upgrade your account to enroll.`,
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonText: 'Upgrade Now',
                        cancelButtonText: 'Later'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = " ";
                        }
                    });
                });

                document.getElementById('upgrade-btn-card')?.addEventListener('click', function() {
                    window.location.href = " ";
                });
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Main enroll button handler
                const enrollBtn = document.getElementById('enroll-btn');
                if (enrollBtn) {
                    enrollBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        handleEnrollment();
                    });
                }

                // Sidebar enroll button handler
                const sidebarEnrollBtn = document.getElementById('sidebar-enroll-btn');

                if (sidebarEnrollBtn) {
                    sidebarEnrollBtn.addEventListener('click', function (e) {
                        e.preventDefault();

                        const courseId = this.dataset.courseId;
                        const planType = this.dataset.planType;
                        const coursePrice = this.dataset.coursePrice;

                        const courseTitle = document.querySelector('.title-meta-container h1')?.textContent || 'this course';
                        
                        const hasFormalPayment = document.querySelector('meta[name="has-formal-payment"]')?.content === 'true';

                        if (!courseId) {
                            console.error('Course ID not found');
                            return;
                        }

                        Swal.fire({
                            title: 'Confirm Enrollment',
                            html: `Are you sure you want to enroll in <strong>${courseTitle}</strong>?`,
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#38b6ff',
                            cancelButtonColor: '#718096',
                            confirmButtonText: 'Yes, Enroll',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                if (planType === 'frml_training') {
                                    if (hasFormalPayment) {
                                        window.location.href = `/enrolled-courses/${courseId}`;
                                    } else {
                                        // Sithebe, sithebe
                                        // This is where you'll be working
                                        // After Yoco is successful, 
                                        // Update the client_course_subscription->payment_status to 'formal_payment'
                                        // exmaple for the url with the course->price
                                        // window.location.href = `/payment/checkout/${courseId}?amount=${coursePrice}`;
                                    }
                                } else {
                                    enrollInCourse(courseId);
                                }
                            }
                        });
                    });
                }

                function handleEnrollment() {
                    const courseTitle = document.querySelector('.title-meta-container h1')?.textContent || 'this course';
                    const courseId = document.querySelector('input[name="course_id"]')?.value || 
                                    document.querySelector('#sidebar-enroll-form input[name="course_id"]')?.value;
                    const planType = document.querySelector('meta[name="course-plan-type"]')?.content;
                    const coursePrice = document.querySelector('meta[name="course-price"]')?.content;

                    const hasFormalPayment = document.querySelector('meta[name="has-formal-payment"]')?.content === 'true';
                    
                    if (!courseId) {
                        console.error('Course ID not found');
                        return;
                    }

                    Swal.fire({
                        title: 'Confirm Enrollment',
                        html: `Are you sure you want to enroll in <strong>${courseTitle}</strong>?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#38b6ff',
                        cancelButtonColor: '#718096',
                        confirmButtonText: 'Yes, Enroll',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (planType === 'frml_training') {
                                console.log('hasFormalPayment:', hasFormalPayment);

                                if (hasFormalPayment) {
                                    window.location.href = `/enrolled-courses/${courseId}`;
                                } else {
                                    // Sithebe, sithebe
                                    // This is where you'll be working
                                    // After Yoco is successful, 
                                    // Update the client_course_subscription->payment_status to 'formal_payment'
                                    // exmaple for the url with the course->price
                                    // window.location.href = `/payment/checkout/${courseId}?amount=${coursePrice}`;
                                }
                            } else {
                                enrollInCourse(courseId);
                            }
                        }
                    });
                }

                function enrollInCourse(courseId) {
                    fetch('/courses/enroll', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ course_id: courseId })
                    })
                    .then(async response => {
                        const data = await response.json();

                        if (response.status === 409) {
                            if (data.redirect) {
                                window.location.href = data.redirect;
                            } else {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Already Enrolled',
                                    text: data.message || 'You are already enrolled in this course',
                                    timer: 3000,
                                    showConfirmButton: true
                                }).then(() => {
                                    if (data.redirect) {
                                        window.location.href = data.redirect;
                                    }
                                });
                            }
                            return;
                        }

                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: data.message,
                                timer: 2500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = `/enrolled-courses/${courseId}`;
                            });
                        } else if (data.open_url) {
                            window.location.href = data.open_url;
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || 'Enrollment failed',
                                timer: 5000,
                                showConfirmButton: true
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Enrollment error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred during enrollment',
                            timer: 5000,
                            showConfirmButton: true
                        });
                    });
                }
            });
        </script>
    </body>
</html>