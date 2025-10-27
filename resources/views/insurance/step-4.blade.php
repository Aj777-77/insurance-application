@extends('insurance.layout')

@section('content')
<form method="POST" action="{{ route('insurance.step.process', ['step' => $currentStep]) }}" id="step4Form">
    @csrf
    
    <div class="step-title">
        Insurance Details
    </div>
    
    <p style="text-align: center; color: #212529; margin-bottom: 30px;">
        Choose the type of insurance coverage you need
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
        <label class="form-label">Insurance Type * <small style="color: #6c757d;">(You can select one or both)</small></label>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 10px;">
            <label style="display: block; padding: 20px; border: 2px solid #e9ecef; border-radius: 8px; cursor: pointer; transition: all 0.3s ease;" class="insurance-option" data-type="accidental-damage">
                <input type="checkbox" name="insurance_types[]" value="accidental-damage" 
                    {{ in_array('accidental-damage', old('insurance_types', is_array($formData['insurance_type'] ?? null) ? $formData['insurance_type'] : (isset($formData['insurance_type']) ? [$formData['insurance_type']] : []))) ? 'checked' : '' }} 
                    style="margin-right: 10px;">
                <div>
                    <strong style="color: #4c63d2;">Zain Accidental Damage Protection</strong>
                    <p style="margin: 5px 0 0 0; font-size: 0.9rem; color: #212529;">
                        Covers accidental damage including drops, spills, and other unexpected incidents. Available in Premium and Saver tiers with flexible periods.
                    </p>
                </div>
            </label>
            
            <label style="display: block; padding: 20px; border: 2px solid #e9ecef; border-radius: 8px; cursor: pointer; transition: all 0.3s ease;" class="insurance-option" data-type="extended-warranty">
                <input type="checkbox" name="insurance_types[]" value="extended-warranty" 
                    {{ in_array('extended-warranty', old('insurance_types', is_array($formData['insurance_type'] ?? null) ? $formData['insurance_type'] : (isset($formData['insurance_type']) ? [$formData['insurance_type']] : []))) ? 'checked' : '' }} 
                    style="margin-right: 10px;">
                <div>
                    <strong style="color: #4c63d2;">Zain Extended Warranty</strong>
                    <p style="margin: 5px 0 0 0; font-size: 0.9rem; color: #212529;">
                        Extends your device's warranty coverage for an additional year beyond the manufacturer's warranty.
                    </p>
                </div>
            </label>
        </div>
        @error('insurance_types')
            <span class="error-message">{{ $message }}</span>
        @enderror
        @error('insurance_type')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <!-- Service Period for Accidental Damage -->
    <div class="form-group" id="accidental_damage_period" style="display: none;">
        <label for="accidental_damage_service_period" class="form-label">Accidental Damage Service Period *</label>
        <select class="form-control" id="accidental_damage_service_period" name="accidental_damage_service_period">
            <option value="">Select service period</option>
            <option value="premium-12-months" {{ old('accidental_damage_service_period', $formData['accidental_damage_service_period'] ?? '') == 'premium-12-months' ? 'selected' : '' }}>
                Premium - 12 Months
            </option>
            <option value="premium-18-months" {{ old('accidental_damage_service_period', $formData['accidental_damage_service_period'] ?? '') == 'premium-18-months' ? 'selected' : '' }}>
                Premium - 18 Months
            </option>
            <option value="premium-24-months" {{ old('accidental_damage_service_period', $formData['accidental_damage_service_period'] ?? '') == 'premium-24-months' ? 'selected' : '' }}>
                Premium - 24 Months
            </option>
            <option value="saver-12-months" {{ old('accidental_damage_service_period', $formData['accidental_damage_service_period'] ?? '') == 'saver-12-months' ? 'selected' : '' }}>
                Saver - 12 Months
            </option>
            <option value="saver-18-months" {{ old('accidental_damage_service_period', $formData['accidental_damage_service_period'] ?? '') == 'saver-18-months' ? 'selected' : '' }}>
                Saver - 18 Months
            </option>
            <option value="saver-24-months" {{ old('accidental_damage_service_period', $formData['accidental_damage_service_period'] ?? '') == 'saver-24-months' ? 'selected' : '' }}>
                Saver - 24 Months
            </option>
        </select>
        @error('accidental_damage_service_period')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <!-- Service Period for Extended Warranty -->
    <div class="form-group" id="extended_warranty_period" style="display: none;">
        <label for="extended_warranty_service_period" class="form-label">Extended Warranty Service Period *</label>
        <select class="form-control" id="extended_warranty_service_period" name="extended_warranty_service_period">
            <option value="">Select service period</option>
            <option value="extended-warranty-1-year" {{ old('extended_warranty_service_period', $formData['extended_warranty_service_period'] ?? '') == 'extended-warranty-1-year' ? 'selected' : '' }}>
                Extended Warranty - 1 Year
            </option>
        </select>
        @error('extended_warranty_service_period')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="#4c63d2">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
            <h4 style="margin: 0; color: #4c63d2;">Coverage Includes:</h4>
        </div>
        <ul style="margin: 0; padding-left: 20px; color: #212529;">
            <li>24/7 customer support</li>
            <li>Fast repair or replacement service</li>
            <li>Coverage for original accessories</li>
            <li>No hidden fees or deductibles</li>
            <li>Worldwide coverage protection</li>
        </ul>
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
// Insurance type selection styling
document.querySelectorAll('input[name="insurance_types[]"]').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const label = this.closest('.insurance-option');
        const insuranceType = label.getAttribute('data-type');
        
        if (this.checked) {
            label.style.borderColor = '#4c63d2';
            label.style.backgroundColor = '#f8f9ff';
            
            // Show corresponding service period section
            if (insuranceType === 'accidental-damage') {
                document.getElementById('accidental_damage_period').style.display = 'block';
                document.getElementById('accidental_damage_service_period').setAttribute('required', 'required');
            } else if (insuranceType === 'extended-warranty') {
                document.getElementById('extended_warranty_period').style.display = 'block';
                document.getElementById('extended_warranty_service_period').setAttribute('required', 'required');
            }
        } else {
            label.style.borderColor = '#e9ecef';
            label.style.backgroundColor = '#fff';
            
            // Hide corresponding service period section
            if (insuranceType === 'accidental-damage') {
                document.getElementById('accidental_damage_period').style.display = 'none';
                document.getElementById('accidental_damage_service_period').removeAttribute('required');
                document.getElementById('accidental_damage_service_period').value = '';
            } else if (insuranceType === 'extended-warranty') {
                document.getElementById('extended_warranty_period').style.display = 'none';
                document.getElementById('extended_warranty_service_period').removeAttribute('required');
                document.getElementById('extended_warranty_service_period').value = '';
            }
        }
    });
});

// Initialize selected option styling on page load
document.addEventListener('DOMContentLoaded', function() {
    const selectedCheckboxes = document.querySelectorAll('input[name="insurance_types[]"]:checked');
    selectedCheckboxes.forEach(checkbox => {
        checkbox.dispatchEvent(new Event('change'));
    });
});

// Form validation
document.getElementById('step4Form').addEventListener('submit', function(e) {
    let isValid = true;
    
    // Clear previous error messages
    document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
    
    // Check if at least one insurance type is selected
    const insuranceTypesChecked = document.querySelectorAll('input[name="insurance_types[]"]:checked');
    if (insuranceTypesChecked.length === 0) {
        isValid = false;
        const errorSpan = document.querySelector('input[name="insurance_types[]"]').closest('.form-group').querySelector('.error-message');
        if (errorSpan) {
            errorSpan.textContent = 'Please select at least one insurance type';
        }
    }
    
    // Check service periods for selected insurance types
    insuranceTypesChecked.forEach(checkbox => {
        const label = checkbox.closest('.insurance-option');
        const insuranceType = label.getAttribute('data-type');
        
        if (insuranceType === 'accidental-damage') {
            const servicePeriod = document.getElementById('accidental_damage_service_period');
            if (!servicePeriod.value) {
                isValid = false;
                const errorSpan = servicePeriod.parentNode.querySelector('.error-message');
                if (errorSpan) {
                    errorSpan.textContent = 'Please select a service period for Accidental Damage Protection';
                }
                servicePeriod.style.borderColor = '#dc3545';
            } else {
                servicePeriod.style.borderColor = '#28a745';
            }
        }
        
        if (insuranceType === 'extended-warranty') {
            const servicePeriod = document.getElementById('extended_warranty_service_period');
            if (!servicePeriod.value) {
                isValid = false;
                const errorSpan = servicePeriod.parentNode.querySelector('.error-message');
                if (errorSpan) {
                    errorSpan.textContent = 'Please select a service period for Extended Warranty';
                }
                servicePeriod.style.borderColor = '#dc3545';
            } else {
                servicePeriod.style.borderColor = '#28a745';
            }
        }
    });
    
    if (!isValid) {
        e.preventDefault();
    }
});
</script>
@endsection
