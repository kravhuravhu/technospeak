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
        <meta name="csrf-token" content="{{ csrf_token() }}">
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
    </head>
    <body>
        @include('components.preference-popup', [
            'categories' => \App\Models\CourseCategory::all()
        ])

        @include('components.pop-up')

        <!-- group session pop-ups -->
        @include('components.sessions_registration', ['typeId' => 4, 'typeName' => 'Q/A Session'])
        @include('components.sessions_registration', ['typeId' => 5, 'typeName' => 'Live Q/A Session'])

        <!-- Hamburger Menu Button -->
        <div class="hamburger-menu" id="hamburgerMenu">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <!-- Overlay for sidebar -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <section class="sidebar bar-lt-rt">
            <div class="main_container">
                <div class="logo_container">
                    <a href="/">
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
                        <input type="text" id="dashboardSearch" placeholder="Search your current Tips&Tricks">
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
                                                        {{ $course->is_enrolled ? 'Enrolled' : ($course->plan_type === 'paid' ? 'Enroll Free' : 'Enroll Free') }}
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
                                    @if(isset($filteredCategory) && $filteredCategory)
                                        <p class="subtitle">Showing results for: <strong>{{ $filteredCategory }}</strong> 
                                            <a href="{{ url('/dashboard#usr_alltricks') }}" class="clear-filter-btn" style="display: inline-block; padding: 5px 15px; background-color: #3b82f6; color: white; border-radius: 5px; text-decoration: none; font-size: 0.9em; margin-left: 10px; transition: all 0.3s ease;">Clear Filter & Show All</a>
                                        </p>
                                    @else
                                        <p class="subtitle">Collections of Tips and tricks designed to boost your skills efficiently.</p>
                                    @endif
                                </div>
                                <div class="search-filter-container">
                                    <div class="search-box">
                                        <i class="fas fa-search search-icon"></i>
                                        <input type="text" id="tipsSearchInput" placeholder="Search tips and tricks..." class="search-control" 
                                            value="{{ isset($filteredCategory) && $filteredCategory ? '' : '' }}">
                                    </div>
                                    <div class="filter-dropdown">
                                        <select id="tipsFilterSelect" class="search-control">
                                            <option value="">All Categories</option>
                                            @foreach(\App\Models\CourseCategory::all() as $category)
                                                <option value="{{ $category->name }}" 
                                                    {{ (isset($filteredCategory) && $filteredCategory === $category->name) ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <i class="fas fa-filter filter-icon"></i>
                                    </div>
                                </div>
                            </div>

                            <div id="courseNoResultsMessageTips" style="display:none;" class="no-results-message">
                                No Tips & tricks match your criteria. Try a different search or filter by category
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
                                        @if(isset($filteredCategory) && $filteredCategory)
                                            <p>No Tips & Tricks available for <strong>{{ $filteredCategory }}</strong> at the moment.</p>
                                            <a href="{{ url('/dashboard#usr_alltricks') }}" class="browse-btn">Browse All Tips & Tricks →</a>
                                        @else
                                            <p>There are no Tips & Tricks available at the moment. Please check back later!</p>
                                        @endif
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
                                        <a href="/dashboard#usr_formaltraining" class="browse-btn">Browse All Below ↓</a>
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
                                    <p class="subtitle">Structured formal trainings for in-depth learning</p>
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
                                                                <label>Full Details</label>
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
                @include('components.task-assistance-form')

                <!-- Personal guide -->
                @include('components.personal-guide-form')

                <!-- subscriptions containers -->
                <div class="content-section subscriptions_content" id="usr_mysubscriptions">
                    <!-- 1. Your Current Plan -->
                    <div class="current-plans">
                        <div class="container">
                            <div class="title">
                                <h2>Your Current Plan</h2>
                                <p>Your active subscription plan</p>
                            </div>
                            
                            <div class="card-grid">
                                @if($currentPlan)
                                <div class="plan-card {{ $currentPlan->id == 7 ? 'free-plan' : 'current-plan' }}">
                                    @if($currentPlan->id == 6)
                                        <span class="plan-badge premium-badge">
                                            Active until {{ auth()->user()->subscription_expiry->format('M d, Y') }}
                                        </span>
                                    @elseif($currentPlan->id == 7)
                                        <span class="plan-badge free-badge">Always Active</span>
                                    @endif
                                    
                                    <h3>{{ $currentPlan->name }}</h3>
                                    <div class="plan-price">
                                        @if($currentPlan->id == 7)
                                            Free Access
                                        @else
                                            @if($currentPlan->student_price)
                                                From R{{ $currentPlan->student_price }}
                                            @endif
                                            <!-- @if($currentPlan->professional_price)
                                                | R{{ $currentPlan->professional_price }} (business)
                                            @endif -->
                                        @endif
                                    </div>
                                    <p class="plan-description">{{ $currentPlan->description }}</p>
                                    
                                    <div class="plan-actions">
                                        @if($currentPlan->id == 7)
                                            <a href="{{ route('subscription.yoco.redirect') }}" class="btn btn-primary">Upgrade to Premium</a>
                                        @else
                                            <span class="btn btn-outline">Current Plan</span>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- 2. Your Group Sessions -->
                    <div class="group-sessions">
                        <div class="container">
                            <div class="title">
                                <h2>Your Group Sessions</h2>
                                <p>Sessions you've enrolled in with detailed information</p>
                            </div>
                            
                            @if($groupSessions->count() > 0)
                            <div class="card-grid">
                                @foreach($groupSessions as $session)
                                <div class="session-card {{ $session['is_active'] ? 'active-session' : 'completed-session' }}">
                                    <span class="session-badge {{ $session['is_active'] ? 'active-badge' : 'completed-badge' }}">
                                        {{ $session['is_active'] ? 'Enrolled' : 'Completed' }}
                                    </span>
                                    
                                    <div class="session-header">
                                        <h3>{{ $session['name'] }}</h3>
                                        <div class="session-type">{{ $session['type_name'] }}</div>
                                    </div>
                                    
                                    <div class="session-details">
                                        <div class="detail-row">
                                            <span class="detail-label">Date:</span>
                                            <span class="detail-value">{{ $session['formatted_date'] }}</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="detail-label">Time:</span>
                                            <span class="detail-value">{{ $session['formatted_time'] }}</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="detail-label">Duration:</span>
                                            <span class="detail-value">{{ $session['duration'] }}</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="detail-label">Instructor:</span>
                                            <span class="detail-value">{{ $session['instructor_name'] }}</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="detail-label">Category:</span>
                                            <span class="detail-value">{{ $session['category_name'] }}</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="detail-label">Amount Paid:</span>
                                            <span class="detail-value price-display">
                                                R{{ number_format($session['student_price'] ?? $session['professional_price'], 2) }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <p class="session-description">{{ $session['description'] }}</p>
                                    
                                    <div class="session-footer">
                                        <div class="session-status {{ $session['is_active'] ? 'active-status' : 'completed-status' }}">
                                            <i class="fas {{ $session['is_active'] ? 'fa-calendar-check' : 'fa-check-circle' }}"></i>
                                            {{ $session['is_active'] ? 'Upcoming Session' : 'Session Completed' }}
                                        </div>
                                        <div class="payment-info">
                                            @if(isset($session['formatted_payment_date']) && $session['formatted_payment_date'] !== 'N/A')
                                                Paid on {{ $session['formatted_payment_date'] }}
                                                <span class="transaction-id">{{ substr($session['transaction_id'], -8) }}</span>
                                            @else
                                                Payment details not available
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="empty-state">
                                <i class="fas fa-users fa-3x"></i>
                                <h3>No Group Sessions Yet</h3>
                                <p>You haven't enrolled in any group sessions yet.</p>
                                <a href="{{ route('training.register') }}" class="btn">Browse Available Sessions</a>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- 3. Your Formal Trainings -->
                    <div class="formal-trainings">
                        <div class="container">
                            <div class="title">
                                <h2>Your Formal Trainings</h2>
                                <p>Formal trainings you've registered for</p>
                            </div>
                            
                            @if($formalTrainingsRegistered->count() > 0)
                            <div class="card-grid">
                                @foreach($formalTrainingsRegistered as $training)
                                <div class="training-card {{ $training['is_active'] ? 'active-session' : 'completed-session' }}">
                                    <span class="session-badge {{ $training['is_active'] ? 'active-badge' : 'completed-badge' }}">
                                        {{ $training['is_active'] ? 'Registered' : 'Completed' }}
                                    </span>
                                    
                                    <div class="session-header">
                                        <h3>{{ $training['name'] }}</h3>
                                        <div class="session-type">{{ $training['type_name'] }}</div>
                                    </div>
                                    
                                    <div class="session-details">
                                        <div class="detail-row">
                                            <span class="detail-label">Type:</span>
                                            <span class="detail-value">
                                                {{ $training['source'] === 'course' ? 'Self-paced Course' : 'Scheduled Session' }}
                                            </span>
                                        </div>
                                        @if($training['source'] === 'training_session')
                                        <div class="detail-row">
                                            <span class="detail-label">Date:</span>
                                            <span class="detail-value">{{ $training['formatted_date'] }}</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="detail-label">Time:</span>
                                            <span class="detail-value">{{ $training['formatted_time'] }}</span>
                                        </div>
                                        @else
                                        <div class="detail-row">
                                            <span class="detail-label">Enrolled:</span>
                                            <span class="detail-value">{{ $training['formatted_date'] }}</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="detail-label">Schedule:</span>
                                            <span class="detail-value">{{ $training['formatted_time'] }}</span>
                                        </div>
                                        @endif
                                        <div class="detail-row">
                                            <span class="detail-label">Duration:</span>
                                            <span class="detail-value">{{ $training['duration'] }}</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="detail-label">Instructor:</span>
                                            <span class="detail-value">{{ $training['instructor_name'] }}</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="detail-label">Category:</span>
                                            <span class="detail-value">{{ $training['category_name'] }}</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="detail-label">Amount Paid:</span>
                                            <span class="detail-value price-display">
                                                R{{ number_format($training['student_price'] ?? $training['professional_price'], 2) }}
                                            </span>
                                        </div>
                                        @if($training['source'] === 'course' && isset($training['progress']))
                                        <div class="detail-row">
                                            <span class="detail-label">Progress:</span>
                                            <span class="detail-value">{{ $training['progress'] }}%</span>
                                        </div>
                                        @endif
                                    </div>
                                    
                                    <p class="session-description">{{ $training['description'] }}</p>
                                    
                                    <div class="session-footer">
                                        <div class="session-status {{ $training['is_active'] ? 'active-status' : 'completed-status' }}">
                                            <i class="fas {{ $training['is_active'] ? 'fa-calendar-check' : 'fa-graduation-cap' }}"></i>
                                            {{ $training['is_active'] ? 'Upcoming Training' : 'Training Completed' }}
                                        </div>
                                        <div class="payment-info">
                                            Paid on {{ $training['formatted_payment_date'] }}
                                            <span class="transaction-id">{{ substr($training['transaction_id'], -8) }}</span>
                                        </div>
                                        <!-- Replaced the Continue Learning button with More Formal Trainings -->
                                        <div class="training-actions">
                                            <a href="{{ url('/dashboard#usr_formaltraining') }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-book-open"></i> More Formal Trainings
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="empty-state">
                                <i class="fas fa-graduation-cap fa-3x"></i>
                                <h3>No Formal Trainings Yet</h3>
                                <p>You haven't registered for any formal trainings yet.</p>
                                <a href="{{ url('/dashboard#usr_formaltraining') }}" class="btn">Browse Formal Trainings</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- 4. Available Product Plans -->
                    <div class="available-plans">
                        @php
                            // Get the latest upcoming sessions
                            $qaSession = \App\Models\TrainingSession::where('type_id', 4)
                                ->where('scheduled_for', '>', now())
                                ->orderBy('scheduled_for')
                                ->first();
                                
                            $consultSession = \App\Models\TrainingSession::where('type_id', 5)
                                ->where('scheduled_for', '>', now())
                                ->orderBy('scheduled_for')
                                ->first();
                        @endphp
                        <div class="container">
                            <div class="section-title">
                                <h2>Available Product Plans</h2>
                                <p>Explore our range of tech solutions tailored to your needs</p>
                            </div>
                            
                            <div class="plans-grid">
                                @foreach($availablePlans as $plan)
                                    <div class="plan-card">
                                        @if($plan->id == 6)
                                            <div class="ribbon">Most Popular</div>
                                        @endif
                                        
                                        <div class="plan-header">
                                            <h3 class="plan-name">{{ $plan->name }}</h3>
                                            <div class="student-price active">
                                                <div class="plan-price">
                                                    @if($plan->student_price > 0)
                                                        From R{{ $plan->student_price }}
                                                    @else
                                                        Free
                                                    @endif
                                                </div>
                                                <div class="price-note">
                                                    @if($plan->id == 6)
                                                        Quarterly 
                                                    @elseif(in_array($plan->id, [1, 2, 3]))
                                                        Per Course 
                                                    @elseif(in_array($plan->id, [4, 5]))
                                                        Per Hour 
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="professional-price">
                                                <div class="plan-price">
                                                    <!-- @if($plan->professional_price > 0)
                                                        R{{ $plan->professional_price }}
                                                    @else
                                                        Free
                                                    @endif -->
                                                </div>
                                                <div class="price-note">
                                                    <!-- @if($plan->id == 6)
                                                        Quarterly (Business)
                                                    @elseif(in_array($plan->id, [1, 2, 3]))
                                                        Per Course (Business)
                                                    @elseif(in_array($plan->id, [4, 5]))
                                                        Per Hour (Business)
                                                    @endif -->
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="plan-body">
                                            <p class="plan-description">{{ $plan->description }}</p>
                                            <ul class="plan-features">
                                                @if($plan->id == 7)
                                                    <li>Access to clickbait videos</li>
                                                    <li>Comment section questions</li>
                                                    <li>Brief answers with website links</li>
                                                @elseif($plan->id == 6)
                                                    <li>All clickbait-style videos</li>
                                                    <li>Downloadable resources & guides</li>
                                                    <li>Monthly email newsletters</li>
                                                    <li>Exclusive tech tips</li>
                                                @elseif($plan->id == 1)
                                                    <li>40 hours of comprehensive training</li>
                                                    <li>EUC and web development focus</li>
                                                    <li>Portfolio building support</li>
                                                    <li>All skill levels welcome</li>
                                                @elseif($plan->id == 4)
                                                    <li>Live Q&A sessions</li>
                                                    <li>Submit questions via chat</li>
                                                    <li>Multiple topics covered</li>
                                                    <li>Interactive learning</li>
                                                @elseif($plan->id == 5)
                                                    <li>Response to video comments</li>
                                                    <li>Programming topics</li>
                                                    <li>Cybersecurity discussions</li>
                                                    <li>Tech skill-building</li>
                                                @elseif($plan->id == 2)
                                                    <li>Hands-on assistance with coding tasks</li>
                                                    <li>Web development support</li>
                                                    <li>System configurations</li>
                                                    <li>Tech-related task completion</li>
                                                @elseif($plan->id == 3)
                                                    <li>One-on-one personalized guidance</li>
                                                    <li>Submit requests in advance</li>
                                                    <li>Video call or chat sessions</li>
                                                    <li>Flexible scheduling</li>
                                                @endif
                                            </ul>
                                        </div>
                                        
                                        <!-- In the Available Product Plans section -->
                                        <div class="plan-actions">
                                            @if(Auth::check())
                                                    @if($plan->id == 6) <!-- Premium Plan -->
                                                        @php
                                                            $subscriptionType = strtolower(auth()->user()->subscription_type);
                                                            $hasActivePremium = $subscriptionType === 'premium' && 
                                                                            auth()->user()->subscription_expiry && 
                                                                            auth()->user()->subscription_expiry->isFuture();
                                                        @endphp
                                                        
                                                        @if($hasActivePremium)
                                                            <span class="btn btn-outline">Already Subscribed</span>
                                                            <div class="subscription-info" style="font-size: 12px; margin-top: 5px; color: #666;">
                                                                Expires: {{ auth()->user()->subscription_expiry->format('M d, Y') }}
                                                            </div>
                                                        @else
                                                            <a href="{{ route('subscription.yoco.redirect') }}" class="btn btn-primary">Upgrade Now</a>
                                                        @endif
                                                    @elseif($plan->id == 1) <!-- Formal Training -->
                                                    @if($formalTrainingsRegistered->contains('id', $plan->id))
                                                        <span class="btn btn-outline">Already Registered</span>
                                                    @else
                                                        <a href="{{ url('/dashboard#usr_formaltraining') }}" class="btn btn-primary">Enroll Now</a>
                                                    @endif
                                                @elseif(in_array($plan->id, [4, 5])) <!-- Group Sessions -->
                                                    @php
                                                        $session = $plan->id == 4 ? $qaSession : $consultSession;
                                                        $hasRegistered = $groupSessions->contains('id', $plan->id);
                                                    @endphp
                                                    @if($hasRegistered)
                                                        <span class="btn btn-outline">Already Registered</span>
                                                    @elseif($session)
                                                        <a href="#" class="btn btn-primary registration-trigger" 
                                                        data-type-id="{{ $plan->id }}" 
                                                        data-session-id="{{ $session->id }}">
                                                            BOOK NOW
                                                        </a>
                                                    @else
                                                        <button class="btn btn-primary" disabled>BOOK NOW</button>
                                                    @endif
                                                @elseif($plan->id == 2) <!-- Task Assistance -->
                                                    <a href="{{ url('/dashboard#usr_taskAssistance') }}" class="btn btn-primary">Get Help</a>
                                                @elseif($plan->id == 3) <!-- Personal Guide -->
                                                    <a href="{{ url('/dashboard#usr_guide') }}" class="btn btn-primary">Get Guide</a>
                                                @endif
                                            @else
                                                <a href="{{ url('/login?redirect=' . urlencode(url()->current())) }}" class="btn btn-primary">
                                                    @if($plan->id == 6)Upgrade Now
                                                    @elseif($plan->id == 1)Enroll Now
                                                    @elseif(in_array($plan->id, [4, 5]))BOOK NOW
                                                    @elseif($plan->id == 2)Get Help
                                                    @elseif($plan->id == 3)Get Guide
                                                    @else Get Started
                                                    @endif
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- resources containers -->
                <div class="content-section resources_content" id="usr_resources">
                    <div class="resources-container">
                        <div class="container">
                            <div class="title">
                                <h2>Available Resources</h2>
                                <p>Browse through materials available with your current product plan</p>
                                
                                <!-- Search bar -->
                                <div class="resources-search">
                                    <i class="fas fa-search"></i>
                                    <input type="text" id="resourcesSearch" placeholder="Search resources..." oninput="filterResources(this.value.toLowerCase())">
                                </div>
                            </div>
                            
                            <!-- Free user message -->
                            <div class="free-user-message" id="freeUserMessage" style="display: none;">
                                <div class="message-content">
                                    <i class="fas fa-crown"></i>
                                    <div class="message-text">
                                        <h3>Upgrade to Access All Resources</h3>
                                        <p>Your free plan has limited access. Upgrade to unlock all premium resources.</p>
                                    </div>
                                    <button class="upgrade-cta" onclick="showUpgradeModal()">More Details</button>
                                </div>
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

                <!-- Upgrade Modal -->
                <div class="resources-modal" id="upgradeModal" style="display: none;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>Tips&Tricks Subscription</h3>
                            <span class="close-modal" onclick="closeUpgradeModal()">&times;</span>
                        </div>
                        <div class="modal-body">
                            <div class="price-tag">
                                <span>From R350/quarter</span>
                            </div>
                            <p>Full access to all our premium content with exclusive resources for serious learners and professionals.</p>
                            <ul>
                                <li>All Tips&Tricks videos</li>
                                <li>Downloadable resources & cheat sheets</li>
                                <li>Monthly curated tech newsletters on your favourite topics</li>
                            </ul>
                            <div class="modal-actions">
                                <button class="btn-secondary" onclick="closeUpgradeModal()">Maybe Later</button>
                                <button>
                                @if(Auth::check())
                                    <a href="{{ route('subscription.yoco.form') }}" class="btn-primary">Upgrade Now</a>
                                @else
                                    <a href="{{ url('/login?redirect=subscription/yoco/form') }}" class="btn-primary">Upgrade Now</a>
                                @endif
                                </button>
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
                                                    <li>Scroll down to "Update Password" section</li>
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
                                                    <li><strong>Dashboard:</strong> Your most recent Tips & Tricks appear in the "Dashboard" section</li>
                                                    <li><strong>Formal Trainings:</strong>The enrolled formal trainings are marked with a Navy-blue "Enrolled" badge — Whereas the unenrolled trainings are shown below the "My Trainings" section, labelled as "More Trainings".</li>
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
                                                    <li>Click on "Edit Profile" or go to setting(Left bar)</li>
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
                                                    <li>Each purchase is emailed to you</li>
                                                    <li>Contact Us for an electronic invoice at <i>admin@technospeak.co.za</i></li>
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
                                <form id="supportForm" class="supportForm" enctype="multipart/form-data">
                                    <!-- Choose Type -->
                                    <div class="form-group">
                                        <label for="requestType">Message Type:</label>
                                        <select id="requestType" name="requestType" required>
                                            <option value="problem" selected>Problem Report</option>
                                            <option value="feedback">Feedback Survey</option>
                                        </select>
                                    </div>

                                    <!-- Problem Report Fields -->
                                    <div id="problemFields">
                                        <div class="form-group">
                                            <label for="supportSubject">Subject:</label>
                                            <input type="text" id="supportSubject" name="supportSubject" placeholder="What's this about?" data-required>
                                        </div>

                                        <div class="form-group">
                                            <label for="supportMessage">Message:</label>
                                            <textarea id="supportMessage" name="supportMessage" rows="5" placeholder="Describe your issue in detail..." data-required></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="supportPriority">Priority:</label>
                                            <select id="supportPriority" name="supportPriority" data-required>
                                                <option value="low">Low - General question</option>
                                                <option value="medium" selected>Medium - Need help</option>
                                                <option value="high">High - Urgent issue</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="fileUpload">Attach File (optional):</label>
                                            <input type="file" id="fileUpload" name="fileUpload[]" multiple>
                                            <div id="fileList"></div>
                                        </div>
                                    </div>

                                    <!-- Feedback Survey Fields -->
                                    <div id="feedbackFields" style="display:none;">
                                        <div class="form-group">
                                            <label for="feedbackExperience">Overall Experience:</label>
                                            <select id="feedbackExperience" name="feedbackExperience" data-required>
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
                                            <select id="feedbackEase" name="feedbackEase" data-required>
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
                                            <select id="feedbackRecommend" name="feedbackRecommend" data-required>
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
                                            <textarea id="feedbackComment" name="feedbackComment" rows="4" placeholder="Tell us how we can improve..."></textarea>
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

                            @if (!auth()->user()->google_id)
                                <!-- Password-based deletion -->
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
                            @else
                                <!-- Google re-authentication -->
                                <form>
                                    @csrf
                                    <a href="{{ route('google.reauth') }}" class="delete-btn">
                                        Verify W/ Google to Delete account
                                    </a>
                                </form>
                            @endif
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

                        @forelse ($upcomingGroupSessions as $i => $session)
                            @php
                                $bgClass = $i % 2 === 0 ? 'if-qa-session-background-color' : 'if-new-video-background-color';
                                $typeIcon = match($session->type->name) {
                                    'Group Session 1' => 'fa-comments',
                                    'Group Session 2' => 'fa-video',
                                    default => 'fa-calendar',
                                };
                                $typeId = $session->type->id;
                                $isUpcoming = $session->scheduled_for->isFuture();
                            @endphp

                            <div class="up_session_bar {{ $isUpcoming ? 'registration-trigger' : 'session-disabled' }}" data-type-id="{{ $isUpcoming ? $typeId : '' }}" style="cursor: {{ $isUpcoming ? 'pointer' : 'not-allowed' }}; opacity: {{ $isUpcoming ? '1' : '0.5' }};">
                                <div class="icon up_container {{ $bgClass }}">
                                    <i class="fa {{ $typeIcon }}" aria-hidden="true"></i>
                                </div>
                                <div class="content_sbar up_container">
                                    <strong>{{ $session->title }} - {{ $session->type->name }}</strong>
                                    <p>{{ $session->scheduled_for->format('d M Y, l') }} - 
                                        @if ($isUpcoming)
                                            <span class="text-green-600 text-sm" style="color:#1fb12b;"><i>Upcoming</i></span>
                                        @else
                                            <span class="text-gray-500 text-sm" style="color:#d36262;"><i>Completed</i></span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 p-2">No upcoming group sessions.</p>
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
                                <a href="tel:+27692855642" class="contact-btn">+27 (0) 69 285 5642</a>
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
        <!-- main dash search -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const searchInput = document.getElementById('dashboardSearch');
                const myLearningsContainer = document.querySelector('#usr_dashboard .my_learnings .card-grid');
                const myLearningsCards = myLearningsContainer.querySelectorAll('a.enrolled-course-link');
                const emptyState = myLearningsContainer.querySelector('.empty-state');

                const noResultsMessage = document.createElement('div');
                noResultsMessage.className = 'no-results-message';
                noResultsMessage.style.padding = '20px';
                noResultsMessage.style.textAlign = 'center';
                noResultsMessage.style.color = '#718096';
                noResultsMessage.style.background = '#f8fafc';
                noResultsMessage.style.borderRadius = '8px';
                noResultsMessage.style.margin = '20px';
                noResultsMessage.style.fontStyle = 'italic';
                noResultsMessage.innerHTML = '<p>There are no current Tips & Tricks matching your search. Please try a different keyword!</p>';

                searchInput.addEventListener('input', function () {
                    const query = searchInput.value.toLowerCase();
                    let anyVisible = false;

                    myLearningsCards.forEach(card => {
                        const title = card.querySelector('h1')?.innerText.toLowerCase() || '';
                        const description = card.querySelector('p')?.innerText.toLowerCase() || '';

                        if (title.includes(query) || description.includes(query)) {
                            card.style.display = '';
                            anyVisible = true;
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    if (!anyVisible) {
                        if (!myLearningsContainer.contains(noResultsMessage)) {
                            myLearningsContainer.appendChild(noResultsMessage);
                        }
                        if (emptyState) emptyState.style.display = 'none';
                    } else {
                        if (myLearningsContainer.contains(noResultsMessage)) {
                            myLearningsContainer.removeChild(noResultsMessage);
                        }
                        if (emptyState) emptyState.style.display = '';
                    }
                });
            });
        </script>

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
        <script src="@secureAsset('/script/dashboard.js')"></script>

        <!-- functions for only user subsciptions -->
        <script src="@secureAsset('/script/subscription.js')"></script>

        <!-- Functions for resources -->
        <script src="@secureAsset('/script/resources.js')"></script>

        <!-- Functions for free and paid trainigs -->
        <script src="@secureAsset('/script/dash_trainings.js')"></script>

        <!-- logout session -->
        <script src="@secureAsset('/script/logout_session.js')"></script>

        <!-- pop-up general -->
        <script src="@secureAsset('/script/pop-up.js')"></script>

        <!-- search functions for courses -->
        <script src="@secureAsset('/script/trainings-filtering.js')"></script>

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
                        title: 'Removed',
                        text: decodeURIComponent(message || 'You no longer have access.'),
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

        <!-- assistance submission -->
        <script src="@secureAsset('/script/sendMail/support_assistance.js')"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Handle training card clicks
                document.querySelectorAll('.training-card').forEach(card => {
                    card.addEventListener('click', function(e) {
                        e.preventDefault();
                        
                        const courseId = this.getAttribute('data-course-id');
                        const trainingType = this.getAttribute('data-training-type');
                        const isEnrolled = this.getAttribute('data-enrolled') === 'true';
                        
                        if (isEnrolled) {
                            // If already enrolled, go directly to the course
                            window.location.href = this.getAttribute('data-show-link');
                        } else if (trainingType === 'frml_training') {
                            // For formal trainings, go to the details page first
                            window.location.href = `/unenrolled-courses/${courseId}`;
                        } else {
                            // For tips & tricks, use the existing enrollment flow
                            enrollInCourse(courseId);
                        }
                    });
                });

                // Your existing enrollInCourse function
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
                            return;
                        }

                        if (data.success) {
                            if (data.open_url) {
                                // Redirect to the specified URL
                                window.location.href = data.open_url;
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: data.message,
                                    timer: 2500,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.href = `/enrolled-courses/${courseId}`;
                                });
                            }
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

        <script>
            // Mobile sidebar functionality
            document.addEventListener('DOMContentLoaded', function() {
                const hamburgerMenu = document.getElementById('hamburgerMenu');
                const sidebar = document.querySelector('.sidebar');
                const sidebarOverlay = document.getElementById('sidebarOverlay');
                
                function toggleSidebar() {
                    sidebar.classList.toggle('active');
                    sidebarOverlay.classList.toggle('active');
                    document.body.classList.toggle('no-scroll');
                }
                
                hamburgerMenu.addEventListener('click', toggleSidebar);
                sidebarOverlay.addEventListener('click', toggleSidebar);
                
                // Close sidebar when a nav item is clicked (on mobile)
                document.querySelectorAll('.nav-item a').forEach(item => {
                    item.addEventListener('click', function() {
                        if (window.innerWidth <= 1024) {
                            toggleSidebar();
                        }
                    });
                });
                
                // Handle window resize
                window.addEventListener('resize', function() {
                    if (window.innerWidth > 1024) {
                        sidebar.classList.remove('active');
                        sidebarOverlay.classList.remove('active');
                        document.body.classList.remove('no-scroll');
                    }
                });
            });
        </script>
    </body>
</html>