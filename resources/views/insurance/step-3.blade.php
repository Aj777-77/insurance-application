@extends('insurance.layout')

@section('content')
<form method="POST" action="{{ route('insurance.step.process', ['step' => $currentStep]) }}" id="step3Form">
    @csrf
    
    <div class="step-title">
        Device Information
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

    <div class="form-row">
        <div class="form-group">
            <label for="device_brand" class="form-label">Device Brand *</label>
            <select 
                class="form-control" 
                id="device_brand" 
                name="device_brand" 
                required>
                <option value="">Select Device Brand</option>
                <option value="Apple" {{ old('device_brand', $formData['device_brand'] ?? '') == 'Apple' ? 'selected' : '' }}>Apple</option>
                <option value="Samsung" {{ old('device_brand', $formData['device_brand'] ?? '') == 'Samsung' ? 'selected' : '' }}>Samsung</option>
                <option value="Google" {{ old('device_brand', $formData['device_brand'] ?? '') == 'Google' ? 'selected' : '' }}>Google</option>
                <option value="OnePlus" {{ old('device_brand', $formData['device_brand'] ?? '') == 'OnePlus' ? 'selected' : '' }}>OnePlus</option>
                <option value="Xiaomi" {{ old('device_brand', $formData['device_brand'] ?? '') == 'Xiaomi' ? 'selected' : '' }}>Xiaomi</option>
                <option value="Huawei" {{ old('device_brand', $formData['device_brand'] ?? '') == 'Huawei' ? 'selected' : '' }}>Huawei</option>
                <option value="Oppo" {{ old('device_brand', $formData['device_brand'] ?? '') == 'Oppo' ? 'selected' : '' }}>Oppo</option>
                <option value="Vivo" {{ old('device_brand', $formData['device_brand'] ?? '') == 'Vivo' ? 'selected' : '' }}>Vivo</option>
                <option value="Sony" {{ old('device_brand', $formData['device_brand'] ?? '') == 'Sony' ? 'selected' : '' }}>Sony</option>
                <option value="Nokia" {{ old('device_brand', $formData['device_brand'] ?? '') == 'Nokia' ? 'selected' : '' }}>Nokia</option>
                <option value="Motorola" {{ old('device_brand', $formData['device_brand'] ?? '') == 'Motorola' ? 'selected' : '' }}>Motorola</option>
                <option value="Realme" {{ old('device_brand', $formData['device_brand'] ?? '') == 'Realme' ? 'selected' : '' }}>Realme</option>
                <option value="Nothing" {{ old('device_brand', $formData['device_brand'] ?? '') == 'Nothing' ? 'selected' : '' }}>Nothing</option>
                <option value="Other" {{ old('device_brand', $formData['device_brand'] ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
            @error('device_brand')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <!-- Other Brand Input (shown when "Other" is selected) -->
        <div class="form-group" id="other_brand_group" style="display: none;">
            <label for="other_brand" class="form-label">Please specify brand *</label>
            <input 
                type="text" 
                class="form-control" 
                id="other_brand" 
                name="other_brand" 
                value="{{ old('other_brand', $formData['other_brand'] ?? '') }}"
                placeholder="Enter brand name">
            @error('other_brand')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="device_model" class="form-label">Device Model *</label>
            
            <!-- Apple iPhone Models Dropdown (shown when Apple is selected) -->
            <select 
                class="form-control" 
                id="apple_model_dropdown"
                style="display: none;">
                <option value="">Select iPhone Model</option>
                <option value="Other" {{ old('device_model', $formData['device_model'] ?? '') == 'Other' ? 'selected' : '' }}>Other (specify below)</option>
                <option value="iPhone 15" {{ old('device_model', $formData['device_model'] ?? '') == 'iPhone 15' ? 'selected' : '' }}>iPhone 15</option>
                <option value="iPhone 15 Plus" {{ old('device_model', $formData['device_model'] ?? '') == 'iPhone 15 Plus' ? 'selected' : '' }}>iPhone 15 Plus</option>
                <option value="iPhone 15 Pro" {{ old('device_model', $formData['device_model'] ?? '') == 'iPhone 15 Pro' ? 'selected' : '' }}>iPhone 15 Pro</option>
                <option value="iPhone 15 Pro Max" {{ old('device_model', $formData['device_model'] ?? '') == 'iPhone 15 Pro Max' ? 'selected' : '' }}>iPhone 15 Pro Max</option>
                <option value="iPhone 16" {{ old('device_model', $formData['device_model'] ?? '') == 'iPhone 16' ? 'selected' : '' }}>iPhone 16</option>
                <option value="iPhone 16 Plus" {{ old('device_model', $formData['device_model'] ?? '') == 'iPhone 16 Plus' ? 'selected' : '' }}>iPhone 16 Plus</option>
                <option value="iPhone 16 Pro" {{ old('device_model', $formData['device_model'] ?? '') == 'iPhone 16 Pro' ? 'selected' : '' }}>iPhone 16 Pro</option>
                <option value="iPhone 16 Pro Max" {{ old('device_model', $formData['device_model'] ?? '') == 'iPhone 16 Pro Max' ? 'selected' : '' }}>iPhone 16 Pro Max</option>
                <option value="iPhone 16e" {{ old('device_model', $formData['device_model'] ?? '') == 'iPhone 16e' ? 'selected' : '' }}>iPhone 16e</option>
                <option value="iPhone 17" {{ old('device_model', $formData['device_model'] ?? '') == 'iPhone 17' ? 'selected' : '' }}>iPhone 17</option>
                <option value="iPhone 17 Pro" {{ old('device_model', $formData['device_model'] ?? '') == 'iPhone 17 Pro' ? 'selected' : '' }}>iPhone 17 Pro</option>
                <option value="iPhone 17 Pro Max" {{ old('device_model', $formData['device_model'] ?? '') == 'iPhone 17 Pro Max' ? 'selected' : '' }}>iPhone 17 Pro Max</option>
                <option value="iPhone Air" {{ old('device_model', $formData['device_model'] ?? '') == 'iPhone Air' ? 'selected' : '' }}>iPhone Air</option>
            </select>
            
            <!-- Custom Apple Model Input (shown when "Other" is selected in Apple dropdown) -->
            <input 
                type="text" 
                class="form-control" 
                id="custom_apple_model"
                style="display: none; margin-top: 10px;"
                value="{{ old('custom_apple_model', $formData['custom_apple_model'] ?? '') }}"
                placeholder="Enter custom iPhone model (e.g., iPhone 14, iPhone SE, etc.)">
            
            <!-- Hidden input that will always carry the device_model value -->
            <input type="hidden" id="device_model_hidden" name="device_model" value="{{ old('device_model', $formData['device_model'] ?? '') }}">
            
            <!-- General Device Model Input (shown for non-Apple brands) -->
            <input 
                type="text" 
                class="form-control" 
                id="device_model_input"
                style="display: none;"
                value="{{ old('device_model', $formData['device_model'] ?? '') }}"
                placeholder="Galaxy S24, Pixel 8 Pro, OnePlus 12">
            
            @error('device_model')
                <span class="error-message">{{ $message }}</span>
            @enderror
            @error('custom_apple_model')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="imei_number" class="form-label">IMEI Number (15 digits) *</label>
        <input 
            type="text" 
            class="form-control" 
            id="imei_number" 
            name="imei_number" 
            required 
            maxlength="15" 
            pattern="[0-9]{15}"
            value="{{ old('imei_number', $formData['imei_number'] ?? '') }}"
            placeholder="123456789012345">
        <small style="color: #6c757d; font-size: 0.875rem;">
            Dial *#06# on your device to get the IMEI number
        </small>
        @error('imei_number')
            <span class="error-message">{{ $message }}</span>
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
            Next Step
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                <path d="M9 18L15 12L9 6"/>
            </svg>
        </button>
    </div>
</form>

<script>
// Device brand dropdown - handle "Other" input and Apple model dropdown
document.getElementById('device_brand').addEventListener('change', function() {
    const selectedBrand = this.value;
    
    // Get all elements
    const otherBrandGroup = document.getElementById('other_brand_group');
    const otherBrandInput = document.getElementById('other_brand');
    const appleModelDropdown = document.getElementById('apple_model_dropdown');
    const deviceModelInput = document.getElementById('device_model_input');
    const customAppleModel = document.getElementById('custom_apple_model');
    
    // Hide all conditional elements first
    otherBrandGroup.style.display = 'none';
    appleModelDropdown.style.display = 'none';
    deviceModelInput.style.display = 'none';
    customAppleModel.style.display = 'none';
    
    // Reset all required attributes
    otherBrandInput.required = false;
    appleModelDropdown.required = false;
    deviceModelInput.required = false;
    customAppleModel.required = false;
    
    // Show appropriate elements based on selection (don't clear values here)
    if (selectedBrand === 'Other') {
        otherBrandGroup.style.display = 'block';
        otherBrandInput.required = true;
        deviceModelInput.style.display = 'block';
        deviceModelInput.required = true;
    } else if (selectedBrand === 'Apple') {
        appleModelDropdown.style.display = 'block';
        appleModelDropdown.required = true;
    } else if (selectedBrand) {
        deviceModelInput.style.display = 'block';
        deviceModelInput.required = true;
    }
});

// Apple model dropdown - show/hide custom input for "Other" option
document.getElementById('apple_model_dropdown').addEventListener('change', function() {
    const customAppleModel = document.getElementById('custom_apple_model');
    const deviceModelHidden = document.getElementById('device_model_hidden');
    
    if (this.value === 'Other') {
        customAppleModel.style.display = 'block';
        customAppleModel.required = true;
        customAppleModel.style.animation = 'fadeInUp 0.3s ease-out';
    } else {
        customAppleModel.style.display = 'none';
        customAppleModel.required = false;
        customAppleModel.value = '';
        // Sync the selected Apple model to hidden field immediately
        if (this.value) {
            deviceModelHidden.value = this.value;
        }
    }
});

// Sync custom Apple model input to hidden field
document.getElementById('custom_apple_model').addEventListener('input', function() {
    const deviceModelHidden = document.getElementById('device_model_hidden');
    deviceModelHidden.value = this.value;
});

// Sync general device model input to hidden field
document.getElementById('device_model_input').addEventListener('input', function() {
    const deviceModelHidden = document.getElementById('device_model_hidden');
    deviceModelHidden.value = this.value;
});

// Initialize the form state on page load
document.addEventListener('DOMContentLoaded', function() {
    // Trigger change event to set initial state
    const deviceBrandSelect = document.getElementById('device_brand');
    const currentBrand = deviceBrandSelect.value;
    
    console.log('Initial brand on load:', currentBrand); // Debug
    
    // Always trigger the change event to initialize display state
    if (currentBrand) {
        // Manually trigger the visibility logic
        const appleModelDropdown = document.getElementById('apple_model_dropdown');
        const deviceModelInput = document.getElementById('device_model_input');
        const customAppleModel = document.getElementById('custom_apple_model');
        const otherBrandGroup = document.getElementById('other_brand_group');
        
        if (currentBrand === 'Apple') {
            console.log('Showing Apple dropdown on load'); // Debug
            appleModelDropdown.style.display = 'block';
            appleModelDropdown.required = true;
            
            // Restore the Apple model selection if available
            const savedModel = '{{ old("device_model", $formData["device_model"] ?? "") }}';
            if (savedModel) {
                if (appleModelDropdown.querySelector('option[value="' + savedModel + '"]')) {
                    appleModelDropdown.value = savedModel;
                    if (savedModel === 'Other') {
                        customAppleModel.style.display = 'block';
                        customAppleModel.required = true;
                        appleModelDropdown.name = 'apple_model_selection';
                        customAppleModel.name = 'device_model';
                    }
                } else {
                    // Custom model case
                    appleModelDropdown.value = 'Other';
                    customAppleModel.style.display = 'block';
                    customAppleModel.required = true;
                    customAppleModel.value = savedModel;
                    appleModelDropdown.name = 'apple_model_selection';
                    customAppleModel.name = 'device_model';
                }
            }
        } else if (currentBrand === 'Other') {
            otherBrandGroup.style.display = 'block';
            deviceModelInput.style.display = 'block';
            deviceModelInput.required = true;
        } else if (currentBrand) {
            deviceModelInput.style.display = 'block';
            deviceModelInput.required = true;
        }
    }
});

// IMEI number formatting
document.getElementById('imei_number').addEventListener('input', function(e) {
    // Remove any non-numeric characters
    let value = e.target.value.replace(/\D/g, '');
    
    // Limit to 15 digits
    if (value.length > 15) {
        value = value.substr(0, 15);
    }
    
    e.target.value = value;
    
    // Visual feedback for IMEI validation
    if (value.length === 15) {
        e.target.style.borderColor = '#28a745';
    } else if (value.length > 0) {
        e.target.style.borderColor = '#ffc107';
    } else {
        e.target.style.borderColor = '#dc3545';
    }
});

// Purchase date validation (cannot be in the future)
document.getElementById('purchase_date').addEventListener('change', function(e) {
    const selectedDate = new Date(e.target.value);
    const today = new Date();
    today.setHours(23, 59, 59, 999); // End of today
    
    if (selectedDate > today) {
        alert('Purchase date cannot be in the future');
        e.target.value = '';
        e.target.style.borderColor = '#dc3545';
    } else {
        e.target.style.borderColor = '#28a745';
    }
});

// Form validation
document.getElementById('step3Form').addEventListener('submit', function(e) {
    let isValid = true;
    
    // Clear previous error messages
    document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
    
    // Get form elements
    const deviceBrandSelect = document.getElementById('device_brand');
    const deviceBrand = deviceBrandSelect.value;
    const deviceModelHidden = document.getElementById('device_model_hidden');
    const appleModelDropdown = document.getElementById('apple_model_dropdown');
    
    console.log('Form submit - Brand:', deviceBrand);
    console.log('Apple dropdown value:', appleModelDropdown.value);
    
    // Sync the visible field value to the hidden device_model input
    if (deviceBrand === 'Apple') {
        if (appleModelDropdown.value && appleModelDropdown.value !== 'Other') {
            deviceModelHidden.value = appleModelDropdown.value;
            console.log('Set hidden field to Apple model:', appleModelDropdown.value);
        } else if (appleModelDropdown.value === 'Other') {
            const customAppleModel = document.getElementById('custom_apple_model');
            deviceModelHidden.value = customAppleModel.value;
            console.log('Set hidden field to custom model:', customAppleModel.value);
        } else {
            // If no value selected, mark as invalid
            isValid = false;
            const errorSpan = appleModelDropdown.parentNode.querySelector('.error-message');
            if (errorSpan) {
                errorSpan.textContent = 'Please select an iPhone model';
            }
        }
    } else if (deviceBrand && deviceBrand !== 'Other') {
        const deviceModelInput = document.getElementById('device_model_input');
        deviceModelHidden.value = deviceModelInput.value;
        console.log('Set hidden field to device model:', deviceModelInput.value);
    }
    
    console.log('Final hidden field value:', deviceModelHidden.value);
    
    // Ensure hidden select fields are enabled for submission
    if (appleModelDropdown.style.display === 'none') {
        appleModelDropdown.removeAttribute('required');
    }
    
    // Validate device brand
    if (!deviceBrandSelect.value.trim()) {
        isValid = false;
        const errorSpan = deviceBrandSelect.parentNode.querySelector('.error-message');
        if (errorSpan) {
            errorSpan.textContent = 'This field is required';
        }
        deviceBrandSelect.style.borderColor = '#dc3545';
    }
    
    // Validate device model based on brand selection
    if (deviceBrand === 'Apple') {
        const appleModelDropdown = document.getElementById('apple_model_dropdown');
        if (appleModelDropdown.value === 'Other') {
            const customAppleModelInput = document.getElementById('custom_apple_model');
            if (!customAppleModelInput.value.trim()) {
                isValid = false;
                const errorSpan = customAppleModelInput.parentNode.querySelector('.error-message');
                if (errorSpan) {
                    errorSpan.textContent = 'Please specify the iPhone model';
                }
                customAppleModelInput.style.borderColor = '#dc3545';
            }
        } else if (!appleModelDropdown.value.trim()) {
            isValid = false;
            const errorSpan = appleModelDropdown.parentNode.querySelector('.error-message');
            if (errorSpan) {
                errorSpan.textContent = 'Please select an iPhone model';
            }
            appleModelDropdown.style.borderColor = '#dc3545';
        }
    } else if (deviceBrand && deviceBrand !== 'Other') {
        const deviceModelInput = document.getElementById('device_model_input');
        if (!deviceModelInput.value.trim()) {
            isValid = false;
            const errorSpan = deviceModelInput.parentNode.querySelector('.error-message');
            if (errorSpan) {
                errorSpan.textContent = 'This field is required';
            }
            deviceModelInput.style.borderColor = '#dc3545';
        }
    }
    
    // Validate other required fields
    const otherRequiredFields = ['imei_number'];
    otherRequiredFields.forEach(field => {
        const input = document.getElementById(field);
        if (!input.value.trim()) {
            isValid = false;
            const errorSpan = input.parentNode.querySelector('.error-message');
            if (errorSpan) {
                errorSpan.textContent = 'This field is required';
            }
            input.style.borderColor = '#dc3545';
        }
    });
    
    // Validate "Other" brand field if selected
    const otherBrandInput = document.getElementById('other_brand');
    if (deviceBrand === 'Other' && !otherBrandInput.value.trim()) {
        isValid = false;
        const errorSpan = otherBrandInput.parentNode.querySelector('.error-message');
        if (errorSpan) {
            errorSpan.textContent = 'Please specify the brand name';
        }
        otherBrandInput.style.borderColor = '#dc3545';
    }
    
    // IMEI validation
    const imeiInput = document.getElementById('imei_number');
    if (imeiInput.value && imeiInput.value.length !== 15) {
        isValid = false;
        const errorSpan = imeiInput.parentNode.querySelector('.error-message');
        if (errorSpan) {
            errorSpan.textContent = 'IMEI number must be exactly 15 digits';
        }
        imeiInput.style.borderColor = '#dc3545';
    }
    
    if (!isValid) {
        e.preventDefault();
    }
});
</script>
@endsection
