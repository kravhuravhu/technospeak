<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Technospeak - Pricing</title>
        <meta name="author" content="TechnoSpeak">
        <meta property="og:type" content="website">
        <link rel="icon" href="@secureAsset('images/icon.png')" type="image/x-icon">
        <link rel="stylesheet" href="@secureAsset('style/pricing.css')" type="text/css">
        <link rel="stylesheet" href="@secureAsset('style/home.css')" type="text/css">
        <link rel="stylesheet" href="@secureAsset('style/footer.css')" type="text/css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Alegreya:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Schoolbell&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>
    <body>
        {{-- Include the navbar --}}
        @include('layouts.navbar', ['whiteBg' => $whiteBg ?? true])

        <!-- Task Assistance Form Modal] -->
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

        <section class="price_container">
            <div class="main-container">
                <div class="title_container">
                    <div>
                        <h1>Subscription Plans & Pricing</h1>
                        <p>Choose the perfect plan for your tech learning journey. From free access to premium personalised support, we have options for everyone.</p>
                    </div>
                </div>
                <div class="plans_container">
                    <div class="container">
                        <div class="card-grid">
                            <div class="container-grid">
                                <!-- Plan 1 -->
                                <div class="card_container">
                                    <div class="card">
                                        <div class="plan_title">
                                            <h2>Tech Teasers</h2>
                                        </div>
                                        <div class="icon">
                                            <img src="../images/icons/quality-service.png"/>
                                        </div>
                                        <div class="price">
                                            <p>
                                                <span>
                                                    <sup class="context">R</sup>
                                                </span>
                                                Free
                                                <span class="dur">/ always</span>
                                            </p>
                                        </div>
                                        <div class="dscpt_container">
                                            <div class="dscpt">
                                                <div class="tick">
                                                    <img src="../images/icons/quality.png"/>
                                                </div>
                                                <div class="dscpt-p">
                                                    <p>Access to social media videos</p>
                                                </div>
                                            </div>
                                            <div class="dscpt">
                                                <div class="tick">
                                                    <img src="../images/icons/quality.png"/>
                                                </div>
                                                <div class="dscpt-p">
                                                    <p>Comment on Q&A session</p>
                                                </div>
                                            </div>
                                            <div class="dscpt">
                                                <div class="tick">
                                                    <img src="../images/icons/quality.png"/>
                                                </div>
                                                <div class="dscpt-p">
                                                    <p>Links to full content</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bttn">
                                            @if(Auth::check())
                                                <a href="{{ route('subscription.subscribe.free') }}" class="btn btn-primary">GET STARTED</a>
                                            @else
                                                <a href="{{ route('login') }}" class="btn btn-primary">GET STARTED</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Plan 2 -->
                                <div class="card_container">
                                    <div class="card card-2 highlight">
                                        <div class="plan_title">
                                            <h2>Premium</h2>
                                        </div>
                                        <div class="icon">
                                            <img src="../images/icons/quality-service.png"/>
                                        </div>
                                        <div class="price">
                                            <p>
                                                <span>
                                                    <sub class="sub context">from</sub>
                                                    <sup class="context">R</sup>
                                                </span>
                                                350
                                                <span class="dur">/ quarterly</span>
                                            </p>
                                            <!-- <p style="font-size:0.8em;color:#666;margin-top:5px;">(R400 for business)</p> -->
                                        </div>
                                        <div class="dscpt_container">
                                            <div class="dscpt">
                                                <div class="tick">
                                                    <img src="../images/icons/quality.png"/>
                                                </div>
                                                <div class="dscpt-p">
                                                    <p>Full video access</p>
                                                </div>
                                            </div>
                                            <div class="dscpt">
                                                <div class="tick">
                                                    <img src="../images/icons/quality.png"/>
                                                </div>
                                                <div class="dscpt-p">
                                                    <p>Downloadable resources</p>
                                                </div>
                                            </div>
                                            <div class="dscpt">
                                                <div class="tick">
                                                    <img src="../images/icons/quality.png"/>
                                                </div>
                                                <div class="dscpt-p">
                                                    <p>Monthly tech newsletters</p>
                                                </div>
                                            </div>
                                            <div class="dscpt">
                                                <div class="tick">
                                                    <img src="../images/icons/quality.png"/>
                                                </div>
                                                <div class="dscpt-p">
                                                    <p>Cheatsheets & guides</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bttn">
                                            @if(Auth::check())
                                                <a href="{{ route('subscription.yoco.redirect') }}" class="btn btn-primary">SUBSCRIBE</a>
                                            @else
                                                <a href="{{ url('/login?redirect=subscription/yoco/redirect') }}" class="btn btn-primary">SUBSCRIBE</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Plan 3 -->
                                <div class="card_container">
                                    <div class="card">
                                        <div class="plan_title">
                                            <h2>Formal Training</h2>
                                        </div>
                                        <div class="icon">
                                            <img src="../images/icons/quality-service.png"/>
                                        </div>
                                        <div class="price">
                                            <p>
                                                <span>
                                                    <sub class="sub context">from</sub>
                                                    <sup class="context">R</sup>
                                                </span>
                                                2,500
                                                <span class="dur">/ course</span>
                                            </p>
                                            <!-- <p style="font-size:0.8em;color:#666;margin-top:5px;">(R3,500 for business)</p> -->
                                        </div>
                                        <div class="dscpt_container">
                                            <div class="dscpt">
                                                <div class="tick">
                                                    <img src="../images/icons/quality.png"/>
                                                </div>
                                                <div class="dscpt-p">
                                                    <p>40-hour comprehensive training</p>
                                                </div>
                                            </div>
                                            <div class="dscpt">
                                                <div class="tick">
                                                    <img src="../images/icons/quality.png"/>
                                                </div>
                                                <div class="dscpt-p">
                                                    <p>EUC & web development</p>
                                                </div>
                                            </div>
                                            <div class="dscpt">
                                                <div class="tick">
                                                    <img src="../images/icons/quality.png"/>
                                                </div>
                                                <div class="dscpt-p">
                                                    <p>Portfolio building support</p>
                                                </div>
                                            </div>
                                            <div class="dscpt">
                                                <div class="tick">
                                                    <img src="../images/icons/quality.png"/>
                                                </div>
                                                <div class="dscpt-p">
                                                    <p>Professional certification</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bttn">
                                            <a href="{{ Auth::check() ? url('/dashboard#usr_formaltraining') : url('/login') }}" class="btn btn-primary">Enroll Now</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Row 2 Container -->
                                <div class="row2-container">
                                    <!-- Personal Guide & Task Assistance -->
                                    <div class="card_container row2">
                                        <div class="card">
                                            <div class="plan_title">
                                                <h2>Help On Demand</h2>
                                            </div>
                                            <div class="icon">
                                                <img src="../images/icons/quality-service.png" />
                                            </div>
                                            <div class="price">
                                                <p>
                                                    <span><sub class="sub context">from</sub><sup class="context">R</sup></span> 100
                                                    <span class="dur">per hour</span>
                                                </p>
                                            </div>
                                            <div class="dscpt_container">
                                                <div class="dscpt">
                                                    <div class="tick"><img src="../images/icons/quality.png" /></div>
                                                    <div class="dscpt-p"><p>Live sessions or task completion</p></div>
                                                </div>
                                            </div>
                                            <div class="bttn">
                                                <a href="#" id="openPersonalGuideModal" class="btn btn-primary">PERSONAL GUIDE</a>
                                                <a href="#" id="openTaskAssistanceModal" class="btn btn-primary">TASK ASSISTANCE</a>
                                            </div>
                                        </div>

                                        <!-- Modal: Personal Guide -->
                                        <!-- <div id="modal-guide" class="modal" onclick="closeModal(event, 'modal-guide')">
                                            <div class="card popup-content" onclick="event.stopPropagation();">
                                                <div class="plan_title">
                                                    <h2>Personal Guide</h2>
                                                </div>
                                                <div class="icon">
                                                    <img src="../images/icons/quality-service.png" />
                                                </div>
                                                <div class="price">
                                                    <p><span><sub class="sub context">from</sub><sup class="context">R</sup></span> 110 <span class="dur">/ hour</span></p>
                                                </div>
                                                <div class="dscpt_container">
                                                    <div class="dscpt"><div class="tick"><img src="../images/icons/quality.png" /></div><div class="dscpt-p"><p>Live personalised sessions</p></div></div>
                                                    <div class="dscpt"><div class="tick"><img src="../images/icons/quality.png" /></div><div class="dscpt-p"><p>Flexible scheduling</p></div></div>
                                                    <div class="dscpt"><div class="tick"><img src="../images/icons/quality.png" /></div><div class="dscpt-p"><p>Video call or chat options</p></div></div>
                                                    <div class="dscpt"><div class="tick"><img src="../images/icons/quality.png" /></div><div class="dscpt-p"><p>Additional hours available</p></div></div>
                                                </div>
                                                <div class="bttn">
                                                    @if(Auth::check())
                                                        <a href="{{ route('stripe.checkout', ['clientId' => auth()->id(), 'planId' => 'training_3']) }}" class="btn btn-primary">PERSONAL GUIDE</a>
                                                    @else
                                                        <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="btn btn-primary">PERSONAL GUIDE</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div> -->

                                        <!-- Modal: Task Assistance -->
                                        <!-- <div id="modal-task" class="modal" onclick="closeModal(event, 'modal-task')">
                                            <div class="card popup-content" onclick="event.stopPropagation();">
                                                <div class="plan_title">
                                                    <h2>Task Assistance</h2>
                                                </div>
                                                <div class="icon">
                                                    <img src="../images/icons/quality-service.png" />
                                                </div>
                                                <div class="price">
                                                    <p><span><sup class="context">R</sup></span> 100 <span class="dur">/ hour</span></p>
                                                </div>
                                                <div class="dscpt_container">
                                                    <div class="dscpt"><div class="tick"><img src="../images/icons/quality.png" /></div><div class="dscpt-p"><p>Hands-on task completion</p></div></div>
                                                    <div class="dscpt"><div class="tick"><img src="../images/icons/quality.png" /></div><div class="dscpt-p"><p>Coding & development</p></div></div>
                                                    <div class="dscpt"><div class="tick"><img src="../images/icons/quality.png" /></div><div class="dscpt-p"><p>System configurations</p></div></div>
                                                    <div class="dscpt"><div class="tick"><img src="../images/icons/quality.png" /></div><div class="dscpt-p"><p>Tech-related solutions</p></div></div>
                                                </div>
                                                <div class="bttn">
                                                    @if(Auth::check())
                                                        <a href="{{ route('stripe.checkout', ['clientId' => auth()->id(), 'planId' => 'training_2']) }}" class="btn btn-primary">TASK ASSISTANCE</a>
                                                    @else
                                                        <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="btn btn-primary">TASK ASSISTANCE</a>
                                                    @endif
                                                    <button class="btn btn-secondary" onclick="document.getElementById('modal-task').style.display='none'">CLOSE</button>
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                    <!-- Group Session -->
                                    <div class="card_container row2">
                                        <div class="card">
                                            <div class="plan_title">
                                                <h2>Group Session</h2>
                                            </div>
                                            <div class="icon">
                                                <img src="../images/icons/quality-service.png" />
                                            </div>
                                            <div class="price">
                                                <p>
                                                    <span>
                                                        <sub class="sub context">from</sub>
                                                        <sup class="context">R</sup>
                                                    </span>
                                                    130
                                                    <span class="dur">per session / hour</span>
                                                </p>
                                            </div>
                                            <div class="dscpt_container">
                                                <div class="dscpt">
                                                    <div class="tick">
                                                        <img src="../images/icons/quality.png" />
                                                    </div>
                                                    <div class="dscpt-p">
                                                        <p>Live Q&A and Consultation options</p>
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="bttn">
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

                                                @if(Auth::check())
                                                    <!-- Group Q/A Button -->
                                                    @if($qaSession)
                                                        <a href="#" class="btn btn-primary registration-trigger" 
                                                        data-type-id="4" 
                                                        data-session-id="{{ $qaSession->id }}">
                                                            GROUP Q/A
                                                        </a>
                                                    @else
                                                        <button class="btn btn-primary" disabled>GROUP Q/A</button>
                                                    @endif
                                                    
                                                    <!-- Consultation Button -->
                                                    @if($consultSession)
                                                        <a href="#" class="btn btn-primary registration-trigger" 
                                                        data-type-id="5" 
                                                        data-session-id="{{ $consultSession->id }}">
                                                            CONSULTATION
                                                        </a>
                                                    @else
                                                        <button class="btn btn-primary" disabled>CONSULTATION</button>
                                                    @endif
                                                    @else
                                                        <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="btn btn-primary">GROUP Q/A</a>
                                                        <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="btn btn-primary">CONSULTATION</a>
                                                    @endif
                                            </div>
                                        </div>
                                        <!-- Modal: Group Q/A -->
                                         <!-- <div id="modal-qa" class="modal" onclick="closeModal(event, 'modal-qa')">
                                            <div class="card popup-content" onclick="event.stopPropagation();">
                                                <div class="plan_title">
                                                    <h2>Group Q/A</h2>
                                                </div>
                                                <div class="icon">
                                                    <img src="../images/icons/quality-service.png" />
                                                </div>
                                                <div class="price">
                                                    <p><span><sup class="context">R</sup></span> Free <span class="dur">/ session</span></p>
                                                </div>
                                                <div class="dscpt_container">
                                                    <div class="dscpt"><div class="tick"><img src="../images/icons/quality.png" /></div><div class="dscpt-p"><p>Live Q&A sessions</p></div></div>
                                                    <div class="dscpt"><div class="tick"><img src="../images/icons/quality.png" /></div><div class="dscpt-p"><p>Immediate feedback</p></div></div>
                                                    <div class="dscpt"><div class="tick"><img src="../images/icons/quality.png" /></div><div class="dscpt-p"><p>Submit questions via chat</p></div></div>
                                                    <div class="dscpt"><div class="tick"><img src="../images/icons/quality.png" /></div><div class="dscpt-p"><p>Various tech topics covered</p></div></div>
                                                </div>
                                                <div class="bttn">
                                                    @if(Auth::check())
                                                        <a href="#" class="registration-trigger" data-type-id="4">Register</a>
                                                    @else
                                                        <a href="{{ route('login', ['redirect' => url()->current()]) }}">Register</a>
                                                    @endif
                                                    <button onclick="document.getElementById('modal-session1').style.display='none'">Close</button>
                                                </div>
                                            </div>
                                        </div>  -->
                                        <!-- Modal: Consultation -->
                                        <!-- <div id="modal-consult" class="modal" onclick="closeModal(event, 'modal-consult')">
                                            <div class="card popup-content" onclick="event.stopPropagation();">
                                                <div class="plan_title">
                                                    <h2>Consultation</h2>
                                                </div>
                                                <div class="icon">
                                                    <img src="../images/icons/quality-service.png" />
                                                </div>
                                                <div class="price">
                                                    <p><span><sup class="context">R</sup></span> 130 <span class="dur">/ hour</span></p>
                                                </div>
                                                <div class="dscpt_container">
                                                    <div class="dscpt"><div class="tick"><img src="../images/icons/quality.png" /></div><div class="dscpt-p"><p>Detailed response to comments</p></div></div>
                                                    <div class="dscpt"><div class="tick"><img src="../images/icons/quality.png" /></div><div class="dscpt-p"><p>Programming support</p></div></div>
                                                    <div class="dscpt"><div class="tick"><img src="../images/icons/quality.png" /></div><div class="dscpt-p"><p>Cybersecurity guidance</p></div></div>
                                                    <div class="dscpt"><div class="tick"><img src="../images/icons/quality.png" /></div><div class="dscpt-p"><p>Skill-building sessions</p></div></div>
                                                </div>
                                                <div class="bttn">
                                                    @if(Auth::check())
                                                        <a href="#" class="registration-trigger" data-type-id="5">Register</a>
                                                    @else
                                                        <a href="{{ route('login', ['redirect' => url()->current()]) }}">Register</a>
                                                    @endif
                                                    <button onclick="document.getElementById('modal-session2').style.display='none'">Close</button>
                                                </div>
                                            </div>
                                        </div>  -->
                                    </div>
                                </div>
                            </div>
                        </div>
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

        <!-- Main Content Section -->
        <main class="main-container-pricing">
        <!-- Portfolio Showcase Section -->
        <section class="portfolio-showcase">
            <div class="background-elements">
                <div class="blue-wave"></div>
                <div class="light-circle"></div>
            </div>
            
            <div class="portfolio-container">
                <!-- Section Header -->
                <div class="portfolio-header">
                    <div class="section-badge">
                        <span>Our Creative Work</span>
                    </div>
                    <h2>See Our Work In Action</h2>
                    <p class="portfolio-description">
                        Explore our portfolio of stunning designs and innovative solutions that have helped clients achieve their goals.
                    </p>
                </div>

                <!-- Poster Design Showcase -->
                <div class="showcase-section">
                    <div class="showcase-header">
                        <h3>Creative Poster Designs</h3>
                        <p>Eye-catching designs that communicate effectively and engage audiences</p>
                    </div>
                    <div class="poster-grid">
                        <div class="poster-item">
                            <div class="poster-frame">
                                <img src="@secureAsset('/images/AI-Potential.jpeg')" alt="Creative Poster Design 1" class="poster-image">
                                <div class="poster-overlay">
                                    <div class="overlay-content">
                                        <h4>Tech Innovation Poster</h4>
                                        <p>Modern design for tech</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="poster-item">
                            <div class="poster-frame">
                                <img src="@secureAsset('/images/TS-resume.jpeg')" alt="Creative Poster Design 2" class="poster-image">
                                <div class="poster-overlay">
                                    <div class="overlay-content">
                                        <h4>Education & Resume creation</h4>
                                        <p>Engaging educational material & Resemuse assistance</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="poster-item">
                            <div class="poster-frame">
                                <img src="@secureAsset('/images/TS-helloMonday.jpeg')" alt="Creative Poster Design 3" class="poster-image">
                                <div class="poster-overlay">
                                    <div class="overlay-content">
                                        <h4>Casual Posts</h4>
                                        <p>Engaging & fun posts with TechnoSpeak</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="poster-item">
                            <div class="poster-frame">
                                <img src="@secureAsset('/images/TS-deliverTech.jpeg')" alt="Creative Poster Design 4" class="poster-image">
                                <div class="poster-overlay">
                                    <div class="overlay-content">
                                        <h4>Tips & Tricks</h4>
                                        <p>Deliver free helpful videos</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Website Design Showcase - Section 1 -->
                <div class="showcase-section website-showcase">
                    <div class="showcase-header">
                        <h3>Website Development Projects</h3>
                        <p>Responsive, user-friendly websites built with modern technologies</p>
                    </div>
                    <div class="website-grid">
                        <div class="website-item">
                            <div class="browser-mockup">
                                <div class="browser-header">
                                    <div class="browser-dots">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </div>
                                <a href="https://www.chippexstravel.co.za/" target="_blank" rel="noopener noreferrer">
                                    <img src="@secureAsset('/images/chippexTravel.png')" alt="Website Project 1" class="website-image">
                                </a>
                            </div>
                            <div class="website-info">
                                <h4>E-Commerce Platform</h4>
                                <p>Full-stack traveling website solution with payment integration.</p>
                                <div class="tech-tags">
                                    <span>React</span>
                                    <span>Node.js</span>
                                    <span>MongoDB</span>
                                </div>
                            </div>
                        </div>
                        <div class="website-item">
                            <div class="browser-mockup">
                                <div class="browser-header">
                                    <div class="browser-dots">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </div>
                                <a href="https://nkosimbewelawgroup.co.za/" target="_blank" rel="noopener noreferrer">
                                    <img src="@secureAsset('/images/nkosimbewe.png')" alt="Website Project 2" class="website-image">
                                </a>
                            </div>
                            <div class="website-info">
                                <h4>Corporate Law Business</h4>
                                <p>Legal matter handle website, with valuable information.</p>
                                <div class="tech-tags">
                                    <span>PHP</span>
                                    <span>Laravel</span>
                                    <span>MySQL</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Website Design Showcase - Section 2 -->
                <div class="showcase-section website-showcase">
                    <div class="showcase-header">
                        <h3>Web Applications</h3>
                        <p>Interactive web applications with seamless user experiences</p>
                    </div>
                    <div class="website-grid">
                        <div class="website-item">
                            <div class="browser-mockup">
                                <div class="browser-header">
                                    <div class="browser-dots">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </div>
                                <a href="https://mbewegroup.co.za/" target="_blank" rel="noopener noreferrer">
                                    <img src="@secureAsset('/images/mbewegroup.png')" alt="Website Project 3" class="website-image">
                                </a>
                            </div>
                            <div class="website-info">
                                <h4>Law, Property, Financial & Car Hire website</h4>
                                <p>Handling all the legal & financial matter that matter in daily life.</p>
                                <div class="tech-tags">
                                    <span>PHP</span>
                                    <span>MySql</span>
                                    <span>HTML, CSS</span>
                                </div>
                            </div>
                        </div>
                        <div class="website-item">
                            <div class="browser-mockup">
                                <div class="browser-header">
                                    <div class="browser-dots">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </div>
                                <a href="https://africantravelogue.co.za/" target="_blank" rel="noopener noreferrer">
                                    <img src="@secureAsset('/images/africanTravel.png')" alt="Website Project 4" class="website-image">
                                </a>
                            </div>
                            <div class="website-info">
                                <h4>African Experience Traveling website</h4>
                                <p>Explore the beautiful countries in Africa with exciting activities.</p>
                                <div class="tech-tags">
                                    <span>PHP</span>
                                    <span>MySql</span>
                                    <span>HTML, CSS</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Website Design Showcase - Section 3 -->
                <!-- <div class="showcase-section website-showcase">
                    <div class="showcase-header">
                        <h3>Mobile-First Solutions</h3>
                        <p>Optimized experiences for all devices and screen sizes</p>
                    </div>
                    <div class="website-grid"> 
                        <div class="website-item">
                            <div class="browser-mockup">
                                <div class="browser-header">
                                    <div class="browser-dots">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </div>
                                <img src="../images/portfolio/website5.jpg" alt="Website Project 5" class="website-image">
                            </div>
                            <div class="website-info">
                                <h4>Travel Booking Platform</h4>
                                <p>Mobile-first travel booking experience</p>
                                <div class="tech-tags">
                                    <span>React Native</span>
                                    <span>Express.js</span>
                                    <span>Redis</span>
                                </div>
                            </div>
                        </div>
                        <div class="website-item">
                            <div class="browser-mockup">
                                <div class="browser-header">
                                    <div class="browser-dots">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </div>
                                <img src="../images/portfolio/website6.jpg" alt="Website Project 6" class="website-image">
                            </div>
                            <div class="website-info">
                                <h4>Health & Fitness App</h4>
                                <p>Wellness platform with tracking features</p>
                                <div class="tech-tags">
                                    <span>Flutter</span>
                                    <span>Django</span>
                                    <span>SQLite</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->

                <!-- Call to Action -->
                <div class="portfolio-cta">
                    <div class="cta-content">
                        <h3>Ready to Start Your Project?</h3>
                        <p>Let's create something amazing together. Get in touch to discuss your ideas.</p>
                        <div class="cta-buttons">
                            <a href="#contact" class="btn btn-primary">Start Your Project</a>
                            <a href="#portfolio" class="btn btn-secondary">View More Work</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

            <!-- Ask Questions -->
            <div class="question-container">
                <div class="question-box">
                    <h2 class="question-title">Real Questions. Real Answers.</h2>
                    
                    <!-- Form with proper attributes but hidden -->
                    <form id="questionForm" action="" method="POST" style="display: none;">
                        @csrf
                        <input type="email" name="email" id="formEmail" required>
                        <textarea name="question" id="formQuestion" required></textarea>
                    </form>

                    <div class="input-group">
                        <input type="email" placeholder="Enter your email" class="input-field" id="questionEmail"/>
                        <div class="error-message" id="email-error" style="color: red; display: none; font-size: 12px; margin-top: 5px;"></div>
                        
                        <textarea placeholder="Write your question here..." class="input-field message-field" rows="3" id="questionText"></textarea>
                        <div class="error-message" id="question-error" style="color: red; display: none; font-size: 12px; margin-top: 5px;"></div>
                    </div>
                    
                    <svg class="arrow" viewBox="0 0 100 50" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5,25 Q30,15 50,25 T95,25" stroke="white" stroke-width="2" fill="none" marker-end="url(#arrowhead)"/>
                        <defs>
                            <marker id="arrowhead" markerWidth="10" markerHeight="7" refX="9" refY="3.5" orient="auto">
                            <polygon points="0 0, 10 3.5, 0 7" fill="white"/>
                            </marker>
                        </defs>
                    </svg>
                    
                    <button class="send-btn" id="questionSubmitBtn">
                        Send Question
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22 2L11 13" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M22 2L15 22L11 13L2 9L22 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>

                    <div class="circle circle1"></div>
                    <div class="circle circle2"></div>
                    <div class="circle circle3"></div>
                </div>
            </div>

            <!-- Footer Section -->
            {{-- Include the footer --}}
            @include('layouts.footer')
        </main>

        <!-- Ask Question script -->
        <!-- <script>
            function submitQuestion() {
            const email = document.querySelector('input[type="email"]').value;
            const question = document.querySelector('input[type="text"]').value;
            if (email && question) {
                alert(`Email: ${email}\nQuestion: ${question}`);
            } else {
                alert('Please fill in both fields.');
            }
            }
        </script> -->

        <!-- Price modals -->
        <script>
            function closeModal(e, id) {
                if (e.target.id === id) {
                    document.getElementById(id).style.display = 'none';
                }
            }
            function openModal(id) {
                document.getElementById(id).style.display = 'flex';
            }
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
                
                // Close modal handlers (keep your existing ones)
                function closeModal(event, modalId) {
                    event.stopPropagation();
                    document.getElementById(modalId).style.display = 'none';
                    document.body.classList.remove('no-scroll');
                }
            });
        </script>

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

        <script src="script/pricing.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="script/pop-up.js"></script>
    </body>

    <!-- Style for Modal -->
    <style>
        .session-registration-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            display: none;
            justify-content: center;
            align-items: center;
        }

        .session-registration-modal .modal-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
        }

        .session-registration-modal .modal-content {
            position: relative;
            background: white;
            padding: 2rem;
            border-radius: 10px;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            z-index: 10000;
        }

        .session-registration-modal .close-modal {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 1.5rem;
            background: none;
            border: none;
            cursor: pointer;
            color: #333;
        }

        .session-registration-modal .form-group {
            margin-bottom: 1rem;
            width: 100%;
        }

        .session-registration-modal .form-group label {
            display: block;
            margin-bottom: 0.5rem;
        }

        .session-registration-modal .form-group input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .session-registration-modal .submit-btn {
            background-color: #38b6ff;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            width: 100%;
            margin-top: 1rem;
        }

        .no-scroll {
            overflow: hidden;
        }
    </style>

    <!-- Ask Question validation handle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('questionEmail');
            const questionInput = document.getElementById('questionText');
            const emailError = document.getElementById('email-error');
            const questionError = document.getElementById('question-error');
            const submitBtn = document.getElementById('questionSubmitBtn');
            const formEmail = document.getElementById('formEmail');
            const formQuestion = document.getElementById('formQuestion');

            // Track validation state
            let isEmailValid = false;
            let isQuestionValid = false;

            // Validation functions
            function validateEmail() {
                const email = emailInput.value.trim();
                
                // Clear previous error
                emailError.style.display = 'none';
                
                if (!email) {
                    emailError.textContent = 'Email address is required';
                    emailError.style.display = 'block';
                    isEmailValid = false;
                    updateSubmitButton();
                    return false;
                }
                
                // Check for proper email format with domain and TLD
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
                if (!emailRegex.test(email)) {
                    emailError.textContent = 'Please enter a valid email address';
                    emailError.style.display = 'block';
                    isEmailValid = false;
                    updateSubmitButton();
                    return false;
                }
                
                // Check domain part has at least one dot
                const domainPart = email.split('@')[1];
                if (!domainPart.includes('.')) {
                    emailError.textContent = 'Please enter a valid email address';
                    emailError.style.display = 'block';
                    isEmailValid = false;
                    updateSubmitButton();
                    return false;
                }
                
                // Check for test/invalid domains
                const invalidDomains = ['test', 'example', 'localhost', 'invalid'];
                const domain = domainPart.toLowerCase();
                const hasInvalidDomain = invalidDomains.some(invalid => 
                    domain.includes(invalid) || domain === invalid
                );
                
                if (hasInvalidDomain) {
                    emailError.textContent = 'Please use a valid email address';
                    emailError.style.display = 'block';
                    isEmailValid = false;
                    updateSubmitButton();
                    return false;
                }
                
                // Email is valid
                isEmailValid = true;
                updateSubmitButton();
                return true;
            }

            function validateQuestion() {
                const question = questionInput.value.trim();
                
                // Clear previous error
                questionError.style.display = 'none';
                
                if (!question) {
                    questionError.textContent = 'Question is required';
                    questionError.style.display = 'block';
                    isQuestionValid = false;
                    updateSubmitButton();
                    return false;
                }
                
                // Check if question has minimum length
                if (question.length < 10) {
                    questionError.textContent = 'Question must be at least 10 characters long';
                    questionError.style.display = 'block';
                    isQuestionValid = false;
                    updateSubmitButton();
                    return false;
                }
                
                // Check if question is too long
                if (question.length > 500) {
                    questionError.textContent = 'Question must be less than 500 characters';
                    questionError.style.display = 'block';
                    isQuestionValid = false;
                    updateSubmitButton();
                    return false;
                }
                
                // Question is valid
                isQuestionValid = true;
                updateSubmitButton();
                return true;
            }

            function updateSubmitButton() {
                // Only enable button when BOTH fields are valid
                if (isEmailValid && isQuestionValid) {
                    submitBtn.disabled = false;
                    submitBtn.style.opacity = '1';
                    submitBtn.style.cursor = 'pointer';
                } else {
                    submitBtn.disabled = true;
                    submitBtn.style.opacity = '0.6';
                    submitBtn.style.cursor = 'not-allowed';
                }
            }

            // Real-time validation
            emailInput.addEventListener('input', function() {
                validateEmail();
            });

            emailInput.addEventListener('blur', function() {
                validateEmail();
            });

            questionInput.addEventListener('input', function() {
                validateQuestion();
            });

            questionInput.addEventListener('blur', function() {
                validateQuestion();
            });

            // Handle button click
            submitBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Final validation before submission
                const emailValid = validateEmail();
                const questionValid = validateQuestion();
                
                // If anything is invalid, STOP here
                if (!emailValid || !questionValid) {
                    // Scroll to first error
                    if (!emailValid) {
                        emailInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        emailInput.focus();
                    } else {
                        questionInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        questionInput.focus();
                    }
                    
                    alert('Please fix the errors before sending your question.');
                    return false;
                }
                
                // Update the hidden form fields
                if (formEmail && formQuestion) {
                    formEmail.value = emailInput.value.trim();
                    formQuestion.value = questionInput.value.trim();
                    
                    // Submit the form
                    document.getElementById('questionForm').submit();
                } else {
                    alert('Form submission error. Please try again.');
                }
            });

            // Initialize submit button state
            updateSubmitButton();
        });
    </script>

</html>