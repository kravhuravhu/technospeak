<!DOCTYPE html>
<html lang="en">
    <head>
        <title>
            Dashboard - 
            @if(Auth::check())
                {{ Auth::user()->name }} {{ Auth::user()->surname }}
            @else
                Technospeak Strategies
            @endif
        </title>
        <meta charset="UTF-8">
        <meta name="user-id" content="{{ auth()->id() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="TechnoSpeak">
        <meta property="og:type" content="website">
        <link rel="icon" href="@secureAsset('images/icon.png')" type="image/x-icon">
        <link rel="stylesheet" href="@secureAsset('style/dashboard.css')">
        <link rel="stylesheet" href="@secureAsset('style/footer.css')">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Alegreya:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Schoolbell&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <!-- Font Awesome CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        @include('components.preference-popup', [
            'categories' => \App\Models\CourseCategory::all()
        ])

        @include('components.pop-up')

        <section class="sidebar bar-lt-rt">
            <div class="main_container">
                <div class="logo_container">
                    <a href="#">
                        <img src="@secureAsset('/images/default-no-logo.png')" alt="technospeak_icon">
                    </a>
                </div>
                <div class="nav-bar">
                    <div class="container">
                        <div class="nav-item active" data-section="usr_dashboard">
                            <a href="">
                                <div class="icon">
                                    <i class="fa-solid fa-border-all"></i>
                                </div>
                                <div class="title">
                                    <span>Dashboard</span>
                                </div>
                            </a>
                        </div>

                        <div class="nav-item" data-section="usr_alltricks">
                            <a href="">
                                <div class="icon">
                                    <i class="fa-solid fa-lightbulb"></i>
                                </div>
                                <div class="title">
                                    <span>Tips/Tricks</span>
                                </div>
                            </a>
                        </div>

                        <div class="nav-item" data-section="usr_formaltraining">
                            <a href="">
                                <div class="icon">
                                    <i class="fa-solid fa-computer"></i>
                                </div>
                                <div class="title">
                                    <span>Formal Training</span>
                                </div>
                            </a>
                        </div>

                        <div class="nav-item" data-section="usr_taskAssistance">
                            <a href="">
                                <div class="icon">
                                    <i class="fa-solid fa-handshake-angle"></i>
                                </div>
                                <div class="title">
                                    <span>Task Assistance</span>
                                </div>
                            </a>
                        </div>

                        <div class="nav-item" data-section="usr_guide">
                            <a href="">
                                <div class="icon">
                                    <i class="fa-solid fa-user-graduate"></i>
                                </div>
                                <div class="title">
                                    <span>Personal Guides</span>
                                </div>
                            </a>
                        </div>

                        <div class="nav-item" data-section="usr_mysubscriptions">
                            <a href="">
                            <div class="icon">
                                <i class="fa-solid fa-tags"></i>
                            </div>
                            <div class="title">
                                <span>Product Plan</span>
                            </div>
                            </a>
                        </div>
                        <div class="nav-item" data-section="usr_resources">
                            <a href="">
                            <div class="icon">
                                <i class="fa-solid fa-award"></i>
                            </div>
                            <div class="title">
                                <span>Resources</span>
                            </div>
                            </a>
                        </div>   
                        <div class="nav-item" data-section="usr_support">
                            <a href="">
                            <div class="icon">
                                <i class="fa-solid fa-circle-info"></i>
                            </div>
                            <div class="title">
                                <span>Support</span>
                            </div>
                            </a>
                        </div>
                        <div class="nav-item" data-section="usr_settings">
                            <a href="">
                            <div class="icon">
                                <i class="fa-solid fa-gears"></i>
                            </div>
                            <div class="title">
                                <span>Settings</span>
                            </div>
                            </a>
                        </div>
                        <hr>
                        <div class="nav_home">
                            <a href="/">
                            <div class="icon">
                                <i class="fa-solid fa-home"></i>
                            </div>
                            <div class="title">
                                <span>Home</span>
                            </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="promo ">
                <div class="rightbar_nav">
                    <div class="txt_btn" id="txt_btn_rm">
                        <p>Something about cheatsheet? well ipsum dolor sit amet consectetur</p>
                        <button>Upgrade Now</button>
                    </div>
                    <div class="profile_cont_rt_bar" id="profile_tag">
                        {{-- Include the right bar profile tag --}}
                       @include('layouts.profileTag', ['showDropdown' => false])
                    </div>
                </div>
            </div>
        </section>

        <section class="main">
            <div class="container">
                <!-- dashboard containers -->
                <div class="content-section active dashboard_content with_current_learnings" id="usr_dashboard">
                    <div class="topbar search-bar">
                        <i class="fa fa-search search-icon"></i>
                        <input type="text" placeholder="Search...">
                    </div>
                   <div class="welcome">
                        <div class="nname">
                            <h1>
                                @php
                                    $hour = now()->hour;
                                    if ($hour < 12) {
                                        echo 'Good Morning,';
                                    } elseif ($hour < 17) {
                                        echo 'Good Afternoon,';
                                    } else {
                                        echo 'Good Evening,';
                                    }
                                @endphp
                                {{ Auth::user()->name }}!
                            </h1>

                            @if(isset($tipsAndTricksCourses) && $tipsAndTricksCourses->isNotEmpty())
                                <p>Dive back into your favorite Tips & Tricks videos or explore more Formal Trainings to level up your skills.</p>
                                @php
                                    $nextCourse = $tipsAndTricksCourses->first() ?? ($formalTrainingCourses->first() ?? null);
                                @endphp
                                @if($nextCourse)
                                    <p><i class="fas fa-arrow-circle-right"></i> Why not continue with <strong>{{ $nextCourse->title }}</strong>?</p>
                                @endif
                            @else
                                <p><span>Explore our Tips & Tricks and Formal Trainings to unlock new skills & knowledge.</p>
                                <p>Start your first trainings today and make progress toward your goals!</p>
                            @endif
                        </div>
                        <div class="welcome-illustration">
                            <picture>
                                <source srcset="https://fonts.gstatic.com/s/e/notoemoji/latest/1f44b_1f3fd/512.webp" type="image/webp">
                                <img src="https://fonts.gstatic.com/s/e/notoemoji/latest/1f44b_1f3fd/512.gif" alt="👋" class="waving-hand">
                            </picture>
                        </div>
                    </div>
                    <div class="my_learnings ln_rcmm">
                        <div class="container">
                            <div class="title">
                                <h1>Your Current Tips&Tricks</h1>
                            </div>
                            <div class="card-grid">
                                @forelse($tipsAndTricksCurrent as $course)
                                    <a href="{{ route('enrolled-courses.show', $course->uuid) }}" class="enrolled-course-link">
                                        <div class="card">
                                            <div class="thmbnail">
                                                <img src="{{ $course->thumbnail }}" alt="{{ $course->title }}">
                                                <div class="trnsprnt"></div>
                                            </div>
                                            <div class="details">
                                                <div class="title content">
                                                    <h1>{{ $course->title }}</h1>
                                                </div>

                                                <div class="dur content">
                                                    <p>{{ $course->catch_phrase }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="empty-state">
                                        <p>You're currently not watching any tips and tricks videos yet.</p>
                                        <a href="#usr_alltricks" class="browse-btn">Browse Tips&Tricks → </a>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="rcmmnd_trngs ln_rcmm">
                        <div class="container">
                            <div class="title">
                                <h1>Recommended Trainings</h1>
                                @if(Auth::user()->preferred_category_id)
                                    <p>Based on your interest in {{ Auth::user()->preferredCategory->name }}</p>
                                @endif
                            </div>
                            <div class="card-grid thn_grid_cd">
                                @forelse($recommendedCourses as $course)
                                    <a href="#" class="training-card"
                                        data-course-id="{{ $course->uuid }}"
                                        data-training-type="{{ $course->plan_type }}"
                                        data-title="{{ $course->title }}"
                                        data-description="{{ $course->description }}"
                                        data-image="{{ $course->thumbnail }}"
                                        data-duration="{{ $course->formatted_duration }}"
                                        data-level="{{ ucfirst($course->level) }}"
                                        data-instructor="{{ $course->instructor->name ?? 'Unknown' }}"
                                        data-enrolled="{{ $course['is_enrolled'] ? 'true' : 'false' }}"
                                        data-show-link="{{ $course['is_enrolled'] ? route('enrolled-courses.show', $course['uuid']) : '' }}"
                                        data-category="{{ $course->category->name ?? 'Uncategorized' }}"
                                        data-price="{{ $course->plan_type === 'paid' ? 'Premium Training' : 'Free' }}"
                                        data-episodes='@json($course->episodes->map(function($episode) {
                                            return [
                                                "number" => $episode->episode_number,
                                                "name" => $episode->title,
                                                "duration" => $episode->duration_formatted
                                            ];
                                        }))'
                                        data-time="{{ $course->formatted_duration }}"
                                        data-created="{{ $course->created_at->toDateTimeString() }}">
                                        <div class="card rcmmd_cd">
                                            <div class="thmbnail thn_rcmm">
                                                <div class="trnsprnt thmb_img">
                                                    <img src="{{ $course->thumbnail }}" alt="{{ $course->title }}">
                                                </div>
                                            </div>
                                            <div class="details thmb_dt">
                                                <div class="title content thmb_cnt">
                                                    <h1 class="thmb_h1">{{ Str::limit($course->title, 20) }}</h1>
                                                </div>
                                                <div class="ctprs content thmb_cnt">
                                                    <p class="thmb_ct">{{ Str::limit($course->description, 150) }}...</p>
                                                </div>
                                                <div class="thmb_dur_ep_container content thmb_cnt">
                                                    <div class="cont left-side">
                                                        <i class="fa-solid fa-stopwatch"></i>
                                                        <span>{{ $course->formatted_duration }}</span>
                                                    </div>
                                                    <div class="cont right-side">
                                                        <i class="fa-solid fa-video"></i>
                                                        <span>{{ $course->episodes->count() }} Video<i>(s)</i></span>
                                                    </div>
                                                </div>
                                                <div class="thmb_enrll content">
                                                    <label class="{{ $course->is_enrolled ? 'enrolled' : '' }}">
                                                        {{ $course->is_enrolled ? 'Enrolled' : ($course->plan_type === 'paid' ? 'Unlock' : 'Enroll Free') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="no-courses-message" style="padding: 20px;text-align: center;color: #718096;background: #f8fafc;border-radius: 8px;margin: 20px;font-style: italic;">
                                        <p>No recommended courses available at the moment.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- tips and tricks containers -->
                <div class="content-section alltricks_content" id="usr_alltricks">
                    <div class="rcmmnd_trngs tips_tricks all_tr ln_rcmm">
                        <div class="container">
                            <div class="section-header">
                                <div class="title">
                                    <h1>Tips & Tricks</h1>
                                    <p class="subtitle">Collections of Tips and tricks designed to boost your skills efficiently.</p>
                                </div>
                                <div class="search-filter-container">
                                    <div class="search-box">
                                        <i class="fas fa-search search-icon"></i>
                                        <input type="text" id="tipsSearchInput" placeholder="Search tips and tricks..." class="search-control">
                                    </div>
                                    <div class="filter-dropdown">
                                        <select id="tipsFilterSelect" class="search-control">
                                            <option value="">All Categories</option>
                                            @foreach(\App\Models\CourseCategory::all() as $category)
                                                <option value="{{ $category->name }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <i class="fas fa-filter filter-icon"></i>
                                    </div>
                                </div>
                            </div>

                            <div id="courseNoResultsMessageTips" style="display:none;" class="no-results-message">
                                No trainings match your criteria. Try a different search
                            </div>

                            <div class="card-grid thn_grid_cd" id="tips-trainings">
                                @if($allTipsTricks->count() > 0)
                                    @foreach($allTipsTricks as $course)
                                        <a href="#" class="training-card"
                                            data-course-id="{{ $course['uuid'] }}"
                                            data-training-type="{{ $course['plan_type'] }}"
                                            data-title="{{ $course['title'] }}"
                                            data-description="{{ $course['description'] }}"
                                            data-image="{{ $course['thumbnail'] }}"
                                            data-duration="{{ $course['formatted_duration'] }}"
                                            data-level="{{ ucfirst($course['level']) }}"
                                            data-instructor="{{ $course['instructor_name'] }}"
                                            data-category="{{ $course['category_name'] }}"
                                            data-episodes='@json($course["episodes"])'
                                            data-time="{{ $course['formatted_duration'] }}"
                                            data-enrolled="{{ $course['is_enrolled'] ? 'true' : 'false' }}"
                                            data-show-link="{{ $course['is_enrolled'] ? route('enrolled-courses.show', $course['uuid']) : '' }}"
                                            data-created="{{ $course['created_at']->toDateTimeString() }}">
                                            <div class="card rcmmd_cd">
                                                <div class="thmbnail thn_rcmm">
                                                    <div class="trnsprnt thmb_img">
                                                        <img src="{{ $course['thumbnail'] }}" alt="{{ $course['title'] }}">
                                                    </div>
                                                </div>
                                                <div class="details thmb_dt">
                                                    <div class="title content thmb_cnt">
                                                        <h1 class="thmb_h1">{{ Str::limit($course['title'], 20) }}</h1>
                                                    </div>
                                                    <div class="ctprs content thmb_cnt">
                                                        <p class="thmb_ct">{{ Str::limit($course['description'], 150) }}...</p>
                                                    </div>
                                                    <div class="thmb_dur_ep_container content thmb_cnt">
                                                        <div class="cont left-side">
                                                            <i class="fa-solid fa-stopwatch"></i>
                                                            <span>{{ $course['formatted_duration'] }}</span>
                                                        </div>
                                                        <div class="cont right-side">
                                                            <i class="fa-solid fa-video"></i>
                                                            <span>{{ $course['episodes_count'] }} Video<i>(s)</i></span>
                                                        </div>
                                                    </div>
                                                    <div class="thmb_enrll content">
                                                        <label class="{{ $course['is_enrolled'] ? 'enrolled' : '' }}">
                                                            {{ $course['is_enrolled'] ? 'Continue Watching' : 'Watch Now' }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                @else
                                    <div class="no-results-message" style="padding: 20px;text-align: center;color: #718096;background: #f8fafc;border-radius: 8px;margin: 20px;font-style: italic;">
                                        <p>There are no Tips & Tricks available at the moment. Please check back later!</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formal Trainings -->
                <div class="content-section formaltrainings_content with_current_learnings" id="usr_formaltraining">
                    <div class="my_learnings ln_rcmm">
                        <div class="container">
                            <div class="title">
                                <h1>My Trainings</h1>
                            </div>
                            <div class="card-grid">
                                @forelse($formalTrainingCurrent as $course)
                                    <a href="{{ route('enrolled-courses.show', $course->uuid) }}" class="enrolled-course-link">
                                        <div class="card">
                                            <div class="thmbnail">
                                                <img src="{{ $course->thumbnail }}" alt="{{ $course->title }}">
                                                <div class="trnsprnt"></div>
                                            </div>
                                            <div class="details">
                                                <div class="title content">
                                                    <h1>{{ $course->title }}</h1>
                                                </div>
                                                <div class="dur content">
                                                    <p><i>Duration: {{ $course->formatted_duration }}</i></p>
                                                </div>
                                                <div class="progress_bar content">
                                                    <div class="main-bar">
                                                        <div class="progress" style="width: {{ $course->progress }}%"></div>
                                                    </div>
                                                    <div class="cr-bar">{{ $course->progress }}%</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="empty-state">
                                        <p>You haven't enrolled in any formal trainings yet.</p>
                                        <a href="#usr_formaltraining" class="browse-btn">Browse All Trainings → </a>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="rcmmnd_trngs formal_tr all_tr ln_rcmm">
                        <div class="container">
                            <div class="section-header">
                                <div class="title">
                                    <h1>More Trainings</h1>
                                    <p class="subtitle">Structured courses for in-depth learning</p>
                                </div>
                                <div class="search-filter-container">
                                    <div class="search-box">
                                        <i class="fas fa-search search-icon"></i>
                                        <input type="text" id="formalSearchInput" placeholder="Search formal trainings..." class="search-control">
                                    </div>
                                    <div class="filter-dropdown">
                                        <select id="formalFilterSelect" class="search-control">
                                            <option value="">All Categories</option>
                                            @foreach(\App\Models\CourseCategory::all() as $category)
                                                <option value="{{ $category->name }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <i class="fas fa-filter filter-icon"></i>
                                    </div>
                                </div>
                            </div>

                            <div id="courseNoResultsMessageFormal" style="display:none;" class="no-results-message">
                                No formal trainings match your criteria. Try a different search.
                            </div>

                            <div class="card-grid thn_grid_cd" id="formal-trainings">
                                @if($formalTrainings->count() > 0)
                                    @foreach($formalTrainings as $course)
                                        <a href="#" class="training-card"
                                            data-course-id="{{ $course['uuid'] }}"
                                            data-training-type="{{ $course['plan_type'] }}"
                                            data-title="{{ $course['title'] }}"
                                            data-description="{{ $course['description'] }}"
                                            data-image="{{ $course['thumbnail'] }}"
                                            data-duration="{{ $course['formatted_duration'] }}"
                                            data-level="{{ ucfirst($course['level']) }}"
                                            data-instructor="{{ $course['instructor_name'] }}"
                                            data-category="{{ $course['category_name'] }}"
                                            data-price="{{ $course['price'] }}"
                                            data-episodes='@json($course["episodes"])'
                                            data-time="{{ $course['formatted_duration'] }}"
                                            data-enrolled="{{ $course['is_enrolled'] ? 'true' : 'false' }}"
                                            data-show-link="{{ $course['is_enrolled'] ? route('enrolled-courses.show', $course['uuid']) : '' }}"
                                            data-created="{{ $course['created_at']->toDateTimeString() }}">
                                            <div class="card rcmmd_cd">
                                                <div class="thmbnail thn_rcmm">
                                                    <div class="trnsprnt thmb_img">
                                                        <img src="{{ $course['thumbnail'] }}" alt="{{ $course['title'] }}">
                                                    </div>
                                                </div>
                                                <div class="details thmb_dt">
                                                    <div class="title content thmb_cnt">
                                                        <h1 class="thmb_h1">{{ Str::limit($course['title'], 20) }}</h1>
                                                    </div>
                                                    <div class="ctprs content thmb_cnt">
                                                        <p class="thmb_ct">{{ Str::limit($course['description'], 150) }}...</p>
                                                    </div>
                                                    <div class="thmb_dur_ep_container content thmb_cnt">
                                                        <div class="cont left-side">
                                                            <i class="fa-solid fa-stopwatch"></i>
                                                            <span>{{ $course['formatted_duration'] }}</span>
                                                        </div>
                                                        <div class="cont right-side">
                                                            <i class="fa-solid fa-video"></i>
                                                            <span>{{ $course['episodes_count'] }} Video<i>(s)</i></span>
                                                        </div>
                                                    </div>
                                                    <div class="thmb_enrll thmb_formal_enrll content">
                                                        @if($course['is_enrolled'])
                                                            <label class="enrolled">Enrolled</label>
                                                        @else
                                                            <div class="price-formal">
                                                                <span>R{{ $course['price'] }}</span>
                                                            </div>
                                                            <div>
                                                                <label>Enroll Now</label>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                @else
                                    <div class="no-results-message" style="padding: 20px;text-align: center;color: #718096;background: #f8fafc;border-radius: 8px;margin: 20px;font-style: italic;">
                                        <p>No formal trainings available at the moment. Please check back later!</p>
                                    </div>
                                @endif
                            </div>

                            @if($formalTrainings->count() > 4)
                                <button class="toggle-btn formal-btn" id="toggle-formal">More Formal Trainings</button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Modal for Training Details -->
                <div id="training-modal" class="modal trainings_modal_details">
                    <div class="modal-content">
                        <span class="close-btn">&times;</span>
                        <div class="modal-header">
                            <h2 class="modal-title" id="modal-title-cs"></h2>
                            <div class="modal-price" id="modal-price"></div>
                        </div>
                        <img src="" alt="Training Image" class="modal-image" id="modal-image">
                        <div class="modal-description" id="modal-description"></div>
                        <div class="modal-meta">
                            <div class="meta-item">
                                <span class="meta-label"><i class="fas fa-stopwatch"></i> Duration:</span>
                                <span id="modal-duration"></span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label"><i class="fas fa-chart-line"></i> Level:</span>
                                <span id="modal-level"></span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label"><i class="fas fa-user-tie"></i> Technite:</span>
                                <span id="modal-instructor"></span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label"><i class="fas fa-tag"></i> Category:</span>
                                <span id="modal-category"></span>
                            </div>
                        </div>
                        
                        <!-- Episode List Section -->
                        <div class="episodes-container">
                            <h3 class="episodes-title"><i class="fas fa-list-ol"></i> Training Videos</h3>
                            <ul class="episode-list" id="episode-list">
                                <!-- by JavaScript -->
                            </ul>
                        </div>
                        
                        <a href="#" class="enroll-btn" id="enroll-btn">Enroll Now</a>
                    </div>
                </div>

                <!-- Task assistance -->
                <div class="content-section assistance_content" id="usr_taskAssistance">
                    <div class="assistance">
                        <div class="container">
                            <div class="section-header">
                                <div class="title">
                                    <h1>Task Assistance Request</h1>
                                    <p class="subtitle">Please fill out this form so we can better understand your needs and provide the right assistance.</p>
                                </div>
                            </div>
                            
                            <form id="taskAssistanceForm" class="task-assistance-form">
                                <div class="form-section">
                                    <h2 class="form-section-title">PERSONAL INFO</h2>
                                    <div class="form-row">
                                        <div class="form-group half-width">
                                            <label for="firstName-task">First Name:</label>
                                            <input type="text" id="firstName-task" name="firstName" required>
                                        </div>
                                        <div class="form-group half-width">
                                            <label for="lastName-task">Last Name:</label>
                                            <input type="text" id="lastName-task" name="lastName" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email-task">Email Address:</label>
                                        <input type="email" id="email-task" name="email" required>
                                    </div>
                                </div>
                                
                                <div class="form-section">
                                    <h2 class="form-section-title">TASK OBJECTIVE</h2>
                                    <div class="form-group fm-g-rw">
                                        <label>Type of Task:</label>
                                        <div class="checkbox-group">
                                            <label class="checkbox-container">
                                                <input type="radio" name="taskType" value="administrative">
                                                <span class="checkmark"></span>
                                                Administrative (e.g. emails, scheduling, data-entry)
                                            </label>
                                            <label class="checkbox-container">
                                                <input type="radio" name="taskType" value="research">
                                                <span class="checkmark"></span>
                                                Research (e.g. internet research, data gathering, analysis, etc)
                                            </label>
                                            <label class="checkbox-container">
                                                <input type="radio" name="taskType" value="writing">
                                                <span class="checkmark"></span>
                                                Writing (e.g. copywriting, reports, articles, etc)
                                            </label>
                                            <label class="checkbox-container">
                                                <input type="radio" name="taskType" value="technical">
                                                <span class="checkmark"></span>
                                                Technical Assistance (e.g. IT Support, software help, etc.)
                                            </label>
                                            <label class="checkbox-container other-option">
                                                <input type="radio" name="taskType" value="other" id="otherTaskType-task">
                                                <span class="checkmark"></span>
                                                Other
                                                <input type="text" id="otherTaskTypeInput-task" class="other-input" placeholder="Specify other task type">
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group fm-g-rw">
                                        <label for="goal-task">What's the main goal or outcome you want to achieve?</label>
                                        <textarea id="goal-task" name="goal" rows="1"></textarea>
                                    </div>
                                    
                                    <div class="form-group fm-g-rw">
                                        <label for="mustHaves-task">Are there any must-have features, functions, or elements?</label>
                                        <textarea id="mustHaves-task" name="mustHaves" rows="1"></textarea>
                                    </div>
                                    
                                    <div class="form-group fm-g-rw">
                                        <label for="taskDescription-task">Task Description:</label>
                                        <textarea id="taskDescription-task" name="taskDescription" rows="1" placeholder="---"></textarea>
                                    </div>
                                </div>
                                
                                <div class="form-section">
                                    <h2 class="form-section-title">MORE DETAILS <i>(ATTACHMENTS OPTIONAL)</i></h2>
                                    <div class="form-group fm-g-rw">
                                        <label for="additionalInfo-task">Any other specifics you'd like to add:</label>
                                        <textarea id="additionalInfo-task" name="additionalInfo" rows="1"></textarea>
                                    </div>
                                    
                                    <div class="form-group fm-g-rw">
                                        <label for="fileUpload-task" class="file-upload-label">
                                            <i class="fas fa-paperclip"></i>
                                            Attach Files
                                        </label>
                                        <input type="file" id="fileUpload-task" name="fileUpload" multiple style="display: none;">
                                        <div id="fileList-task" class="file-list"></div>
                                    </div>
                                </div>
                                
                                <button type="submit" class="submit-btn">Submit Request</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Personal guide -->
                <div class="content-section assistance_content" id="usr_guide">
                    <div class="assistance">
                        <div class="container">
                            <div class="section-header">
                                <div class="title">
                                    <h1>Personal Guide Request Form</h1>
                                    <p class="subtitle">Please fill in this form so we can guide you step-by-step through your task while you learn to do it yourself.</p>
                                </div>
                            </div>
                            
                            <form id="personalGuideForm" class="assistance-form">
                                <div class="form-section">
                                    <h2 class="form-section-title">PERSONAL INFO</h2>
                                    <div class="form-row">
                                        <div class="form-group half-width">
                                            <label for="firstName-guide">First Name:</label>
                                            <input type="text" id="firstName-guide" name="firstName" required>
                                        </div>
                                        <div class="form-group half-width">
                                            <label for="lastName-guide">Last Name:</label>
                                            <input type="text" id="lastName-guide" name="lastName" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group half-width">
                                            <label for="email-guide">Email Address:</label>
                                            <input type="email" id="email-guide" name="email" required>
                                        </div>
                                    </div>
                                    <div class="form-group half-width">
                                        <div class="form-group fm-g-rw">
                                            <label for="preferredMethod-guide">Preferred Method:</label>
                                            <div class="checkbox-group">
                                                <label class="checkbox-container">
                                                    <input type="radio" name="preferredMethod" value="zoom">
                                                    <span class="checkmark"></span>
                                                    Zoom
                                                </label>
                                                <label class="checkbox-container">
                                                    <input type="radio" name="preferredMethod" value="gmeet">
                                                    <span class="checkmark"></span>
                                                    Google Meet
                                                </label>
                                                <label class="checkbox-container">
                                                    <input type="radio" name="preferredMethod" value="teams">
                                                    <span class="checkmark"></span>
                                                    Microsoft Teams
                                                </label>
                                                <label class="checkbox-container">
                                                    <input type="radio" name="preferredMethod" value="whatsapp">
                                                    <span class="checkmark"></span>
                                                    WhatsApp
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-section">
                                    <h2 class="form-section-title">GUIDANCE OBJECTIVE</h2>
                                    <div class="form-group">
                                        <label for="guideType-guide">What Kind Of Guidance You Need Help With? <i>(Briefly describe what you need help with.)</i></label>
                                        <input type="text" id="guideType-guide" name="guide_type" required>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group fm-g-rw">
                                            <label>Your Current Skill Level In This Task:</label>
                                            <div class="checkbox-group">
                                                <label class="checkbox-container">
                                                    <input type="radio" name="skillLevel" value="beginner">
                                                    <span class="checkmark"></span>
                                                    Beginner
                                                </label>
                                                <label class="checkbox-container">
                                                    <input type="radio" name="skillLevel" value="intermediate">
                                                    <span class="checkmark"></span>
                                                    Intermediate
                                                </label>
                                                <label class="checkbox-container">
                                                    <input type="radio" name="skillLevel" value="advanced">
                                                    <span class="checkmark"></span>
                                                    Advanced
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group fm-g-rw">
                                        <label for="goal-guide">Task Guide Description:</label>
                                        <textarea id="goal-guide" name="goal" rows="1"></textarea>
                                    </div>
                                    
                                    <div class="form-group fm-g-rw">
    <label for="startDateTime-guide">When would you like to start</label>
    <input type="datetime-local" id="startDateTime-guide" name="startDateTime" required>
</div>

                                </div>
                                
                                <div class="form-section">
                                    <h2 class="form-section-title">MORE DETAILS <i>(ATTACHMENTS OPTIONAL)</i></h2>
                                    <div class="form-group fm-g-rw">
                                        <label for="additionalInfo-guide">Any other specifics you'd like to add:</label>
                                        <textarea id="additionalInfo-guide" name="additionalInfo" rows="1"></textarea>
                                    </div>
                                    
                                    <div class="form-group fm-g-rw">
                                        <label for="fileUpload-guide" class="file-upload-label">
                                            <i class="fas fa-paperclip"></i>
                                            Attach Files
                                        </label>
                                        <input type="file" id="fileUpload-guide" name="fileUpload" multiple style="display: none;">
                                        <div id="fileList-guide" class="file-list"></div>
                                    </div>
                                </div>
                                
                                <button type="submit" class="submit-btn">Submit Request</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- subscriptions containers -->
                @isset($activePlans)
                <div class="content-section" id="usr_mysubscriptions">
                    <div class="current-plans">
                        <div class="container">
                            <div class="title">
                                <h2>Your Current Plans</h2>
                                <p>All plans you're actively subscribed to</p>
                            </div>
                            
                            <div class="card-grid">
                                @foreach($activePlans as $plan)
                                @if($plan) <!-- Safety check -->
                                <div class="plan-card {{ $plan->id == 7 ? 'free-plan' : '' }}">
                                    @if($plan->id == 7)
                                        <span class="plan-badge free-badge">Always Active</span>
                                    @elseif($plan->id == 6)
                                        <span class="plan-badge premium-badge">
                                            Active until {{ auth()->user()->subscription_expiry->format('M d, Y') }}
                                        </span>
                                    @else
                                        <span class="plan-badge paid-badge">Active</span>
                                    @endif
                                    
                                    <h3>{{ $plan->name }}</h3>
                                    <div class="plan-price">
                                        @if($plan->id == 7)
                                            Free Access
                                        @else
                                            @if($plan->student_price)
                                                R{{ $plan->student_price }} (students)
                                            @endif
                                            @if($plan->professional_price)
                                                | R{{ $plan->professional_price }} (business)
                                            @endif
                                        @endif
                                    </div>
                                    <p class="plan-description">{{ $plan->description }}</p>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endisset

                <!-- resources containers -->
                <div class="content-section resources_content" id="usr_resources">
                    <div class="resources-container">
                        <div class="container">
                            <div class="title">
                                <h2>Available Resources</h2>
                                <p>Browse through materials available with your current product plan</p>
                            </div>
                            
                            <div class="resource-grid" id="resourceGrid">
                                <div id="loader" style="display:none; text-align:center; padding:20px;">
                                    <i class="fas fa-spinner fa-spin" style="font-size: 2em; color: #555;"></i>
                                </div>
                                <!-- Resource cards will be inserted here by JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Support Section -->
                <div class="content-section support_content" id="usr_support">
                    <div class="support-container">
                        <div class="container">
                            <div class="title">
                                <h2>Support Center</h2>
                                <p>Find answers to common questions or contact our support team</p>
                            </div>
                            <!-- FAQ Section -->
                            <div class="faq-section">
                                <div class="section-header">
                                    <h2><i class="fas fa-question-circle"></i> Frequently Asked Questions</h2>
                                    <div class="faq-filter">
                                        <input type="text" placeholder="Filter questions..." id="faqFilter">
                                        <i class="fas fa-filter"></i>
                                    </div>
                                </div>
                                <div class="faq-tabs">
                                    <button class="faq-tab active" data-category="all">All</button>
                                    <button class="faq-tab" data-category="general">General</button>
                                    <button class="faq-tab" data-category="account">Account</button>
                                    <button class="faq-tab" data-category="billing">Billing</button>
                                    <button class="faq-tab" data-category="technical">Technical</button>
                                </div>
                                <div class="faq-accordion">
                                    <div class="faq-category" data-category="general">
                                        <div class="faq-item">
                                            <button class="faq-question">
                                                <span class="question-text">How do I reset my password?</span>
                                                <span class="faq-meta">Account</span>
                                                <i class="fas fa-chevron-down"></i>
                                            </button>
                                            <div class="faq-answer">
                                                <p>To reset your password:</p>
                                                <ol>
                                                    <li>Go to the Settings page from your dashboard</li>
                                                    <li>Click on "Update Password" in the left menu</li>
                                                    <li>Enter your current password</li>
                                                    <li>Enter your new password twice to confirm</li>
                                                    <li>Click "Save" to update your password</li>
                                                </ol>
                                                <p>If you've forgotten your password, you can use the "Forgot Password" link on the login page to reset it via email.</p>
                                                <div class="faq-helpful">
                                                    <span>Was this helpful?</span>
                                                    <button class="helpful-btn yes">Yes</button>
                                                    <button class="helpful-btn no">No</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="faq-item">
                                            <button class="faq-question">
                                                <span class="question-text">Where can I find my enrolled trainings?</span>
                                                <span class="faq-meta">Trainings</span>
                                                <i class="fas fa-chevron-down"></i>
                                            </button>
                                            <div class="faq-answer">
                                                <p>All your enrolled trainings are available in two places:</p>
                                                <ul>
                                                    <li><strong>Dashboard:</strong> Your most recent trainings appear in the "My Trainings" section</li>
                                                    <li><strong>All Trainings Page:</strong> Enrolled courses are marked with a green "Enrolled" badge</li>
                                                </ul>
                                                <p>You can also filter the All Trainings page to show only your enrolled courses using the "My Courses" filter.</p>
                                                <div class="faq-helpful">
                                                    <span>Was this helpful?</span>
                                                    <button class="helpful-btn yes">Yes</button>
                                                    <button class="helpful-btn no">No</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="faq-category hidden" data-category="account">
                                        <div class="faq-item">
                                            <button class="faq-question">
                                                <span class="question-text">How can I update my email address?</span>
                                                <span class="faq-meta">Account</span>
                                                <i class="fas fa-chevron-down"></i>
                                            </button>
                                            <div class="faq-answer">
                                                <p>To update your email:</p>
                                                <ol>
                                                    <li>Navigate to your account settings</li>
                                                    <li>Click on "Edit Profile"</li>
                                                    <li>Change the email field and save your changes</li>
                                                    <li>Check your new email for a confirmation message</li>
                                                </ol>
                                                <div class="faq-helpful">
                                                    <span>Was this helpful?</span>
                                                    <button class="helpful-btn yes">Yes</button>
                                                    <button class="helpful-btn no">No</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="faq-category hidden" data-category="billing">
                                        <div class="faq-item">
                                            <button class="faq-question">
                                                <span class="question-text">Where can I download my invoices?</span>
                                                <span class="faq-meta">Billing</span>
                                                <i class="fas fa-chevron-down"></i>
                                            </button>
                                            <div class="faq-answer">
                                                <p>To access invoices:</p>
                                                <ul>
                                                    <li>Go to the "Billing" section in your account settings</li>
                                                    <li>Click on the "Invoices" tab</li>
                                                    <li>Download any invoice as a PDF by clicking the download icon</li>
                                                </ul>
                                                <div class="faq-helpful">
                                                    <span>Was this helpful?</span>
                                                    <button class="helpful-btn yes">Yes</button>
                                                    <button class="helpful-btn no">No</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="faq-category hidden" data-category="technical">
                                        <div class="faq-item">
                                            <button class="faq-question">
                                                <span class="question-text">Why isn't the video loading?</span>
                                                <span class="faq-meta">Technical</span>
                                                <i class="fas fa-chevron-down"></i>
                                            </button>
                                            <div class="faq-answer">
                                                <p>Try the following steps:</p>
                                                <ul>
                                                    <li>Refresh the page</li>
                                                    <li>Clear your browser cache and cookies</li>
                                                    <li>Try a different browser or device</li>
                                                    <li>Ensure you're not behind a VPN or firewall blocking video traffic</li>
                                                </ul>
                                                <p>If the issue continues, please contact our technical support team.</p>
                                                <div class="faq-helpful">
                                                    <span>Was this helpful?</span>
                                                    <button class="helpful-btn yes">Yes</button>
                                                    <button class="helpful-btn no">No</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="faq-footer">
                                    <p>Still have questions?
                                        <a href="/dashboard#usr_support:contact">
                                            Contact our support team
                                        </a> 
                                        for personalized help.</p>
                                </div>
                            </div>
                            <!-- Contact Form -->
                            <div class="support-form" id="contact">
                                <h4>Send us a message</h4>
                                <form id="supportForm" class="supportForm">
                                    <!-- Choose Type -->
                                    <div class="form-group">
                                    <label for="requestType">Message Type:</label>
                                    <select id="requestType" required>
                                        <option value="problem" selected>Problem Report</option>
                                        <option value="feedback">Feedback Survey</option>
                                    </select>
                                    </div>
                                    <!-- Problem Report Fields -->
                                    <div id="problemFields">
                                    <div class="form-group">
                                        <label for="supportSubject">Subject:</label>
                                        <input type="text" id="supportSubject" placeholder="What's this about?" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="supportMessage">Message:</label>
                                        <textarea id="supportMessage" rows="5" placeholder="Describe your issue in detail..." required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="supportPriority">Priority:</label>
                                        <select id="supportPriority">
                                        <option value="low">Low - General question</option>
                                        <option value="medium" selected>Medium - Need help</option>
                                        <option value="high">High - Urgent issue</option>
                                        </select>
                                    </div>
                                    </div>
                                    <!-- Feedback Survey Fields -->
                                    <div id="feedbackFields" style="display:none;">
                                        <div class="form-group">
                                            <label for="feedbackExperience">Overall Experience:</label>
                                            <select id="feedbackExperience" required>
                                            <option value="">Choose a rating</option>
                                            <option value="5">Excellent ⭐⭐⭐⭐⭐</option>
                                            <option value="4">Good ⭐⭐⭐⭐</option>
                                            <option value="3">Average ⭐⭐⭐</option>
                                            <option value="2">Poor ⭐⭐</option>
                                            <option value="1">Very Poor ⭐</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="feedbackEase">Ease of Use:</label>
                                            <select id="feedbackEase" required>
                                            <option value="">Choose a rating</option>
                                            <option value="5">Very Easy</option>
                                            <option value="4">Easy</option>
                                            <option value="3">Neutral</option>
                                            <option value="2">Difficult</option>
                                            <option value="1">Very Difficult</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="feedbackRecommend">Would you recommend Technospeak to a friend?</label>
                                            <select id="feedbackRecommend" required>
                                            <option value="">Choose a rating</option>
                                            <option value="5">Definitely</option>
                                            <option value="4">Probably</option>
                                            <option value="3">Maybe</option>
                                            <option value="2">Unlikely</option>
                                            <option value="1">Definitely Not</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="feedbackComment">Additional Comments:</label>
                                            <textarea id="feedbackComment" rows="4" placeholder="Tell us how we can improve..."></textarea>
                                        </div>
                                    </div>
                                    <button type="submit" class="submit-btn">
                                        <i class="fas fa-paper-plane"></i> Send Message
                                    </button>
                                </form>
                            </div>
                            <!-- Support Status Section -->
                            <div class="status-section">
                                <h2><i class="fas fa-heartbeat"></i> System Status</h2>
                                <p>Check the current status of our platform and services</p>
                                <div class="status-grid">
                                    <div class="status-item operational">
                                        <div class="status-icon">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <div class="status-info">
                                            <h3>Website</h3>
                                            <p>All systems operational</p>
                                        </div>
                                    </div>
                                    <div class="status-item operational">
                                        <div class="status-icon">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <div class="status-info">
                                            <h3>Training Platform</h3>
                                            <p>All systems operational</p>
                                        </div>
                                    </div>
                                    <div class="status-item maintenance">
                                        <div class="status-icon">
                                            <i class="fas fa-tools"></i>
                                        </div>
                                        <div class="status-info">
                                            <h3>Mobile App</h3>
                                            <p>Coming soon...</p>
                                        </div>
                                    </div>
                                    <div class="status-item outage">
                                        <div class="status-icon">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </div>
                                        <div class="status-info">
                                            <h3>Payment System</h3>
                                            <p>All systems operational</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="status-history">
                                    <h3>Recent Incidents</h3>
                                    <div class="incident">
                                        <div class="incident-date">May 15, 2025</div>
                                        <div class="incident-details">
                                            <h4>Video Playback Issues</h4>
                                            <p class="incident-status resolved">Resolved</p>
                                            <p class="incident-desc">Some users reported intermittent video playback errors. The issue has been identified and fixed.</p>
                                        </div>
                                    </div>
                                    
                                    <div class="incident">
                                        <div class="incident-date">May 10, 2025</div>
                                        <div class="incident-details">
                                            <h4>Scheduled Maintenance</h4>
                                            <p class="incident-status maintenance">Completed</p>
                                            <p class="incident-desc">We performed scheduled maintenance to improve system performance.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- settings containers -->
                <div class="content-section settings_content" id="usr_settings">
                    <div class="settings-profile">
                        <!-- Update Profile Information -->
                        <section class="setting-block">
                            <h2 class="setting-title">Profile Information</h2>
                            <p class="setting-desc">Update your account's profile information and email address.</p>

                            <!-- Email verification resend -->
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit" style="display:none;"></button>
                            </form>

                            <form method="POST" action="{{ route('profile.update') }}">
                                @csrf
                                @method('PATCH')
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input id="name" name="name" type="text" value="{{ old('name', auth()->user()->name) }}" required />
                                    @error('name')<div class="error-msg">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group">
                                    <label for="surname">Surname</label>
                                    <input id="surname" name="surname" type="text" value="{{ old('surname', auth()->user()->surname) }}" required />
                                    @error('surname')<div class="error-msg">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" name="email" type="email" value="{{ old('email', auth()->user()->email) }}" required />
                                    @error('email')<div class="error-msg">{{ $message }}</div>@enderror

                                    @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                                        <div class="verify-notice">
                                            <p>Your email address is unverified.</p>
                                            <button type="submit" formaction="{{ route('verification.send') }}">Click here to re-send the verification email.</button>
                                        </div>
                                    @endif
                                </div>
                                <button class="save-btn" type="submit">Save</button>
                                @if (session('status') === 'profile-updated')
                                    <p class="status-msg">Profile updated</p>
                                @endif
                                @if (session('status') === 'verification-link-sent')
                                    <p class="status-msg">A new verification link has been sent to your email.</p>
                                @endif

                                @if (session('status') === 'email-already-verified')
                                    <p class="status-msg">Your email is already verified.</p>
                                @endif
                            </form>
                        </section>

                        <!-- Update Password -->
                        <section class="setting-block">
                            <h2 class="setting-title">Update Password</h2>
                            <p class="setting-desc">Ensure your account is using a long, random password to stay secure.</p>

                            <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input id="current_password" name="current_password" type="password" />
                                @error('current_password', 'updatePassword')<div class="error-msg">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input id="password" name="password" type="password" />
                                @error('password', 'updatePassword')<div class="error-msg">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" />
                                @error('password_confirmation', 'updatePassword')<div class="error-msg">{{ $message }}</div>@enderror
                            </div>

                            <button class="save-btn" type="submit">Save</button>

                            @if (session('status') === 'password-updated')
                                <p class="status-msg">New password saved.</p>
                            @endif
                            </form>
                        </section>

                        <!-- Delete Account -->
                        <section class="setting-block">
                            <h2 class="setting-title">Delete Account</h2>
                            <p class="setting-desc">
                            Once your account is deleted, all of its resources and data will be permanently deleted.
                            </p>

                            <form method="POST" action="{{ route('profile.destroy') }}">
                            @csrf
                            @method('DELETE')

                            <div class="form-group">
                                <label for="delete_password">Password</label>
                                <input id="delete_password" name="password" type="password" placeholder="Enter your password" />
                                @error('password', 'userDeletion')<div class="error-msg">{{ $message }}</div>@enderror
                            </div>

                            <button class="delete-btn" type="submit">Delete Account</button>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </section>

        <section class="rightbar bar-lt-rt rt-bar" id="rightbar-container">
            <div class="main_container">
                <div class="right-bar">
                    {{-- Include the right bar profile tag --}}
                    @include('layouts.profileTag', ['showDropdown' => true])

                    @php
                        $progressData = app('App\Http\Controllers\CourseAccessController')->getOverallProgressData();
                        $progressPercent = $progressData['overall_progress'];

                        $progressMessage = $progressData['message'];
                        $activeLevel = $progressData['level'];
                    @endphp

                    <div class="progress_box" id="fml-progress-boxx">
                        <div class="progress-container">
                            <div class="progress-header">
                                <h1 class="progress-title">Your Overall Progress</h1>
                                <p class="progress-percent">{{ $progressPercent }}%</p>
                            </div>
                            <div class="progress-track">
                                <div class="progress-fill" style="width: {{ $progressPercent }}%;"></div>

                                @for ($i = 0; $i < 5; $i++)
                                    <div class="level-marker {{ $i <= $activeLevel ? 'active' : '' }}"></div>
                                @endfor
                            </div>
                            <div class="progress-labels">
                                <div class="label">0%<br><span></span></div>
                                <div class="label">25%<br><span>Beginner</span></div>
                                <div class="label">50%<br><span>Intermediate</span></div>
                                <div class="label">75%<br><span>Advanced</span></div>
                                <div class="label">100%<br><span>Expert</span></div>
                            </div>
                            <div class="progress-message">
                                <p>{{ $progressMessage }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="upcoming_box" id="up-coming-boxx">
                        <div class="title">
                            <h4>Upcoming Sessions</h4>
                        </div>

                        @forelse ($upcomingSessions as $i => $session)
                            @php
                                $bgClass = $i % 2 === 0 ? 'if-qa-session-background-color' : 'if-new-video-background-color';

                                $typeIcon = match($session->type->name) {
                                    'Formal Training' => 'fa-graduation-cap',
                                    'Task Assistance' => 'fa-tasks',
                                    'Personal Guide' => 'fa-user',
                                    'Group Session 1' => 'fa-users',
                                    'Group Session 2' => 'fa-users',
                                    default => 'fa-calendar',
                                };

                                $formattedDate = \Carbon\Carbon::parse($session->scheduled_for)->format('d M Y, l');
                            @endphp

                            <div class="up_session_bar">
                                <div class="icon up_container {{ $bgClass }}">
                                    <i class="fa {{ $typeIcon }}" aria-hidden="true"></i>
                                </div>
                                <div class="content_sbar up_container">
                                    <strong>{{ $session->title }} - {{ $session->type->name }}</strong>
                                    <p>{{ $formattedDate }} - 
                                        @if ($session->scheduled_for->isFuture())
                                            <span class="text-green-600 text-sm" style="color:#1fb12b;"><i>Upcoming</i></span>
                                        @else
                                            <span class="text-gray-500 text-sm" style="color:#d36262;"><i>Completed</i></span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 p-2">No upcoming sessions.</p>
                        @endforelse
                    </div>

                    <!-- task assistance bar -->
                    <div class="rt-ts-asst rt-ts-asst_rt-ps-guide" id="rt-ts-asst-fnc">
                        <div class="inner_container">
                            <div class="title_container">
                                <h3>About Task Assitance Product:</h3>
                            </div>
                            <div class="description">
                                <p>Something about the types of assistance we provide. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non.</p>
                                <p><br>Something about the types of assistance we provide. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non.</p>
                            </div>
                            <div class="title_container">
                                <h3>Purpose:</h3>
                            </div>
                            <div class="description">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                            <div class="title_container">
                                <h3>Price:</h3>
                            </div>
                            <div class="button">
                                <p>
                                    <sup class="context">from</sup>
                                    R100
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- personal guide bar -->
                    <div class="rt-ps-guide rt-ts-asst_rt-ps-guide" id="rt-ps-guide-fnc">
                        <div class="inner_container">
                            <div class="title_container">
                                <h3>About Personal Guide Product:</h3>
                            </div>
                            <div class="description">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                <p><br>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                            </div>
                            <div class="title_container">
                                <h3>Purpose:</h3>
                            </div>
                            <div class="description">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                            <div class="title_container">
                                <h3>Price:</h3>
                            </div>
                            <div class="button">
                                <p>
                                    <sup class="context">from</sup>
                                    R110
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Support Section -->
                    <div class="contact-section" id="cntct-sctn-spprt">
                        <h2><i class="fas fa-headset"></i> Contact Support</h2>
                        <div class="contact-options">
                            <div class="contact-card">
                                <div class="contact-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <h4>Email Us</h4>
                                <p>Send us an email & we'll respond within 24 hours</p>
                                <a href="mailto:admin@technospeak.co.za" class="contact-btn">Email Support</a>
                            </div>
                            <div class="contact-card">
                                <div class="contact-icon">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <h4>Call Us</h4>
                                <p>Speak directly with a support representative</p>
                                <a href="tel:+1234567890" class="contact-btn">+1 (234) 567-890</a>
                            </div>
                            <div class="contact-card">
                                <div class="contact-icon">
                                    <i class="fas fa-comment-dots"></i>
                                </div>
                                <h4>Live Chat</h4>
                                <p>Chat with us in real-time during business hours</p>
                                <button class="contact-btn" id="liveChatBtn">Start Live Chat</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Js connections -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const progressPercent = {{ $progressPercent }};
                updateProgress(progressPercent);

                function updateProgress(percent) {
                    const fill = document.querySelector('.progress-fill');
                    const percentText = document.querySelector('.progress-percent');
                    const markers = document.querySelectorAll('.level-marker');

                    fill.style.width = percent + '%';
                    percentText.textContent = percent + '%';

                    markers.forEach((marker, index) => {
                        const thresholds = [0, 25, 50, 75, 100];
                        if (percent >= thresholds[index]) {
                            marker.classList.add('active');
                        } else {
                            marker.classList.remove('active');
                        }
                    });
                }

                // parse #contact for main url to use :
                function getSectionAndAnchor() {
                    var raw = (window.location.hash || "").replace(/^#/, "");
                    var parts = raw.split(/[:/|]/);
                    return { section: parts[0] || "", anchor: parts[1] || "" };
                }

                function handleInitialLoad() {
                    // URL hash, then localStorage, then default to dashboard
                    var parsed = getSectionAndAnchor();
                    var storedSection = localStorage.getItem('activeSection');
                    var defaultSection = 'usr_dashboard';

                    var targetSection = parsed.section || storedSection || defaultSection;
                    switchToSection(targetSection, true);
                    window.activeSection = targetSection;

                    if (parsed.anchor) {
                        setTimeout(function () {
                            var el = document.getElementById(parsed.anchor) ||
                                    document.querySelector('#' + targetSection + ' #' + parsed.anchor);
                            if (el) el.scrollIntoView({ behavior: 'smooth' });
                        }, 300);
                    }
                }

                function switchToSection(sectionId, isInitialLoad = false) {
                    const navItem = document.querySelector(`.nav-item[data-section="${sectionId}"]`);
                    
                    if (!navItem || !document.getElementById(sectionId)) {
                        console.warn(`Section ${sectionId} not found`);
                        // back to dashboard if section doesn't exist
                        if (sectionId !== 'usr_dashboard') {
                            switchToSection('usr_dashboard', isInitialLoad);
                        }
                        return;
                    }

                    // navigation
                    document.querySelectorAll('.nav-item').forEach(item => item.classList.remove('active'));
                    document.querySelectorAll('.content-section').forEach(section => section.classList.remove('active'));

                    navItem.classList.add('active');
                    document.getElementById(sectionId).classList.add('active');

                    localStorage.setItem('activeSection', sectionId);
                    window.activeSection = sectionId;

                    // right bar visibility
                    const rightbar = document.getElementById('rightbar-container');
                    const profile_tag = document.getElementById('profile_tag');
                    const txt_btn_rm = document.getElementById('txt_btn_rm');
                    
                    // right bar elements
                    const up_coming_box = document.getElementById('up-coming-boxx');
                    const fml_progress_box = document.getElementById('fml-progress-boxx');
                    const rt_ts_asst_fnc = document.getElementById('rt-ts-asst-fnc');
                    const rt_ps_guide_fnc = document.getElementById('rt-ps-guide-fnc');
                    const cntct_sctn_spprt = document.getElementById('cntct-sctn-spprt');

                    // reset all right bar
                    if (up_coming_box) up_coming_box.style.display = "none";
                    if (fml_progress_box) fml_progress_box.style.display = "none";
                    if (rt_ts_asst_fnc) rt_ts_asst_fnc.style.display = "none";
                    if (rt_ps_guide_fnc) rt_ps_guide_fnc.style.display = "none";
                    if (cntct_sctn_spprt) cntct_sctn_spprt.style.display = "none";

                    // sidebar promo section
                    if (profile_tag) profile_tag.style.display = "none";
                    if (txt_btn_rm) txt_btn_rm.style.display = "none";

                    // right bar for most sections
                    if (rightbar) rightbar.style.display = "block";

                    // section cases
                    switch (sectionId) {
                        case "usr_dashboard":
                            // hide progress box
                            if (fml_progress_box) fml_progress_box.style.display = "none";
                            // show upcoming session
                            if (up_coming_box) up_coming_box.style.display = "block";
                            break;
                        
                            case "usr_alltricks":
                            // right bar for tips & tricks
                            if (rightbar) rightbar.style.display = "none";
                            // profile tag in sidebar
                            if (profile_tag) profile_tag.style.display = "block";
                            break;
                            
                        case "usr_formaltraining":
                            // progress box for formal training
                            if (fml_progress_box) fml_progress_box.style.display = "block";
                            // profile tag in sidebar
                            if (profile_tag) profile_tag.style.display = "block";
                            break;
                            
                        case "usr_taskAssistance":
                            // task assistance content
                            if (rt_ts_asst_fnc) rt_ts_asst_fnc.style.display = "block";
                            break;
                            
                        case "usr_guide":
                            // personal guide content
                            if (rt_ps_guide_fnc) rt_ps_guide_fnc.style.display = "block";
                            break;
                            
                        case "usr_mysubscriptions":
                            // hide the whole right bar except the name
                            if (up_coming_box) up_coming_box.style.display = "none";
                            if (fml_progress_box) fml_progress_box.style.display = "none";
                            break;

                        case "usr_resources":
                            // hide the whole right bar except the name
                            if (up_coming_box) up_coming_box.style.display = "none";
                            if (fml_progress_box) fml_progress_box.style.display = "none";
                            break;
                        
                        case "usr_support":
                            // hide the whole right bar except the name
                            if (up_coming_box) up_coming_box.style.display = "none";
                            if (fml_progress_box) fml_progress_box.style.display = "none";
                            if (fml_progress_box) fml_progress_box.style.display = "none";
                            if (cntct_sctn_spprt) cntct_sctn_spprt.style.display = "block";
                            break;

                        default:
                            // all back to normal
                            if (up_coming_box) up_coming_box.style.display = "block";
                            if (fml_progress_box) fml_progress_box.style.display = "block";
                            // promo in sidebar
                            if (txt_btn_rm) txt_btn_rm.style.display = "flex";
                            break;
                    }

                    if (!isInitialLoad && window.location.hash.substring(1) !== sectionId) {
                        history.replaceState(null, null, `#${sectionId}`);
                    }

                    if (!isInitialLoad) {
                        var parsed = getSectionAndAnchor();
                        var newHash = '#' + sectionId + (parsed.anchor ? ':' + parsed.anchor : '');
                        if (window.location.hash !== newHash) {
                            history.replaceState(null, null, newHash);
                        }
                    }
                }

                // hash change listener
                window.addEventListener('hashchange', function () {
                    var parsed = getSectionAndAnchor();
                    var sectionId = parsed.section || window.activeSection;

                    switchToSection(sectionId);

                    if (parsed.anchor) {
                        setTimeout(function () {
                            var el = document.getElementById(parsed.anchor) ||
                                    document.querySelector('#' + sectionId + ' #' + parsed.anchor);
                            if (el) el.scrollIntoView({ behavior: 'smooth' });
                        }, 200);
                    }
                });

                // nav item click handlers
                document.querySelectorAll('.nav-item').forEach(item => {
                    item.addEventListener('click', function(event) {
                        event.preventDefault();
                        const sectionId = this.getAttribute('data-section');
                        switchToSection(sectionId);
                    });
                });

                // anchor links within the page
                document.addEventListener('click', function(event) {
                    if (event.target.matches('a[href^="#"]')) {
                        const href = event.target.getAttribute('href');
                        const sectionId = href.substring(1);
                        
                        if (document.getElementById(sectionId)) {
                            event.preventDefault();
                            switchToSection(sectionId);
                        }
                    }
                });

                // initialize the page
                handleInitialLoad();
                
                // available globally
                window.switchToSection = switchToSection;
            });

            // Set initial active section for other scripts
            window.activeSection = localStorage.getItem('activeSection') || 'usr_dashboard';
        </script>

        <!-- pass session value to JS to remain on usr_settings -->
        <script>
            window.activeSection = localStorage.getItem('activeSection') || 'usr_dashboard';
        </script>

        <!-- log out and profile settings dropdown-->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function () {
                $('.nt_nm').on('click', function (e) {
                    e.stopPropagation();
                    $('#dropdownMenu').toggleClass('hidden');
                });

                $(window).on('click', function () {
                    $('#dropdownMenu').addClass('hidden');
                });
            });
        </script>

        <!-- Swiper JS -->
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
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

        <!-- Function for share your issue section -->
        <script src="/script/dashboard.js"></script>

        <!-- functions for only user subsciptions -->
        <script src="/script/subscription.js"></script>

        <!-- Functions for resources -->
        <script src="/script/resources.js"></script>

        <!-- Functions for free and paid trainigs -->
        <script src="/script/dash_trainings.js"></script>

        <!-- logout session -->
        <script src="/script/logout_session.js"></script>

        <!-- pop-up general -->
        <script src="/script/pop-up.js"></script>

        <!-- search functions for courses -->
        <script src="/script/trainings-filtering.js"></script>

        <!-- pop up swal -->
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- success unenrollment -->
         <script>
            document.addEventListener('DOMContentLoaded', function () {
                const params = new URLSearchParams(window.location.search);
                const wasUnenrolled = params.get('unenrolled');
                const message = params.get('message');

                if (wasUnenrolled === '1') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Unenrolled',
                        text: decodeURIComponent(message || 'You have been unenrolled successfully'),
                        timer: 7000,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false
                    });

                    if (window.history.replaceState) {
                        const url = new URL(window.location);
                        url.searchParams.delete('unenrolled');
                        url.searchParams.delete('message');
                        window.history.replaceState({}, document.title, url.pathname);
                    }
                }
            });
        </script>

        <!-- swap between send message or report a problem -->
        <script>
            const requestType = document.getElementById('requestType');
            const problemFields = document.getElementById('problemFields');
            const feedbackFields = document.getElementById('feedbackFields');
            requestType.addEventListener('change', function () {
                if (this.value === 'problem') {
                    problemFields.style.display = 'block';
                    feedbackFields.style.display = 'none';
                } else {
                    problemFields.style.display = 'none';
                    feedbackFields.style.display = 'block';
                }
            });
        </script>

        <!-- Confirm message sent -->
        <script>
            function submitForm(formId, type) {
                const form = document.getElementById(formId);
                const submitBtn = form.querySelector('button[type="submit"]');

                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Disable button
                    submitBtn.disabled = true;
                    
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = 'Processing..';

                    // spinner
                    const spinner = document.createElement('span');
                    spinner.classList.add('button-spinner');
                    submitBtn.appendChild(spinner);

                    const formData = new FormData(form);

                    fetch(`/submit/${type}`, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        submitBtn.disabled = false;
                        spinner.remove();
                        submitBtn.innerHTML = 'Submit Now';

                        if(data.success) {
                            Swal.fire('Success', data.message, 'success');
                            form.reset();
                            form.querySelectorAll('input[type="file"]').forEach(input => {
                                input.value = '';
                            })
                        } else {
                            Swal.fire('Error', 'Something went wrong', 'error');
                        }
                    })
                    .catch(err => {
                        submitBtn.disabled = false;
                        spinner.remove();
                        submitBtn.innerHTML = 'Try Again';
                        Swal.fire('Error', 'Network error. Please try again.', 'error');
                    });
                });
            }

            // file upload handling
            function setupFileUpload(formId, fileInputId, fileListId) {
                const fileInput = document.getElementById(fileInputId);
                const fileList = document.getElementById(fileListId);
                
                fileInput.addEventListener('change', function() {
                    fileList.innerHTML = '';
                    Array.from(this.files).forEach(file => {
                        const fileItem = document.createElement('div');
                        fileItem.className = 'file-item';
                        fileItem.innerHTML = `
                            <span>${file.name}</span>
                            <span>(${(file.size / 1024).toFixed(2)} KB)</span>
                        `;
                        fileList.appendChild(fileItem);
                    });
                });
            }

            setupFileUpload('taskAssistanceForm', 'fileUpload-task', 'fileList-task');
            setupFileUpload('personalGuideForm', 'fileUpload-guide', 'fileList-guide');
            submitForm('taskAssistanceForm', 'task');
            submitForm('personalGuideForm', 'guide');
        </script>
    </body>
</html>