<!DOCTYPE html>
<html>
    <head>
        <title>Technospeak - Home</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="TechnoSpeak">
        <meta property="og:type" content="website">
        <link rel="icon" href="IMAGES/icon.png" type="image/x-icon">
        <link rel="stylesheet" href="style/home.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Alegreya:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Schoolbell&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <!-- Font Awesome CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        {{-- Include the navbar --}}
        @include('layouts.navbar', ['whiteBg' => $whiteBg ?? false])

        <section class="landing_container">
            <div class="main_container">
                <div class="slider_container">
                    <div class="still_block">
                        <div class="main_block">
                            <div class="slider">
                                <div class="header">
                                    <h3 id="animated_header">Add a header</h3>
                                </div>
                                <div class="dscpt">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </div>
                                <div class="cta">
                                    <a href="">
                                        <div>Click here</div>
                                    </a>
                                </div>
                            </div>
                            <div class="slider">
                                <div class="header">
                                    <h3>Add a header5</h3>
                                </div>
                                <div class="dscpt">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </div>
                                <div class="cta">
                                    <a href="">
                                        <div>Register now</div>
                                    </a>
                                </div>
                            </div>
                            <div class="slider">
                                <div class="header">
                                    <h3>Add a header2</h3>
                                </div>
                                <div class="dscpt">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </div>
                                <div class="cta">
                                    <a href="">
                                        <div>Discover more</div>
                                    </a>
                                </div>
                            </div>
                            <div class="slider">
                                <div class="header">
                                    <h3>Add a header3</h3>
                                </div>
                                <div class="dscpt">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </div>
                                <div class="cta">
                                    <a href="">
                                        <div>Check it out</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Dot navigation -->
                        <div class="dot_container">
                            <div class="dot"></div>
                            <div class="dot"></div>
                            <div class="dot"></div>
                            <div class="dot"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="categories_cont">
            <div class="main_container">
                <div class="title_container">
                    <h2>Service Categories</h2>
                </div>
                <div class="main_cont">
                    <div class="rt_arrw control_arrows">
                        <button class="arrow-btn arrow-btn-prev" tabindex="0">←</button>
                    </div>
                    <div class="container">
                        <div class="cards-wrapper">
                            <div class="cards">
                                <!-- Card 1: Creative Tools & AI -->
                                <button class="card card1">
                                    <div class="cr-img">
                                        <img src="../images/image5-min-1.png"/>
                                    </div>
                                    <div class="st_title_container">
                                        <h3>Creative Tools & AI</h3>
                                    </div>
                                    <div class="st_dscrpt">
                                        <p>Learn how to create stunning designs, videos, and content using tools like Canva, Photoshop, and beginner AI apps. Ideal for content creators, students, and small businesses.</p>
                                    </div>
                                </button>

                                <!-- Card 2: ICT Office Administration -->
                                <button class="card card2">
                                    <div class="cr-img">
                                        <img src="../images/image5-min-1.png"/>
                                    </div>
                                    <div class="st_title_container">
                                        <h3>ICT Office Administration</h3>
                                    </div>
                                    <div class="st_dscrpt">
                                        <p>Master everyday office tools like Microsoft Office and Google Workspace. Perfect for job readiness, admin tasks, and school assignments.</p>
                                    </div>
                                </button>

                                <!-- Card 3: Technical Support Services -->
                                <button class="card card3">
                                    <div class="cr-img">
                                        <img src="../images/image5-min-1.png"/>
                                    </div>
                                    <div class="st_title_container">
                                        <h3>Technical Support Services</h3>
                                    </div>
                                    <div class="st_dscrpt">
                                        <p>Get help with software installation, system cleanup, device setup, and other common tech problems. Support tailored for home users, students, and small offices.</p>
                                    </div>
                                </button>

                                <!-- Card 4: Programming & EUC -->
                                <button class="card card4">
                                    <div class="cr-img">
                                        <img src="../images/image5-min-1.png"/>
                                    </div>
                                    <div class="st_title_container">
                                        <h3>Programming & End-User Computing (EUC)</h3>
                                    </div>
                                    <div class="st_dscrpt">
                                        <p>Learn to code using Python, HTML, JavaScript, and more. Includes web/app development and computing essentials for students, freelancers, and aspiring developers.</p>
                                    </div>
                                </button>

                                <!-- Card 5: Networking & Internet Basics -->
                                <button class="card card5">
                                    <div class="cr-img">
                                        <img src="../images/image5-min-1.png"/>
                                    </div>
                                    <div class="st_title_container">
                                        <h3>Networking & Internet Basics</h3>
                                    </div>
                                    <div class="st_dscrpt">
                                        <p>Understand how to set up home or office Wi-Fi, configure routers, manage IP settings, and secure your internet connection with basic network skills.</p>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="lt_arrw control_arrows">
                        <button class="arrow-btn arrow-btn-next" tabindex="0">→</button>
                    </div>
                </div>
            </div>
        </section>
        <section class="about_summ">
            <div class="main_container">
                <div class="image_block block">
                    <img src="/images/teams/two_team.jpeg" alt="office_technospeak"/>
                </div>
                <div class="about_brief block">
                    <div class="title_container">
                        <h2>About Us</h2>
                    </div>
                    <div class="dscpt">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                    <div class="bttn">
                        <a href="/about">Read More</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="rcnt_vd">
            <div class="main_container">
                <div class="title_container">
                    <h2>Recent Trainings</h2>
                </div>
                <div class="container">
                    <div class="block">
                        <div class="fr_img">
                            <div class="img_container">
                                <img src="/images/image5-min-1.png"/>
                                <div class="trns">
                                    <div class="logo">
                                        <img src="../images/gpt_logo.png"/>
                                    </div>
                                    <div class="ctchprs">
                                        <h3>Get To Learn How To Apply For Jobs Using ChatGPT!</h3>
                                    </div>
                                    <div class="bttn">
                                        <a href="">Watch Here</a>
                                    </div>
                                </div> 
                            </div>
                            <div class="caption">
                                <div class="ctgry_dur">
                                    <div class="ctgry">
                                        <p>Category: <i>Tips & Tricks</i></p>
                                    </div>
                                    <div class="dur">
                                        <p>Duration: <i>30s</i></p>
                                    </div>
                                </div>
                                <div class="trainer">
                                    <p>Instructor: <i>Lehlogonolo</i></p>
                                </div>    
                            </div>                  
                        </div>
                    </div>
                    <div class="block">
                        <div class="fr_img">
                            <div class="img_container">
                                <img src="/images/image5-min-1.png"/>
                                <div class="trns">
                                    <div class="logo">
                                        <img src="../images/gpt_logo.png"/>
                                    </div>
                                    <div class="ctchprs">
                                        <h3>Get To Learn How To Apply For Jobs Using ChatGPT!</h3>
                                    </div>
                                    <div class="bttn">
                                        <a href="">Watch Here</a>
                                    </div>
                                </div> 
                            </div>
                            <div class="caption">
                                <div class="ctgry_dur">
                                    <div class="ctgry">
                                        <p>Category: <i>Tips & Tricks</i></p>
                                    </div>
                                    <div class="dur">
                                        <p>Duration: <i>30s</i></p>
                                    </div>
                                </div>
                                <div class="trainer">
                                    <p>Instructor: <i>Lehlogonolo</i></p>
                                </div>    
                            </div>                  
                        </div>
                    </div>
                    <div class="block">
                        <div class="fr_img">
                            <div class="img_container">
                                <img src="/images/image5-min-1.png"/>
                                <div class="trns">
                                    <div class="logo">
                                        <img src="../images/gpt_logo.png"/>
                                    </div>
                                    <div class="ctchprs">
                                        <h3>Get To Learn How To Apply For Jobs Using ChatGPT!</h3>
                                    </div>
                                    <div class="bttn">
                                        <a href="">Watch Here</a>
                                    </div>
                                </div> 
                            </div>
                            <div class="caption">
                                <div class="ctgry_dur">
                                    <div class="ctgry">
                                        <p>Category: <i>Tips & Tricks</i></p>
                                    </div>
                                    <div class="dur">
                                        <p>Duration: <i>30s</i></p>
                                    </div>
                                </div>
                                <div class="trainer">
                                    <p>Instructor: <i>Lehlogonolo</i></p>
                                </div>    
                            </div>                  
                        </div>
                    </div>
                    <div class="block">
                        <div class="fr_img">
                            <div class="img_container">
                                <img src="/images/image5-min-1.png"/>
                                <div class="trns">
                                    <div class="logo">
                                        <img src="../images/gpt_logo.png"/>
                                    </div>
                                    <div class="ctchprs">
                                        <h3>Get To Learn How To Apply For Jobs Using ChatGPT!</h3>
                                    </div>
                                    <div class="bttn">
                                        <a href="">Watch Here</a>
                                    </div>
                                </div> 
                            </div>
                            <div class="caption">
                                <div class="ctgry_dur">
                                    <div class="ctgry">
                                        <p>Category: <i>Tips & Tricks</i></p>
                                    </div>
                                    <div class="dur">
                                        <p>Duration: <i>30s</i></p>
                                    </div>
                                </div>
                                <div class="trainer">
                                    <p>Instructor: <i>Lehlogonolo</i></p>
                                </div>    
                            </div>                  
                        </div>
                    </div>
                    <div class="block">
                        <div class="fr_img">
                            <div class="img_container">
                                <img src="/images/image5-min-1.png"/>
                                <div class="trns">
                                    <div class="logo">
                                        <img src="../images/gpt_logo.png"/>
                                    </div>
                                    <div class="ctchprs">
                                        <h3>Get To Learn How To Apply For Jobs Using ChatGPT!</h3>
                                    </div>
                                    <div class="bttn">
                                        <a href="">Watch Here</a>
                                    </div>
                                </div> 
                            </div>
                            <div class="caption">
                                <div class="ctgry_dur">
                                    <div class="ctgry">
                                        <p>Category: <i>Tips & Tricks</i></p>
                                    </div>
                                    <div class="dur">
                                        <p>Duration: <i>30s</i></p>
                                    </div>
                                </div>
                                <div class="trainer">
                                    <p>Instructor: <i>Lehlogonolo</i></p>
                                </div>    
                            </div>                  
                        </div>
                    </div>
                    <div class="block">
                        <div class="fr_img">
                            <div class="img_container">
                                <img src="/images/image5-min-1.png"/>
                                <div class="trns">
                                    <div class="logo">
                                        <img src="../images/gpt_logo.png"/>
                                    </div>
                                    <div class="ctchprs">
                                        <h3>Get To Learn How To Apply For Jobs Using ChatGPT!</h3>
                                    </div>
                                    <div class="bttn">
                                        <a href="">Watch Here</a>
                                    </div>
                                </div> 
                            </div>
                            <div class="caption">
                                <div class="ctgry_dur">
                                    <div class="ctgry">
                                        <p>Category: <i>Workshops</i></p>
                                    </div>
                                    <div class="dur">
                                        <p>Duration: <i>30s</i></p>
                                    </div>
                                </div>
                                <div class="trainer">
                                    <p>Instructor: <i>Phuti</i></p>
                                </div>    
                            </div>                  
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="wkly_sessions">
            <div class="main_container">
                <div class="title_container">
                    <h3>Real Questions. Real Answers.</h3>
                    <h2>Join Our Weekly Q/A Sessions</h2>
                </div>
                <div class="button">
                    <a href="">Register Q/A</a>
                </div>
            </div>
        </section>
        <section class="gtch">
            <div class="main_container">
                <div class="title_container">
                    <h2>Get In Touch</h2>
                </div>
                <div class="form_container">
                    <div class="form"> 
                        <form action="">
                            <div class="block">
                                <div class="prgrph">
                                    <p>Full Names:</p>
                                </div>
                                <div class="field">
                                    <input type="text" name="uname" placeholder="Enter name here.."/>
                                </div>
                            </div>
                            <div class="block">
                                <div class="prgrph">
                                    <p>Email Address:</p>
                                </div>
                                <div class="field">
                                    <input type="text" name="email" placeholder="Enter email here.."/>
                                </div>
                            </div>
                            <div class="block">
                                <div class="prgrph">
                                    <p>Message:</p>
                                </div>
                                <div class="field">
                                    <textarea name="message" placeholder="Enter your message.."></textarea>
                                </div>
                            </div>
                            <div class="block">
                                <div class="field">
                                    <a href="">Submit</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="scl_md_container">
                        <div class="md">
                            <a href="" target="_blank">
                                <i class="fa-brands fa-facebook"></i>
                            </a>
                        </div>
                        <div class="md">
                            <a href="" target="_blank">
                                <i class="fa-brands fa-tiktok"></i>
                            </a>
                        </div>
                        <div class="md">
                            <a href="" target="_blank">
                                <i class="fa-brands fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
    <script src="script/home_slider.js"></script>
</html>