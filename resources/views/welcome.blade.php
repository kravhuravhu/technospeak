<!DOCTYPE html>
<html>
    <head>
        <title>Technospeak - Home</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="TechnoSpeak">
        <meta property="og:type" content="website">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="@secureAsset('images/icon.png')" type="image/x-icon">
        <link rel="stylesheet" href="@secureAsset('style/home.css')">
        <link rel="stylesheet" href="@secureAsset('style/about.css')">
        <link rel="stylesheet" href="@secureAsset('style/footer.css')">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Alegreya:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Schoolbell&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

        <!-- Swipers -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
        <!-- Font Awesome CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        {{-- Include the navbar --}}
        @include('layouts.navbar', ['whiteBg' => $whiteBg ?? true])

        <!-- Task Assistance Form Modal -->
        <div id="taskAssistanceModalUnique" class="assistanceTP_form_modal">
            <div class="task_modal-content">
                <span id="closeTaskAssistanceModal" class="close">&times;</span>
                @include('components.task-assistance-form')
            </div>
        </div>

        <!-- Personal Guide Form Modal -->
        <div id="personalGuideModalUnique" class="assistanceTP_form_modal">
            <div class="task_modal-content">
                <span id="closePersonalGuideModal" class="close">&times;</span>
                @include('components.personal-guide-form')
            </div>
        </div>

        <!-- Service Assistance Form Modal -->
        <div id="serviceAssistanceModalUnique" class="assistanceTP_form_modal">
            <div class="task_modal-content">
                <span id="closeServiceAssistanceModal" class="close">&times;</span>
                @include('components.service-assistance-form')
            </div>
        </div>

        <!-- Landing page container -->
        <section class="landing_container">
            <div class="main_container">
                <div class="slider_container">
                    <div class="still_block">
                        <div class="main_block">
                            <!-- Slide 1: Transform Your Digital Future - Technical Support & Maintenance -->
                            <div class="slider">
                                <div class="header">
                                    <h3 id="animated_header">Transform Your Digital Future</h3>
                                </div>
                                <div class="dscpt">
                                    <p><strong>Technospeak</strong> empowers you to master technology with confidence. We offer easy-to-follow tutorials...</p>
                                </div>
                                <div class="cta">
                                    @if(Auth::check())
                                        <a href="{{ url('/dashboard') }}?category={{ urlencode('Technical Support & Maintenance') }}#usr_alltricks" class="cta">
                                            <div>Explore Solutions</div>
                                        </a>
                                    @else
                                        <a href="{{ url('/login') }}?redirect={{ urlencode('dashboard?category=' . urlencode('Technical Support & Maintenance') . '#usr_alltricks') }}" class="cta">
                                            <div>Explore Solutions</div>
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <!-- Slide 2: AI-Powered Business Revolution - AI Content Creation Tools -->
                            <div class="slider">
                                <div class="header">
                                    <h3>AI-Powered Business Revolution</h3>
                                </div>
                                <div class="dscpt">
                                    <p>Discover how AI can simplify your everyday tasks and boost productivity—no technical background needed...</p>
                                </div>
                                <div class="cta">
                                    @if(Auth::check())
                                        <a href="{{ url('/dashboard') }}?category={{ urlencode('AI Content Creation Tools') }}#usr_alltricks" class="cta">
                                            <div>Explore Courses</div>
                                        </a>
                                    @else
                                        <a href="{{ url('/login') }}?redirect={{ urlencode('dashboard?category=' . urlencode('AI Content Creation Tools') . '#usr_alltricks') }}" class="cta">
                                            <div>Explore Courses</div>
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <!-- Slide 3: Cloud Infrastructure Reimagined - Networking & Internet Essentials -->
                            <div class="slider">
                                <div class="header">
                                    <h3>Cloud Infrastructure Reimagined</h3>
                                </div>
                                <div class="dscpt">
                                    <p>Unlock the power of cloud tools for learning, collaboration, and productivity. At <strong>Technospeak</strong>, we guide you...</p>
                                </div>
                                <div class="cta">
                                    @if(Auth::check())
                                        <a href="{{ url('/dashboard') }}?category={{ urlencode('Networking & Internet Essentials') }}#usr_alltricks" class="cta">
                                            <div>Explore Courses</div>
                                        </a>
                                    @else
                                        <a href="{{ url('/login') }}?redirect={{ urlencode('dashboard?category=' . urlencode('Networking & Internet Essentials') . '#usr_alltricks') }}" class="cta">
                                            <div>Explore Courses</div>
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <!-- Slide 4: Cybersecurity Awareness - Networking & Internet Essentials -->
                            <div class="slider">
                                <div class="header">
                                    <h3>Cybersecurity Awareness</h3>
                                </div>
                                <div class="dscpt">
                                    <p>Stay safe online with our easy-to-follow cybersecurity guidance and practical tools. We help you recognize scams, protect your accounts...</p>
                                </div>
                                <div class="cta">
                                    @if(Auth::check())
                                        <a href="{{ url('/dashboard') }}?category={{ urlencode('Networking & Internet Essentials') }}#usr_alltricks" class="cta">
                                            <div>Explore Courses</div>
                                        </a>
                                    @else
                                        <a href="{{ url('/login') }}?redirect={{ urlencode('dashboard?category=' . urlencode('Networking & Internet Essentials') . '#usr_alltricks') }}" class="cta">
                                            <div>Explore Courses</div>
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
        <section class="product-plans-section" id="prod-plans">
            <h2 class="section-title">Our Product Plans</h2>
            <div class="section-content">
                <div class="slider-container swiper">
                    <div class="slider-wrapper">
                        <ul class="product-list swiper-wrapper">
                            <!-- Card 1: Free Subscription -->
                            <li class="products swiper-slide">
                                <img src="@secureAsset('/images/Free subscription.png')" alt="Free Subscription" class="product-image"/>
                                <h3 class="subtitle">Free Subscription</h3>

                                <i class="description">
                                    <p>Access our free clickbait videos on social media. Ask questions in comments and get brief answers with links to full details on our website.</p>
                                    <p>Free access to social media content</p>
                                    <p>Brief answers to your questions</p>
                                    <p>Links to detailed explanations</p>
                                </i>

                                <div class="plan-button">
                                    <a href="{{ Auth::check() ? url('/dashboard#usr_alltricks') : url('/login') }}">Sign up Free</a>
                                </div>
                            </li>

                            <!-- Card 2: Premium Subscription -->
                            <li class="products swiper-slide">
                                <img src="@secureAsset('/images/premium subscription.png')" alt="Premium Subscription" class="product-image"/>
                                <h3 class="subtitle">Premium Subscription</h3>
                                    <div class="price-tag">
                                        <span>From R350/quarter</span>
                                    </div>

                                <i class="description">
                                    <p>Full access to all our premium content with exclusive resources for serious learners and professionals.</p>
                                    <p>All clickbait-style videos</p>
                                    <p>Downloadable resources & cheat sheets</p>
                                    <p>Monthly curated tech newsletters</p>
                                    <p>Student and business pricing options</p>
                                </i>

                                <div class="plan-button">
                                    @if(Auth::check())
                                        <a href="{{ route('subscription.yoco.form') }}">Subscribe Now</a>
                                    @else
                                        <a href="{{ url('/login?redirect=subscription/yoco/form') }}">Subscribe Now</a>
                                    @endif
                                </div>
                            </li>

                            <!-- Card 3: Formal Training -->
                            <li class="products swiper-slide">
                                <img src="@secureAsset('/images/Formal training.png')" alt="Formal Training" class="product-image"/>
                                <h3 class="subtitle">Formal Training</h3>
                                    <div class="price-tag">
                                        <span>From R1500/training</span>
                                    </div>

                                <i class="description">
                                    <p>Comprehensive 40-hour training programs in End-User Computing and web development for all skill levels.</p>
                                    <p>Structured 8-hour daily sessions</p>
                                    <p>Tailored to students & professionals</p>
                                    <p>Portfolio development support</p>
                                    <p>Partnership opportunities</p>
                                </i>

                                <div class="plan-button">
                                    <a href="{{ Auth::check() ? url('/dashboard#usr_formaltraining') : url('/login') }}">Enroll Now</a>
                                </div>
                            </li>

                            <!-- Card 4: Personal Guide -->
                            <li class="products swiper-slide">
                                <img src="@secureAsset('/images/Personal guide.png')" alt="Personal Guide" class="product-image"/>
                                <h3 class="subtitle">Personal Guide</h3>
                                    <div class="price-tag">
                                        <span>From R110/hour</span>
                                    </div>

                                <i class="description">
                                    <p>One-on-one sessions with expert tutors for personalized attention and focused learning.</p>
                                    <p>Submit requests in advance</p>
                                    <p>Video call or chat sessions</p>
                                    <p>Flexible scheduling</p>
                                    <p>Additional hours available</p>
                                </i>

                                <div class="plan-button">
                                    <a href="#categories_cont" id="openPersonalGuideModal">Get Guide</a>
                                </div>
                            </li>

                            <!-- Card 5: Task Assistance -->
                            <li class="products swiper-slide">
                                <img src="@secureAsset('/images/Task assistance.png')" alt="Task Assistance" class="product-image"/>
                                <h3 class="subtitle">Task Assistance</h3>
                                    <div class="price-tag">
                                        <span>From R100/hour</span>
                                    </div>

                                <i class="description">
                                    <p>We provide hands-on support by completing technical tasks for you—ranging from coding and automation to system configurations and troubleshooting etc.</p>
                                    <p>Coding & web development help</p>
                                    <p>System configuration support</p>
                                    <p>Direct task completion</p>
                                    <p>Student and business rates</p>
                                </i>

                                <div class="plan-button">
                                    <a href="#categories_cont" id="openTaskAssistanceModal">Get Assistance</a>
                                </div>
                            </li>

                            <!-- Card 6: Group Session 1 -->
                            <li class="products swiper-slide">
                                <img src="@secureAsset('/images/live Q&A session.png')" alt="Group Session 1" class="product-image"/>
                                <h3 class="subtitle">Live Q&A Sessions</h3>
                                    <div class="price-tag">
                                        <span>From R130/hour</span>
                                    </div>

                                <i class="description">
                                    <p>Interactive group sessions where you can ask questions and get immediate expert answers.</p>
                                    <p>Live Q&A with experts</p>
                                    <p>Submit questions via chat</p>
                                    <p>Various tech topics covered</p>
                                    <p>Different pricing for students/business</p>
                                </i>

                                <div class="plan-button">
                                    @if(Auth::check())
                                    <!-- Group Q/A Button -->
                                    @if(isset($qaSession) && $qaSession)
                                        <a href="#" class="btn btn-primary registration-trigger" 
                                        data-type-id="4" 
                                        data-session-id="{{ $qaSession->id }}">
                                            BOOK NOW
                                        </a>
                                    @else
                                        <button class="btn btn-primary" disabled>BOOK NOW</button>
                                    @endif
                                    @else
                                        <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="btn btn-primary">BOOK NOW</a>
                                    @endif
                                </div>
                            </li>

                            <!-- Card 7: Group Session 2 (cleaned and consistent with other cards) -->
                            <li class="products swiper-slide">
                                <img src="@secureAsset('images/live consultation.png')" alt="Group Session 2" class="product-image"/>
                                <h3 class="subtitle">Response Consultations</h3>

                                <div class="price-tag">
                                    <span>From R130/hour</span>
                                </div>

                                <i class="description">
                                    <p>Focused sessions addressing comments and questions from our video content.</p>
                                    <p>Answers to video comments</p>
                                    <p>Programming &amp; cybersecurity focus</p>
                                    <p>Interactive skill-building</p>
                                    <p>Live response to questions</p>
                                </i>

                                <div class="plan-button">
                                    @if(Auth::check())
                                        @if(isset($consultSession) && $consultSession)
                                            <a href="#" class="btn btn-primary registration-trigger"
                                               data-type-id="5"
                                               data-session-id="{{ $consultSession->id }}">
                                                BOOK NOW
                                            </a>
                                        @else
                                            <button class="btn btn-primary" disabled>BOOK NOW</button>
                                        @endif
                                    @else
                                        <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="btn btn-primary">BOOK NOW</a>
                                    @endif
                                </div>
                            </li>

                        </ul>

                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>
            </div>

            <!-- Modals and Includes -->
            @if(isset($premiumPlan))
                @include('components.subscription_modal', [
                    'planId' => $premiumPlan->id,
                    'planName' => $premiumPlan->name,
                    'plan' => $premiumPlan
                ])
            @endif

            @include('components.training_modal')
            @include('components.sessions_registration', [
                'typeId' => 4,
                'typeName' => 'Group Session 1'
            ])
            @include('components.sessions_registration', [
                'typeId' => 5, 
                'typeName' => 'Group Session 2'
            ])

            @include('components.sessions_registration', [
                'typeId' => 1,
                'typeName' => 'Formal Training'
            ])

            @include('components.sessions_registration', [
                'typeId' => 2, 
                'typeName' => 'Task Assistance'
            ])

            @include('components.sessions_registration', [
                'typeId' => 3,
                'typeName' => 'Personal Guide'
            ])
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

                    <!-- Right Content - Details Panel (Desktop) -->
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
                        </div>
                    </div>
                </div>
            </div>
        </section>

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
                        <a href="{{ url('/dashboard#usr_formaltraining') }}" class="view-more-btn">View More Courses</a>
                    @else
                        @php
                            $url = url("/dashboard#usr_formaltraining");
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
                        <form action="{{ route('contact.message.send') }}" method="POST" id="contact-form">
                            @csrf
                            <div class="block">
                                <div class="prgrph"><p>Full Names:</p></div>
                                <div class="field">
                                    <input type="text" name="contact_full_name" id="contact_full_name" placeholder="Enter name here..." required />
                                    <div class="error-message" id="name-error" style="color: red; display: none; font-size: 12px; margin-top: 5px;"></div>
                                </div>
                            </div>
                            <div class="block">
                                <div class="prgrph">
                                    <p>Email Address:</p>
                                </div>
                                <div class="field">
                                    <input type="email" name="contact_email" id="contact_email" placeholder="Enter email here..." required />
                                    <div class="error-message" id="email-error" style="color: red; display: none; font-size: 12px; margin-top: 5px;"></div>
                                </div>
                            </div>
                            <div class="block">
                                <div class="prgrph"><p>Message:</p></div>
                                <div class="field">
                                    <textarea name="contact_message" id="contact_message" placeholder="Enter your message..." required></textarea>
                                    <div class="error-message" id="message-error" style="color: red; display: none; font-size: 12px; margin-top: 5px;"></div>
                                </div>
                            </div>
                            <div class="block">
                                <div class="field">
                                    <button type="submit" id="contact-submit-btn">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="scl_md_container">
                        <div class="md">
                            <a href="https://www.facebook.com/profile.php?id=61575880092292&mibextid=rS40aB7S9Ucbxw6v" target="_blank">
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
        <!-- Linking Swiper script -->
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


        <!-- Assistance Modal -->
        <script>
            document.addEventListener("DOMContentLoaded", function() {    
                function openModal(modalId) {
                    var modal = document.getElementById(modalId);
                    modal.style.display = "block";
                    
                    document.body.style.overflow = "hidden";
                    document.body.style.position = "fixed";
                    document.body.style.width = "100%";
                }

                function closeModal(modalId) {
                    var modal = document.getElementById(modalId);
                    modal.style.display = "none";
                    
                    document.body.style.overflow = "auto";
                    document.body.style.position = "";
                    document.body.style.width = "";
                }

                window.onclick = function(event) {
                    var taskAssistanceModal = document.getElementById("taskAssistanceModalUnique");
                    var personalGuideModal = document.getElementById("personalGuideModalUnique");
                    
                    if (event.target == taskAssistanceModal) {
                        closeModal("taskAssistanceModalUnique");
                    } else if (event.target == personalGuideModal) {
                        closeModal("personalGuideModalUnique");
                    }
                }

                // Task Assistance Modal
                var openTaskAssistanceModalBtn = document.getElementById("openTaskAssistanceModal");
                var closeTaskAssistanceModalBtn = document.getElementById("closeTaskAssistanceModal");

                openTaskAssistanceModalBtn.onclick = function(event) {
                    event.preventDefault();
                    openModal("taskAssistanceModalUnique");
                };

                closeTaskAssistanceModalBtn.onclick = function() {
                    closeModal("taskAssistanceModalUnique");
                };

                // Personal Guide Modal
                var openPersonalGuideModalBtn = document.getElementById("openPersonalGuideModal");
                var closePersonalGuideModalBtn = document.getElementById("closePersonalGuideModal");

                openPersonalGuideModalBtn.onclick = function(event) {
                    event.preventDefault();
                    openModal("personalGuideModalUnique");
                };

                closePersonalGuideModalBtn.onclick = function() {
                    closeModal("personalGuideModalUnique");
                };
            });
        </script>

        <!-- QA & Consult Modal -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Handle registration triggers
                document.querySelectorAll('.registration-trigger').forEach(trigger => {
                    trigger.addEventListener('click', function(e) {
                        e.preventDefault();
                        const typeId = this.dataset.typeId;
                        
                        // Show the appropriate modal based on typeId
                        if(typeId == 4) {
                            document.getElementById('modal-qa').style.display = 'flex';
                        } else if(typeId == 5) {
                            document.getElementById('modal-consult').style.display = 'flex';
                        }
                        
                        document.body.classList.add('no-scroll');
                    });
                });
                
                function closeModal(event, modalId) {
                    event.stopPropagation();
                    document.getElementById(modalId).style.display = 'none';
                    document.body.classList.remove('no-scroll');
                }
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- account deleted pop -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                @if(session('accountDeleted'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        timer: 7000,
                        toast: true,
                        text: 'Your account has been deleted successfully.',
                        showConfirmButton: false,
                        position: 'top-end',
                    });
                    localStorage.clear();
                @endif
            });
        </script>

        <!-- Get in touch validation handle -->
         <script>
            document.addEventListener('DOMContentLoaded', function() {
                const contactForm = document.getElementById('contact-form');
                const nameInput = document.getElementById('contact_full_name');
                const emailInput = document.getElementById('contact_email');
                const messageInput = document.getElementById('contact_message');
                const nameError = document.getElementById('name-error');
                const emailError = document.getElementById('email-error');
                const messageError = document.getElementById('message-error');
                const submitBtn = document.getElementById('contact-submit-btn');

                // Track validation state
                let isNameValid = false;
                let isEmailValid = false;
                let isMessageValid = false;

                // Validation functions
                function validateName() {
                    const name = nameInput.value.trim();
                    
                    // Clear previous error
                    nameError.style.display = 'none';
                    nameInput.style.borderColor = '';
                    
                    if (!name) {
                        nameError.textContent = 'Full name is required';
                        nameError.style.display = 'block';
                        nameInput.style.borderColor = 'red';
                        isNameValid = false;
                        updateSubmitButton();
                        return false;
                    }
                    
                    // Check if name has at least 2 characters
                    if (name.length < 2) {
                        nameError.textContent = 'Name must be at least 2 characters long';
                        nameError.style.display = 'block';
                        nameInput.style.borderColor = 'red';
                        isNameValid = false;
                        updateSubmitButton();
                        return false;
                    }
                    
                    // Check if name contains only letters, spaces, hyphens, and apostrophes
                    const nameRegex = /^[a-zA-Z\s\-']+$/;
                    if (!nameRegex.test(name)) {
                        nameError.textContent = 'Name can only contain letters, spaces, hyphens, and apostrophes';
                        nameError.style.display = 'block';
                        nameInput.style.borderColor = 'red';
                        isNameValid = false;
                        updateSubmitButton();
                        return false;
                    }
                    
                    // Check if name has at least one space (first and last name)
                    if (!name.includes(' ')) {
                        nameError.textContent = 'Please enter your full name (first and last name)';
                        nameError.style.display = 'block';
                        nameInput.style.borderColor = 'red';
                        isNameValid = false;
                        updateSubmitButton();
                        return false;
                    }
                    
                    // Check if name is too long
                    if (name.length > 100) {
                        nameError.textContent = 'Name must be less than 100 characters';
                        nameError.style.display = 'block';
                        nameInput.style.borderColor = 'red';
                        isNameValid = false;
                        updateSubmitButton();
                        return false;
                    }
                    
                    // Name is valid
                    nameInput.style.borderColor = 'green';
                    isNameValid = true;
                    updateSubmitButton();
                    return true;
                }

                function validateEmail() {
                    const email = emailInput.value.trim();
                    
                    // Clear previous error
                    emailError.style.display = 'none';
                    emailInput.style.borderColor = '';
                    
                    if (!email) {
                        emailError.textContent = 'Email address is required';
                        emailError.style.display = 'block';
                        emailInput.style.borderColor = 'red';
                        isEmailValid = false;
                        updateSubmitButton();
                        return false;
                    }
                    
                    // Check for proper email format with domain and TLD
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
                    if (!emailRegex.test(email)) {
                        emailError.textContent = 'Please enter a valid email address (e.g., name@company.co.za)';
                        emailError.style.display = 'block';
                        emailInput.style.borderColor = 'red';
                        isEmailValid = false;
                        updateSubmitButton();
                        return false;
                    }
                    
                    // Check domain part has at least one dot
                    const domainPart = email.split('@')[1];
                    if (!domainPart.includes('.')) {
                        emailError.textContent = 'Email domain must be valid (e.g., gmail.com, company.co.za)';
                        emailError.style.display = 'block';
                        emailInput.style.borderColor = 'red';
                        isEmailValid = false;
                        updateSubmitButton();
                        return false;
                    }
                    
                    // Check for test/invalid domains
                    const invalidDomains = ['test', 'example', 'localhost', 'invalid', 'fake', 'demo'];
                    const domain = domainPart.toLowerCase();
                    const hasInvalidDomain = invalidDomains.some(invalid => 
                        domain.includes(invalid) || domain === invalid
                    );
                    
                    if (hasInvalidDomain) {
                        emailError.textContent = 'Please use a valid business or personal email address';
                        emailError.style.display = 'block';
                        emailInput.style.borderColor = 'red';
                        isEmailValid = false;
                        updateSubmitButton();
                        return false;
                    }
                    
                    // Email is valid
                    emailInput.style.borderColor = 'green';
                    isEmailValid = true;
                    updateSubmitButton();
                    return true;
                }

                function validateMessage() {
                    const message = messageInput.value.trim();
                    
                    // Clear previous error
                    messageError.style.display = 'none';
                    messageInput.style.borderColor = '';
                    
                    if (!message) {
                        messageError.textContent = 'Message is required';
                        messageError.style.display = 'block';
                        messageInput.style.borderColor = 'red';
                        isMessageValid = false;
                        updateSubmitButton();
                        return false;
                    }
                    
                    // Check if message has minimum length
                    if (message.length < 10) {
                        messageError.textContent = 'Message must be at least 10 characters long';
                        messageError.style.display = 'block';
                        messageInput.style.borderColor = 'red';
                        isMessageValid = false;
                        updateSubmitButton();
                        return false;
                    }
                    
                    // Check if message is too long
                    if (message.length > 1000) {
                        messageError.textContent = 'Message must be less than 1000 characters';
                        messageError.style.display = 'block';
                        messageInput.style.borderColor = 'red';
                        isMessageValid = false;
                        updateSubmitButton();
                        return false;
                    }
                    
                    // Check for excessive whitespace
                    const excessiveSpaces = message.split('  ').length > 1; // Check for double spaces
                    const excessiveNewlines = message.split('\n\n\n').length > 1; // Check for triple newlines
                    
                    if (excessiveSpaces || excessiveNewlines) {
                        messageError.textContent = 'Message contains excessive spacing';
                        messageError.style.display = 'block';
                        messageInput.style.borderColor = 'red';
                        isMessageValid = false;
                        updateSubmitButton();
                        return false;
                    }
                    
                    // Message is valid
                    messageInput.style.borderColor = 'green';
                    isMessageValid = true;
                    updateSubmitButton();
                    return true;
                }

                function updateSubmitButton() {
                    // Only enable button when ALL fields are valid
                    if (isNameValid && isEmailValid && isMessageValid) {
                        submitBtn.disabled = false;
                        submitBtn.style.opacity = '1';
                        submitBtn.style.cursor = 'pointer';
                        submitBtn.textContent = 'Send Message';
                        submitBtn.style.backgroundColor = ''; // Reset to default
                    } else {
                        submitBtn.disabled = true;
                        submitBtn.style.opacity = '0.6';
                        submitBtn.style.cursor = 'not-allowed';
                        submitBtn.textContent = 'Send Message';
                        submitBtn.style.backgroundColor = '#ccc';
                    }
                }

                // Real-time validation
                nameInput.addEventListener('input', function() {
                    validateName();
                });

                nameInput.addEventListener('blur', function() {
                    validateName();
                });

                emailInput.addEventListener('input', function() {
                    validateEmail();
                });

                emailInput.addEventListener('blur', function() {
                    validateEmail();
                });

                messageInput.addEventListener('input', function() {
                    validateMessage();
                });

                messageInput.addEventListener('blur', function() {
                    validateMessage();
                });

                // Handle form submission
                contactForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Final validation before submission
                    const nameValid = validateName();
                    const emailValid = validateEmail();
                    const messageValid = validateMessage();
                    
                    // If anything is invalid, STOP here
                    if (!nameValid || !emailValid || !messageValid) {
                        // Scroll to first error
                        if (!nameValid) {
                            nameInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            nameInput.focus();
                        } else if (!emailValid) {
                            emailInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            emailInput.focus();
                        } else {
                            messageInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            messageInput.focus();
                        }
                        
                        alert('Please fix all validation errors before sending the message.');
                        return false;
                    }
                    
                    // If all validations pass, submit the form
                    contactForm.submit();
                });

                // Initialize submit button state
                updateSubmitButton();
            });
        </script>

        <!-- Swiper initialization for Product Plans slider -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof Swiper !== 'undefined') {
                    const swiper = new Swiper('.slider-wrapper', {
                        loop: true,
                        grabCursor: true,
                        spaceBetween: 20,
                        slidesPerView: 1,
                        pagination: {
                            el: '.swiper-pagination',
                            clickable: true,
                            dynamicBullets: true,
                        },
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                        breakpoints: {
                            640: {
                                slidesPerView: 2,
                                spaceBetween: 20
                            },
                            1024: {
                                slidesPerView: 3,
                                spaceBetween: 25
                            },
                            1280: {
                                slidesPerView: 3,
                                spaceBetween: 30
                            }
                        }
                    });
                }
            });
        </script>



        <!-- assistance submission -->
        <script src="@secureAsset('/script/sendMail/support_assistance.js')"></script>
    </body> 
</html>