@extends('insurance.layout')

@section('content')
<form method="POST" action="{{ route('insurance.step.process', ['step' => $currentStep]) }}" id="step6Form">
    @csrf
    
    <div class="step-title">
        Digital Signature
    </div>
    
    <p style="text-align: center; color: #212529; margin-bottom: 30px;">
        Please provide your digital signature and agree to the terms
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

    <div class="form-group">
        <label for="signature_name" class="form-label">Your Name *</label>
        <input 
            type="text" 
            class="form-control" 
            id="signature_name" 
            name="signature_name" 
            required 
            value="{{ old('signature_name', $formData['signature_name'] ?? '') }}"
            placeholder="Your name">
        @error('signature_name')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label">Draw Your Signature *</label>
        <div style="text-align: center;">
            <canvas 
                id="signature" 
                width="600" 
                height="200" 
                style="border: 2px solid black; cursor: crosshair; background: white; max-width: 100%;">
            </canvas>
            <input type="hidden" id="signature_data" name="signature_data" required>
        </div>
        <div style="text-align: center; margin-top: 10px;">
            <button type="button" class="btn btn-secondary" onclick="clearSignature()" style="padding: 8px 16px; font-size: 0.875rem;">
                Clear Signature
            </button>
        </div>
        @error('signature_data')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div style="background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px; padding: 20px; margin: 20px 0;">
        <h4 style="color: #856404; margin-bottom: 15px;">📋 Terms and Conditions</h4>
        <div style="max-height: 200px; overflow-y: auto; background: white; padding: 15px; border-radius: 4px; margin-bottom: 15px; font-size: 0.9rem; line-height: 1.6; color: #212529;">
            <p style="margin-bottom: 12px;"><strong>1. Coverage Agreement:</strong> This insurance policy provides coverage for the specified device subject to the terms and conditions outlined herein.</p>
            
            <p style="margin-bottom: 12px;"><strong>2. Premium Payment:</strong> Coverage begins upon receipt of the first premium payment and continues for the selected policy period.</p>
            
            <p style="margin-bottom: 12px;"><strong>3. Claim Process:</strong> Claims must be reported within 30 days of the incident. All claims are subject to investigation and approval.</p>
            
            <p style="margin-bottom: 12px;"><strong>4. Exclusions:</strong> This policy does not cover intentional damage, theft due to negligence, or pre-existing conditions.</p>
            
            <p style="margin-bottom: 12px;"><strong>5. Deductible:</strong> A deductible may apply to certain claims as specified in your policy documents.</p>
            
            <p style="margin-bottom: 12px;"><strong>6. Policy Changes:</strong> This policy cannot be modified except in writing and signed by an authorized representative.</p>
            
            <p style="margin-bottom: 0;"><strong>7. Cancellation:</strong> You may cancel this policy at any time with written notice. Refunds are prorated based on unused coverage period.</p>
        </div>
        
        <label style="display: flex; align-items: flex-start; gap: 10px; cursor: default;">
            <input 
                type="checkbox" 
                id="terms_agreement_display" 
                name="terms_agreement_display" 
                value="1" 
                checked
                disabled
                style="margin-top: 3px; width: auto; cursor: not-allowed;">
            <input type="hidden" name="terms_agreement" value="1">
            <span style="color: #212529; font-size: 0.95rem; line-height: 1.4;">
                I acknowledge that I have read, understood, and agree to be bound by the terms and conditions of this insurance policy. I confirm that all information provided is accurate and complete. *
            </span>
        </label>
        @error('terms_agreement')
            <span class="error-message" style="display: block; margin-top: 5px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="button-group">
        <a href="{{ route('insurance.step', ['step' => $currentStep - 1]) }}" class="btn btn-secondary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                <path d="M15 18L9 12L15 6"/>
            </svg>
            Previous Step
        </a>
        <button type="submit" class="btn btn-primary">
            Final Review
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                <path d="M9 18L15 12L9 6"/>
            </svg>
        </button>
    </div>
</form>

<script>
var canvas = document.getElementById('signature');
var ctx = canvas.getContext("2d");
var drawing = false;
var prevX, prevY;
var currX, currY;
var signature = document.getElementById('signature_data');

canvas.addEventListener("mousemove", draw);
canvas.addEventListener("mouseup", stop);
canvas.addEventListener("mousedown", start);

// Touch support for mobile devices
canvas.addEventListener("touchmove", function(e) {
    e.preventDefault();
    var touch = e.touches[0];
    var mouseEvent = new MouseEvent("mousemove", {
        clientX: touch.clientX,
        clientY: touch.clientY
    });
    canvas.dispatchEvent(mouseEvent);
}, { passive: false });

canvas.addEventListener("touchend", function(e) {
    e.preventDefault();
    stop();
}, { passive: false });

canvas.addEventListener("touchstart", function(e) {
    e.preventDefault();
    var touch = e.touches[0];
    var mouseEvent = new MouseEvent("mousedown", {
        clientX: touch.clientX,
        clientY: touch.clientY
    });
    canvas.dispatchEvent(mouseEvent);
}, { passive: false });

function start(e) {
    drawing = true;
    var rect = canvas.getBoundingClientRect();
    prevX = e.clientX - rect.left;
    prevY = e.clientY - rect.top;
}

function stop() {
    drawing = false;
    prevX = prevY = null;
    signature.value = canvas.toDataURL();
}

function draw(e) {
    if (!drawing) {
        return;
    }
    
    var rect = canvas.getBoundingClientRect();
    currX = e.clientX - rect.left;
    currY = e.clientY - rect.top;
    
    ctx.beginPath();
    ctx.moveTo(prevX, prevY);
    ctx.lineTo(currX, currY);
    ctx.strokeStyle = 'black';
    ctx.lineWidth = 2;
    ctx.stroke();
    ctx.closePath();

    prevX = currX;
    prevY = currY;
}

function clearSignature() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    signature.value = '';
}

// Form validation on submit
document.getElementById('step6Form').addEventListener('submit', function(e) {
    // Check if signature is drawn
    if (!signature.value) {
        alert('Please draw your signature');
        e.preventDefault();
        return false;
    }
    
    // Check if name is filled
    var name = document.getElementById('signature_name');
    if (!name.value.trim()) {
        alert('Please enter your name');
        e.preventDefault();
        return false;
    }
    
    return true;
});
</script>
@endsection
