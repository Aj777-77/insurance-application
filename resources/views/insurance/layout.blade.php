<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $stepTitle ?? 'Insurance Application' }} - Step {{ $currentStep ?? 1 }} of {{ $totalSteps ?? 7 }}</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #004e5c, #009487) !important;
            min-height: 100vh;
            color: #212529;
        }

        .main-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header {
            text-align: center;
            color: white;
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        .header h1 {
            font-size: 2rem;
            font-weight: 600;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            color: white;
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .header-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .header-logo {
            height: 100px;
            width: auto;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
        }

        /* Progress Bar Styles */
        .progress-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .step-info {
            font-size: 1.1rem;
            font-weight: 600;
            color: #212529;
        }

        .percentage {
            font-size: 1rem;
            color: #212529;
            font-weight: 500;
        }

        .progress-bar-container {
            background: #e9ecef;
            height: 12px;
            border-radius: 6px;
            overflow: hidden;
            margin-bottom: 20px;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(to right, #004e5c, #009487);
            border-radius: 6px;
            transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        .steps-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 10px;
            margin-top: 15px;
        }

        .step-item {
            text-align: center;
            padding: 8px;
            border-radius: 8px;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .step-item.completed {
            background: #28a745;
            color: white;
            transform: scale(1.05);
        }

        .step-item.current {
            background: #009487;
            color: white;
            font-weight: 600;
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(0, 148, 135, 0.4);
        }

        .step-item.pending {
            background: #f8f9fa;
            color: #212529;
            border: 2px dashed #dee2e6;
        }

        /* Form Container Styles */
        .form-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            flex-grow: 1;
            margin-bottom: 20px;
        }

        .step-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: #212529;
            margin-bottom: 30px;
            text-align: center;
            position: relative;
        }

        .step-title::after {
            content: '';
            display: block;
            width: 60px;
            height: 3px;
            background: linear-gradient(to right, #004e5c, #009487);
            margin: 10px auto;
            border-radius: 2px;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #212529;
            font-size: 0.95rem;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #fff;
        }

        .form-control:focus {
            outline: none;
            border-color: #009487;
            box-shadow: 0 0 0 3px rgba(0, 148, 135, 0.1);
            transform: translateY(-1px);
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        /* Button Styles */
        .button-group {
            display: none !important; /* Hide bottom navigation buttons */
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-width: 120px;
            justify-content: center;
        }

        .btn-primary {
            background: linear-gradient(90deg, #1f4d5b 0%, #3c8981 100%);
            color: #ffffff;
        }

        .btn-secondary {
            background: linear-gradient(90deg, #1f4d5b 0%, #3c8981 100%);
            color: #ffffff;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .btn:active {
            transform: translateY(0);
        }

        /* Error Styles */
        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 5px;
            display: block;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-danger {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-container {
                padding: 10px;
            }

            .header h1 {
                font-size: 1.5rem;
            }
            
            .header-logo {
                height: 50px !important;
            }
            
            .header-container {
                flex-direction: column !important;
                gap: 10px !important;
            }

            .progress-container,
            .form-container {
                padding: 15px;
                border-radius: 10px;
            }
            
            .nav-buttons-container {
                flex-direction: column !important;
                gap: 12px !important;
            }
            
            .nav-btn-prev,
            .nav-btn-next {
                width: 100% !important;
                justify-content: center !important;
                padding: 10px 20px !important;
                font-size: 0.9rem !important;
            }
            
            .progress-header {
                flex-direction: column !important;
                gap: 8px;
                text-align: center;
            }
            
            .step-info {
                font-size: 1rem !important;
            }
            
            .percentage {
                font-size: 0.9rem !important;
            }

            .steps-list {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .step-title {
                font-size: 1.4rem;
            }

            .form-row {
                grid-template-columns: 1fr !important;
                gap: 15px;
            }
            
            .form-group {
                margin-bottom: 15px;
            }
            
            .form-label {
                font-size: 0.9rem;
            }
            
            .form-control {
                padding: 10px 12px;
                font-size: 0.95rem;
            }
            
            select.form-control {
                background-position: right 8px center !important;
                padding-right: 35px !important;
            }

            .button-group {
                flex-direction: column;
                gap: 12px;
            }
            
            .btn {
                width: 100%;
                padding: 10px 20px;
            }
            
            canvas#signaturePad {
                width: 100% !important;
                height: 150px !important;
            }
            
            .alert {
                padding: 12px;
                font-size: 0.9rem;
            }
            
            /* Insurance type cards */
            .insurance-option {
                padding: 15px !important;
            }
            
            /* Tables */
            table {
                font-size: 0.85rem;
            }
        }
        
        @media (max-width: 480px) {
            .main-container {
                padding: 5px;
            }
            
            .header h1 {
                font-size: 1.2rem;
            }
            
            .header-logo {
                height: 40px !important;
            }
            
            .progress-container,
            .form-container {
                padding: 12px;
            }
            
            .step-title {
                font-size: 1.2rem;
            }
            
            .form-control {
                font-size: 0.9rem;
                padding: 8px 10px;
            }
            
            .btn {
                font-size: 0.85rem;
                padding: 8px 16px;
            }
            
            .nav-btn-prev,
            .nav-btn-next {
                font-size: 0.85rem !important;
                padding: 8px 16px !important;
            }
        }

        /* Animation for step transitions */
        .step-content {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Header -->
        <div class="header">
            <div class="header-container">
                <img src="{{ asset('images/logo.png') }}" alt="Zain Logo" class="header-logo">
                @if(($currentStep ?? 1) == 1)
                    <h1>Insurance Application</h1>
                @endif
            </div>
        </div>

        <!-- Navigation and Progress Section -->
        <div class="progress-container">
            <!-- Progress Bar -->
            <div class="progress-header">
                <div class="step-info">
                    {{ $stepTitle ?? 'Getting Started' }}
                </div>
                <div class="percentage">
                    {{ number_format($progressPercentage ?? 0, 1) }}% Complete
                </div>
            </div>
            
            <div class="progress-bar-container">
                <div class="progress-bar" style="width: {{ $progressPercentage ?? 0 }}%"></div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="form-container">
            <div class="step-content">
                @yield('content')
            </div>
        </div>

        <!-- Navigation Buttons at Bottom -->
        <div class="progress-container" style="margin-top: 30px;">
            <div class="nav-buttons-container" style="display: flex; justify-content: space-between; align-items: center;">
                @if(($currentStep ?? 1) > 1)
                    <a href="{{ route('insurance.step', ['step' => ($currentStep ?? 1) - 1]) }}" class="btn btn-secondary nav-btn-prev" style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; background: linear-gradient(90deg,#1f4d5b 0,#3c8981 100%); color: #ffffff; border: none; border-radius: 8px; font-size: 1rem; font-weight: 500; cursor: pointer; text-decoration: none; transition: all 0.3s ease;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M15 18L9 12L15 6"/>
                        </svg>
                        Previous
                    </a>
                @else
                    <div></div>
                @endif
                
                @if(($currentStep ?? 1) < ($totalSteps ?? 7))
                    <button type="submit" form="step{{ $currentStep ?? 1 }}Form" class="btn btn-primary nav-btn-next" style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; background: linear-gradient(90deg,#1f4d5b 0,#3c8981 100%); color: #ffffff; border: none; border-radius: 8px; font-size: 1rem; font-weight: 500; cursor: pointer; transition: all 0.3s ease;">
                        Next
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 18L15 12L9 6"/>
                        </svg>
                    </button>
                @else
                    <button type="submit" form="step{{ $currentStep ?? 1 }}Form" class="btn btn-primary nav-btn-submit" style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 30px; background: linear-gradient(90deg,#1f4d5b 0,#3c8981 100%); color: #ffffff; border: none; border-radius: 8px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.2);">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                        Submit Application
                    </button>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Form validation and navigation
        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth scrolling
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });

            // Auto-focus first input field
            const firstInput = document.querySelector('.form-control');
            if (firstInput) {
                firstInput.focus();
            }
        });

        // Progress bar animation on page load
        window.addEventListener('load', function() {
            const progressBar = document.querySelector('.progress-bar');
            if (progressBar) {
                progressBar.style.width = '0%';
                setTimeout(() => {
                    progressBar.style.width = '{{ $progressPercentage ?? 0 }}%';
                }, 300);
            }
        });
    </script>
</body>
</html>