<!DOCTYPE html>
<html>
    <head>
        <title>Technospeak - Home</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="TechnoSpeak">
        <meta property="og:type" content="website">
        <link rel="icon" href="@secureAsset('images/icon.png')" type="image/x-icon">
        <link rel="stylesheet" href="@secureAsset('style/home.css')">
        <link rel="stylesheet" href="@secureAsset('style/about.css')">
        <link rel="stylesheet" href="@secureAsset('style/footer.css')">
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
        @include('layouts.navbar', ['whiteBg' => $whiteBg ?? true])

        <!-- Landing page container -->
        <section class="landing_container">
            <div class="main_container">
                <div class="slider_container">
                    <div class="still_block">
                        <div class="main_block">
                            <div class="slider">
                                <div class="header">
                                    <h3 id="animated_header">Transform Your Digital Future</h3>
                                </div>
                                <div class="dscpt">
                                    <p><strong>Technospeak</strong> empowers you to master technology with confidence. We offer easy-to-follow tutorials, 
                                        practical guides, and real-world support for students, professionals, and small businesses. 
                                        Whether you want to boost productivity, learn new digital skills, or solve everyday tech challenges, 
                                        our team is here to help you succeed—no jargon, just results.</p>
                                </div>
                                <div class="cta">
                                    @if(Auth::check())
                                        <a href="{{ url('/dashboard#usr_alltricks') }}" class="cta">
                                            <div>Explore Solutions</div>
                                        </a>
                                    @else
                                        <a href="{{ url('/login') }}" class="cta">
                                            <div>Explore Solutions</div>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="slider">
                                <div class="header">
                                    <h3>AI-Powered Business Revolution</h3>
                                </div>
                                <div class="dscpt">
                                    <p>Discover how AI can simplify your everyday tasks and boost productivity—no technical background needed. 
                                        At <strong>Technospeak</strong>, we guide you through practical uses of AI tools for writing, research, and creative 
                                        projects. Learn to use chatbots, automate simple processes, and make smarter decisions with 
                                        easy-to-follow tutorials designed for students, professionals, and small businesses.</p>
                                </div>
                                <div class="cta">
                                    @if(Auth::check())
                                        <a href="{{ url('/dashboard#usr_alltricks') }}" class="cta">
                                            <div>Explore Courses</div>
                                        </a>
                                    @else
                                        <a href="{{ url('/login') }}" class="cta">
                                            <div>Explore Courses</div>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="slider">
                                <div class="header">
                                    <h3>Cloud Infrastructure Reimagined</h3>
                                </div>
                                <div class="dscpt">
                                    <p>Unlock the power of cloud tools for learning, collaboration, and productivity. At <strong>Technospeak</strong>, 
                                        we guide you through using Google Workspace, Microsoft 365, and other essential platforms—no jargon, 
                                        just practical skills. Whether you’re a student, educator, or small business, we help you work smarter, 
                                        store safely, and access your files anywhere.</p>
                                </div>
                                <div class="cta">
                                    @if(Auth::check())
                                        <a href="{{ url('/dashboard#usr_alltricks') }}" class="cta">
                                            <div>View Learning Tools</div>
                                        </a>
                                    @else
                                        <a href="{{ url('/login') }}" class="cta">
                                            <div>View Learning Tools</div>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="slider">
                                <div class="header">
                                    <h3>24/7 Cybersecurity Shield</h3>
                                </div>
                                <div class="dscpt">
                                    <p>Stay safe online with our easy-to-follow cybersecurity guidance and practical tools. We help you 
                                        recognize scams, protect your accounts, and secure your devices—no technical jargon required. Learn 
                                        how to keep your personal and business information safe, and gain confidence navigating the digital 
                                        world.</p>
                                </div>
                                <div class="cta">
                                    @if(Auth::check())
                                        <a href="{{ url('/dashboard#usr_techCoach') }}" class="cta">
                                            <div>Get Cyber Shield</div>
                                        </a>
                                    @else
                                        <a href="{{ url('/login') }}" class="cta">
                                            <div>Get Cyber Shield</div>
                                        </a>
                                    @endif
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

        <!-- Product Plans section -->
        <section class="categories_cont">
            <div class="main_container">
                <div class="title_container">
                    <h2>Our Product Plans</h2>
                </div>
                <div class="main_cont">
                    <div class="rt_arrw control_arrows">
                        <button class="arrow-btn arrow-btn-prev" tabindex="0">←</button>
                    </div>
                    <div class="container">
                        <div class="cards-wrapper">
                            <div class="cards">
                                <!-- Card 1: Free Subscription -->
                                <div class="card card1">
                                    <div class="cr-img">
                                    <img src="@secureAsset('/images/Free subscription.png')" alt="Free Subscription"/>
                                    </div>
                                    <div class="st_title_container">
                                        <h3>Free Subscription</h3>
                                    </div>
                                    <div class="st_dscrpt">
                                        <p>Access our free clickbait videos on social media. Ask questions in comments and get brief answers with links to full details on our website.</p>
                                        <ul>
                                            <li>Free access to social media content</li>
                                            <li>Brief answers to your questions</li>
                                            <li>Links to detailed explanations</li>
                                        </ul>
                                    </div>
                                    <div class="plan-button">
                                        <a href="{{ Auth::check() ? url('/dashboard#usr_alltricks') : url('/login') }}">Get Started</a>
                                    </div>
                                </div>

                                <!-- Card 3: Formal Training -->
                                <div class="card card3">
                                    <div class="cr-img">
                                    <img src="@secureAsset('/images/Formal training.png')" alt="Formal Training"/>
                                    </div>
                                    <div class="st_title_container">
                                        <h3>Formal Training</h3>
                                        <div class="price-tag">
                                            <span>From R1500/training</span>
                                        </div>
                                    </div>
                                    <div class="st_dscrpt">
                                        <p>Comprehensive 40-hour training programs in End-User Computing and web development for all skill levels.</p>
                                        <ul>
                                            <li>Structured 8-hour daily sessions</li>
                                            <li>Tailored to students & professionals</li>
                                            <li>Portfolio development support</li>
                                            <li>Partnership opportunities</li>
                                        </ul>
                                    </div>
                                    <div class="plan-button">
                                        <a href="#" onclick="openComingSoonModal(); return false;">Enroll Now</a>
                                    </div>
                                </div>

                                <!-- Card 4: Personal Guide -->
                                <div class="card card4">
                                    <div class="cr-img">
                                    <img src="@secureAsset('/images/Personal guide.png')" alt="Personal Guide"/>
                                    </div>
                                    <div class="st_title_container">
                                        <h3>Personal Guide</h3>
                                        <div class="price-tag">
                                            <span>From R110/hour</span>
                                        </div>
                                    </div>
                                    <div class="st_dscrpt">
                                        <p>One-on-one sessions with expert tutors for personalized attention and focused learning.</p>
                                        <ul>
                                            <li>Submit requests in advance</li>
                                            <li>Video call or chat sessions</li>
                                            <li>Flexible scheduling</li>
                                            <li>Additional hours available</li>
                                        </ul>
                                    </div>
                                    <div class="plan-button">
                                        <a href="{{ Auth::check() ? url('/dashboard#usr_guide') : url('/login') }}">Get Guide</a>
                                    </div>
                                </div>

                                <!-- Card 2: Premium Subscription -->
                                <div class="card card2 active">
                                    <div class="cr-img">
                                    <img src="@secureAsset('/images/premium subscription.png')" alt="Premium Subscription"/>
                                    </div>
                                    <div class="st_title_container">
                                        <h3>Premium Subscription</h3>
                                        <div class="price-tag">
                                            <span>From R350/quarter</span>
                                        </div>
                                    </div>
                                    <div class="st_dscrpt">
                                        <p>Full access to all our premium content with exclusive resources for serious learners and professionals.</p>
                                        <ul>
                                            <li>All clickbait-style videos</li>
                                            <li>Downloadable resources & cheat sheets</li>
                                            <li>Monthly curated tech newsletters</li>
                                            <li>Student and business pricing options</li>
                                        </ul>
                                    </div>
                                    <div class="plan-button">
                                        @if(Auth::check())
                                            <a href="{{ route('subscription.yoco.redirect') }}">Subscribe Now</a>
                                        @else
                                            <a href="{{ url('/login?redirect=subscription/yoco/redirect') }}">Subscribe Now</a>
                                        @endif
                                    </div>
                                </div>

                                <!-- Card 5: Task Assistance -->
                                <div class="card card5">
                                    <div class="cr-img">
                                    <img src="@secureAsset('/images/Task assistance.png')" alt="Task Assistance"/>
                                    </div>
                                    <div class="st_title_container">
                                        <h3>Task Assistance</h3>
                                        <div class="price-tag">
                                            <span>From R100/hour</span>
                                        </div>
                                    </div>
                                    <div class="st_dscrpt">
                                        <p>Hands-on help with your technical tasks from coding to system configurations.</p>
                                        <ul>
                                            <li>Coding & web development help</li>
                                            <li>System configuration support</li>
                                            <li>Direct task completion</li>
                                            <li>Student and business rates</li>
                                        </ul>
                                    </div>
                                    <div class="plan-button">
                                        <a href="{{ Auth::check() ? url('/dashboard#usr_taskAssistance') : url('/login') }}">Get Assistance</a>
                                    </div>
                                </div>

                                <!-- Card 6: Group Session 1 -->
                                <div class="card card6">
                                    <div class="cr-img">
                                    <img src="@secureAsset('/images/live Q&A session.png')" alt="Group Session 1"/>
                                    </div>
                                    <div class="st_title_container">
                                        <h3>Live Q&A Sessions</h3>
                                        <div class="price-tag">
                                            <span>From R130/hour</span>
                                        </div>
                                    </div>
                                    <div class="st_dscrpt">
                                        <p>Interactive group sessions where you can ask questions and get immediate expert answers.</p>
                                        <ul>
                                            <li>Live Q&A with experts</li>
                                            <li>Submit questions via chat</li>
                                            <li>Various tech topics covered</li>
                                            <li>Different pricing for students/business</li>
                                        </ul>
                                    </div>
                                     <div class="plan-button">
                                        @if(Auth::check())
                                            <a href="#" class="registration-trigger" data-type-id="4">Book Now</a>
                                        @else
                                            <a href="{{ route('login', ['redirect' => url()->current()]) }}">Book Now</a>
                                        @endif
                                    </div>
                                </div>

                                <!-- Card 7: Group Session 2 -->
                                <div class="card card7">
                                    <div class="cr-img">
                                    <img src="@secureAsset('/images/live consultation.png')" alt="Group Session 2"/>
                                    </div>
                                    <div class="st_title_container">
                                        <h3>Response Consultations</h3>
                                        <div class="price-tag">
                                            <span>From R130/hour</span>
                                        </div>
                                    </div>
                                    <div class="st_dscrpt">
                                        <p>Focused sessions addressing comments and questions from our video content.</p>
                                        <ul>
                                            <li>Answers to video comments</li>
                                            <li>Programming & cybersecurity focus</li>
                                            <li>Interactive skill-building</li>
                                            <li>Live response to questions</li>
                                        </ul>
                                    </div>
                                    <div class="plan-button">
                                        @if(Auth::check())
                                            <a href="#" class="registration-trigger" data-type-id="4">Book Now</a>
                                        @else
                                            <a href="{{ route('login', ['redirect' => url()->current()]) }}">Book Now</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lt_arrw control_arrows">
                        <button class="arrow-btn arrow-btn-next" tabindex="0">→</button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Service Categories Section -->
        <section class="services-categories">
            <div class="services-container">
                <div class="services-header">
                <h2 class="services-title">Service Categories</h2>
                <p class="services-subtitle">
                    Explore our wide range of done-for-you services designed to make your life easier. 
                    From professional design and content creation to technical support, web development, 
                    and digital marketing, we deliver ready-to-use solutions—no learning, no hassle, just results.
                </p>
                </div>

            <div class="services-content">
            <!-- Left Categories - Visual Cards -->
            <div class="services-visual">
                <div class="service-cards">
                <div class="service-card" data-service="design">
                    <div class="card-icon">🎨</div>
                    <h3>Graphic Design Tools</h3>
                    <p>Professional visuals for your brand</p>
                    <div class="card-hover-content">
                    </div>
                </div>

                <div class="service-card" data-service="ai">
                    <div class="card-icon">🤖</div>
                    <h3>AI Content Creation</h3>
                    <p>Smart content generation</p>
                    <div class="card-hover-content">
                    
                    </div>
                </div>

                <div class="service-card" data-service="office">
                    <div class="card-icon">📊</div>
                    <h3>Office Admin (ICT)</h3>
                    <p>Streamline office tasks</p>
                    <div class="card-hover-content">
                    
                    </div>
                </div>

                <div class="service-card" data-service="support">
                    <div class="card-icon">🔧</div>
                    <h3>Technical Support</h3>
                    <p>Reliable IT assistance</p>
                    <div class="card-hover-content">
                    
                    </div>
                </div>

                <div class="service-card" data-service="web">
                    <div class="card-icon">💻</div>
                    <h3>Web & App Programming</h3>
                    <p>Custom digital solutions</p>
                    <div class="card-hover-content">
                    
                    </div>
                </div>

                <div class="service-card" data-service="network">
                    <div class="card-icon">🌐</div>
                    <h3>Networking Essentials</h3>
                    <p>Secure connectivity solutions</p>
                    <div class="card-hover-content">
                    
                    </div>
                </div>

                <div class="service-card" data-service="marketing">
                    <div class="card-icon">📢</div>
                    <h3>Digital Marketing</h3>
                    <p>Grow your online presence</p>
                    <div class="card-hover-content">
                    
                    </div>
                </div>
                </div>
            </div>

                <!-- Right Content - Details Panel -->
                <div class="services-details" id="service-details">
                    <div class="details-content">
                    <div class="details-header">
                        <div class="details-icon">🎨</div>
                        <h3>Bring Your Ideas to Life with Stunning Designs</h3>
                    </div>
                    <div class="details-text">
                        <p>We provide a full spectrum of design services tailored to your business or personal needs. From eye-catching logos, professional business cards, and polished brochures to posters, flyers, and social media graphics, we deliver ready-to-use, high-quality visuals.</p>
                        <p>Every design is crafted with your brand and audience in mind—no learning, no trial-and-error. You receive professional results, ready for print or online publication, helping your brand make a lasting impression instantly.</p>
                        <p class="highlight">✨ Ready to stand out? Let us create your next masterpiece today!</p>
                    </div>
                    <button class="details-btn">
                        <span>Need Assistance?</span>
                        <div class="btn-arrow">→</div>
                    </button>
                    </div>
                </div>
                </div>
            </div>
        </section>
`
        <!-- About Us section -->
        <section class="about_summ">
            <div class="main_container">
                <div class="image_block block">
                    <img src="@secureAsset('images/teams/two_team.jpeg')" alt="office_technospeak"/>
                </div>
                <div class="about_brief block">
                    <div class="title_container">
                        <h2>About Us</h2>
                    </div>
                    <div class="dscpt">
                        <p>At <strong>Technospeak</strong>, we turn tech confusion into confidence. We empowered 
                        individuals and businesses with practical, jargon-free technology training and support. Our 
                        approach blends hands-on learning with real-world applications—whether you're mastering creative 
                        tools, troubleshooting devices, or building cloud solutions. Think of us as your personal tech 
                        translators, here to make technology work <em>for</em> you, not against you.</p>
                    </div>
                    <div class="bttn">
                        <a href="/about">Read More</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Recent trainings section -->
        <section class="rcnt_vd">
            <div class="main_container">
                <div class="title_container">
                    <h2>Recent Trainings</h2>
                </div>
                <div class="container">
                    @if($courses->where('plan_type', 'free')->count() > 0)
                        @foreach($courses as $course)
                            @if($course->plan_type == 'free')
                                <div class="block">
                                    <div class="fr_img">
                                        <div class="img_container">
                                            <img src="{{ $course->thumbnail ?? '/images/image5-min-1.png' }}" alt="{{ $course->title ?? 'Course' }}"/>
                                            <div class="trns">
                                                <div class="logo">
                                                    <img src="{{ $course->software_app_icon ?? '../images/gpt_logo.png' }}"/>
                                                </div>
                                                <div class="ctchprs">
                                                    <h3>{{ !empty(trim($course->catch_phrase)) ? $course->catch_phrase : 'Get To Learn How To Apply For Jobs Using ChatGPT!' }}</h3>
                                                </div>
                                                <div class="bttn">
                                                    @if(Auth::check())
                                                        @php
                                                            $url = $course['is_enrolled'] 
                                                                ? url("/enrolled-courses/{$course['uuid']}") 
                                                                : url("/unenrolled-courses/{$course['uuid']}");
                                                        @endphp
                                                        <a href="{{ $url }}">Watch Here</a>
                                                    @else
                                                        @php
                                                            $url = $course['is_enrolled'] 
                                                                ? url("/enrolled-courses/{$course['uuid']}") 
                                                                : url("/unenrolled-courses/{$course['uuid']}");
                                                        @endphp
                                                        <a href="{{ url('/login?redirect=' . urlencode($url)) }}">Watch Here</a>
                                                    @endif
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="caption">
                                            <div class="ctgry_dur">
                                                <div class="ctgry">
                                                    <p>Technite: <i>{{ $course->instructor?->name ?? 'Our Team' }}</i></p>
                                                </div>
                                                <div class="dur">
                                                    @php
                                                        $duration = $course->total_duration;

                                                        if ($duration < 60) {
                                                            $formatted = $duration . 's';
                                                        } elseif ($duration < 3600) {
                                                            $minutes = floor($duration / 60);
                                                            $seconds = $duration % 60;
                                                            $formatted = $minutes . 'm ' . $seconds . 's';
                                                        } else {
                                                            $hours = floor($duration / 3600);
                                                            $minutes = floor(($duration % 3600) / 60);
                                                            $seconds = $duration % 60;
                                                            $formatted = $hours . 'h ' . $minutes . 'm ' . $seconds . 's';
                                                        }
                                                    @endphp
                                                    <p>Duration: <i>{{ $formatted }}</i></p>
                                                </div>
                                            </div>
                                            <div class="trainer">
                                                <p>Category: <i>{{ $course->category?->name ?? 'General' }}</i></p>
                                            </div>    
                                        </div>                  
                                    </div>  
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="block">
                            <div class="fr_img">
                                <div class="img_container">
                                    <img src="{{ '/images/image5-min-1.png' }}"/>
                                    <div class="trns" style="justify-content:center;align-items:center;">
                                        <div class="ctchprs" style="margin:3px auto;">
                                            <h3 style="display:block;">{{ 'No Trainings Available at the Moment!' }}</h3>
                                        </div>
                                        <div class="bttn" style="margin:3px auto;">
                                            <a href="https://www.youtube.com/@TechnoSpeak-j3f" target="_blank">Visit Our YouTube Channel</a>
                                        </div>
                                    </div> 
                                </div>
                                <div class="caption">
                                    <div class="trainer">
                                        <p style="text-align:center;">Our team is working hard to bring you new courses. Stay tuned!</p>
                                    </div>    
                                </div>              
                            </div>  
                        </div>
                    @endif
                </div>
                <div class="view-more-container">
                    @if(Auth::check())
                        <a href="{{ url('/dashboard#usr_alltricks') }}" class="view-more-btn">View More Courses</a>
                    @else
                        @php
                            $url = url("/dashboard#usr_alltricks");
                        @endphp
                        <a href="{{ url('/login?redirect=' . urlencode($url)) }}" class="view-more-btn">View More Courses</a>

                    @endif
                </div>
            </div>
        </section>

        <!-- Weekly Q/A sessions section -->
        <section class="wkly_sessions">
            <div class="main_container">
                <div class="title_container">
                    <h3>Real Questions. Real Answers.</h3>
                    <h2>Join Our Weekly Q/A Sessions</h2>
                    <p>Our weekly Q/A sessions put your conversations in the spotlight—shaped by questions and feedback from our community across social channels—so every discussion stays relevant, focused, and practical.</p>
                </div>
                <div class="button">
                    @if(Auth::check())
                        <a href="#" class="registration-trigger" data-type-id="4">Register Q/A</a>
                    @else
                        <a href="{{ route('login', ['redirect' => url()->current()]) }}">Register Q/A</a>
                    @endif
                </div>
            </div>
        </section>

        @include('components.sessions_registration', [
            'typeId' => 4,
            'typeName' => 'Q/A Session'
        ])

        <!-- Get in touch section -->
        <section class="gtch" id="contact-section">
            <div class="main_container">
                <div class="title_container">
                    <h2>Get In Touch</h2>
                </div>
                <div class="form_container">
                    <div class="form"> 
                        <form action=" " method="POST">
                            @csrf
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
                            <a href="https://www.facebook.com/profile.php?id=61567521075043" target="_blank">
                                <i class="fa-brands fa-facebook"></i>
                            </a>
                        </div>
                        <div class="md">
                            <a href="https://www.tiktok.com/@everything.tips8" target="_blank">
                                <i class="fa-brands fa-tiktok"></i>
                            </a>
                        </div>
                        <div class="md">
                            <a href="https://www.youtube.com/@TechnoSpeak-j3f" target="_blank">
                                <i class="fa-brands fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer Section -->
        {{-- Include the footer --}}
        @include('layouts.footer')

        <script src="script/home_slider.js"></script>
        <script src="script/pop-up.js"></script>



        <!-- Coming Soon Modal -->
        <div id="coming-soon-modal" class="modal" style="display: none;">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Coming Soon</h2>
                </div>
                <div class="modal-body">
                    <div class="modal-icon">⏱️</div>
                    <p>Our Formal Training program is currently in development and will be available soon.</p>
                    <p>We're working hard to create the best learning experience for you. Please check back later or contact us for more information.</p>
                </div>
                <div class="modal-footer">
                    <button class="modal-btn cancel" id="modal-close-btn">Close</button>
                    <button class="modal-btn confirm" id="modal-contact-btn">Contact Us</button>
                </div>
            </div>
        </div>

    </body> 
</html>