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
                                                    <p>Comment section Q&A</p>
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
            <!-- One-on-One Sessions Section -->
            <section class="session-section1">
                <div class="section-background1">
                    <div class="bubble bubble-top-left"></div>
                    <div class="bubble bubble-bottom-right"></div>
                </div>
                
                <div class="session-container1">
                    <!-- Video Demo -->
                    <div class="video-demo1">
                        <div class="device-mockup1">
                            <div class="device-frame1">
                                <div class="device-screen1">
                                    <div class="video-placeholder1">
                                        <div class="play-button1">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="device-notch1"></div>
                        </div>
                    </div>

                    <!-- Session Details -->
                    <div class="session-details1">
                        <div class="section-badge1">
                            <span>Premium Service</span>
                        </div>
                        <h2>Personalised One-on-One Sessions</h2>
                        <p class="session-description1">
                            Get dedicated, customized learning with our expert instructors. Our one-on-one sessions provide:
                        </p>
                        <ul class="session-features1">
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                                </svg>
                                <span>Tailored curriculum based on your needs</span>
                            </li>
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                                </svg>
                                <span>Flexible scheduling at your convenience</span>
                            </li>
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                                </svg>
                                <span>Direct feedback and Q&A with experts</span>
                            </li>
                        </ul>

                        <div class="session-meta1">
                            <div class="meta-item1">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.31-8.86c-1.77-.45-2.34-.94-2.34-1.67 0-.84.79-1.43 2.1-1.43 1.38 0 1.9.66 1.94 1.64h1.71c-.05-1.34-.87-2.57-2.49-2.97V5H10.9v1.69c-1.51.32-2.72 1.3-2.72 2.81 0 1.79 1.49 2.69 3.66 3.21 1.95.46 2.34 1.15 2.34 1.87 0 .53-.39 1.39-2.1 1.39-1.6 0-2.23-.72-2.32-1.64H8.04c.1 1.7 1.36 2.66 2.86 2.97V19h2.34v-1.67c1.52-.29 2.72-1.16 2.73-2.77-.01-2.2-1.9-2.96-3.66-3.42z"/>
                                </svg>
                                <div>
                                    <span class="meta-label1">Starting from</span>
                                    <span class="meta-value1">R110/hour (R210 for business)</span>
                                </div>
                            </div>
                            <div class="meta-item1">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                                </svg>
                                <div>
                                    <span class="meta-label1">Duration</span>
                                    <span class="meta-value1">60-90 minutes</span>
                                </div>
                            </div>
                        </div>

                        <button class="register-btn1" id="openPersonalGuideModalSession" type="button">
                            <span>Schedule Your Session</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
                            </svg>
                        </button>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                var btn = document.getElementById("openPersonalGuideModalSession");
                                if (btn) {
                                    btn.onclick = function(event) {
                                        event.preventDefault();
                                        var modal = document.getElementById("personalGuideModalUnique");
                                        if (modal) {
                                            modal.style.display = "block";
                                            document.body.style.overflow = "hidden";
                                            document.body.style.position = "fixed";
                                            document.body.style.width = "100%";
                                        }
                                    };
                                }
                            });
                        </script>
                    </div>
                </div>
            </section>

            <!-- Live Sessions Section -->
            <section class="live-sessions">
                <div class="background-elements">
                    <div class="blue-wave"></div>
                    <div class="light-circle"></div>
                </div>
                
                <div class="container">
                    <!-- Left: Content Card -->
                    <div class="info-card">
                        <div class="card-badge">
                            <span>Interactive Learning</span>
                        </div>
                        <h2>Join Our Live Q&A Sessions</h2>
                        <p class="card-description">
                            Experience real-time learning with industry professionals. Our live sessions offer:
                        </p>
                        <ul class="features-list">
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm4.59-12.42L10 14.17l-2.59-2.58L6 13l4 4 8-8z"/>
                                </svg>
                                <span>Direct interaction with instructors</span>
                            </li>
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm4.59-12.42L10 14.17l-2.59-2.58L6 13l4 4 8-8z"/>
                                </svg>
                                <span>Practical, hands-on demonstrations</span>
                            </li>
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm4.59-12.42L10 14.17l-2.59-2.58L6 13l4 4 8-8z"/>
                                </svg>
                                <span>Q&A and community discussions</span>
                            </li>
                        </ul>

                        <div class="session-details">
                            <div class="detail-item">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.31-8.86c-1.77-.45-2.34-.94-2.34-1.67 0-.84.79-1.43 2.1-1.43 1.38 0 1.9.66 1.94 1.64h1.71c-.05-1.34-.87-2.57-2.49-2.97V5H10.9v1.69c-1.51.32-2.72 1.3-2.72 2.81 0 1.79 1.49 2.69 3.66 3.21 1.95.46 2.34 1.15 2.34 1.87 0 .53-.39 1.39-2.1 1.39-1.6 0-2.23-.72-2.32-1.64H8.04c.1 1.7 1.36 2.66 2.86 2.97V19h2.34v-1.67c1.52-.29 2.72-1.16 2.73-2.77-.01-2.2-1.9-2.96-3.66-3.42z"/>
                                </svg>
                                <div>
                                    <span class="detail-label">Starting from</span>
                                    <span class="detail-value">Free/session</span>
                                </div>
                            </div>
                            <div class="detail-item">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                                </svg>
                                <div>
                                    <span class="detail-label">Duration</span>
                                    <span class="detail-value">60-90 minutes</span>
                                </div>
                            </div>
                        </div>

                        @if(Auth::check())
                            @if($qaSession)
                                <a href="#" class="register-btn registration-trigger"
                                   data-type-id="4"
                                   data-session-id="{{ $qaSession->id }}">
                                    <span>Reserve Your Spot</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
                                    </svg>
                                </a>
                            @else
                                <button class="register-btn" type="button" onclick="Swal.fire('No session available', 'There are currently no live Q/A sessions available. Please check back later.', 'info');">
                                    <span>Reserve Your Spot</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
                                    </svg>
                                </button>
                            @endif
                        @else
                            <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="register-btn">
                                <span>Reserve Your Spot</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
                                </svg>
                            </a>
                        @endif
                    </div>

                    <!-- Right: Media Section -->
                    <div class="media-section">
                        <div class="laptop-mockup">
                            <div class="laptop-screen">
                                <div class="video-container">
                                    <div class="play-overlay">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="laptop-base"></div>
                        </div>

                        <div class="social-platforms">
                            <h3 class="platforms-title">Follow us for updates</h3>
                            <div class="platform-icons">
                                <a href="https://www.tiktok.com/@everything.tips8" aria-label="TikTok" class="platform-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                    </svg>
                                </a>
                                <a href="https://www.youtube.com/@TechnoSpeak-j3f" aria-label="YouTube" class="platform-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M10 16.5l6-4.5-6-4.5v9zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                                    </svg>
                                </a>
                                <a href="https://www.facebook.com/profile.php?id=61575880092292&mibextid=rS40aB7S9Ucbxw6v" aria-label="Facebook" class="platform-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                                    </svg>
                                </a>
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