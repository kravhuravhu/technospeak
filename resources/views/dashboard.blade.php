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
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <!-- Font Awesome CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        <section class="sidebar">
            <div class="main_container">
                <div class="logo_container">
                    <a href="#">
                        <img src="/images/default-no-logo.png" alt="technospeak_icon">
                    </a>
                </div>
                <div class="nav-bar">
                    <div class="container">
                        <div class="nav-item active">Dashboard</div>
                        <div class="nav-item">All Trainings</div>
                        <div class="nav-item">Q/A Session Recap</div>
                        <div class="nav-item">My Subscriptions</div>
                        <div class="nav-item">Resources</div>
                        <div class="nav-item">Task Assistance</div>
                        <div class="nav-item">Help Center</div>
                        <div class="nav-item">Settings</div>
                    </div>
                </div>
            </div>
        </section>
    <div class="sidebar">
        <div>
            
            </div>
            <div class="promo">
            <p>Something about cheatsheet? well ipsum dolor sit amet consectetur</p>
            <button>Upgrade Now</button>
        </div>
    </div>

    <div class="main">
        <div class="topbar">
        <input type="text" placeholder="Search...">
        <div class="user">
            <span>Rose Ravhuravhu</span>
            <div class="avatar" style="width: 30px; height: 30px; background: #ccc; border-radius: 50%;"></div>
        </div>
        </div>

        <div class="welcome">
        <div>
            <h2>Welcome back, Rose</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
        </div>
        <div style="font-size: 48px;">👋</div>
        </div>

        <div class="section">
        <h3>My Learnings</h3>
        <div class="card-grid">
            <div class="card">
            <div class="image"></div>
            <h4>Training Title</h4>
            <p>Duration: 30min</p>
            <p>Video description We use AI to help</p>
            <div class="progress-bar"><div class="progress-bar-inner"></div></div>
            </div>
            <div class="card">
            <div class="image"></div>
            <h4>Training Title</h4>
            <p>Duration: 30min</p>
            <p>Video description We use AI to help</p>
            <div class="progress-bar"><div class="progress-bar-inner"></div></div>
            </div>
            <div class="card">
            <div class="image"></div>
            <h4>Training Title</h4>
            <p>Duration: 30min</p>
            <p>Video description We use AI to help</p>
            <div class="progress-bar"><div class="progress-bar-inner"></div></div>
            </div>
        </div>
        </div>

        <div class="section">
        <h3>Recommended Trainings</h3>
        <div class="card-grid">
            <div class="card recommend">
            <div class="image"></div>
            <h4>Courses Title</h4>
            <p>Study Smarter with Google & Microsoft Tools</p>
            <div class="price-enroll">
                <span>R149.85</span>
                <button>Enroll</button>
            </div>
            </div>
            <div class="card recommend">
            <div class="image"></div>
            <h4>Courses Title</h4>
            <p>Study Smarter with Google & Microsoft Tools</p>
            <div class="price-enroll">
                <span>R149.85</span>
                <button>Enroll</button>
            </div>
            </div>
            <div class="card recommend">
            <div class="image"></div>
            <h4>Courses Title</h4>
            <p>Study Smarter with Google & Microsoft Tools</p>
            <div class="price-enroll">
                <span>R149.85</span>
                <button>Enroll</button>
            </div>
            </div>
        </div>
        </div>
    </div>

    <div class="rightbar">
        <div class="box">
        <h4>Your Overall Progress <span style="color:#3b82f6;">25%</span></h4>
        <div class="progress"><div class="progress-inner"></div></div>
        <p style="font-size: 12px;">You're making great progress in the course! Keep up the fantastic work 🎉</p>
        </div>

        <div class="box">
        <h4>Upcoming Sessions</h4>
        <div class="session">
            <strong>Q/A Session - Constant BlueScreen Errors</strong>
            <p>21 Aug 2025, Friday</p>
        </div>
        <div class="session">
            <strong>Introduction to Microsoft Office</strong>
            <p>01 Oct 2025, Saturday</p>
        </div>
        <button>View All Courses</button>
        </div>
    </div>

    <script>
        const navItems = document.querySelectorAll('.nav-item');
        navItems.forEach(item => {
        item.addEventListener('click', () => {
            navItems.forEach(el => el.classList.remove('active'));
            item.classList.add('active');
        });
        });
    </script>
    </body>
</html>
