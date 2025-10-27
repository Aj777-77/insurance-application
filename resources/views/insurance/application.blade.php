<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Insurance Application Form</title>
    
    <style>
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .form-section {
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #e5e5e5;
            border-radius: 6px;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #212529;
            margin-bottom: 15px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 8px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #212529;
        }
        
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        
        .form-control:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0,123,255,0.3);
        }
        
        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .checkbox-group input[type="checkbox"] {
            margin-right: 8px;
        }
        
        .file-upload {
            border: 2px dashed #ddd;
            padding: 20px;
            text-align: center;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .file-upload:hover {
            border-color: #007bff;
        }
        
        .signature-pad {
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: crosshair;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin: 5px;
        }
        
        .btn-primary {
            background: linear-gradient(90deg, #1f4d5b 0%, #3c8981 100%);
            color: #ffffff;
        }
        
        .btn-secondary {
            background: linear-gradient(90deg, #1f4d5b 0%, #3c8981 100%);
            color: #ffffff;
        }
        
        .btn-success {
            background: linear-gradient(90deg, #1f4d5b 0%, #3c8981 100%);
            color: #ffffff;
        }
        
        .btn:hover {
            opacity: 0.9;
        }
        
        .row {
            display: flex;
            gap: 15px;
        }
        
        .col {
            flex: 1;
        }
        
        body {
            background: linear-gradient(to right, #004e5c, #009487) !important;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-8">
        <div class="form-container">
            <div style="display: flex; align-items: center; justify-content: center; gap: 20px; margin-bottom: 30px;">
                <img src="{{ asset('images/logo.png') }}" alt="Company Logo" style="height: 60px; width: auto;">
                <h1 class="text-3xl font-bold" style="color: #212529;">Insurance Application Form</h1>
            </div>
            
            <form id="insuranceForm" method="POST" action="{{ route('insurance.store') }}" enctype="multipart/form-data">
                @csrf
                
                <!-- Personal Information Section -->
                <div class="form-section">
                    <h2 class="section-title">Personal Information</h2>
                    
                    <div class="form-group">
                        <label class="form-label" for="full_name">Full Name *</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" required value="{{ old('full_name') }}">
                        <div class="error-message" id="full_name_error"></div>
                    </div>
                    
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label" for="contact_number">Contact Number *</label>
                                <input type="tel" class="form-control" id="contact_number" name="contact_number" required value="{{ old('contact_number') }}">
                                <div class="error-message" id="contact_number_error"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label" for="email">Email Address *</label>
                                <input type="email" class="form-control" id="email" name="email" required value="{{ old('email') }}">
                                <div class="error-message" id="email_error"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Address Information Section -->
                <div class="form-section">
                    <h2 class="section-title">Address Information</h2>
                    
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label" for="house_building">House/Building Number *</label>
                                <input type="text" class="form-control" id="house_building" name="house_building" required value="{{ old('house_building') }}">
                                <div class="error-message" id="house_building_error"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label" for="road">Road *</label>
                                <input type="text" class="form-control" id="road" name="road" required value="{{ old('road') }}">
                                <div class="error-message" id="road_error"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label" for="block">Block *</label>
                                <input type="text" class="form-control" id="block" name="block" required value="{{ old('block') }}">
                                <div class="error-message" id="block_error"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label" for="city">City *</label>
                                <input type="text" class="form-control" id="city" name="city" required value="{{ old('city') }}">
                                <div class="error-message" id="city_error"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label" for="postal_code">Postal Code</label>
                                <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ old('postal_code') }}">
                                <div class="error-message" id="postal_code_error"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="checkbox-group">
                            <input type="checkbox" id="has_flat" name="has_flat" value="1" {{ old('has_flat') ? 'checked' : '' }}>
                            <label for="has_flat">Do you live in a flat/apartment?</label>
                        </div>
                    </div>
                    
                    <div id="flat_details" style="display: {{ old('has_flat') ? 'block' : 'none' }};">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label" for="flat_number">Flat Number</label>
                                    <input type="text" class="form-control" id="flat_number" name="flat_number" value="{{ old('flat_number') }}">
                                    <div class="error-message" id="flat_number_error"></div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label" for="floor_number">Floor Number</label>
                                    <input type="text" class="form-control" id="floor_number" name="floor_number" value="{{ old('floor_number') }}">
                                    <div class="error-message" id="floor_number_error"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Device Information Section -->
                <div class="form-section">
                    <h2 class="section-title">Device Information</h2>
                    
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label" for="device_brand">Device Brand *</label>
                                <input type="text" class="form-control" id="device_brand" name="device_brand" required value="{{ old('device_brand') }}">
                                <div class="error-message" id="device_brand_error"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label" for="device_model">Device Model *</label>
                                <input type="text" class="form-control" id="device_model" name="device_model" required value="{{ old('device_model') }}">
                                <div class="error-message" id="device_model_error"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="imei_number">IMEI Number (15 digits) *</label>
                        <input type="text" class="form-control" id="imei_number" name="imei_number" required maxlength="15" pattern="[0-9]{15}" value="{{ old('imei_number') }}">
                        <div class="error-message" id="imei_number_error"></div>
                    </div>
                    
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label" for="purchase_date">Purchase Date *</label>
                                <input type="date" class="form-control" id="purchase_date" name="purchase_date" required value="{{ old('purchase_date') }}">
                                <div class="error-message" id="purchase_date_error"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label" for="purchase_price">Purchase Price ($) *</label>
                                <input type="number" class="form-control" id="purchase_price" name="purchase_price" required min="0" step="0.01" value="{{ old('purchase_price') }}">
                                <div class="error-message" id="purchase_price_error"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Insurance Information Section -->
                <div class="form-section">
                    <h2 class="section-title">Insurance Information</h2>
                    
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label" for="insurance_type">Insurance Type *</label>
                                <select class="form-control" id="insurance_type" name="insurance_type" required>
                                    <option value="">Select Insurance Type</option>
                                    <option value="accidental-damage" {{ old('insurance_type') == 'accidental-damage' ? 'selected' : '' }}>Accidental Damage</option>
                                    <option value="extended-warranty" {{ old('insurance_type') == 'extended-warranty' ? 'selected' : '' }}>Extended Warranty</option>
                                </select>
                                <div class="error-message" id="insurance_type_error"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label" for="service_period">Service Period *</label>
                                <select class="form-control" id="service_period" name="service_period" required>
                                    <option value="">Select Service Period</option>
                                    <option value="12-months" {{ old('service_period') == '12-months' ? 'selected' : '' }}>12 Months</option>
                                    <option value="24-months" {{ old('service_period') == '24-months' ? 'selected' : '' }}>24 Months</option>
                                    <option value="36-months" {{ old('service_period') == '36-months' ? 'selected' : '' }}>36 Months</option>
                                </select>
                                <div class="error-message" id="service_period_error"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- File Uploads Section -->
                <div class="form-section">
                    <h2 class="section-title">File Uploads</h2>
                    
                    <div class="form-group">
                        <label class="form-label" for="device_images">Device Images (Multiple files allowed) *</label>
                        <div class="file-upload" onclick="document.getElementById('device_images').click()">
                            <input type="file" id="device_images" name="device_images[]" multiple accept="image/jpeg,image/jpg,image/png" style="display: none;" required>
                            <p>Click here to upload device images (JPEG, JPG, PNG - Max 2MB each)</p>
                            <div id="device_images_preview"></div>
                        </div>
                        <div class="error-message" id="device_images_error"></div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="purchase_receipt">Purchase Receipt *</label>
                        <div class="file-upload" onclick="document.getElementById('purchase_receipt').click()">
                            <input type="file" id="purchase_receipt" name="purchase_receipt" accept="image/jpeg,image/jpg,image/png,application/pdf" style="display: none;" required>
                            <p>Click here to upload purchase receipt (JPEG, JPG, PNG, PDF - Max 2MB)</p>
                            <div id="receipt_preview"></div>
                        </div>
                        <div class="error-message" id="purchase_receipt_error"></div>
                    </div>
                </div>
                
                <!-- Digital Signature Section -->
                <div class="form-section">
                    <h2 class="section-title">Digital Signature</h2>
                    
                    <div class="form-group">
                        <label class="form-label" for="signature_name">Signature Name *</label>
                        <input type="text" class="form-control" id="signature_name" name="signature_name" required value="{{ old('signature_name') }}">
                        <div class="error-message" id="signature_name_error"></div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Draw Your Signature *</label>
                        <canvas id="signaturePad" class="signature-pad" width="400" height="200"></canvas>
                        <input type="hidden" id="signature_data" name="signature_data" required>
                        <div class="mt-2">
                            <button type="button" class="btn btn-secondary" onclick="clearSignature()">Clear Signature</button>
                        </div>
                        <div class="error-message" id="signature_data_error"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="checkbox-group">
                            <input type="checkbox" id="terms_agreement" name="terms_agreement" value="1" required {{ old('terms_agreement') ? 'checked' : '' }}>
                            <label for="terms_agreement">I agree to the terms and conditions *</label>
                        </div>
                        <div class="error-message" id="terms_agreement_error"></div>
                    </div>
                </div>
                
                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="btn btn-success" id="submitBtn">Submit Application</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Flat details toggle
        document.getElementById('has_flat').addEventListener('change', function() {
            const flatDetails = document.getElementById('flat_details');
            flatDetails.style.display = this.checked ? 'block' : 'none';
        });

        // File upload previews
        document.getElementById('device_images').addEventListener('change', function() {
            const preview = document.getElementById('device_images_preview');
            preview.innerHTML = '';
            
            for (let i = 0; i < this.files.length; i++) {
                const file = this.files[i];
                const fileName = document.createElement('p');
                fileName.textContent = file.name;
                preview.appendChild(fileName);
            }
        });

        document.getElementById('purchase_receipt').addEventListener('change', function() {
            const preview = document.getElementById('receipt_preview');
            const file = this.files[0];
            if (file) {
                preview.innerHTML = '<p>' + file.name + '</p>';
            }
        });

        // Signature pad functionality
        const canvas = document.getElementById('signaturePad');
        const ctx = canvas.getContext('2d');
        let isDrawing = false;

        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('touchstart', startDrawing);
        canvas.addEventListener('touchmove', draw);
        canvas.addEventListener('touchend', stopDrawing);

        function startDrawing(e) {
            isDrawing = true;
            draw(e);
        }

        function draw(e) {
            if (!isDrawing) return;
            
            const rect = canvas.getBoundingClientRect();
            const x = (e.clientX || e.touches[0].clientX) - rect.left;
            const y = (e.clientY || e.touches[0].clientY) - rect.top;
            
            ctx.lineWidth = 2;
            ctx.lineCap = 'round';
            ctx.strokeStyle = '#000';
            
            ctx.lineTo(x, y);
            ctx.stroke();
            ctx.beginPath();
            ctx.moveTo(x, y);
        }

        function stopDrawing() {
            if (isDrawing) {
                isDrawing = false;
                ctx.beginPath();
                // Save signature data
                document.getElementById('signature_data').value = canvas.toDataURL();
            }
        }

        function clearSignature() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            document.getElementById('signature_data').value = '';
        }

        // Form submission
        document.getElementById('insuranceForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submitBtn');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Submitting...';
            submitBtn.disabled = true;
            
            // Clear previous errors
            document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
            
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Application submitted successfully!');
                    window.location.href = data.redirect_url;
                } else {
                    // Show validation errors
                    if (data.errors) {
                        Object.keys(data.errors).forEach(field => {
                            const errorElement = document.getElementById(field + '_error');
                            if (errorElement) {
                                errorElement.textContent = data.errors[field][0];
                            }
                        });
                    } else {
                        alert(data.message || 'An error occurred. Please try again.');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            })
            .finally(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        });
    </script>
</body>
</html>