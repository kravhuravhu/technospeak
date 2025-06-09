<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Technospeak Strategies - Home</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="TechnoSpeak">
        <meta property="og:type" content="website">
        <link rel="icon" href="IMAGES/icon.png" type="image/x-icon">
        <link rel="stylesheet" href="style/dashboard.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Alegreya:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Schoolbell&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <!-- Font Awesome CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        <section class="sidebar bar-lt-rt">
            <div class="main_container">
                <div class="logo_container">
                    <a href="#">
                        <img src="/images/default-no-logo.png" alt="technospeak_icon">
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
                        <div class="nav-item" data-section="usr_alltrainings">
                            <a href="">
                            <div class="icon">
                                <i class="fa-solid fa-computer"></i>
                            </div>
                            <div class="title">
                                <span>All Trainings</span>
                            </div>
                            </a>
                        </div>
                        <div class="nav-item" data-section="usr_qasessions">
                            <a href="">
                            <div class="icon">
                                <i class="fa-solid fa-person-circle-question"></i>
                            </div>
                            <div class="title">
                                <span>Q/A Sessions Recap</span>
                            </div>
                            </a>
                        </div>
                        <div class="nav-item" data-section="usr_mysubscriptions">
                            <a href="">
                            <div class="icon">
                                <i class="fa-solid fa-tags"></i>
                            </div>
                            <div class="title">
                                <span>My Subscriptions</span>
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
                        <div class="nav-item" data-section="usr_tsassistance">
                            <a href="">
                            <div class="icon">
                                <i class="fa-solid fa-handshake-angle"></i>
                            </div>
                            <div class="title">
                                <span>Task Assistance</span>
                            </div>
                            </a>
                        </div>
                        <div class="nav-item" data-section="usr_hlpcenter">
                            <a href="">
                            <div class="icon">
                                <i class="fa-solid fa-circle-info"></i>
                            </div>
                            <div class="title">
                                <span>Help Center</span>
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
                    </div>
                </div>
            </div>
            <div class="promo">
                <div>
                    <p>Something about cheatsheet? well ipsum dolor sit amet consectetur</p>
                    <button>Upgrade Now</button>
                </div>
            </div>
        </section>

        <section class="main">
            <div class="container">
                <!-- dashboard containers -->
                <div class="content-section active dashboard_content" id="usr_dashboard">
                    <div class="topbar search-bar">
                        <i class="fa fa-search search-icon"></i>
                        <input type="text" placeholder="Search...">
                    </div>
                    <div class="welcome">
                        <div class="nname">
                            <h1>Welcome back, {{ Auth::user()->name }}</h1>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, </p>
                            <p>sed do eiusmod tempor incididunt ut labore et dolore </p>
                        </div>
                        <div>
                            <picture>
                                <source srcset="https://fonts.gstatic.com/s/e/notoemoji/latest/1f44b_1f3fd/512.webp" type="image/webp">
                                <img src="https://fonts.gstatic.com/s/e/notoemoji/latest/1f44b_1f3fd/512.gif" alt="👋"/>
                            </picture>
                        </div>
                    </div>
                    <div class="my_learnings ln_rcmm">
                        <div class="container">
                            <div class="title">
                                <h1>My Trainings</h1>
                            </div>
                            <div class="card-grid">
                                <a href="">
                                    <div class="card">
                                        <div class="thmbnail">
                                            <img src="../images/teams/zinhle.jpeg" alt="team two">
                                            <div class="trnsprnt"></div>
                                        </div>
                                        <div class="details">
                                            <div class="title content">
                                                <h1>Training Title</h1>
                                            </div>
                                            <div class="dur content">
                                                <p><i>Duration: 30min</i></p>
                                            </div>
                                            <div class="ctprs content">
                                                <p>Video catchphrase here blah blah</p>
                                            </div>
                                            <div class="progress_bar content">
                                                <div class="main-bar">
                                                    <div class="progress"></div>
                                                </div>
                                                <div class="cr-bar">65%</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="">
                                    <div class="card">
                                        <div class="thmbnail">
                                            <img src="../images/teams/zinhle.jpeg" alt="team two">
                                            <div class="trnsprnt"></div>
                                        </div>
                                        <div class="details">
                                            <div class="title content">
                                                <h1>Training Title</h1>
                                            </div>
                                            <div class="dur content">
                                                <p><i>Duration: 30min</i></p>
                                            </div>
                                            <div class="ctprs content">
                                                <p>Video catchphrase here blah blah</p>
                                            </div>
                                            <div class="progress_bar content">
                                                <div class="main-bar">
                                                    <div class="progress"></div>
                                                </div>
                                                <div class="cr-bar">65%</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="">
                                    <div class="card">
                                        <div class="thmbnail">
                                            <img src="../images/teams/zinhle.jpeg" alt="team two">
                                            <div class="trnsprnt"></div>
                                        </div>
                                        <div class="details">
                                            <div class="title content">
                                                <h1>Training Title</h1>
                                            </div>
                                            <div class="dur content">
                                                <p><i>Duration: 30min</i></p>
                                            </div>
                                            <div class="ctprs content">
                                                <p>Video catchphrase here blah blah</p>
                                            </div>
                                            <div class="progress_bar content">
                                                <div class="main-bar">
                                                    <div class="progress"></div>
                                                </div>
                                                <div class="cr-bar">65%</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="">
                                    <div class="card">
                                        <div class="thmbnail">
                                            <img src="../images/teams/zinhle.jpeg" alt="team two">
                                            <div class="trnsprnt"></div>
                                        </div>
                                        <div class="details">
                                            <div class="title content">
                                                <h1>Training Title</h1>
                                            </div>
                                            <div class="dur content">
                                                <p><i>Duration: 30min</i></p>
                                            </div>
                                            <div class="ctprs content">
                                                <p>Video catchphrase here blah blah</p>
                                            </div>
                                            <div class="progress_bar content">
                                                <div class="main-bar">
                                                    <div class="progress"></div>
                                                </div>
                                                <div class="cr-bar">65%</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="rcmmnd_trngs ln_rcmm">
                        <div class="container">
                            <div class="title">
                                <h1>Recommended Trainings</h1>
                            </div>
                            <div class="card-grid thn_grid_cd">
                                <a href="">
                                    <div class="card rcmmd_cd">
                                        <div class="thmbnail thn_rcmm">
                                            <div class="trnsprnt thmb_img">
                                                <img src="../images/teams/zinhle.jpeg" alt="team two">
                                            </div>
                                        </div>
                                        <div class="details thmb_dt">
                                            <div class="title content thmb_cnt">
                                                <h1 class="thmb_h1">Training Title</h1>
                                            </div>
                                            <div class="ctprs content thmb_cnt">
                                                <p class="thmb_ct">Study Smarter with Google & Microsoft Tools</p>
                                            </div>
                                            <div class="thmb_dur_ep_container content thmb_cnt">
                                                <div class="cont left-side">
                                                    <i class="fa-solid fa-stopwatch"></i>
                                                    <span>1h30min</span>
                                                </div>
                                                <div class="cont right-side">
                                                    <i class="fa-solid fa-video"></i>
                                                    <span>4 Episodes</span>
                                                </div>
                                            </div>
                                            <div class="thmb_enrll content">
                                                <label>Enroll</label>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="">
                                    <div class="card rcmmd_cd">
                                        <div class="thmbnail thn_rcmm">
                                            <div class="trnsprnt thmb_img">
                                                <img src="../images/teams/zinhle.jpeg" alt="team two">
                                            </div>
                                        </div>
                                        <div class="details thmb_dt">
                                            <div class="title content thmb_cnt">
                                                <h1 class="thmb_h1">Training Title</h1>
                                            </div>
                                            <div class="ctprs content thmb_cnt">
                                                <p class="thmb_ct">Study Smarter with Google & Microsoft Tools</p>
                                            </div>
                                            <div class="thmb_dur_ep_container content thmb_cnt">
                                                <div class="cont left-side">
                                                    <i class="fa-solid fa-stopwatch"></i>
                                                    <span>1h30min</span>
                                                </div>
                                                <div class="cont right-side">
                                                    <i class="fa-solid fa-video"></i>
                                                    <span>4 Episodes</span>
                                                </div>
                                            </div>
                                            <div class="thmb_enrll content">
                                                <label>Enroll</label>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="">
                                    <div class="card rcmmd_cd">
                                        <div class="thmbnail thn_rcmm">
                                            <div class="trnsprnt thmb_img">
                                                <img src="../images/teams/zinhle.jpeg" alt="team two">
                                            </div>
                                        </div>
                                        <div class="details thmb_dt">
                                            <div class="title content thmb_cnt">
                                                <h1 class="thmb_h1">Training Title</h1>
                                            </div>
                                            <div class="ctprs content thmb_cnt">
                                                <p class="thmb_ct">Study Smarter with Google & Microsoft Tools</p>
                                            </div>
                                            <div class="thmb_dur_ep_container content thmb_cnt">
                                                <div class="cont left-side">
                                                    <i class="fa-solid fa-stopwatch"></i>
                                                    <span>1h30min</span>
                                                </div>
                                                <div class="cont right-side">
                                                    <i class="fa-solid fa-video"></i>
                                                    <span>4 Episodes</span>
                                                </div>
                                            </div>
                                            <div class="thmb_enrll content">
                                                <label>Enroll</label>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="">
                                    <div class="card rcmmd_cd">
                                        <div class="thmbnail thn_rcmm">
                                            <div class="trnsprnt thmb_img">
                                                <img src="../images/teams/zinhle.jpeg" alt="team two">
                                            </div>
                                        </div>
                                        <div class="details thmb_dt">
                                            <div class="title content thmb_cnt">
                                                <h1 class="thmb_h1">Training Title</h1>
                                            </div>
                                            <div class="ctprs content thmb_cnt">
                                                <p class="thmb_ct">Study Smarter with Google & Microsoft Tools</p>
                                            </div>
                                            <div class="thmb_dur_ep_container content thmb_cnt">
                                                <div class="cont left-side">
                                                    <i class="fa-solid fa-stopwatch"></i>
                                                    <span>1h30min</span>
                                                </div>
                                                <div class="cont right-side">
                                                    <i class="fa-solid fa-video"></i>
                                                    <span>4 Episodes</span>
                                                </div>
                                            </div>
                                            <div class="thmb_enrll content">
                                                <label>Enroll</label>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- trainings containers -->
                <div class="content-section alltrainings_content" id="usr_alltrainings">
                    <h1>All Trainings</h1>
                    <p>Browse all available training materials here.</p>
                </div>
                
                <!-- subscriptions containers -->
                <div class="content-section subscriptions_content" id="usr_mysubscriptions">
                    <div class="topbar search-bar">
                        <i class="fa fa-search search-icon"></i>
                        <input type="text" placeholder="Search plans...">
                    </div>
                    
                    <div class="welcome">
                        <div class="nname">
                            <h1>My Subscription Plans</h1>
                            <p>Manage your current subscriptions and explore new opportunities</p>
                        </div>
                        <div class="welcome-emoji">
                            <picture>
                                <source srcset="https://fonts.gstatic.com/s/e/notoemoji/latest/1f4b8/512.webp" type="image/webp">
                                <img src="../images/icons/moneygiff.gif" alt="💸"/>
                            </picture>
                        </div>
                    </div>

                    <div class="current-plans">
                        <div class="container">
                            <div class="title">
                                <h2>Your Active Plans</h2>
                                <p>These are the plans you're currently subscribed to</p>
                            </div>
                            <div class="card-grid" id="userPlans">
                                <!-- Plans inserted by JavaScript -->
                            </div>
                        </div>
                    </div>
                    
                    <div class="other-plans">
                        <div class="container">
                            <div class="title">
                                <h2>Available Plans</h2>
                                <p>Upgrade your experience with these additional options</p>
                            </div>
                            <div class="card-grid" id="otherPlans">
                                <!-- Other plans will be inserted here by JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- resources containers -->
                <div class="content-section resources_content" id="usr_resources">
                    <div class="topbar search-bar">
                        <i class="fa fa-search search-icon"></i>
                        <input type="text" placeholder="Search resources...">
                    </div>
                    
                    <div class="welcome">
                        <div class="nname">
                            <h1>Learning Resources</h1>
                            <p>Access valuable materials to boost your technical skills</p>
                            <p>Upgrade your plan to unlock premium content</p>
                        </div>
                        <div class="welcome-emoji">
                            <picture>
                                <source srcset="https://i.pinimg.com/originals/a4/7b/57/a47b57e90d479592b4e8e09199105b8f.gif" type="image/webp">
                                <img src="../images/icons/books6.gif" alt="📚"/>
                            </picture>
                        </div>
                    </div>

                    <div class="resources-container">
                        <div class="container">
                            <div class="title">
                                <h2>Available Resources</h2>
                                <p>Browse through materials available with your current subscription</p>
                            </div>
                            
                            <div class="resource-grid" id="resourceGrid">
                                <!-- Resource cards will be inserted here by JavaScript -->
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

        <section class="rightbar bar-lt-rt rt-bar">
            <div class="main_container">
                <div class="right-bar">
                    <div class="ntfc_name">
                        <div class="ntfc nt_nm">
                            <i class="fa-solid fa-bell"></i>
                        </div>
                        <div class="name nt_nm">
                            <div class="cont">
                                <p>{{ Auth::user()->name }} {{ Auth::user()->surname }}</p>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <div id="dropdownMenu" class="dropdown hidden">
                                <a href="" class="content-section">Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="progress_box">
                        <div class="progress-container">
                            <div class="progress-header">
                                <h1 class="progress-title">Your Overall Progress</h1>
                                <p class="progress-percent">25%</p>
                            </div>
                            <div class="progress-track">
                                <div class="progress-fill" style="width: 25%;"></div>
                                <div class="level-marker active"></div>
                                <div class="level-marker active"></div>
                                <div class="level-marker"></div>
                                <div class="level-marker"></div>
                                <div class="level-marker"></div>
                            </div>
                            <div class="progress-labels">
                                <div class="label">0%<br><span></span></div>
                                <div class="label">25%<br><span>Beginner</span></div>
                                <div class="label">50%<br><span>Intermediate</span></div>
                                <div class="label">75%<br><span>Advanced</span></div>
                                <div class="label">100%<br><span>Expert</span></div>
                            </div>
                            <div class="progress-message">
                                <p>You're making great progress in the course! Keep up the fantastic work <span class="emoji">💯</span>! You've got this! Keep learning, and you'll be amazed at what you can accomplish.</p>
                            </div>
                        </div>
                    </div>
                    <div class="upcoming_box">
                        <div class="title">
                            <h4>Upcoming Sessions</h4>
                        </div>
                        <div class="up_session_bar">
                            <div class="icon up_container if-qa-session-background-color">
                                <i class="fa fa-comments" aria-hidden="true"></i>
                            </div>
                            <div class="content_sbar up_container">
                                <strong>Q/A Session - Constant BlueScreen Errors</strong>
                                <p>21 Aug 2025, Friday</p>
                            </div>
                        </div>
                        <div class="up_session_bar">
                            <div class="icon up_container if-new-video-background-color">
                                <i class="fa fa-book" aria-hidden="true"></i>
                            </div>
                            <div class="content_sbar up_container">
                                <strong>Introduction to Microsoft Office, manage your productivity</strong>
                                <p>01 Oct 2025, Saturday</p>
                            </div>
                        </div>
                        <div class="up_session_bar">
                            <div class="icon up_container if-qa-session-background-color">
                                <i class="fa fa-comments" aria-hidden="true"></i>
                            </div>
                            <div class="content_sbar up_container">
                                <strong>Q/A Session - Constant BlueScreen Errors</strong>
                                <p>21 Aug 2025, Friday</p>
                            </div>
                        </div>
                        <div class="up_session_bar">
                            <div class="icon up_container if-new-video-background-color">
                                <i class="fa fa-book" aria-hidden="true"></i>
                            </div>
                            <div class="content_sbar up_container">
                                <strong>Introduction to Microsoft Office, manage your productivity</strong>
                                <p>01 Oct 2025, Saturday</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Js connections -->
        <script>
            const navItems = document.querySelectorAll('.nav-item');
            navItems.forEach(item => {
                item.addEventListener('click', () => {
                    navItems.forEach(el => el.classList.remove('active'));
                    item.classList.add('active');
                });
            });
            document.addEventListener('DOMContentLoaded', () => {
                updateProgress(50);

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
            });
        </script>

        <!-- pass session value to JS to remain on usr_settings -->
        <script>
            window.activeSection = "{{ session('section', 'usr_dashboard') }}";
        </script>

        <!-- switching b|n menu-items -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const navItems = document.querySelectorAll('.nav-item');
                const contentSections = document.querySelectorAll('.content-section');
                
                if (window.activeSection) {
                    navItems.forEach(navItem => navItem.classList.remove('active'));
                    contentSections.forEach(section => section.classList.remove('active'));

                    const activeNav = document.querySelector(`.nav-item[data-section="${window.activeSection}"]`);
                    if (activeNav) activeNav.classList.add('active');

                    const activeSection = document.getElementById(window.activeSection);
                    if (activeSection) activeSection.classList.add('active');
                }

                navItems.forEach(item => {
                    item.addEventListener('click', function() {
                        event.preventDefault();
                        navItems.forEach(navItem => {
                            navItem.classList.remove('active');
                        });

                        this.classList.add('active');
                        
                        // Get the section
                        const sectionId = this.getAttribute('data-section');
                        
                        contentSections.forEach(section => {
                            section.classList.remove('active');
                        });

                        document.getElementById(sectionId).classList.add('active');
                    });
                });
            });
        </script>

        <!-- log out and profile settings -->
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

        <!-- functions for only user subsciptions -->
        <script src="/script/subscription.js"></script>

        <!-- Functions for resources -->
        <script src="/script/resources.js"></script>



    </body>
</html>