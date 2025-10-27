@extends('insurance.layout')

@section('content')
<form method="POST" action="{{ route('insurance.step.process', ['step' => $currentStep]) }}" id="step1Form">
    @csrf
    
    <div class="step-title">
        Personal Information
    </div>
    


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
        <label for="full_name" class="form-label">Full Name *</label>
        <input 
            type="text" 
            class="form-control" 
            id="full_name" 
            name="full_name" 
            autocomplete="name"
            required 
            value="{{ old('full_name', $formData['full_name'] ?? '') }}"
            placeholder="Your Name">
        @error('full_name')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="contact_number" class="form-label">Contact Number *</label>
            <input 
                type="tel" 
                class="form-control" 
                id="contact_number" 
                name="contact_number" 
                autocomplete="tel"
                required 
                value="{{ old('contact_number', $formData['contact_number'] ?? '') }}"
                placeholder="36******">
            @error('contact_number')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Email Address *</label>
            <input 
                type="email" 
                class="form-control" 
                id="email" 
                name="email" 
                autocomplete="email"
                required 
                value="{{ old('email', $formData['email'] ?? '') }}"
                placeholder="your.email@example.com">
            @error('email')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="button-group">
        <div></div> <!-- Empty div for spacing -->
        <button type="submit" class="btn btn-primary">
            Next Step
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2L13.09 8.26L22 9L13.09 9.74L12 16L10.91 9.74L2 9L10.91 8.26L12 2Z"/>
                <path d="M8 12L14 18L22 10"/>
            </svg>
        </button>
    </div>
</form>

<script>
document.getElementById('step1Form').addEventListener('submit', function(e) {
    const requiredFields = ['full_name', 'contact_number', 'email'];
    let isValid = true;
    
    // Clear previous error messages
    document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
    
    requiredFields.forEach(field => {
        const input = document.getElementById(field);
        if (!input.value.trim()) {
            isValid = false;
            const errorSpan = input.parentNode.querySelector('.error-message');
            if (errorSpan) {
                errorSpan.textContent = 'This field is required';
            }
            input.style.borderColor = '#dc3545';
        } else {
            input.style.borderColor = '#28a745';
        }
    });
    
    // Email validation
    const emailInput = document.getElementById('email');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (emailInput.value && !emailRegex.test(emailInput.value)) {
        isValid = false;
        const errorSpan = emailInput.parentNode.querySelector('.error-message');
        if (errorSpan) {
            errorSpan.textContent = 'Please enter a valid email address';
        }
        emailInput.style.borderColor = '#dc3545';
    }
    
    if (!isValid) {
        e.preventDefault();
    }
});

// Real-time validation feedback
document.querySelectorAll('.form-control').forEach(input => {
    input.addEventListener('blur', function() {
        if (this.value.trim()) {
            this.style.borderColor = '#28a745';
        } else if (this.required) {
            this.style.borderColor = '#dc3545';
        }
    });
    
    input.addEventListener('input', function() {
        if (this.style.borderColor === 'rgb(220, 53, 69)') { // red border
            this.style.borderColor = '#e9ecef';
        }
    });
});
</script>
@endsection
