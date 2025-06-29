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
        <link rel="stylesheet" href="style/footer.css">
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
        @include('components.preference-popup', [
            'categories' => \App\Models\CourseCategory::all()
        ])

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
                                <span>Training Library</span>
                            </div>
                            </a>
                        </div>
                        <div class="nav-item" data-section="usr_shareIssue">
                            <a href="">
                            <div class="icon">
                                <i class="fa-solid fa-bug"></i>
                            </div>
                            <div class="title">
                                <span>Get Help</span>
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
                        <div class="nav-item" data-section="usr_techCoach">
                            <a href="">
                            <div class="icon">
                                <i class="fa-solid fa-person-chalkboard"></i>
                            </div>
                            <div class="title">
                                <span>Coaching</span>
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
                    <!-- Free Trainings Section -->
                    <div class="rcmmnd_trngs free_tr all_tr ln_rcmm">
                        <div class="container">
                            <div class="title">
                                <h1>Free Trainings</h1>
                            </div>
                            <div class="card-grid thn_grid_cd" id="free-trainings">
                                <a href="#" class="training-card" 
                                    data-training-type="free"
                                    data-title="Introduction to Digital Marketing"
                                    data-description="Learn the fundamentals of digital marketing including SEO, social media, and content marketing. This comprehensive course will take you from beginner to confident practitioner with hands-on projects and real-world examples."
                                    data-image="/images/thumbnails/Whisk_e3ccd6591e.jpg"
                                    data-duration="4 weeks"
                                    data-level="Beginner"
                                    data-instructor="Sarah Johnson"
                                    data-category="Marketing"
                                    data-episodes='[
                                        {"number":1,"name":"Introduction to Digital Marketing","duration":"15 min"},
                                        {"number":2,"name":"Understanding SEO Basics","duration":"22 min"},
                                        {"number":3,"name":"Social Media Marketing Strategies","duration":"18 min"},
                                        {"number":4,"name":"Content Marketing Fundamentals","duration":"20 min"},
                                        {"number":5,"name":"Email Marketing Techniques","duration":"16 min"},
                                        {"number":6,"name":"Google Analytics Overview","duration":"25 min"},
                                        {"number":7,"name":"PPC Advertising Basics","duration":"19 min"},
                                        {"number":8,"name":"Creating a Digital Marketing Plan","duration":"30 min"}
                                    ]'
                                    data-time="3h 45min">
                                    <div class="card rcmmd_cd">
                                        <div class="thmbnail thn_rcmm">
                                            <div class="trnsprnt thmb_img">
                                                <img src="/images/thumbnails/Whisk_e3ccd6591e.jpg" alt="Introduction to Digital Marketing">
                                            </div>
                                        </div>
                                        <div class="details thmb_dt">
                                            <div class="title content thmb_cnt">
                                                <h1 class="thmb_h1">Digital Marketing</h1>
                                            </div>
                                            <div class="ctprs content thmb_cnt">
                                                <p class="thmb_ct">Learn the fundamentals of digital marketing including SEO, social media, and content marketing. This comprehensive course will take you from beginner to confident practitioner with hands-on projects and real-world examples....</p>
                                            </div>
                                            <div class="thmb_dur_ep_container content thmb_cnt">
                                                <div class="cont left-side">
                                                    <i class="fa-solid fa-stopwatch"></i>
                                                    <span>3h 45min</span>
                                                </div>
                                                <div class="cont right-side">
                                                    <i class="fa-solid fa-video"></i>
                                                    <span>8 Episodes</span>
                                                </div>
                                            </div>
                                            <div class="thmb_enrll content">
                                                <label>Enroll Free</label>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="training-card" 
                                    data-training-type="free"
                                    data-title="Python for Beginners"
                                    data-description="Start your programming journey with this comprehensive Python course for absolute beginners. Learn syntax, data structures, and problem-solving techniques through practical exercises."
                                    data-image="images/thumbnails/Whisk_f4a5896531.jpg"
                                    data-duration="6 weeks"
                                    data-level="Beginner"
                                    data-instructor="Michael Chen"
                                    data-category="Programming"
                                    data-episodes='[
                                        {"number":1,"name":"Python Installation & Setup","duration":"12 min"},
                                        {"number":2,"name":"Variables and Data Types","duration":"18 min"},
                                        {"number":3,"name":"Conditional Statements","duration":"20 min"},
                                        {"number":4,"name":"Loops and Iterations","duration":"25 min"},
                                        {"number":5,"name":"Functions in Python","duration":"22 min"},
                                        {"number":6,"name":"Working with Lists","duration":"15 min"},
                                        {"number":7,"name":"Dictionaries and Tuples","duration":"18 min"},
                                        {"number":8,"name":"File Handling Basics","duration":"20 min"}
                                    ]'
                                    data-time="5h 30min">
                                    <div class="card rcmmd_cd">
                                        <div class="thmbnail thn_rcmm">
                                            <div class="trnsprnt thmb_img">
                                                <img src="images/thumbnails/Whisk_f4a5896531.jpg" alt="Python for Beginners">
                                            </div>
                                        </div>
                                        <div class="details thmb_dt">
                                            <div class="title content thmb_cnt">
                                                <h1 class="thmb_h1">Python for Beginners</h1>
                                            </div>
                                            <div class="ctprs content thmb_cnt">
                                                <p class="thmb_ct">Start your programming journey with this comprehensive Python course for absolute beginners. Learn syntax, data structures, and problem-solving techniques through practical exercises....</p>
                                            </div>
                                            <div class="thmb_dur_ep_container content thmb_cnt">
                                                <div class="cont left-side">
                                                    <i class="fa-solid fa-stopwatch"></i>
                                                    <span>5h 30min</span>
                                                </div>
                                                <div class="cont right-side">
                                                    <i class="fa-solid fa-video"></i>
                                                    <span>8 Episodes</span>
                                                </div>
                                            </div>
                                            <div class="thmb_enrll content">
                                                <label>Enroll Free</label>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="training-card" 
                                    data-training-type="free"
                                    data-title="Python for Beginners"
                                    data-description="Start your programming journey with this comprehensive Python course for absolute beginners. Learn syntax, data structures, and problem-solving techniques through practical exercises."
                                    data-image="images/thumbnails/Whisk_f4a5896531.jpg"
                                    data-duration="6 weeks"
                                    data-level="Beginner"
                                    data-instructor="Michael Chen"
                                    data-category="Programming"
                                    data-episodes='[
                                        {"number":1,"name":"Python Installation & Setup","duration":"12 min"},
                                        {"number":2,"name":"Variables and Data Types","duration":"18 min"},
                                        {"number":3,"name":"Conditional Statements","duration":"20 min"},
                                        {"number":4,"name":"Loops and Iterations","duration":"25 min"},
                                        {"number":5,"name":"Functions in Python","duration":"22 min"},
                                        {"number":6,"name":"Working with Lists","duration":"15 min"},
                                        {"number":7,"name":"Dictionaries and Tuples","duration":"18 min"},
                                        {"number":8,"name":"File Handling Basics","duration":"20 min"}
                                    ]'
                                    data-time="5h 30min">
                                    <div class="card rcmmd_cd">
                                        <div class="thmbnail thn_rcmm">
                                            <div class="trnsprnt thmb_img">
                                                <img src="images/thumbnails/Whisk_f4a5896531.jpg" alt="Python for Beginners">
                                            </div>
                                        </div>
                                        <div class="details thmb_dt">
                                            <div class="title content thmb_cnt">
                                                <h1 class="thmb_h1">Python for Beginners</h1>
                                            </div>
                                            <div class="ctprs content thmb_cnt">
                                                <p class="thmb_ct">Start your programming journey with this comprehensive Python course for absolute beginners. Learn syntax, data structures, and problem-solving techniques through practical exercises....</p>
                                            </div>
                                            <div class="thmb_dur_ep_container content thmb_cnt">
                                                <div class="cont left-side">
                                                    <i class="fa-solid fa-stopwatch"></i>
                                                    <span>5h 30min</span>
                                                </div>
                                                <div class="cont right-side">
                                                    <i class="fa-solid fa-video"></i>
                                                    <span>8 Episodes</span>
                                                </div>
                                            </div>
                                            <div class="thmb_enrll content">
                                                <label>Enroll Free</label>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="training-card" 
                                    data-training-type="free"
                                    data-title="Python for Beginners"
                                    data-description="Start your programming journey with this comprehensive Python course for absolute beginners. Learn syntax, data structures, and problem-solving techniques through practical exercises."
                                    data-image="images/thumbnails/Whisk_f4a5896531.jpg"
                                    data-duration="6 weeks"
                                    data-level="Beginner"
                                    data-instructor="Michael Chen"
                                    data-category="Programming"
                                    data-episodes='[
                                        {"number":1,"name":"Python Installation & Setup","duration":"12 min"},
                                        {"number":2,"name":"Variables and Data Types","duration":"18 min"},
                                        {"number":3,"name":"Conditional Statements","duration":"20 min"},
                                        {"number":4,"name":"Loops and Iterations","duration":"25 min"},
                                        {"number":5,"name":"Functions in Python","duration":"22 min"},
                                        {"number":6,"name":"Working with Lists","duration":"15 min"},
                                        {"number":7,"name":"Dictionaries and Tuples","duration":"18 min"},
                                        {"number":8,"name":"File Handling Basics","duration":"20 min"}
                                    ]'
                                    data-time="5h 30min">
                                    <div class="card rcmmd_cd">
                                        <div class="thmbnail thn_rcmm">
                                            <div class="trnsprnt thmb_img">
                                                <img src="images/thumbnails/Whisk_f4a5896531.jpg" alt="Python for Beginners">
                                            </div>
                                        </div>
                                        <div class="details thmb_dt">
                                            <div class="title content thmb_cnt">
                                                <h1 class="thmb_h1">Python for Beginners</h1>
                                            </div>
                                            <div class="ctprs content thmb_cnt">
                                                <p class="thmb_ct">Start your programming journey with this comprehensive Python course for absolute beginners. Learn syntax, data structures, and problem-solving techniques through practical exercises....</p>
                                            </div>
                                            <div class="thmb_dur_ep_container content thmb_cnt">
                                                <div class="cont left-side">
                                                    <i class="fa-solid fa-stopwatch"></i>
                                                    <span>5h 30min</span>
                                                </div>
                                                <div class="cont right-side">
                                                    <i class="fa-solid fa-video"></i>
                                                    <span>8 Episodes</span>
                                                </div>
                                            </div>
                                            <div class="thmb_enrll content">
                                                <label>Enroll Free</label>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            
                            <div class="card-grid thn_grid_cd hidden" id="more-free-trainings">
                                <a href="#" class="training-card" 
                                    data-training-type="free"
                                    data-title="Python for Beginners"
                                    data-description="Start your programming journey with this comprehensive Python course for absolute beginners. Learn syntax, data structures, and problem-solving techniques through practical exercises."
                                    data-image="images/thumbnails/Whisk_f4a5896531.jpg"
                                    data-duration="6 weeks"
                                    data-level="Beginner"
                                    data-instructor="Michael Chen"
                                    data-category="Programming"
                                    data-episodes='[
                                        {"number":1,"name":"Python Installation & Setup","duration":"12 min"},
                                        {"number":2,"name":"Variables and Data Types","duration":"18 min"},
                                        {"number":3,"name":"Conditional Statements","duration":"20 min"},
                                        {"number":4,"name":"Loops and Iterations","duration":"25 min"},
                                        {"number":5,"name":"Functions in Python","duration":"22 min"},
                                        {"number":6,"name":"Working with Lists","duration":"15 min"},
                                        {"number":7,"name":"Dictionaries and Tuples","duration":"18 min"},
                                        {"number":8,"name":"File Handling Basics","duration":"20 min"}
                                    ]'
                                    data-time="5h 30min">
                                    <div class="card rcmmd_cd">
                                        <div class="thmbnail thn_rcmm">
                                            <div class="trnsprnt thmb_img">
                                                <img src="images/thumbnails/Whisk_f4a5896531.jpg" alt="Python for Beginners">
                                            </div>
                                        </div>
                                        <div class="details thmb_dt">
                                            <div class="title content thmb_cnt">
                                                <h1 class="thmb_h1">Python for Beginners</h1>
                                            </div>
                                            <div class="ctprs content thmb_cnt">
                                                <p class="thmb_ct">Start your programming journey with this comprehensive Python course for absolute beginners. Learn syntax, data structures, and problem-solving techniques through practical exercises....</p>
                                            </div>
                                            <div class="thmb_dur_ep_container content thmb_cnt">
                                                <div class="cont left-side">
                                                    <i class="fa-solid fa-stopwatch"></i>
                                                    <span>5h 30min</span>
                                                </div>
                                                <div class="cont right-side">
                                                    <i class="fa-solid fa-video"></i>
                                                    <span>8 Episodes</span>
                                                </div>
                                            </div>
                                            <div class="thmb_enrll content">
                                                <label>Enroll Free</label>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="training-card" 
                                    data-training-type="free"
                                    data-title="Python for Beginners"
                                    data-description="Start your programming journey with this comprehensive Python course for absolute beginners. Learn syntax, data structures, and problem-solving techniques through practical exercises."
                                    data-image="images/thumbnails/Whisk_f4a5896531.jpg"
                                    data-duration="6 weeks"
                                    data-level="Beginner"
                                    data-instructor="Michael Chen"
                                    data-category="Programming"
                                    data-episodes='[
                                        {"number":1,"name":"Python Installation & Setup","duration":"12 min"},
                                        {"number":2,"name":"Variables and Data Types","duration":"18 min"},
                                        {"number":3,"name":"Conditional Statements","duration":"20 min"},
                                        {"number":4,"name":"Loops and Iterations","duration":"25 min"},
                                        {"number":5,"name":"Functions in Python","duration":"22 min"},
                                        {"number":6,"name":"Working with Lists","duration":"15 min"},
                                        {"number":7,"name":"Dictionaries and Tuples","duration":"18 min"},
                                        {"number":8,"name":"File Handling Basics","duration":"20 min"}
                                    ]'
                                    data-time="5h 30min">
                                    <div class="card rcmmd_cd">
                                        <div class="thmbnail thn_rcmm">
                                            <div class="trnsprnt thmb_img">
                                                <img src="images/thumbnails/Whisk_f4a5896531.jpg" alt="Python for Beginners">
                                            </div>
                                        </div>
                                        <div class="details thmb_dt">
                                            <div class="title content thmb_cnt">
                                                <h1 class="thmb_h1">Python for Beginners</h1>
                                            </div>
                                            <div class="ctprs content thmb_cnt">
                                                <p class="thmb_ct">Start your programming journey with this comprehensive Python course for absolute beginners. Learn syntax, data structures, and problem-solving techniques through practical exercises....</p>
                                            </div>
                                            <div class="thmb_dur_ep_container content thmb_cnt">
                                                <div class="cont left-side">
                                                    <i class="fa-solid fa-stopwatch"></i>
                                                    <span>5h 30min</span>
                                                </div>
                                                <div class="cont right-side">
                                                    <i class="fa-solid fa-video"></i>
                                                    <span>8 Episodes</span>
                                                </div>
                                            </div>
                                            <div class="thmb_enrll content">
                                                <label>Enroll Free</label>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="training-card" 
                                    data-training-type="free"
                                    data-title="Python for Beginners"
                                    data-description="Start your programming journey with this comprehensive Python course for absolute beginners. Learn syntax, data structures, and problem-solving techniques through practical exercises."
                                    data-image="images/thumbnails/Whisk_f4a5896531.jpg"
                                    data-duration="6 weeks"
                                    data-level="Beginner"
                                    data-instructor="Michael Chen"
                                    data-category="Programming"
                                    data-episodes='[
                                        {"number":1,"name":"Python Installation & Setup","duration":"12 min"},
                                        {"number":2,"name":"Variables and Data Types","duration":"18 min"},
                                        {"number":3,"name":"Conditional Statements","duration":"20 min"},
                                        {"number":4,"name":"Loops and Iterations","duration":"25 min"},
                                        {"number":5,"name":"Functions in Python","duration":"22 min"},
                                        {"number":6,"name":"Working with Lists","duration":"15 min"},
                                        {"number":7,"name":"Dictionaries and Tuples","duration":"18 min"},
                                        {"number":8,"name":"File Handling Basics","duration":"20 min"}
                                    ]'
                                    data-time="5h 30min">
                                    <div class="card rcmmd_cd">
                                        <div class="thmbnail thn_rcmm">
                                            <div class="trnsprnt thmb_img">
                                                <img src="images/thumbnails/Whisk_f4a5896531.jpg" alt="Python for Beginners">
                                            </div>
                                        </div>
                                        <div class="details thmb_dt">
                                            <div class="title content thmb_cnt">
                                                <h1 class="thmb_h1">Python for Beginners</h1>
                                            </div>
                                            <div class="ctprs content thmb_cnt">
                                                <p class="thmb_ct">Start your programming journey with this comprehensive Python course for absolute beginners. Learn syntax, data structures, and problem-solving techniques through practical exercises....</p>
                                            </div>
                                            <div class="thmb_dur_ep_container content thmb_cnt">
                                                <div class="cont left-side">
                                                    <i class="fa-solid fa-stopwatch"></i>
                                                    <span>5h 30min</span>
                                                </div>
                                                <div class="cont right-side">
                                                    <i class="fa-solid fa-video"></i>
                                                    <span>8 Episodes</span>
                                                </div>
                                            </div>
                                            <div class="thmb_enrll content">
                                                <label>Enroll Free</label>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="training-card" 
                                    data-training-type="free"
                                    data-title="Python for Beginners"
                                    data-description="Start your programming journey with this comprehensive Python course for absolute beginners. Learn syntax, data structures, and problem-solving techniques through practical exercises."
                                    data-image="images/thumbnails/Whisk_f4a5896531.jpg"
                                    data-duration="6 weeks"
                                    data-level="Beginner"
                                    data-instructor="Michael Chen"
                                    data-category="Programming"
                                    data-episodes='[
                                        {"number":1,"name":"Python Installation & Setup","duration":"12 min"},
                                        {"number":2,"name":"Variables and Data Types","duration":"18 min"},
                                        {"number":3,"name":"Conditional Statements","duration":"20 min"},
                                        {"number":4,"name":"Loops and Iterations","duration":"25 min"},
                                        {"number":5,"name":"Functions in Python","duration":"22 min"},
                                        {"number":6,"name":"Working with Lists","duration":"15 min"},
                                        {"number":7,"name":"Dictionaries and Tuples","duration":"18 min"},
                                        {"number":8,"name":"File Handling Basics","duration":"20 min"}
                                    ]'
                                    data-time="5h 30min">
                                    <div class="card rcmmd_cd">
                                        <div class="thmbnail thn_rcmm">
                                            <div class="trnsprnt thmb_img">
                                                <img src="images/thumbnails/Whisk_f4a5896531.jpg" alt="Python for Beginners">
                                            </div>
                                        </div>
                                        <div class="details thmb_dt">
                                            <div class="title content thmb_cnt">
                                                <h1 class="thmb_h1">Python for Beginners</h1>
                                            </div>
                                            <div class="ctprs content thmb_cnt">
                                                <p class="thmb_ct">Start your programming journey with this comprehensive Python course for absolute beginners. Learn syntax, data structures, and problem-solving techniques through practical exercises....</p>
                                            </div>
                                            <div class="thmb_dur_ep_container content thmb_cnt">
                                                <div class="cont left-side">
                                                    <i class="fa-solid fa-stopwatch"></i>
                                                    <span>5h 30min</span>
                                                </div>
                                                <div class="cont right-side">
                                                    <i class="fa-solid fa-video"></i>
                                                    <span>8 Episodes</span>
                                                </div>
                                            </div>
                                            <div class="thmb_enrll content">
                                                <label>Enroll Free</label>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            
                            <button class="toggle-btn" id="toggle-free">More Free Trainings</button>
                        </div>
                    </div>
                    
                    <!-- Paid Trainings Section -->
                    <div class="rcmmnd_trngs paid_tr all_tr ln_rcmm">
                        <div class="container">
                            <div class="title">
                                <h1>Premium Trainings</h1>
                            </div>
                            <div class="card-grid thn_grid_cd" id="paid-trainings">
                                <!-- Paid training card 1 -->
                                <a href="#" class="training-card" 
                                    data-training-type="paid"
                                    data-title="Advanced Data Science"
                                    data-description="Master machine learning algorithms, data visualization, and statistical analysis with Python. This course includes hands-on projects with real datasets to build your portfolio."
                                    data-image="https://source.unsplash.com/random/400x300/?data,science"
                                    data-duration="10 weeks"
                                    data-level="Advanced"
                                    data-instructor="Dr. Alan Turing"
                                    data-category="Data Science"
                                    data-price="$199"
                                    data-episodes='[
                                        {"number":1,"name":"Advanced Pandas Techniques","duration":"35 min"},
                                        {"number":2,"name":"Data Visualization with Seaborn","duration":"40 min"},
                                        {"number":3,"name":"Statistical Analysis Fundamentals","duration":"45 min"},
                                        {"number":4,"name":"Machine Learning Introduction","duration":"50 min"},
                                        {"number":5,"name":"Supervised Learning Algorithms","duration":"55 min"},
                                        {"number":6,"name":"Unsupervised Learning Techniques","duration":"45 min"},
                                        {"number":7,"name":"Neural Networks Basics","duration":"60 min"},
                                        {"number":8,"name":"Model Evaluation Methods","duration":"40 min"}
                                    ]'
                                    data-time="15h 20min">
                                        <div class="card rcmmd_cd">
                                            <div class="thmbnail thn_rcmm">
                                                <div class="trnsprnt thmb_img">
                                                    <img src="https://source.unsplash.com/random/400x300/?data,science" alt="Advanced Data Science">
                                                </div>
                                            </div>
                                            <div class="details thmb_dt">
                                                <div class="title content thmb_cnt">
                                                    <h1 class="thmb_h1">Advanced Data Science</h1>
                                                </div>
                                                <div class="ctprs content thmb_cnt">
                                                    <p class="thmb_ct">Master machine learning algorithms, data visualization, and statistical analysis with Python. This course includes hands-on projects with real datasets to build your portfolio....</p>
                                                </div>
                                                <div class="thmb_dur_ep_container content thmb_cnt">
                                                    <div class="cont left-side">
                                                        <i class="fa-solid fa-stopwatch"></i>
                                                        <span>15h 20min</span>
                                                    </div>
                                                    <div class="cont right-side">
                                                        <i class="fa-solid fa-video"></i>
                                                        <span>8 Episodes</span>
                                                    </div>
                                                </div>
                                                <div class="thmb_enrll content">
                                                    <label>$199</label>
                                                </div>
                                            </div>
                                        </div>
                                </a>
                                
                                <!-- Paid training card 2 -->
                                <a href="#" class="training-card" 
                                    data-training-type="paid"
                                    data-title="Complete Web Development Bootcamp"
                                    data-description="Become a full-stack developer with HTML, CSS, JavaScript, React, Node.js and MongoDB. Build 5 real-world projects to showcase in your portfolio."
                                    data-image="https://source.unsplash.com/random/400x300/?web,development"
                                    data-duration="12 weeks"
                                    data-level="Intermediate"
                                    data-instructor="Angela Yu"
                                    data-category="Web Development"
                                    data-price="$249"
                                    data-episodes='[
                                        {"number":1,"name":"HTML5 Fundamentals","duration":"30 min"},
                                        {"number":2,"name":"CSS3 and Responsive Design","duration":"45 min"},
                                        {"number":3,"name":"JavaScript Basics","duration":"50 min"},
                                        {"number":4,"name":"DOM Manipulation","duration":"40 min"},
                                        {"number":5,"name":"React Introduction","duration":"55 min"},
                                        {"number":6,"name":"Node.js and Express","duration":"60 min"},
                                        {"number":7,"name":"MongoDB and Databases","duration":"45 min"},
                                        {"number":8,"name":"Building RESTful APIs","duration":"50 min"}
                                    ]'
                                    data-time="20h 45min">
                                        <div class="card rcmmd_cd">
                                            <div class="thmbnail thn_rcmm">
                                                <div class="trnsprnt thmb_img">
                                                    <img src="https://source.unsplash.com/random/400x300/?web,development" alt="Complete Web Development Bootcamp">
                                                </div>
                                            </div>
                                            <div class="details thmb_dt">
                                                <div class="title content thmb_cnt">
                                                    <h1 class="thmb_h1">Complete Web Development Bootcamp</h1>
                                                </div>
                                                <div class="ctprs content thmb_cnt">
                                                    <p class="thmb_ct">Become a full-stack developer with HTML, CSS, JavaScript, React, Node.js and MongoDB. Build 5 real-world projects to showcase in your portfolio....</p>
                                                </div>
                                                <div class="thmb_dur_ep_container content thmb_cnt">
                                                    <div class="cont left-side">
                                                        <i class="fa-solid fa-stopwatch"></i>
                                                        <span>20h 45min</span>
                                                    </div>
                                                    <div class="cont right-side">
                                                        <i class="fa-solid fa-video"></i>
                                                        <span>8 Episodes</span>
                                                    </div>
                                                </div>
                                                <div class="thmb_enrll content">
                                                    <label>$249</label>
                                                </div>
                                            </div>
                                        </div>
                                </a>
                            </div>
                            
                            <div class="card-grid thn_grid_cd hidden" id="more-paid-trainings">
                                <!-- Additional paid training cards would go here -->
                            </div>
                            
                            <button class="toggle-btn paid-btn" id="toggle-paid">More Trainings</button>
                        </div>
                    </div>
                    
                    <!-- Modal for Training Details -->
                    <div id="training-modal" class="modal">
                        <div class="modal-content">
                            <span class="close-btn">&times;</span>
                            <div class="modal-header">
                                <h2 class="modal-title" id="modal-title">Training Title</h2>
                                <div class="modal-price" id="modal-price">Free</div>
                            </div>
                            <img src="" alt="Training Image" class="modal-image" id="modal-image">
                            <div class="modal-description" id="modal-description">
                                Detailed description of the training will appear here.
                            </div>
                            <div class="modal-meta">
                                <div class="meta-item">
                                    <span class="meta-label"><i class="fas fa-stopwatch"></i> Duration:</span>
                                    <span id="modal-duration">4 weeks</span>
                                </div>
                                <div class="meta-item">
                                    <span class="meta-label"><i class="fas fa-chart-line"></i> Level:</span>
                                    <span id="modal-level">Beginner</span>
                                </div>
                                <div class="meta-item">
                                    <span class="meta-label"><i class="fas fa-user-tie"></i> Instructor:</span>
                                    <span id="modal-instructor">John Doe</span>
                                </div>
                                <div class="meta-item">
                                    <span class="meta-label"><i class="fas fa-tag"></i> Category:</span>
                                    <span id="modal-category">Business</span>
                                </div>
                            </div>
                            
                            <!-- Episode List Section -->
                            <div class="episodes-container">
                                <h3 class="episodes-title"><i class="fas fa-list-ol"></i> Training Episodes</h3>
                                <ul class="episode-list" id="episode-list">
                                    <!-- by JavaScript -->
                                </ul>
                            </div>
                            
                            <a href="#" class="enroll-btn" id="enroll-btn">Enroll Now</a>
                        </div>
                    </div>
                </div>

                <!-- Share Your Issue Section -->
                <div class="content-section shareIssue_content" id="usr_shareIssue">
                    <div class="issue-header">
                        <div class="issue-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#38b6ff">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                        </svg>
                        </div>
                        <div class="issue-title">
                        <h2>Tech Troubles? We've Got Your Back!</h2>
                        <p>Share your tech challenge and we'll create a personalised solution just for you.</p>
                        </div>
                    </div>
                    
                    <div class="issue-steps">
                        <div class="step">
                            <div class="step-number">1</div>
                            <div class="step-content">
                                <h3>Describe Your Issue</h3>
                                <p>Tell us what's happening in as much detail as possible</p>
                            </div>
                        </div>
                        <div class="step">
                            <div class="step-number">2</div>
                            <div class="step-content">
                                <h3>We Analyse & Respond</h3>
                                <p>Our experts review and prepare a customised solution</p>
                        </div>
                        </div>
                        <div class="step">
                            <div class="step-number">3</div>
                            <div class="step-content">
                                <h3>Receive Your Solution</h3>
                                <p>Get a video tutorial, step-by-step guide, or personal session</p>
                            </div>
                        </div>
                    </div>
                    
                    <form id="issueForm" class="issue-form">
                        <div class="form-group">
                            <label for="issueTitle">What's the main problem?</label>
                            <input type="text" id="issueTitle" placeholder="E.g., 'Excel formulas not working'" required>
                            <div class="input-icon">
                                <i class="fas fa-heading"></i>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="issueDescription">Tell us more details</label>
                            <textarea id="issueDescription" rows="5" placeholder="Describe what's happening, any error messages you see, and what you've tried so far..." required></textarea>
                            <div class="input-icon">
                                <i class="fas fa-align-left"></i>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="issueCategory">What category does this fall under?</label>
                            <div class="select-wrapper">
                                <select id="issueCategory" required>
                                <option value="" disabled selected>Select a category</option>
                                <option value="microsoft">Microsoft Products (Word, Excel, etc.)</option>
                                <option value="google">Google Workspace</option>
                                <option value="canva">Canva Design</option>
                                <option value="system">Computer/System Issues</option>
                                <option value="general">General Tech Problem</option>
                                <option value="other">Other</option>
                                </select>
                                <div class="select-icon">
                                <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="urgency">How urgent is this?</label>
                            <div class="urgency-levels">
                                <input type="radio" name="urgency" id="low" value="low" checked>
                                <label for="low" class="urgency-label">
                                <i class="far fa-clock"></i>
                                <span>Low (Whenever you can)</span>
                                </label>
                                
                                <input type="radio" name="urgency" id="medium" value="medium">
                                <label for="medium" class="urgency-label">
                                <i class="fas fa-exclamation"></i>
                                <span>Medium (Need help soon)</span>
                                </label>
                                
                                <input type="radio" name="urgency" id="high" value="high">
                                <label for="high" class="urgency-label">
                                <i class="fas fa-fire"></i>
                                <span>High (Critical issue!)</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-footer">
                        <button type="submit" class="submit-btn">
                            <span>Get Help Now</span>
                            <i class="fas fa-paper-plane"></i>
                        </button>
                        <p class="assurance">
                            <i class="fas fa-shield-alt"></i> Your issue will be kept confidential and addressed by our certified experts
                        </p>
                        </div>
                    </form>
                    
                    <div id="confirmation" class="confirmation-message">
                        <div class="confirmation-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#4CAF50">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        </div>
                        <h3>Help is on the way!</h3>
                        <p>We've received your issue and our team is preparing your personalised solution.</p>
                        <div class="next-steps">
                        <div class="next-step">
                            <i class="fas fa-envelope"></i>
                            <span>Check your email for confirmation</span>
                        </div>
                        <div class="next-step">
                            <i class="fas fa-clock"></i>
                            <span>Typical response time: 24-48 hours</span>
                        </div>
                        </div>
                        <button class="back-btn">Report Another Issue</button>
                    </div>
                </div>               

                <!-- subscriptions containers -->
                <div class="content-section subscriptions_content" id="usr_mysubscriptions">
                    <div class="topbar search-bar">
                        <i class="fa fa-search search-icon"></i>
                        <input type="text" placeholder="Search plans...">
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

                <!-- Tech Coach containers -->
                <div class="content-section techCoach_content" id="usr_techCoach">
                    <div class="coach-header">
                        <div class="coach-avatar">
                            <img src="images/tsTeam/Norris.jpg" alt="Your Tech Coach">
                        </div>
                        <div class="coach-intro">
                            <h2>Meet Your Personal Tech Coach</h2>
                            <p class="coach-tagline">Your dedicated guide to tech mastery and problem-solving</p>
                            <div class="coach-bio">
                                <p><strong>Coach Norris</strong>, Velisa Africa facilitator with 5+ years experience helping professionals succeed with technology.</p>
                            </div>
                        </div>
                    </div>     
                    
                    <div class="coach-features">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <div class="feature-content">
                                <h3>Personalised Learning Path</h3>
                                <p>Customised recommendations based on your skills and goals</p>
                            </div>
                        </div>
                        
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-video"></i>
                            </div>
                            <div class="feature-content">
                                <h3>1-on-1 Video Sessions</h3>
                                <p>Get direct help with your specific challenges</p>
                            </div>
                        </div>
                        
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <div class="feature-content">
                                <h3>Progress Tracking</h3>
                                <p>Monitor your improvement with regular checkpoints</p>
                            </div>
                        </div>
                    </div>

                    <div class="coach-recommendations">
                        <h3 class="recommendations-title">Your Personalised Recommendations</h3>
                        
                        <div class="recommendation-card priority">
                        <div class="recommendation-badge">Priority</div>
                        <div class="recommendation-content">
                            <h4><i class="fas fa-star"></i> Mastering Excel Shortcuts</h4>
                            <p class="recommendation-desc">Boost your productivity with these essential keyboard tips that will save you hours each week.</p>
                            <div class="recommendation-meta">
                            <span class="duration"><i class="far fa-clock"></i> 25 min</span>
                            <span class="difficulty"><i class="fas fa-bolt"></i> Beginner</span>
                            </div>
                            <button class="start-btn">Start Learning</button>
                        </div>
                        </div>
                        
                        <div class="recommendation-card">
                        <div class="recommendation-content">
                            <h4><i class="fas fa-users"></i> Google Docs Collaboration</h4>
                            <p class="recommendation-desc">Live training on June 18 at 10AM - Learn real-time collaboration techniques with your team.</p>
                            <div class="recommendation-meta">
                            <span class="date"><i class="far fa-calendar-alt"></i> June 18, 10AM</span>
                            <span class="type"><i class="fas fa-chalkboard-teacher"></i> Live Session</span>
                            </div>
                            <button class="rsvp-btn">RSVP Now</button>
                        </div>
                        </div>
                        
                        <div class="recommendation-card">
                        <div class="recommendation-content">
                            <h4><i class="fas fa-laptop-medical"></i> Fixing Common Laptop Errors</h4>
                            <p class="recommendation-desc">New video tutorial covering the top 5 laptop issues our students face and how to solve them.</p>
                            <div class="recommendation-meta">
                            <span class="duration"><i class="far fa-clock"></i> 42 min</span>
                            <span class="new-badge">New!</span>
                            </div>
                            <button class="watch-btn">Watch Now</button>
                        </div>
                        </div>
                    </div>

                    <!-- <div class="coach-cta2">
                        <h3>Ready for Personalised Guidance?</h3>
                        <p>Schedule a 1-on-1 session with your Tech Coach to get direct help with your specific challenges.</p>
                        <button class="schedule-btn2">
                        <i class="fas fa-calendar-check"></i> Schedule Session
                        </button>
                        <p class="assurance2">
                        <i class="fas fa-shield-alt"></i> All sessions are confidential and tailored to your needs
                        </p>
                    </div>
                    </div> -->

                </div>

                <!-- Support Section -->
                <div class="content-section support_content" id="usr_support">
                    <div class="support-container">
                        <div class="container">
                            <div class="title">
                                <h2>Support Center</h2>
                                <p>Find answers to common questions or contact our support team</p>
                            </div>
                            <!-- Enhanced FAQ Section -->
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
                                    <p>Still have questions? <a href="#contact">Contact our support team</a> for personalized help.</p>
                                </div>
                            </div>

                            <!-- Contact Support Section -->
                            <div class="contact-section">
                                <h2><i class="fas fa-headset"></i> Contact Support</h2>
                                <div class="contact-options">
                                    <div class="contact-card">
                                        <div class="contact-icon">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                        <h4>Email Us</h4>
                                        <p>Send us an email & we'll respond within 24 hours</p>
                                        <a href="mailto:support@yourdomain.com" class="contact-btn">Email Support</a>
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
                                <!-- Contact Form -->
                                <div class="support-form" id="contact">
                                    <h4>Send us a message</h4>
                                    <form id="supportForm" class="supportForm">
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
                                        
                                        <button type="submit" class="submit-btn">
                                            <i class="fas fa-paper-plane"></i> Send Message
                                        </button>
                                    </form>
                                </div>
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
            window.activeSection = localStorage.getItem('activeSection') || 'usr_dashboard';
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

                    if (activeSection) {
                        activeSection.classList.add('active');

                        const rightbar = document.getElementById('rightbar-container');
                        const profile_tag = document.getElementById('profile_tag');
                        const txt_btn_rm = document.getElementById('txt_btn_rm');
                        if (rightbar) {
                            if (window.activeSection === 'usr_alltrainings') {
                                rightbar.style.display = 'none';
                                profile_tag.style.display = 'block';
                                txt_btn_rm.style.display = 'none';
                            } else {
                                rightbar.style.display = 'block';
                                profile_tag.style.display = 'none';
                                txt_btn_rm.style.display = 'flex';
                            }
                        }
                    }
                }

                navItems.forEach(item => {
                    item.addEventListener('click', function() {
                        event.preventDefault();
                        navItems.forEach(navItem => {
                            navItem.classList.remove('active');
                        });

                        this.classList.add('active');
                        
                        const sectionId = this.getAttribute('data-section');
                        localStorage.setItem('activeSection', sectionId);

                        contentSections.forEach(section => {
                            section.classList.remove('active');
                        });

                        document.getElementById(sectionId).classList.add('active');

                        // rightbar, profile_tag, txt_btn_rm toggle
                        const rightbar = document.getElementById('rightbar-container');
                        const profile_tag = document.getElementById('profile_tag');
                        const txt_btn_rm = document.getElementById('txt_btn_rm');

                        if (rightbar) {
                            if (sectionId === 'usr_alltrainings') {
                                rightbar.style.display = 'none';
                                profile_tag.style.display = 'block';
                                txt_btn_rm.style.display = 'none';
                            } else {
                                rightbar.style.display = 'block';
                                profile_tag.style.display = 'none';
                                txt_btn_rm.style.display = 'flex';
                            }
                        }
                    });
                });
            });
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
    </body>
</html>