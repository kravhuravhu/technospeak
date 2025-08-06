<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $course->title }} | Detailed View</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="TechnoSpeak">
    <meta http-equiv="Content-Security-Policy" content="child-src 'none'">
    <link rel="icon" href="{{ asset('/images/icon.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary-color: #38b6ff;
            --primary-dark: #005c91;
            --danger-color: #e53e3e;
            --danger-dark: #a72828;
            --success-color: #48bb78;
            --text-dark: #062644;
            --text-medium: #2d3748;
            --text-light: #718096;
            --bg-light: #e4f4ff;
            --border-light: #ecf5ff;
            --shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            line-height: 1.6;
            color: var(--text-medium);
            background-color: #f8fafc;
            background-image: url("../images/75xPHEQBmvA2.jpg");
            background-size: inherit;
            background-repeat: no-repeat;
            background-position: center;
            & > .main-cont-enrolled {
                background-color: #ffffffc2;
                height: fit-content;
            }
        }
        
        .course-show-container {
            max-width: 85%;
            margin: 0 auto;
            padding: 30px;
        
            .course-header {
                margin-bottom: 30px;
            }
            
            .course-header-top {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 30px;
                gap: 20px;
                flex-wrap: wrap;
            }
            
            .course-info {
                flex: 1;
                min-width: 300px;
            }
            
            .title-meta-container h1 {
                font-size: 28px;
                margin-bottom: 10px;
                color: var(--text-dark);
            }
            
            .course-meta {
                display: flex;
                gap: 15px;
                color: var(--text-light);
                font-size: 14px;
                flex-wrap: wrap;
            }
            
            .course-meta i {
                margin-right: 5px;
                color: var(--primary-color);
            }
            
            .course-actions {
                display: flex;
                flex-direction: row;
                gap: 10px;
                align-self: end;
                flex-wrap: wrap;
            }
            
            .btn {
                border: none;
                font-size: 16px;
                cursor: pointer;
                padding: 15px 20px;
                border-radius: 50px;
                transition: all 0.3s ease;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                white-space: nowrap;
            }
            
            .btn i {
                margin-right: 8px;
            }
            
            .back-btn {
                background-color: var(--primary-color);
                color: #ebebeb;
            }
            
            .back-btn:hover {
                background-color: var(--primary-dark);
                transform: translateY(-1px);
            }
            
            .unenroll-btn {
                background-color: var(--danger-color);
                color: #fff;
            }
            
            .unenroll-btn:hover {
                background-color: var(--danger-dark);
                transform: translateY(-1px);
            }
            
            .course-content {
                display: flex;
                gap: 30px;
            }
            
            .course-video {
                flex: 2;
                min-width: 0;
            }
            
        
            .video-container {
            background: #000;
            border-radius: 8px;
            overflow: hidden;
            aspect-ratio: 16/9;
            margin-bottom: 20px;
            position: relative;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Video element styling */
        .video-container video {
            width: 100%;
            height: 100%;
            display: block;
            background-color: #000;
        }

        /* Custom controls container */
        .custom-video-controls {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
            padding: 10px;
            display: flex;
            flex-direction: column;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 10;
        }

        .video-container:hover .custom-video-controls {
            opacity: 1;
        }

        /* right bar */
        .progress-container-rt, 
        .episodes-list {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: var(--shadow);
            margin-bottom: 25px;
        }

        /* Progress bar styling */
        .progress-container {
            width: 100%;
            height: 6px;
            background: rgba(255, 255, 255, 0.2);
            margin-bottom: 8px;
            cursor: pointer;
            border-radius: 3px;
        }

        .progress-bar {
            height: 100%;
            background: #38b6ff;
            border-radius: 3px;
            position: relative;
            width: 0%;
        }

        .progress-bar::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 12px;
            height: 12px;
            background: #062644;
            border-radius: 50%;
            opacity: 0;
            transition: opacity 0.2s;
        }

        .progress-container:hover .progress-bar::after {
            opacity: 1;
        }

        /* Controls bar */
        .controls-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .left-controls, .right-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Button styling */
        .control-btn {
            background: none;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
            padding: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0.9;
            transition: opacity 0.2s;
        }

        .control-btn:hover {
            opacity: 1;
        }

        /* Time display */
        .time-display {
            color: white;
            font-size: 14px;
            font-family: 'Roboto', sans-serif;
            margin: 0 5px;
        }

        /* Volume control */
        .volume-container {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .volume-slider {
            width: 70px;
            height: 4px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
            cursor: pointer;
            opacity: .7;
            transition: width 0.2s, opacity 0.2s;
        }

        .volume-container:hover .volume-slider {
            opacity: 1;
            width: 100px;
        }

        .volume-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 12px;
            height: 12px;
            background: #f00;
            border-radius: 50%;
            cursor: pointer;
        }

        /* Fullscreen button */
        .fullscreen-btn {
            margin-right: 5px;
        }

        /* Loading spinner */
        .loading-spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50px;
            height: 50px;
            border: 5px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: var(--primary-color);
            animation: spin 1s ease-in-out infinite;
            z-index: 5;
        }

        .video-placeholder {
            position: relative;
            width: 100%;
            height: 100%;
            animation: fadeIn 0.3s ease-in;
        }

        .video-thumb {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.3);
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            cursor: pointer;
            transition: background 0.3s;
            z-index: 2;
        }

        .overlay:hover {
            background: rgba(0, 0, 0, 0.5);
        }

        .overlay i {
            font-size: 50px;
            margin-bottom: 15px;
            color: #e2e8f0;
            transition: transform 0.3s;
        }

        .overlay:hover i {
            transform: scale(1.1);
        }
            
        .video-description h3 {
            font-size: 20px;
            margin-bottom: 15px;
            color: var(--text-dark);
        }
        
        .video-description p {
            color: var(--text-light);
            line-height: 1.6;
            margin-bottom: 25px;
        }
        
        .instructor-info h4 {
            font-size: 18px;
            margin-bottom: 15px;
            color: var(--text-dark);
        }
        
        .instructor-details {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .instructor-avatar img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .instructor-text h5 {
            margin: 0;
            font-size: 16px;
            color: var(--text-dark);
        }
        
        .instructor-text p {
            margin: 5px 0 0;
            font-size: 14px;
            color: var(--text-light);
        }
        
        .course-sidebar {
            flex: 1;
            max-width: 350px;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .progress-header h3 {
            margin: 0;
            font-size: 18px;
            color: var(--text-medium);
        }
        
        .progress-percent {
            font-weight: bold;
            color: var(--primary-color);
        }
        
        .mark-complete-btn {
            background-color: var(--primary-color);
            color: #eefefe;
            width: 100%;
        }
        
        .mark-complete-btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
        }
        
        .episodes-list h3 {
            margin: 0 0 15px;
            font-size: 18px;
            color: var(--text-medium);
        }
        
        #course-episodes-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .episode-item {
            display: flex;
            align-items: center;
            padding: 12px 5px;
            border-bottom: 1px solid var(--border-light);
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .episode-item:last-child {
            border-bottom: none;
        }
        
        .episode-item:hover {
            background: var(--bg-light);
        }
        
        .episode-item.active {
            background: var(--bg-light);
            border-left: 3px solid var(--primary-color);
            padding-left: 10px;
        }
        
        .episode-item.completed .episode-number {
            background: var(--text-dark);
            color: white;
        }
        
        .episode-item.completed .episode-info h4 {
            color: var(--primary-color);
        }
        
        .episode-number {
            width: 40px;
            height: 40px;
            background-color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 15px;
            color: #f1f1f1;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }
        
        .episode-info {
            flex: 1;
            min-width: 0;
        }
        
        .episode-info h4 {
            margin: 0 0 5px;
            font-size: 15px;
            color: var(--text-medium);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .episode-info p {
            margin: 0;
            font-size: 13px;
            color: var(--text-light);
        }
        
        .fa-check-circle {
            color: var(--border-light);
            margin-left: 10px;
            flex-shrink: 0;
        }
        
        @media (max-width: 1024px) {
            .course-show-container {
                max-width: 90%;
                padding: 20px;
            }
        }
        
        @media (max-width: 768px) {
            .course-show-container {
                max-width: 100%;
                padding: 15px;
            }
            
            .course-content {
                flex-direction: column;
            }
            
            .course-sidebar {
                max-width: 100%;
            }
            
            .course-header-top {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .course-actions {
                align-self: flex-start;
                margin-top: 15px;
            }
        }
        
        .loading-spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50px;
            height: 50px;
            border: 5px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: var(--primary-color);
            animation: spin 1s ease-in-out infinite;
        }
        
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--text-dark);
            color: white;
            padding: 15px 25px;
            border-radius: 5px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 1000;
        }
        
        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }
        }

        .course-tabs {
            display: flex;
            border-bottom: 1px solid var(--border-light);
            margin-bottom: 20px;
        }
        
        .tab-btn {
            padding: 10px 20px;
            background: none;
            border: none;
            border-bottom: 3px solid transparent;
            cursor: pointer;
            font-weight: 500;
            color: var(--text-light);
            transition: all 0.3s ease;
        }
        
        .tab-btn.active {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .episode-item.completed {
            opacity: 0.7;
            border-left: 4px solid var(--success-color);
        }
        
        .episode-item.completed .episode-number {
            background-color: var(--success-color);
        }

        .episode-item.completed .episode-info p::after {
            content: " - Watched";
            color: var(--success-color);
            font-weight: 400;
            font-style: italic;
        }
        
        .rating-stars {
            color: gold;
            font-size: 24px;
        }
        
        .resource-item {
            padding: 15px;
            border: 1px solid var(--border-light);
            border-radius: 8px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            transition: all 0.2s ease;
            box-shadow: var(--shadow);
        }
        
        .resource-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .resource-info {
            flex: 1;
        }
        
        .resource-info h4 {
            margin: 0 0 5px;
            color: var(--text-dark);
        }
        
        .resource-info p {
            margin: 0;
            color: var(--text-light);
            font-size: 14px;
        }
        
        .resource-meta {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: var(--text-light);
        }
        
        .resource-icon {
            font-size: 24px;
            margin-right: 15px;
            color: var(--primary-color);
        }
        
        .resource-download-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 14px;
        }
        
        .resource-download-btn:hover {
            background-color: var(--primary-dark);
        }
        
        .resource-type-badge {
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            background-color: #e6f7ff;
            color: var(--primary-dark);
        }

        .comments-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: var(--shadow);
            margin-bottom: 20px;
        }

        #comment-form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border-light);
            border-radius: 4px;
            margin-bottom: 10px;
            min-height: 100px;
        }

        .certificate-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: var(--shadow);
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .certificate-header {
            margin-bottom: 20px;
        }
        
        .certificate-header h3 {
            font-size: 28px;
            color: var(--text-dark);
            margin-bottom: 10px;
        }
        
        .certificate-header p {
            color: var(--text-light);
            font-size: 16px;
        }
        
        .certificate-preview {
            border: 1px solid var(--border-light);
            border-radius: 8px;
            margin: 20px 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        
        .certificate-preview img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .certificate-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin: 20px 0;
            text-align: left;
        }
        
        .certificate-detail-item {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 8px;
        }
        
        .certificate-detail-item h4 {
            margin: 0 0 5px;
            font-size: 14px;
            color: var(--text-light);
        }
        
        .certificate-detail-item p {
            margin: 0;
            font-size: 16px;
            color: var(--text-dark);
            font-weight: 500;
        }
        
        .certificate-actions {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        .certificate-btn {
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            text-decoration: none;
        }
        
        .certificate-download {
            background-color: var(--primary-color);
            color: white;
            border: none;
            cursor: pointer;
        }
        
        .certificate-download:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        .certificate-share {
            background-color: white;
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
            cursor: pointer;
        }
        
        .certificate-share:hover {
            background-color: var(--bg-light);
            transform: translateY(-2px);
        }

        .course-rating {
            margin-top: 30px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: var(--shadow);
        }

        .rating-display {
            margin-bottom: 20px;
        }

        .stars {
            display: inline-flex;
            gap: 2px;
        }

        .stars i {
            color: gold;
            font-size: 20px;
        }

        .star-rating {
            margin: 10px 0;
            font-size: 24px;
        }

        .star-rating i {
            cursor: pointer;
            transition: all 0.2s;
        }

        .star-rating i:hover {
            transform: scale(1.2);
        }

        #rating-review {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border-light);
            border-radius: 4px;
            min-height: 80px;
            margin-bottom: 10px;
        }

        #submit-rating, #edit-rating {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s;
        }

        #submit-rating:hover, #edit-rating:hover {
            background: var(--primary-dark);
        }

        .average-rating {
            margin-bottom: 10px;
            font-size: 16px;
        }

        .average-rating .stars {
            vertical-align: middle;
        }

        #average-score {
            font-weight: bold;
            margin: 0 5px;
        }

        .all-reviews-container {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--border-light);
        }

        .review-item {
            margin-bottom: 20px;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 8px;
            position: relative;
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .review-user {
            display: flex;
            align-items: center;
        }

        .review-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
        }

        .review-user-name {
            font-weight: 500;
            color: var(--text-dark);
        }

        .review-stars {
            color: gold;
            margin-right: 40px;
        }

        .review-date {
            font-size: 12px;
            color: var(--text-light);
            margin-bottom: 10px;
        }

        .review-content {
            line-height: 1.5;
            color: var(--text-medium);
        }

        .edit-review-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            background: none;
            border: none;
            color: var(--text-light);
            cursor: pointer;
            font-size: 14px;
            transition: color 0.2s;
        }

        .edit-review-btn:hover {
            color: var(--primary-color);
        }

        .editable-review {
            border: 1px solid var(--border-light);
            padding: 10px;
            margin-top: 10px;
            border-radius: 4px;
            background: white;
        }

        .edit-review-actions {
            margin-top: 10px;
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .edit-review-actions button {
            padding: 5px 10px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }

        .save-review-btn {
            background: var(--success-color);
            color: white;
        }

        .cancel-review-btn {
            background: var(--danger-color);
            color: white;
        }

        .current-user-review {
            background-color: #e6f7ff;
            border-left: 3px solid var(--primary-color);
        }
        
        .no-resources, .no-certificate {
            text-align: center;
            padding: 40px 20px;
            background: white;
            border-radius: 8px;
            box-shadow: var(--shadow);
        }
        
        .no-resources i, .no-certificate i {
            font-size: 50px;
            color: var(--text-light);
            margin-bottom: 15px;
        }
        
        .no-resources h3, .no-certificate h3 {
            color: var(--text-dark);
            margin-bottom: 10px;
        }
        
        .no-resources p, .no-certificate p {
            color: var(--text-light);
            margin-bottom: 20px;
        }
        
        .resources-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .resources-count {
            color: var(--text-light);
            font-size: 14px;
        }
        
        .resources-filter {
            display: flex;
            gap: 10px;
        }
        
        .filter-btn {
            padding: 8px 15px;
            border-radius: 50px;
            border: 1px solid var(--border-light);
            background: white;
            color: var(--text-medium);
            cursor: pointer;
            transition: all 0.3s;
            font-size: 14px;
        }
        
        .filter-btn.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        
        .filter-btn:hover:not(.active) {
            background: #f5f5f5;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeOut {
            to {
                opacity: 0;
                visibility: hidden;
                transform: translateY(-10px);
            }
        }
        
        @keyframes spin {
            to { transform: translate(-50%, -50%) rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="main-cont-enrolled">
        <div class="course-show-container">
            <div class="course-header">
                <div class="course-header-top">
                    <div class="course-info">
                        <div class="title-meta-container">
                            <h1>{{ $course->title }}</h1>
                        </div>
                        <div class="course-meta">
                            <span><i class="fas fa-tag"></i> {{ $course->category?->name }}</span>
                            <span><i class="fas fa-signal"></i> {{ $course->level }}</span>
                            <span><i class="far fa-clock"></i> {{ $course->formatted_duration }}</span>
                        </div>
                    </div>
                    <div class="course-actions">
                        <button class="btn back-btn" onclick="window.location.href='/dashboard'">
                            <i class="fas fa-arrow-left"></i> Back to Dashboard
                        </button>
                        <form action="{{ route('enrolled-courses.destroy', $course->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn unenroll-btn" id="unenroll-btn">
                                <i class="fas fa-times-circle"></i> Unenroll
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="course-tabs">
                <button class="tab-btn active" data-tab="episodes">Episodes</button>
                <button class="tab-btn" data-tab="resources">Resources</button>
                @if($certificate)
                    <button class="tab-btn" data-tab="certificate">Certificate</button>
                @endif
            </div>

            <div class="tab-content active" id="episodes-tab">     
                <div class="course-content">
                    <div class="course-video">
                        <div class="video-container" id="video-container">
                            <div class="video-placeholder" id="video-placeholder">
                                <img src="{{ $course->thumbnail }}" alt="Course Thumbnail" class="video-thumb" />
                                <div class="overlay" id="video-overlay">
                                    <i class="fas fa-play-circle"></i>
                                    <p>Select an episode to start watching</p>
                                </div>
                            </div>
                        </div>
                        <div class="video-description">
                            <h3>About This Course</h3>
                            <p>{{ $course['description'] }}</p>
                            
                            <div class="instructor-info">
                                <h4>Instructor</h4>
                                <div class="instructor-details">
                                    <div class="instructor-avatar">
                                        <img src="{{ $course->instructor->thumbnail }}" alt="Instructor {{ $course->instructor->name }}">
                                    </div>
                                    <div class="instructor-text">
                                        <h5>{{ $course->instructor->name }}</h5>
                                        <p>Senior Instructor</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="course-rating">
                            <h3>Course Rating</h3>
                            <div class="rating-display">
                                <div class="average-rating">
                                    <div class="stars" id="average-stars"></div>
                                    <span id="average-score">0.0</span> (<span id="rating-count">0</span> ratings)
                                </div>
                            </div>
                            
                            <!-- Rating Form -->
                            <div class="rating-form" id="rating-form" style="display:none">
                                <h4>Rate this course</h4>
                                <div class="star-rating">
                                    <i class="far fa-star" data-rating="1"></i>
                                    <i class="far fa-star" data-rating="2"></i>
                                    <i class="far fa-star" data-rating="3"></i>
                                    <i class="far fa-star" data-rating="4"></i>
                                    <i class="far fa-star" data-rating="5"></i>
                                </div>
                                <textarea id="rating-review" placeholder="Optional review..."></textarea>
                                <button id="submit-rating">Submit Rating</button>
                            </div>
                            
                            <!-- All Reviews Container JS -->
                        </div>
                    </div>
                    
                    <div class="course-sidebar">
                        <div class="progress-container-rt">
                            <div class="progress-header">
                                <h3>Your Progress</h3>
                                <div class="progress-percent">{{ $progress }}%</div>
                            </div>
                            <div class="progress-bar" style="height:10px;width:100%;margin:12px 0;border-radius:15px;background:#38b6ff9c">
                                <div class="progress-fill" style="width: {{ $progress }}%; height:10px; background:#38b6ff; border-radius:15px;"></div>
                            </div>
                            <div class="progress-actions">
                                <button class="btn mark-complete-btn" id="mark-complete-btn">
                                    <i class="fas fa-check-circle"></i> Mark as Complete
                                </button>
                            </div>
                        </div>
                        
                        <div class="episodes-list">
                            <h3>Course Episodes</h3>
                            <ul id="course-episodes-list">
                                @foreach($course['episodes'] as $episode)
                                <li class="episode-item {{ $completedEpisodeIds->contains($episode->id) ? 'completed' : '' }}" 
                                    data-episode-id="{{ $episode['id'] }}"
                                    data-video-url="{{ $episode['video_url'] }}"
                                    data-episode-title="{{ $episode['title'] }}">
                                    <div class="episode-number">{{ $episode->episode_number }}</div>
                                    <div class="episode-info">
                                        <h4>{{ $episode['title'] }}</h4>
                                        <p>{{ $episode->duration_formatted }}</p>
                                    </div>
                                    @if($episode['completed'])
                                        <i class="fas fa-check-circle"></i>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-content" id="resources-tab" style="display:none;">
                <div class="resources-container">
                    <div class="resources-header">
                        <h3>Course Resources</h3>
                        <span class="resources-count">{{ count($resources) }} resources available</span>
                    </div>
                    
                    <div class="resources-filter">
                        <button class="filter-btn active" data-filter="all">All</button>
                        <button class="filter-btn" data-filter="pdf">PDF</button>
                        <button class="filter-btn" data-filter="video">Video</button>
                        <button class="filter-btn" data-filter="audio">Audio</button>
                        <button class="filter-btn" data-filter="document">Document</button>
                    </div>
                    
                    <div class="resources-list" id="resources-list" style="margin: 35px 0;">
                        @forelse($resources as $resource)
                            <div class="resource-item" data-type="{{ strtolower($resource->file_type) }}">
                                <div class="resource-icon">
                                    @if($resource->file_type === 'PDF')
                                        <i class="fas fa-file-pdf"></i>
                                    @elseif($resource->file_type === 'VIDEO')
                                        <i class="fas fa-file-video"></i>
                                    @elseif($resource->file_type === 'AUDIO')
                                        <i class="fas fa-file-audio"></i>
                                    @else
                                        <i class="fas fa-file-alt"></i>
                                    @endif
                                </div>
                                <div class="resource-info">
                                    <h4>{{ $resource->title }}</h4>
                                    <p>{{ $resource->description }}</p>
                                </div>
                                <div class="resource-meta">
                                    <span class="resource-type-badge">{{ strtoupper($resource->file_type) }}</span>
                                    <span>{{ number_format($resource->file_size / 1048576, 1) }} MB</span>
                                    <a href="{{ $resource->file_url }}" download class="resource-download-btn">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="no-resources">
                                <i class="fas fa-folder-open"></i>
                                <h3>No Resources Available</h3>
                                <p>This course doesn't have any additional resources yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="tab-content" id="certificate-tab" style="display:none;">
                @if($certificate)
                    <div class="certificate-container">
                        <div class="certificate-header">
                            <h3>Course Completion Certificate</h3>
                            <p>Congratulations on completing the course! Here's your certificate of completion.</p>
                        </div>
                        
                        <div class="certificate-preview">
                            <img src="{{ $certificate->certificate_url }}" alt="Certificate Preview" id="certificate-image">
                        </div>
                        
                        <div class="certificate-details">
                            <div class="certificate-detail-item">
                                <h4>Issued To</h4>
                                <p>{{ Auth::user()->name }}</p>
                            </div>
                            <div class="certificate-detail-item">
                                <h4>Course Title</h4>
                                <p>{{ $course->title }}</p>
                            </div>
                            <div class="certificate-detail-item">
                                <h4>Date Issued</h4>
                                <p>{{ \Carbon\Carbon::parse($certificate->issued_at)->format('F j, Y') }}</p>
                            </div>
                            <div class="certificate-detail-item">
                                <h4>Certificate ID</h4>
                                <p>{{ $certificate->certificate_id }}</p>
                            </div>
                        </div>
                        
                        <div class="certificate-actions">
                            <a href="{{ $certificate->certificate_url }}" download class="certificate-btn certificate-download">
                                <i class="fas fa-download"></i> Download PDF
                            </a>
                            <button class="certificate-btn certificate-share" id="share-certificate">
                                <i class="fas fa-share-alt"></i> Share
                            </button>
                        </div>
                    </div>
                @else
                    <div class="no-certificate">
                        <i class="fas fa-certificate"></i>
                        <h3>No Certificate Available</h3>
                        <p>Complete all course episodes to earn your certificate of completion.</p>
                        <button class="btn mark-complete-btn" onclick="document.querySelector('.tab-btn[data-tab=\"episodes\"]').click()">
                            <i class="fas fa-play-circle"></i> Continue Learning
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <div class="toast" id="toast"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // toast notifications
            function showToast(message, type = 'success') {
                const icons = {
                    success: 'success',
                    error: 'error',
                    info: 'info'
                };
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: icons[type] || 'success',
                    title: message,
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true
                });
            }

            // episode selection
            function handleEpisodeSelection(item) {
                const videoUrl = item.getAttribute('data-video-url');
                const episodeTitle = item.getAttribute('data-episode-title');

                const videoContainer = document.getElementById('video-container');

                videoContainer.innerHTML = '<div class="loading-spinner"></div>';

                document.querySelectorAll('.episode-item').forEach(ep => ep.classList.remove('active'));
                item.classList.add('active');

                setTimeout(() => {
                    videoContainer.innerHTML = `
                        <video controls autoplay style="width: 100%; height: 100%">
                            <source src="${videoUrl}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    `;

                    const video = videoContainer.querySelector('video');
                    if (video) {
                        video.play().catch(e => {
                            showToast('Click on the video to start playback', 'info');
                        });

                        document.querySelector('.video-description h3').textContent = episodeTitle;
                    }
                }, 500);
            }

            // YouTube-like video player implementation
            function createCustomVideoPlayer(videoUrl) {
                const videoContainer = document.getElementById('video-container');
                
                // Create video element
                const video = document.createElement('video');
                video.src = videoUrl;
                video.style.width = '100%';
                video.style.height = '100%';
                video.style.display = 'block';
                
                // Create controls container
                const controlsContainer = document.createElement('div');
                controlsContainer.className = 'custom-video-controls';
                
                // Create progress bar
                const progressContainer = document.createElement('div');
                progressContainer.className = 'progress-container';
                
                const progressBar = document.createElement('div');
                progressBar.className = 'progress-bar';
                
                progressContainer.appendChild(progressBar);
                
                // Create controls bar
                const controlsBar = document.createElement('div');
                controlsBar.className = 'controls-bar';
                
                // Left controls
                const leftControls = document.createElement('div');
                leftControls.className = 'left-controls';
                
                const playPauseBtn = document.createElement('button');
                playPauseBtn.className = 'control-btn play-pause-btn';
                playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
                
                const timeDisplay = document.createElement('span');
                timeDisplay.className = 'time-display';
                timeDisplay.textContent = '0:00 / 0:00';
                
                leftControls.appendChild(playPauseBtn);
                leftControls.appendChild(timeDisplay);
                
                // Right controls
                const rightControls = document.createElement('div');
                rightControls.className = 'right-controls';
                
                const volumeBtn = document.createElement('button');
                volumeBtn.className = 'control-btn volume-btn';
                volumeBtn.innerHTML = '<i class="fas fa-volume-up"></i>';
                
                const volumeContainer = document.createElement('div');
                volumeContainer.className = 'volume-container';
                
                const volumeSlider = document.createElement('input');
                volumeSlider.type = 'range';
                volumeSlider.className = 'volume-slider';
                volumeSlider.min = '0';
                volumeSlider.max = '1';
                volumeSlider.step = '0.01';
                volumeSlider.value = '1';
                
                volumeContainer.appendChild(volumeBtn);
                volumeContainer.appendChild(volumeSlider);
                
                const fullscreenBtn = document.createElement('button');
                fullscreenBtn.className = 'control-btn fullscreen-btn';
                fullscreenBtn.innerHTML = '<i class="fas fa-expand"></i>';
                
                rightControls.appendChild(volumeContainer);
                rightControls.appendChild(fullscreenBtn);
                
                // Assemble controls bar
                controlsBar.appendChild(leftControls);
                controlsBar.appendChild(rightControls);
                
                // Assemble controls container
                controlsContainer.appendChild(progressContainer);
                controlsContainer.appendChild(controlsBar);
                
                // Add elements to video container
                videoContainer.innerHTML = '';
                videoContainer.appendChild(video);
                videoContainer.appendChild(controlsContainer);
                
                // Add loading spinner
                const loadingSpinner = document.createElement('div');
                loadingSpinner.className = 'loading-spinner';
                videoContainer.appendChild(loadingSpinner);
                
                // Video event listeners
                video.addEventListener('loadedmetadata', function() {
                    // Format time display
                    updateTimeDisplay();
                    loadingSpinner.style.display = 'none';
                });
                
                video.addEventListener('timeupdate', function() {
                    // Update progress bar
                    const progress = (video.currentTime / video.duration) * 100;
                    progressBar.style.width = progress + '%';
                    
                    // Update time display
                    updateTimeDisplay();
                });
                
                video.addEventListener('play', function() {
                    playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
                });
                
                video.addEventListener('pause', function() {
                    playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
                });
                
                video.addEventListener('waiting', function() {
                    loadingSpinner.style.display = 'block';
                });
                
                video.addEventListener('playing', function() {
                    loadingSpinner.style.display = 'none';
                });

                video.addEventListener('keydown', function(e) {
                    if (e.code === 'Space') {
                        e.preventDefault();
                    }
                });

                document.addEventListener('keydown', function(e) {
                    if (e.code === 'Space' && e.target.tagName !== 'INPUT' && e.target.tagName !== 'TEXTAREA') {
                        const video = document.querySelector('#video-container video');
                        if (video) {
                            e.preventDefault();
                            if (video.paused) {
                                video.play().catch(error => {
                                    showToast('Click on the video to start playback', 'info');
                                });
                            } else {
                                video.pause();
                            }
                        }
                    }
                });

                videoContainer.addEventListener('click', function() {
                    const video = this.querySelector('video');
                    if (video) {
                        if (video.paused) {
                            video.play().catch(error => {
                                showToast('Click on the video to start playback', 'info');
                            });
                        } else {
                            video.pause();
                        }
                    }
                });
                
                // Progress bar click handler
                progressContainer.addEventListener('click', function(e) {
                    const rect = this.getBoundingClientRect();
                    const pos = (e.pageX - rect.left) / this.offsetWidth;
                    video.currentTime = pos * video.duration;
                });
                
                // Play/pause button
                playPauseBtn.addEventListener('click', function() {
                    if (video.paused) {
                        video.play();
                    } else {
                        video.pause();
                    }
                });
                
                // Volume controls
                volumeBtn.addEventListener('click', function() {
                    if (video.volume > 0) {
                        video.volume = 0;
                        volumeSlider.value = 0;
                        volumeBtn.innerHTML = '<i class="fas fa-volume-mute"></i>';
                    } else {
                        video.volume = volumeSlider.value;
                        volumeBtn.innerHTML = '<i class="fas fa-volume-up"></i>';
                    }
                });
                
                volumeSlider.addEventListener('input', function() {
                    video.volume = this.value;
                    if (this.value > 0) {
                        volumeBtn.innerHTML = '<i class="fas fa-volume-up"></i>';
                    } else {
                        volumeBtn.innerHTML = '<i class="fas fa-volume-mute"></i>';
                    }
                });
                
                // Fullscreen button
                fullscreenBtn.addEventListener('click', function() {
                    if (!document.fullscreenElement) {
                        videoContainer.requestFullscreen().catch(err => {
                            console.log(`Error attempting to enable fullscreen: ${err.message}`);
                        });
                        fullscreenBtn.innerHTML = '<i class="fas fa-compress"></i>';
                    } else {
                        document.exitFullscreen();
                        fullscreenBtn.innerHTML = '<i class="fas fa-expand"></i>';
                    }
                });
                
                // Format time display
                function formatTime(seconds) {
                    const minutes = Math.floor(seconds / 60);
                    const secs = Math.floor(seconds % 60);
                    return `${minutes}:${secs < 10 ? '0' : ''}${secs}`;
                }
                
                function updateTimeDisplay() {
                    timeDisplay.textContent = `${formatTime(video.currentTime)} / ${formatTime(video.duration)}`;
                }
                
                // Start playing the video
                video.play().catch(e => {
                    showToast('Click on the video to start playback', 'info');
                });

                // Track video progress
                video.addEventListener('timeupdate', function() {
                    const currentTime = video.currentTime;
                    const duration = video.duration;
                    
                    // send progress updates every 5 sec
                    if (currentTime % 5 < 0.1 || currentTime > duration - 5) {
                        const isCompleted = currentTime >= duration - 2;
                        
                        fetch(`/enrolled-courses/${window.currentCourseId}/episodes/${window.currentEpisodeId}/progress`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                watched_seconds: Math.floor(currentTime),
                                is_completed: isCompleted
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success && data.overall_progress) {
                                // overall progress display
                                const progressPercent = document.querySelector('.progress-percent');
                                const progressFill = document.querySelector('.progress-fill');
                                
                                progressPercent.textContent = `${data.overall_progress}%`;
                                progressFill.style.width = `${data.overall_progress}%`;
                                
                                // If completed, update UI
                                if (data.progress.is_completed) {
                                    const activeEpisode = document.querySelector('.episode-item.active');
                                    if (activeEpisode && !activeEpisode.classList.contains('completed')) {
                                        activeEpisode.classList.add('completed');
                                        if (!activeEpisode.querySelector('.fa-check-circle')) {
                                            activeEpisode.innerHTML += '<i class="fas fa-check-circle"></i>';
                                        }
                                    }
                                }
                            }
                            if (data.success) {
                                const bar = document.querySelector('.progress-bar');
                                const text = document.querySelector('.progress-percent');

                                if (bar) bar.style.width = data.overall_progress + '%';
                                if (text) text.textContent = data.overall_progress + '%';
                            }
                        });
                    }
                });              
                
                // auto completion when vid ends
                video.addEventListener('ended', function() {
                    fetch(`/enrolled-courses/${currentCourseId}/episodes/${currentEpisodeId}/progress`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            watched_seconds: video.duration,
                            is_completed: true
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const activeEpisode = document.querySelector('.episode-item.active');
                            if (activeEpisode && !activeEpisode.classList.contains('completed')) {
                                activeEpisode.classList.add('completed');
                                if (!activeEpisode.querySelector('.fa-check-circle')) {
                                    activeEpisode.innerHTML += '<i class="fas fa-check-circle"></i>';
                                }
                                
                                // progress display
                                const progressPercent = document.querySelector('.progress-percent');
                                const progressFill = document.querySelector('.progress-fill');
                                progressPercent.textContent = `${data.overall_progress}%`;
                                progressFill.style.width = `${data.overall_progress}%`;
                                
                                showToast('Episode marked as completed!');
                            }
                        }
                    });
                });

                return video;
            }

            // Updated episode selection function
            function handleEpisodeSelection(item) {
                const videoUrl = item.getAttribute('data-video-url');
                const episodeTitle = item.getAttribute('data-episode-title');
                const episodeId = item.getAttribute('data-episode-id');

                const videoContainer = document.getElementById('video-container');

                videoContainer.innerHTML = '<div class="loading-spinner"></div>';

                // store progress tracking
                window.currentEpisodeId = episodeId;
                window.currentCourseId = {{ $course->id }};

                document.querySelectorAll('.episode-item').forEach(ep => ep.classList.remove('active'));
                item.classList.add('active');

                setTimeout(() => {
                    createCustomVideoPlayer(videoUrl);
                    document.querySelector('.video-description h3').textContent = episodeTitle;
                }, 500);
            }

            // episode click handlers
            document.querySelectorAll('.episode-item').forEach(item => {
                item.addEventListener('click', function () {
                    handleEpisodeSelection(this);
                });
            });

            // video placeholder overlay click
            const videoOverlay = document.getElementById('video-overlay');
            if (videoOverlay) {
                videoOverlay.addEventListener('click', function () {
                    const firstEpisode = document.querySelector('.episode-item');
                    if (firstEpisode) {
                        handleEpisodeSelection(firstEpisode);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'No episodes available',
                            timer: 2500,
                            showConfirmButton: false
                        });
                    }
                });
            }

            // Mark as complete button
            document.getElementById('mark-complete-btn').addEventListener('click', function () {
                const activeEpisode = document.querySelector('.episode-item.active');
                if (!activeEpisode) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Please select an episode first',
                        timer: 2500,
                        showConfirmButton: false
                    });
                    return;
                }

                const episodeId = activeEpisode.getAttribute('data-episode-id');
                const courseId = {{ $course['id'] }};

                Swal.fire({
                    title: 'Marking episode as completed...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch(`/enrolled-courses/${courseId}/episodes/${episodeId}/complete`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            activeEpisode.classList.add('completed');
                            if (!activeEpisode.querySelector('.fa-check-circle')) {
                                activeEpisode.innerHTML += '<i class="fas fa-check-circle"></i>';
                            }

                            const progressPercent = document.querySelector('.progress-percent');
                            const progressFill = document.querySelector('.progress-fill');

                            let currentProgress = parseInt(progressPercent.textContent);
                            const targetProgress = data.progress;

                            const increment = () => {
                                if (currentProgress < targetProgress) {
                                    currentProgress++;
                                    progressPercent.textContent = `${currentProgress}%`;
                                    progressFill.style.width = `${currentProgress}%`;
                                    setTimeout(increment, 20);
                                }
                            };

                            increment();

                            Swal.fire({
                                icon: 'success',
                                title: 'Episode marked as completed!',
                                timer: 2500,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: data.message || 'Operation failed',
                                timer: 3000,
                                showConfirmButton: false
                            });
                        }
                    })
                    .catch(() => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed to mark episode as completed',
                            timer: 3000,
                            showConfirmButton: false
                        });
                    });
            });

            // Confirm before unenrolling
            const unenrollBtn = document.getElementById('unenroll-btn');
            if (unenrollBtn) {
                unenrollBtn.addEventListener('click', function (e) {
                    e.preventDefault();

                    const form = this.closest('form');
                    const courseTitle = document.querySelector('.title-meta-container h1')?.textContent || 'this course';

                    Swal.fire({
                        title: 'Confirm Unenrollment',
                        html: `Are you sure you want to Unenroll from <strong>${courseTitle}</strong>?<br><br>Your progress will be lost.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e53e3e',
                        cancelButtonColor: '#38b6ff',
                        confirmButtonText: 'Yes, Unenroll',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Unenrolling...',
                                allowOutsideClick: false,
                                didOpen: () => Swal.showLoading(),
                            });

                            fetch(form.action, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    _method: 'DELETE'
                                })
                            })
                                .then(response => {
                                    if (!response.ok) throw new Error('Network response was not ok');
                                    return response.json();
                                })
                                .then(data => {
                                    if (data.success) {
                                        const redirectUrl = new URL(data.redirect);
                                        redirectUrl.searchParams.set('unenrolled', '1');
                                        redirectUrl.searchParams.set('message', encodeURIComponent(data.message));
                                        window.location.href = redirectUrl.toString();
                                    } else {
                                        throw new Error('Unenrollment failed');
                                    }
                                })
                                .catch(() => {
                                    Swal.fire(
                                        'Error',
                                        'There was a problem unenrolling from the course. Please try again.',
                                        'error'
                                    );
                                });
                        }
                    });
                });
            }

            // navigation for episodes
            document.addEventListener('keydown', function (e) {
                if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                    const episodes = Array.from(document.querySelectorAll('.episode-item'));
                    const activeIndex = episodes.findIndex(ep => ep.classList.contains('active'));

                    if (activeIndex >= 0) {
                        e.preventDefault();
                        let newIndex;

                        if (e.key === 'ArrowDown' && activeIndex < episodes.length - 1) {
                            newIndex = activeIndex + 1;
                        } else if (e.key === 'ArrowUp' && activeIndex > 0) {
                            newIndex = activeIndex - 1;
                        }

                        if (newIndex !== undefined) {
                            handleEpisodeSelection(episodes[newIndex]);
                            episodes[newIndex].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        }
                    }
                }
            });

            // Tab switching
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const tabId = this.getAttribute('data-tab');

                    // Toggle tab buttons
                    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    // Toggle tab content
                    document.querySelectorAll('.tab-content').forEach(content => {
                        content.style.display = 'none';
                    });

                    const target = document.getElementById(`${tabId}-tab`);
                    if (target) {
                        target.style.display = 'block';
                    }
                });
            });

            // Resource filtering
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    
                    const filter = this.getAttribute('data-filter');
                    const resources = document.querySelectorAll('.resource-item');
                    
                    resources.forEach(resource => {
                        if (filter === 'all') {
                            resource.style.display = 'flex';
                        } else {
                            const type = resource.getAttribute('data-type');
                            resource.style.display = type.includes(filter) ? 'flex' : 'none';
                        }
                    });
                });
            });

            // Share certificate functionality
            const shareCertificateBtn = document.getElementById('share-certificate');
            if (shareCertificateBtn) {
                shareCertificateBtn.addEventListener('click', function() {
                    Swal.fire({
                        title: 'Share Certificate',
                        html: `
                            <p>Share your achievement on social media or copy the link below:</p>
                            <div class="social-share-buttons" style="display: flex; justify-content: center; gap: 10px; margin: 15px 0;">
                                <button class="btn" style="background: #3b5998; color: white; padding: 8px 15px; border-radius: 4px;">
                                    <i class="fab fa-facebook-f"></i> Facebook
                                </button>
                                <button class="btn" style="background: #1da1f2; color: white; padding: 8px 15px; border-radius: 4px;">
                                    <i class="fab fa-twitter"></i> Twitter
                                </button>
                                <button class="btn" style="background: #0077b5; color: white; padding: 8px 15px; border-radius: 4px;">
                                    <i class="fab fa-linkedin-in"></i> LinkedIn
                                </button>
                            </div>
                            <div class="input-group" style="display: flex; margin-top: 10px;">
                                <input type="text" id="certificate-url" value="{{ $certificate ? $certificate->certificate_url : '' }}" readonly style="flex: 1; padding: 8px; border: 1px solid #ddd; border-radius: 4px 0 0 4px;">
                                <button id="copy-certificate-url" class="btn" style="background: var(--primary-color); color: white; border-radius: 0 4px 4px 0;">
                                    Copy
                                </button>
                            </div>
                        `,
                        showConfirmButton: false,
                        showCloseButton: true
                    });

                    document.getElementById('copy-certificate-url').addEventListener('click', function() {
                        const urlInput = document.getElementById('certificate-url');
                        urlInput.select();
                        document.execCommand('copy');
                        showToast('Certificate link copied to clipboard!');
                    });
                });
            }

            // Rating system
            const courseId = {{ $course->id }};
            let currentUserRating = null;

            // editable review
            function createEditableReview(review, rating) {
                const editableDiv = document.createElement('div');
                editableDiv.className = 'editable-review';
                
                const starsDiv = document.createElement('div');
                starsDiv.className = 'star-rating';
                starsDiv.style.marginBottom = '10px';
                
                for (let i = 1; i <= 5; i++) {
                    const star = document.createElement('i');
                    star.className = i <= rating ? 'fas fa-star' : 'far fa-star';
                    star.dataset.rating = i;
                    star.addEventListener('click', function() {
                        selectedRating = parseInt(this.dataset.rating);
                        const stars = this.parentElement.querySelectorAll('i');
                        stars.forEach((s, idx) => {
                            s.className = idx < selectedRating ? 'fas fa-star' : 'far fa-star';
                        });
                    });
                    starsDiv.appendChild(star);
                }
                
                const textarea = document.createElement('textarea');
                textarea.value = review || '';
                textarea.style.width = '100%';
                textarea.style.minHeight = '80px';
                
                const actionsDiv = document.createElement('div');
                actionsDiv.className = 'edit-review-actions';
                
                const saveBtn = document.createElement('button');
                saveBtn.className = 'save-review-btn';
                saveBtn.textContent = 'Save';
                saveBtn.addEventListener('click', function() {
                    updateUserRating(selectedRating, textarea.value);
                });
                
                const cancelBtn = document.createElement('button');
                cancelBtn.className = 'cancel-review-btn';
                cancelBtn.textContent = 'Cancel';
                cancelBtn.addEventListener('click', function() {
                    loadAllReviews();
                });
                
                actionsDiv.appendChild(cancelBtn);
                actionsDiv.appendChild(saveBtn);
                
                editableDiv.appendChild(starsDiv);
                editableDiv.appendChild(textarea);
                editableDiv.appendChild(actionsDiv);
                
                return editableDiv;
            }

            // Update user rating
            function updateUserRating(rating, review) {
                if (!rating) {
                    showToast('Please select a rating', 'error');
                    return;
                }

                Swal.fire({
                    title: 'Updating your rating...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading(),
                });

                const method = currentUserRating ? 'PUT' : 'POST';
                const url = currentUserRating ? 
                    `/api/courses/${courseId}/ratings/${currentUserRating.id}` : 
                    `/api/courses/${courseId}/ratings`;

                fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        rating: rating,
                        review: review
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast('Rating updated successfully!', 'success');
                            loadRatings();
                            loadAllReviews();
                        } else {
                            showToast(data.message || 'Failed to update rating', 'error');
                        }
                    })
                    .catch(() => {
                        showToast('Failed to update rating', 'error');
                    });
            }

            // Load ratings data
            function loadRatings() {
                fetch(`/api/courses/${courseId}/ratings`)
                    .then(response => {
                        if (!response.ok) throw new Error('Failed to fetch ratings');
                        return response.json();
                    })
                    .then(data => {
                        const averageRating = data.average || 0;
                        document.getElementById('average-score').textContent = Number(averageRating).toFixed(1);
                        document.getElementById('rating-count').textContent = data.count;

                        renderStars(document.getElementById('average-stars'), averageRating, false);

                        if (data.user_rating) {
                            currentUserRating = data.user_rating;
                            document.getElementById('rating-form').style.display = 'none';
                        } else {
                            document.getElementById('rating-form').style.display = 'block';
                        }
                    })
                    .catch(() => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Could not load ratings',
                            timer: 3000,
                            showConfirmButton: false
                        });
                    });
            }

            // all ratings
            function loadAllReviews() {
                fetch(`/api/courses/${courseId}/ratings`)
                    .then(response => response.json())
                    .then(data => {
                        const reviewsContainer = document.querySelector('.all-reviews-container');
                        if (reviewsContainer) {
                            reviewsContainer.remove();
                        }

                        const newReviewsContainer = document.createElement('div');
                        newReviewsContainer.className = 'all-reviews-container';
                        newReviewsContainer.innerHTML = '<h4>All Reviews</h4>';

                        if (data.all_ratings && data.all_ratings.length > 0) {
                            data.all_ratings.forEach(review => {
                                const isCurrentUser = data.user_rating && review.id === data.user_rating.id;
                                const reviewElement = createReviewElement(review, isCurrentUser);
                                newReviewsContainer.appendChild(reviewElement);
                            });
                        } else {
                            newReviewsContainer.innerHTML += '<p>No reviews yet</p>';
                        }

                        const ratingSection = document.querySelector('.course-rating');
                        ratingSection.appendChild(newReviewsContainer);
                    })
                    .catch(error => {
                        console.error('Error loading reviews:', error);
                    });
            }

            // Create review element
            function createReviewElement(review, isCurrentUser) {
                const reviewElement = document.createElement('div');
                reviewElement.className = `review-item ${isCurrentUser ? 'current-user-review' : ''}`;
                
                const reviewHeader = document.createElement('div');
                reviewHeader.className = 'review-header';
                
                const reviewUser = document.createElement('div');
                reviewUser.className = 'review-user';
                
                const avatar = document.createElement('img');
                avatar.className = 'review-avatar';
                
                const clientData = review.client || {};
                avatar.src = clientData.avatar || '/images/icons/circle-user-solid.svg';
                avatar.alt = clientData.name || clientData.surname || 'Anonymous';
                
                const userName = document.createElement('span');
                userName.className = 'review-user-name';
                
                userName.textContent = clientData.name && clientData.surname 
                    ? `${clientData.name.substring(0, 3)}${'*'.repeat(clientData.name.length - 3)} ${'*'.repeat(clientData.surname?.length || 0)}`
                    : 'Anonymous';
                
                reviewUser.appendChild(avatar);
                reviewUser.appendChild(userName);
                
                const reviewStars = document.createElement('div');
                reviewStars.className = 'review-stars';
                reviewStars.innerHTML = renderStarsHTML(review.rating);
                
                reviewHeader.appendChild(reviewUser);
                reviewHeader.appendChild(reviewStars);
                
                if (isCurrentUser) {
                    const editBtn = document.createElement('button');
                    editBtn.className = 'edit-review-btn';
                    editBtn.innerHTML = '<i class="fas fa-pencil-alt"></i>';
                    editBtn.addEventListener('click', function() {
                        editReview(reviewElement, review);
                    });
                    reviewHeader.appendChild(editBtn);
                }
                
                const reviewDate = document.createElement('div');
                reviewDate.className = 'review-date';
                reviewDate.textContent = new Date(review.created_at).toLocaleDateString();
                
                const reviewContent = document.createElement('div');
                reviewContent.className = 'review-content';
                reviewContent.textContent = review.review || 'No review provided';
                
                reviewElement.appendChild(reviewHeader);
                reviewElement.appendChild(reviewDate);
                reviewElement.appendChild(reviewContent);
                
                return reviewElement;
            }

            // Edit review
            function editReview(reviewElement, review) {
                const reviewContent = reviewElement.querySelector('.review-content');
                const originalContent = reviewContent.textContent;
                const originalRating = review.rating;
                
                const editableReview = createEditableReview(originalContent, originalRating);
                selectedRating = originalRating;
                
                // Replace the content with editable version
                reviewContent.replaceWith(editableReview);
            }

            // function to render stars HTML
            function renderStarsHTML(rating) {
                let starsHTML = '';
                const fullStars = Math.floor(rating);
                const hasHalfStar = rating % 1 >= 0.5;
                
                for (let i = 1; i <= 5; i++) {
                    if (i <= fullStars) {
                        starsHTML += '<i class="fas fa-star"></i>';
                    } else if (i === fullStars + 1 && hasHalfStar) {
                        starsHTML += '<i class="fas fa-star-half-alt"></i>';
                    } else {
                        starsHTML += '<i class="far fa-star"></i>';
                    }
                }
                return starsHTML;
            }

            // Render stars based on rating
            function renderStars(container, rating, interactive = true) {
                container.innerHTML = '';
                const fullStars = Math.floor(rating);
                const hasHalfStar = rating % 1 >= 0.5;

                for (let i = 1; i <= 5; i++) {
                    const star = document.createElement('i');

                    if (i <= fullStars) {
                        star.className = 'fas fa-star';
                    } else if (i === fullStars + 1 && hasHalfStar) {
                        star.className = 'fas fa-star-half-alt';
                    } else {
                        star.className = 'far fa-star';
                    }

                    if (interactive) {
                        star.dataset.rating = i;
                        star.addEventListener('mouseover', handleStarHover);
                        star.addEventListener('click', handleStarClick);
                    }

                    container.appendChild(star);
                }
            }

            // Star hover effect
            function handleStarHover(e) {
                const rating = parseInt(e.target.dataset.rating);
                const stars = e.target.parentElement.querySelectorAll('i');

                stars.forEach((star, index) => {
                    star.className = index < rating ? 'fas fa-star' : 'far fa-star';
                });
            }

            // Star click handler
            let selectedRating = 0;
            function handleStarClick(e) {
                selectedRating = parseInt(e.target.dataset.rating);
                const stars = document.querySelectorAll('.star-rating i');

                stars.forEach((star, index) => {
                    star.className = index < selectedRating ? 'fas fa-star' : 'far fa-star';
                });
            }

            // submit-rating
            document.getElementById('submit-rating').addEventListener('click', function () {
                if (selectedRating === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Please select a rating',
                        timer: 2500,
                        showConfirmButton: false
                    });
                    return;
                }

                const review = document.getElementById('rating-review').value;

                updateUserRating(selectedRating, review);
            });

            // Star rating interaction
            document.querySelectorAll('.star-rating i').forEach(star => {
                star.addEventListener('mouseover', handleStarHover);
                star.addEventListener('click', handleStarClick);
            });

            loadRatings();

            // all ratings
            loadAllReviews();
        });
    </script>
</body>
</html>