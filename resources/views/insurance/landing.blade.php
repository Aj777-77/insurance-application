<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Device Insurance Application</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: linear-gradient(to right, #004e5c, #009487);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .landing-container {
            max-width: 600px;
            width: 100%;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(90deg, #1f4d5b 0%, #3c8981 100%);
            padding: 40px;
            text-align: center;
            color: white;
        }

        .logo {
            height: 60px;
            width: auto;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 16px;
            opacity: 0.9;
        }

        .content {
            padding: 40px;
        }

        .welcome-message {
            text-align: center;
            margin-bottom: 30px;
        }

        .welcome-message h2 {
            color: #212529;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .welcome-message p {
            color: #6c757d;
            font-size: 14px;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #212529;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .required {
            color: #dc3545;
            margin-left: 2px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e9ecef;
            border-radius: 6px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-control:focus {
            outline: none;
            border-color: #3c8981;
            background: white;
            box-shadow: 0 0 0 3px rgba(60, 137, 129, 0.1);
        }

        .help-text {
            display: block;
            font-size: 12px;
            color: #6c757d;
            margin-top: 6px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-danger {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .alert-info {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
        }

        .btn {
            width: 100%;
            padding: 14px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background: linear-gradient(90deg, #1f4d5b 0%, #3c8981 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(60, 137, 129, 0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .features {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
            margin-bottom: 30px;
        }

        .features h3 {
            color: #212529;
            font-size: 16px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .features ul {
            list-style: none;
            padding: 0;
        }

        .features li {
            padding: 8px 0;
            color: #495057;
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        .features li:before {
            content: "✓";
            display: inline-block;
            width: 20px;
            height: 20px;
            background: #28a745;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 20px;
            margin-right: 10px;
            font-size: 12px;
            flex-shrink: 0;
        }

        .footer {
            text-align: center;
            padding: 20px;
            background: #f8f9fa;
            color: #6c757d;
            font-size: 12px;
        }

        .footer a {
            color: #3c8981;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 576px) {
            .header h1 {
                font-size: 22px;
            }

            .content {
                padding: 30px 20px;
            }

            .welcome-message h2 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="landing-container">
        <div class="header">
            <img src="{{ asset('images/logo.png') }}" alt="Company Logo" class="logo">
            <h1>Device Insurance Application</h1>
            <p>Protect your device with comprehensive coverage</p>
        </div>

        <div class="content">
            <div class="welcome-message">
                <h2>Welcome!</h2>
                <p>To begin your insurance application, please enter your unique user code provided to you.</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('insurance.validate-code') }}">
                @csrf
                
                <div class="form-group">
                    <label for="user_code" class="form-label">
                        User Code <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="user_code" 
                        name="user_code" 
                        class="form-control" 
                        placeholder="Enter your user code"
                        value="{{ old('user_code', request('code')) }}"
                        required
                        autofocus
                        autocomplete="off"
                    >
                    <small class="help-text">
                        Enter the unique code provided to you by our customer service representative.
                    </small>
                </div>

                <button type="submit" class="btn btn-primary">
                    Start Application
                </button>
            </form>

            <div class="features" style="margin-top: 30px;">
                <h3>Why Choose Our Insurance?</h3>
                <ul>
                    <li>Comprehensive coverage for your device</li>
                    <li>Quick and easy claims process</li>
                    <li>24/7 customer support</li>
                    <li>Flexible payment options</li>
                    <li>Coverage against accidental damage and theft</li>
                </ul>
            </div>

            <div class="alert alert-info">
                <strong>Need a user code?</strong> Contact our customer service team at <strong>107</strong> or email <strong>customercare@bh.zain.com</strong>
            </div>
        </div>

        <div class="footer">
            <p>
                &copy; {{ date('Y') }} Device Insurance Services. All rights reserved.<br>
                <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a>
            </p>
        </div>
    </div>

    <script>
        // Auto-format user code input (optional - uppercase and remove spaces)
        document.getElementById('user_code').addEventListener('input', function(e) {
            this.value = this.value.toUpperCase().replace(/\s/g, '');
        });

        // Check for UTM code parameter
        const urlParams = new URLSearchParams(window.location.search);
        const utmCode = urlParams.get('code');
        if (utmCode && !document.getElementById('user_code').value) {
            document.getElementById('user_code').value = utmCode.toUpperCase();
        }
    </script>
</body>
</html>
