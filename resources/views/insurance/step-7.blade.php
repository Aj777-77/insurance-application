@extends('insurance.layout')

@section('content')
<style>
    /* Override the hidden button-group for step 7 to show submit button */
    .button-group {
        display: flex !important;
        justify-content: center;
        gap: 15px;
        margin-top: 30px;
    }
</style>

<form method="POST" action="{{ route('insurance.step.process', ['step' => $currentStep]) }}" id="step7Form">
    @csrf
    
    <div class="step-title">
        Review & Submit
    </div>
    
    <p style="text-align: center; color: #212529; margin-bottom: 30px;">
        Please review all information before submitting your application
    </p>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Personal Information Review -->
    <div style="background: #f8f9fa; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
        <h4 style="color: #212529; margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
            <span style="background: #009487; color: white; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">1</span>
            Personal Information
        </h4>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px;">
            <div><strong>Full Name:</strong> {{ $formData['full_name'] ?? 'Not provided' }}</div>
            <div><strong>Contact:</strong> {{ $formData['contact_number'] ?? 'Not provided' }}</div>
            <div><strong>Email:</strong> {{ $formData['email'] ?? 'Not provided' }}</div>
        </div>
    </div>

    <!-- Address Information Review -->
    <div style="background: #f8f9fa; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
        <h4 style="color: #212529; margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
            <span style="background: #009487; color: white; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">2</span>
            Address Information
        </h4>
        <div>
            <p style="margin: 0;">
                {{ $formData['house_building'] ?? '' }} {{ $formData['road'] ?? '' }}, 
                {{ $formData['block'] ?? '' }}, {{ $formData['city'] ?? '' }}
                @if(isset($formData['postal_code']) && $formData['postal_code'])
                    - {{ $formData['postal_code'] }}
                @endif
            </p>
            @if(isset($formData['has_flat']) && $formData['has_flat'])
                <p style="margin: 5px 0 0 0; color: #212529;">
                    <small>Flat: {{ $formData['flat_number'] ?? 'N/A' }}, Floor: {{ $formData['floor_number'] ?? 'N/A' }}</small>
                </p>
            @endif
        </div>
    </div>

    <!-- Device Information Review -->
    <div style="background: #f8f9fa; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
        <h4 style="color: #212529; margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
            <span style="background: #009487; color: white; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">3</span>
            Device Information
        </h4>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px;">
            <div><strong>Brand:</strong> {{ $formData['device_brand'] ?? 'Not provided' }}</div>
            <div><strong>Model:</strong> {{ $formData['device_model'] ?? 'Not provided' }}</div>
            <div><strong>IMEI:</strong> {{ $formData['imei_number'] ?? 'Not provided' }}</div>
        </div>
    </div>

    <!-- Insurance Details Review -->
    <div style="background: #f8f9fa; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
        <h4 style="color: #212529; margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
            <span style="background: #009487; color: white; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">4</span>
            Insurance Details
        </h4>
        <div style="display: grid; grid-template-columns: 1fr; gap: 15px;">
            <div>
                <strong>Insurance Type(s):</strong>
                @if(isset($formData['insurance_types']) && is_array($formData['insurance_types']))
                    <ul style="margin: 5px 0 0 20px; padding: 0;">
                        @foreach($formData['insurance_types'] as $type)
                            <li>{{ $type === 'accidental-damage' ? 'Zain Accidental Damage Protection' : 'Zain Extended Warranty' }}</li>
                        @endforeach
                    </ul>
                @else
                    Not selected
                @endif
            </div>
            
            @if(isset($formData['insurance_types']) && in_array('accidental-damage', $formData['insurance_types']))
            <div>
                <strong>Accidental Damage Service Period:</strong> 
                {{ ucwords(str_replace('-', ' ', $formData['accidental_damage_service_period'] ?? 'Not selected')) }}
            </div>
            @endif
            
            @if(isset($formData['insurance_types']) && in_array('extended-warranty', $formData['insurance_types']))
            <div>
                <strong>Extended Warranty Service Period:</strong> 
                {{ ucwords(str_replace('-', ' ', $formData['extended_warranty_service_period'] ?? 'Not selected')) }}
            </div>
            @endif
        </div>
    </div>

    <!-- Files & Signature Review -->
    <div style="background: #f8f9fa; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
        <h4 style="color: #212529; margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
            <span style="background: #009487; color: white; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">5</span>
            Files & Signature
        </h4>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px;">
            <div><strong>Device Images:</strong> 
                @if(session('uploaded_device_images'))
                    <span style="color: #28a745;">✓ {{ count(session('uploaded_device_images')) }} image(s) uploaded</span>
                @else
                    <span style="color: #dc3545;">✗ Not uploaded</span>
                @endif
            </div>
            <div><strong>Purchase Receipt:</strong> 
                @if(session('uploaded_receipt'))
                    <span style="color: #28a745;">✓ Uploaded</span>
                @else
                    <span style="color: #dc3545;">✗ Not uploaded</span>
                @endif
            </div>
            <div><strong>Terms Agreed:</strong> 
                @if(isset($formData['terms_agreement']) && $formData['terms_agreement'])
                    <span style="color: #28a745;">✓ Accepted</span>
                @else
                    <span style="color: #dc3545;">✗ Not accepted</span>
                @endif
            </div>
        </div>
        
        <!-- Digital Signature Display -->
        @if(isset($formData['signature_name']) || isset($formData['signature_data']))
        <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #dee2e6;">
            <h5 style="color: #212529; margin-bottom: 10px;">Digital Signature</h5>
            <div style="background: white; border: 2px solid #009487; border-radius: 8px; padding: 15px; display: inline-block; min-width: 300px;">
                @if(isset($formData['signature_data']) && $formData['signature_data'])
                    <img src="{{ $formData['signature_data'] }}" alt="Signature" style="max-width: 100%; height: auto; display: block; margin-bottom: 10px; background: white;">
                @endif
                <p style="margin: 0; text-align: center; color: #212529; border-top: 1px solid #dee2e6; padding-top: 10px;">
                    <strong>{{ $formData['signature_name'] ?? 'Not provided' }}</strong>
                </p>
                <p style="margin: 5px 0 0 0; text-align: center; color: #6c757d; font-size: 0.85rem;">
                    {{ date('F d, Y') }}
                </p>
            </div>
        </div>
        @endif
    </div>

    <!-- Important Notice -->
    <div style="background: #e7f3ff; border: 1px solid #b3d9ff; border-radius: 8px; padding: 20px; margin: 20px 0;">
        <h4 style="color: #007bff; margin-bottom: 15px;">📋 Important Notice</h4>
        <ul style="margin: 0; padding-left: 20px; color: #212529; line-height: 1.6;">
            <li>By submitting this application, you confirm that all information provided is accurate and complete</li>
            <li>Your application will be reviewed within 1-2 business days</li>
            <li>You will receive a confirmation email with your application ID</li>
            <li>Keep your application ID for future reference and inquiries</li>
            <li>Any false information may result in policy cancellation</li>
        </ul>
    </div>

    <!-- Edit Options -->
    <div style="background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
        <p style="margin: 0; color: #856404;">
            <strong>Need to make changes?</strong> You can go back to any previous step to edit your information.
        </p>
    </div>

</form>

<script>
// Final submission confirmation
document.getElementById('step7Form').addEventListener('submit', function(e) {
    // Check if already confirmed
    if (this.dataset.confirmed === 'true') {
        return true; // Allow submission
    }
    
    e.preventDefault();
    
    if (confirm('Are you sure you want to submit your insurance application? Once submitted, you cannot make changes to this application.')) {
        // Mark as confirmed and submit
        this.dataset.confirmed = 'true';
        
        // Find the submit button (could be in the form or in the nav)
        const submitBtn = document.querySelector('button[type="submit"][form="step7Form"]') || this.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.innerHTML = `
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="animation: spin 1s linear infinite;">
                    <path d="M12,4V2A10,10 0 0,0 2,12H4A8,8 0 0,1 12,4Z"/>
                </svg>
                Submitting...
            `;
            submitBtn.disabled = true;
        }
        
        // Submit the form
        this.submit();
    }
});

// Add spinning animation for loading
const style = document.createElement('style');
style.textContent = `
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
`;
document.head.appendChild(style);
</script>
@endsection
