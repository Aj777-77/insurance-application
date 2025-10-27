<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Application Submitted Successfully</title>
    
    <style>
        .success-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 40px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .success-icon {
            width: 80px;
            height: 80px;
            background: #28a745;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .success-icon svg {
            width: 40px;
            height: 40px;
            fill: white;
        }
        
        .success-title {
            color: #28a745;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .success-message {
            color: #212529;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        
        .application-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
            margin-bottom: 30px;
            text-align: left;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .detail-row:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 600;
            color: #212529;
        }
        
        .detail-value {
            color: #212529;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
            margin: 5px;
            transition: all 0.3s ease;
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
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            background: #ffc107;
            color: #212529;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .next-steps {
            background: #e7f3ff;
            border-left: 4px solid #007bff;
            padding: 20px;
            margin: 20px 0;
            text-align: left;
        }
        
        .next-steps h3 {
            color: #007bff;
            margin-bottom: 10px;
        }
        
        .next-steps ul {
            margin: 0;
            padding-left: 20px;
        }
        
        .next-steps li {
            margin-bottom: 5px;
            color: #212529;
        }
        
        body {
            background: linear-gradient(to right, #004e5c, #009487) !important;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto">
        <div class="success-container">
            <div style="text-align: center; margin-bottom: 30px;">
                <img src="{{ asset('images/logo.png') }}" alt="Company Logo" style="height: 60px; width: auto; margin-bottom: 20px;">
            </div>
            
            <div class="success-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                </svg>
            </div>
            
            <h1 class="success-title">Application Submitted Successfully!</h1>
            
            <p class="success-message">
                Thank you for submitting your insurance application. Your application has been received and is currently being processed.
            </p>
            
            <div class="application-details">
                <h3 style="margin-bottom: 15px; color: #212529;">Application Details</h3>
                
                <div class="detail-row">
                    <span class="detail-label">User Code:</span>
                    <span class="detail-value"><strong>{{ $application->user_code }}</strong></span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Applicant Name:</span>
                    <span class="detail-value">{{ $application->full_name }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value">{{ $application->email }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Contact Number:</span>
                    <span class="detail-value">{{ $application->contact_number }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Device:</span>
                    <span class="detail-value">{{ $application->device_brand }} {{ $application->device_model }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Insurance Type:</span>
                    <span class="detail-value">
                        @if(is_array($application->insurance_type))
                            {{ collect($application->insurance_type)->map(function($type) {
                                return ucwords(str_replace('-', ' ', $type));
                            })->join(', ') }}
                        @else
                            {{ ucwords(str_replace('-', ' ', $application->insurance_type)) }}
                        @endif
                    </span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Service Period:</span>
                    <span class="detail-value">
                        @if(is_array($application->service_period))
                            @foreach($application->service_period as $type => $period)
                                <div>{{ ucwords(str_replace('-', ' ', $type)) }}: {{ ucwords(str_replace('-', ' ', $period)) }}</div>
                            @endforeach
                        @else
                            {{ $application->service_period }}
                        @endif
                    </span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Application Status:</span>
                    <span class="detail-value">
                        <span class="status-badge">{{ ucfirst($application->status) }}</span>
                    </span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Submitted On:</span>
                    <span class="detail-value">{{ $application->created_at->format('F d, Y \a\t g:i A') }}</span>
                </div>
            </div>
            
            <div class="next-steps">
                <h3>What happens next?</h3>
                <ul>
                    <li><strong>Review Process:</strong> Our team will review your application within 1-2 business days.</li>
                    <li><strong>Verification:</strong> We may contact you for additional information or clarification.</li>
                    <li><strong>Approval:</strong> Once approved, you'll receive your insurance certificate via email.</li>
                    <li><strong>Updates:</strong> We'll keep you informed throughout the process via email and SMS.</li>
                </ul>
            </div>
            
            <div style="margin-top: 30px;">
                <p style="color: #212529; font-size: 14px; margin-bottom: 20px;">
                    <strong>Important:</strong> Please save your User Code ({{ $application->user_code }}) for future reference.
                    You may need it when contacting our customer service team.
                </p>
                
                <a href="{{ route('insurance.landing') }}" class="btn btn-primary">Submit Another Application</a>
            </div>
            
            <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #e9ecef;">
                <p style="color: #212529; font-size: 12px;">
                    If you have any questions about your application, please contact our customer service team at:
                    <br>
                    <strong>Email:</strong> customercare@bh.zain.com | <strong>Phone:</strong> 107 
                </p>
            </div>
        </div>
    </div>
    
    <script>
        // Auto-print functionality (optional)
        document.addEventListener('DOMContentLoaded', function() {
            // Add a print button
            const printBtn = document.createElement('button');
            printBtn.textContent = 'Print Application Details';
            printBtn.className = 'btn btn-secondary';
            printBtn.style.marginTop = '10px';
            printBtn.onclick = function() {
                window.print();
            };
            
            const container = document.querySelector('.success-container');
            container.appendChild(printBtn);
        });
    </script>
</body>
</html>