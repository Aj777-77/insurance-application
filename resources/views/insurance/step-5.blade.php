@extends('insurance.layout')

@section('content')
<form method="POST" action="{{ route('insurance.step.process', ['step' => $currentStep]) }}" id="step5Form" enctype="multipart/form-data">
    @csrf
    
    <div class="step-title">
        File Uploads
    </div>
    
    <p style="text-align: center; color: #212529; margin-bottom: 30px;">
        Upload images of your device and purchase receipt
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
        <label class="form-label">Device Images *</label>
        <div class="file-upload-area" style="border: 2px dashed #667eea; padding: 40px; text-align: center; border-radius: 8px; background: #f8f9ff; cursor: pointer; transition: all 0.3s ease;" onclick="document.getElementById('device_images').click()">
            <input type="file" id="device_images" name="device_images[]" multiple accept="image/jpeg,image/jpg,image/png" style="display: none;" required>
            <svg width="48" height="48" viewBox="0 0 24 24" fill="#667eea" style="margin-bottom: 10px;">
                <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
            </svg>
            <h4 style="color: #667eea; margin-bottom: 10px;">Upload Device Images</h4>
            <p style="color: #212529; margin: 0;">Click here or drag and drop multiple images</p>
            <small style="color: #999; display: block; margin-top: 5px;">JPEG, JPG, PNG - Max 2MB each</small>
            <div id="device_images_preview" style="margin-top: 15px;">
                @if(isset($uploadedFiles['device_images']) && count($uploadedFiles['device_images']) > 0)
                    @foreach($uploadedFiles['device_images'] as $imagePath)
                        <div style="background: #28a745; color: white; padding: 5px 10px; border-radius: 4px; margin: 5px; display: inline-block; font-size: 0.875rem;">
                            ✓ {{ basename($imagePath) }}
                        </div>
                    @endforeach
                    <p style="color: #28a745; font-size: 0.9rem; margin-top: 10px;">
                        {{ count($uploadedFiles['device_images']) }} image(s) already uploaded. Upload new images to replace them.
                    </p>
                @endif
            </div>
        </div>
        @error('device_images.*')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label">Purchase Receipt *</label>
        <div class="file-upload-area" style="border: 2px dashed #667eea; padding: 40px; text-align: center; border-radius: 8px; background: #f8f9ff; cursor: pointer; transition: all 0.3s ease;" onclick="document.getElementById('purchase_receipt').click()">
            <input type="file" id="purchase_receipt" name="purchase_receipt" accept="image/jpeg,image/jpg,image/png,application/pdf" style="display: none;" required>
            <svg width="48" height="48" viewBox="0 0 24 24" fill="#667eea" style="margin-bottom: 10px;">
                <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
            </svg>
            <h4 style="color: #667eea; margin-bottom: 10px;">Upload Purchase Receipt</h4>
            <p style="color: #212529; margin: 0;">Click here to upload your receipt</p>
            <small style="color: #999; display: block; margin-top: 5px;">JPEG, JPG, PNG, PDF - Max 2MB</small>
            <div id="receipt_preview" style="margin-top: 15px;">
                @if(isset($uploadedFiles['receipt']) && $uploadedFiles['receipt'])
                    <div style="background: #28a745; color: white; padding: 5px 10px; border-radius: 4px; font-size: 0.875rem; display: inline-block;">
                        ✓ {{ basename($uploadedFiles['receipt']) }}
                    </div>
                    <p style="color: #28a745; font-size: 0.9rem; margin-top: 10px;">
                        Receipt already uploaded. Upload a new file to replace it.
                    </p>
                @endif
            </div>
        </div>
        @error('purchase_receipt')
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
// Device images preview
document.getElementById('device_images').addEventListener('change', function() {
    const preview = document.getElementById('device_images_preview');
    preview.innerHTML = '';
    
    for (let i = 0; i < this.files.length; i++) {
        const file = this.files[i];
        const fileName = document.createElement('div');
        fileName.style.cssText = 'background: #28a745; color: white; padding: 5px 10px; border-radius: 4px; margin: 5px; display: inline-block; font-size: 0.875rem;';
        fileName.textContent = `✓ ${file.name}`;
        preview.appendChild(fileName);
    }
    
    // Update upload area styling
    const uploadArea = this.closest('.file-upload-area');
    uploadArea.style.borderColor = '#28a745';
    uploadArea.style.backgroundColor = '#f0fff4';
});

// Purchase receipt preview
document.getElementById('purchase_receipt').addEventListener('change', function() {
    const preview = document.getElementById('receipt_preview');
    const file = this.files[0];
    if (file) {
        preview.innerHTML = `<div style="background: #28a745; color: white; padding: 5px 10px; border-radius: 4px; font-size: 0.875rem; display: inline-block;">✓ ${file.name}</div>`;
        
        // Update upload area styling
        const uploadArea = this.closest('.file-upload-area');
        uploadArea.style.borderColor = '#28a745';
        uploadArea.style.backgroundColor = '#f0fff4';
    }
});

// File upload area hover effects
document.querySelectorAll('.file-upload-area').forEach(area => {
    area.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.style.borderColor = '#4c63d2';
        this.style.backgroundColor = '#e8f2ff';
    });
    
    area.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.style.borderColor = '#667eea';
        this.style.backgroundColor = '#f8f9ff';
    });
    
    area.addEventListener('drop', function(e) {
        e.preventDefault();
        const input = this.querySelector('input[type="file"]');
        input.files = e.dataTransfer.files;
        input.dispatchEvent(new Event('change'));
    });
});

// Form validation
document.getElementById('step5Form').addEventListener('submit', function(e) {
    let isValid = true;
    
    // Check device images
    const deviceImages = document.getElementById('device_images');
    if (!deviceImages.files || deviceImages.files.length === 0) {
        isValid = false;
        alert('Please upload at least one device image');
    }
    
    // Check purchase receipt
    const purchaseReceipt = document.getElementById('purchase_receipt');
    if (!purchaseReceipt.files || purchaseReceipt.files.length === 0) {
        isValid = false;
        alert('Please upload your purchase receipt');
    }
    
    if (!isValid) {
        e.preventDefault();
    }
});
</script>
@endsection
