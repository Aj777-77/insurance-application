<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsuranceApplicationRequest;
use App\Models\InsuranceApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InsuranceApplicationController extends Controller
{
    // Define the 7 steps
    protected $steps = [
        1 => 'Personal Information',
        2 => 'Address Information', 
        3 => 'Device Information',
        4 => 'Insurance Details',
        5 => 'File Uploads',
        6 => 'Digital Signature',
        7 => 'Review & Submit'
    ];

    public function landing()
    {
        // Clear all session data when visiting landing page
        // This ensures users always start fresh from the landing page
        session()->forget('user_code');
        session()->forget('insurance_form_data');
        session()->forget('uploaded_device_images');
        session()->forget('uploaded_receipt');
        
        return view('insurance.landing');
    }

    public function validateUserCode(Request $request)
    {
        $request->validate([
            'user_code' => 'required|string|min:3|max:50',
        ]);

        $userCode = strtoupper(trim($request->input('user_code')));
        
        // Store user code in session
        session(['user_code' => $userCode]);
        
        // Clear any previous application data
        session()->forget('insurance_form_data');
        session()->forget('uploaded_device_images');
        session()->forget('uploaded_receipt');
        
        return redirect()->route('insurance.application');
    }

    public function index()
    {
        // Clear all previous insurance application session data
        session()->forget('insurance_form_data');
        session()->forget('uploaded_device_images');
        session()->forget('uploaded_receipt');
        
        return redirect()->route('insurance.step', ['step' => 1]);
    }

    public function showStep($step = 1)
    {
        $step = (int) $step;
        
        if ($step < 1 || $step > 7) {
            return redirect()->route('insurance.step', ['step' => 1]);
        }

        $data = [
            'currentStep' => $step,
            'totalSteps' => 7,
            'steps' => $this->steps,
            'stepTitle' => $this->steps[$step],
            'progressPercentage' => (($step - 1) / 6) * 100, // 6 intervals for 7 steps
            'formData' => session('insurance_form_data', []),
            'uploadedFiles' => [
                'device_images' => session('uploaded_device_images', []),
                'receipt' => session('uploaded_receipt')
            ]
        ];

        return view('insurance.step-' . $step, $data);
    }

    public function processStep(Request $request, $step = 1)
    {
        $step = (int) $step;
        
        // Validation for each step
        $this->validateStep($request, $step);

        // Store form data in session (excluding files)
        $formData = session('insurance_form_data', []);
        
        // Handle file uploads separately for step 5
        if ($step == 5) {
            $this->handleFileUploads($request);
            // Don't store file objects in session, just store that files were uploaded
            $formData['files_uploaded'] = true;
        } else {
            // For all other steps, merge non-file data
            $requestData = $request->all();
            // Remove any file inputs to prevent serialization issues
            unset($requestData['device_images'], $requestData['purchase_receipt'], $requestData['_token']);
            $formData = array_merge($formData, $requestData);
        }
        
        session(['insurance_form_data' => $formData]);

        // If it's the last step, process the entire form
        if ($step == 7) {
            return $this->processFinalSubmission($request);
        }

        // Move to next step
        $nextStep = $step + 1;
        return redirect()->route('insurance.step', ['step' => $nextStep]);
    }

    protected function handleFileUploads(Request $request)
    {
        // Handle device images
        $deviceImages = [];
        if ($request->hasFile('device_images')) {
            foreach ($request->file('device_images') as $image) {
                $path = $image->store('device-images', 'public');
                $deviceImages[] = $path;
            }
            session(['uploaded_device_images' => $deviceImages]);
        }

        // Handle purchase receipt
        if ($request->hasFile('purchase_receipt')) {
            $receiptPath = $request->file('purchase_receipt')->store('receipts', 'public');
            session(['uploaded_receipt' => $receiptPath]);
        }
    }

    protected function preprocessDeviceModel(Request $request)
    {
        // Handle "Other" brand selection - replace with the custom brand name
        if ($request->input('device_brand') === 'Other' && $request->has('other_brand')) {
            $request->merge(['device_brand' => $request->input('other_brand')]);
        }
        
        // No need for Apple-specific preprocessing since the form already sends device_model correctly
        // The JavaScript handles the field naming to ensure device_model is always sent when needed
    }

    protected function validateStep(Request $request, $step)
    {
        // Special handling for step 3 device model
        if ($step == 3) {
            $this->preprocessDeviceModel($request);
        }
        
        $rules = [];
        
        switch ($step) {
            case 1: // Personal Information
                $rules = [
                    'full_name' => 'required|string|max:255',
                    'contact_number' => 'required|string|max:20',
                    'email' => 'required|email|max:255',
                ];
                break;
            case 2: // Address Information
                $rules = [
                    'address' => 'nullable|string|max:1000',
                ];
                break;
            case 3: // Device Information
                $rules = [
                    'device_brand' => 'required|string|max:255',
                    'device_model' => 'required|string|max:255',
                    'imei_number' => 'required|string|size:15',
                ];
                break;
            case 4: // Insurance Details
                $rules = [
                    'insurance_types' => 'required|array|min:1',
                    'insurance_types.*' => 'in:accidental-damage,extended-warranty',
                ];
                
                // Conditionally require service periods based on selected insurance types
                if ($request->has('insurance_types')) {
                    if (in_array('accidental-damage', $request->input('insurance_types', []))) {
                        $rules['accidental_damage_service_period'] = 'required|string';
                    }
                    if (in_array('extended-warranty', $request->input('insurance_types', []))) {
                        $rules['extended_warranty_service_period'] = 'required|string';
                    }
                }
                break;
            case 5: // File Uploads
                $rules = [];
                
                // Only require files if they haven't been uploaded yet
                if (!session('uploaded_device_images') && !$request->hasFile('device_images')) {
                    $rules['device_images'] = 'required|array|min:1';
                }
                if ($request->hasFile('device_images')) {
                    $rules['device_images.*'] = 'image|mimes:jpeg,jpg,png|max:2048';
                }
                
                if (!session('uploaded_receipt') && !$request->hasFile('purchase_receipt')) {
                    $rules['purchase_receipt'] = 'required|file|mimes:jpeg,jpg,png,pdf|max:2048';
                }
                if ($request->hasFile('purchase_receipt')) {
                    $rules['purchase_receipt'] = 'file|mimes:jpeg,jpg,png,pdf|max:2048';
                }
                break;
            case 6: // Digital Signature
                $rules = [
                    'signature_name' => 'required|string|max:255',
                    'signature_data' => 'required|string',
                    'terms_agreement' => 'required|in:1',
                ];
                break;
        }

        if (!empty($rules)) {
            $request->validate($rules);
        }
    }

    protected function processFinalSubmission(Request $request)
    {
        $formData = session('insurance_form_data', []);
        
        try {
            // Get uploaded files from session
            $deviceImages = session('uploaded_device_images', []);
            $receiptPath = session('uploaded_receipt');
            $userCode = session('user_code');

            $signaturePath = null;
            if (isset($formData['signature_data']) && $formData['signature_data']) {
                $signaturePath = $this->saveBase64Signature($formData['signature_data']);
            }

            // Prepare insurance types and service periods
            $insuranceTypes = $formData['insurance_types'] ?? [];
            $servicePeriods = [];
            
            if (in_array('accidental-damage', $insuranceTypes)) {
                $servicePeriods['accidental-damage'] = $formData['accidental_damage_service_period'] ?? null;
            }
            if (in_array('extended-warranty', $insuranceTypes)) {
                $servicePeriods['extended-warranty'] = $formData['extended_warranty_service_period'] ?? null;
            }

            // Create the application using session data
            $application = InsuranceApplication::create([
                'application_id' => $userCode, // Use user code as application ID
                'user_code' => $userCode, // Store user code separately
                'full_name' => $formData['full_name'],
                'contact_number' => $formData['contact_number'],
                'email' => $formData['email'],
                'house_building' => $formData['address'] ?? '',
                'road' => '',
                'block' => '',
                'city' => 'Manama', // Default city since field is removed
                'postal_code' => $formData['postal_code'] ?? '',
                'has_flat' => false,
                'flat_number' => '',
                'floor_number' => '',
                'device_brand' => $formData['device_brand'],
                'device_model' => $formData['device_model'],
                'imei_number' => $formData['imei_number'],
                'purchase_date' => $formData['purchase_date'] ?? null,
                'purchase_price' => $formData['purchase_price'] ?? null,
                'insurance_type' => $insuranceTypes,
                'service_period' => $servicePeriods,
                'device_images' => json_encode($deviceImages),
                'purchase_receipt' => $receiptPath,
                'signature_name' => $formData['signature_name'],
                'signature_path' => $signaturePath,
                'terms_agreement' => $formData['terms_agreement'] ?? false,
                'status' => 'pending',
            ]);

            // Clear all session data except user_code (in case they want to submit another)
            session()->forget(['insurance_form_data', 'uploaded_device_images', 'uploaded_receipt']);

            return redirect()->route('insurance.success', $application->application_id);

        } catch (\Exception $e) {
            Log::error('Application submission failed: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['error' => 'An error occurred while submitting your application. Please try again. Error: ' . $e->getMessage()]);
        }
    }

    public function store(InsuranceApplicationRequest $request)
    {
        try {
            // Handle file uploads
            $deviceImages = [];
            if ($request->hasFile('device_images')) {
                foreach ($request->file('device_images') as $image) {
                    $path = $image->store('device-images', 'public');
                    $deviceImages[] = $path;
                }
            }

            $receiptPath = null;
            if ($request->hasFile('purchase_receipt')) {
                $receiptPath = $request->file('purchase_receipt')->store('receipts', 'public');
            }

            $signaturePath = null;
            if ($request->filled('signature_data')) {
                $signatureData = $request->input('signature_data');
                $signaturePath = $this->saveBase64Signature($signatureData);
            }

            // Create the application
            $application = InsuranceApplication::create([
                'application_id' => 'APP-' . strtoupper(Str::random(8)),
                'full_name' => $request->input('full_name'),
                'contact_number' => $request->input('contact_number'),
                'email' => $request->input('email'),
                'house_building' => $request->input('address', ''),
                'road' => '',
                'block' => '',
                'city' => 'Manama', // Default city since field is removed
                'postal_code' => $request->input('postal_code', ''),
                'has_flat' => false,
                'flat_number' => '',
                'floor_number' => '',
                'device_brand' => $request->input('device_brand'),
                'device_model' => $request->input('device_model'),
                'imei_number' => $request->input('imei_number'),
                'purchase_date' => $request->input('purchase_date'),
                'purchase_price' => $request->input('purchase_price'),
                'insurance_type' => $request->input('insurance_type'),
                'service_period' => $request->input('service_period'),
                'device_images' => json_encode($deviceImages),
                'purchase_receipt' => $receiptPath,
                'signature_name' => $request->input('signature_name'),
                'signature_path' => $signaturePath,
                'terms_agreement' => $request->boolean('terms_agreement'),
                'status' => 'pending',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Application submitted successfully!',
                'application_id' => $application->application_id,
                'redirect_url' => route('insurance.success', $application->application_id)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while submitting your application. Please try again.'
            ], 500);
        }
    }

    public function success($applicationId)
    {
        // Clear any remaining session data to prevent it from persisting
        session()->forget('insurance_form_data');
        session()->forget('uploaded_device_images');
        session()->forget('uploaded_receipt');
        
        $application = InsuranceApplication::where('application_id', $applicationId)->firstOrFail();
        return view('insurance.success', compact('application'));
    }

    private function saveBase64Signature($signatureData)
    {
        // Remove the data URL prefix
        $signatureData = str_replace('data:image/png;base64,', '', $signatureData);
        $signature = base64_decode($signatureData);
        
        $filename = 'signature_' . time() . '_' . Str::random(8) . '.png';
        $path = 'signatures/' . $filename;
        
        Storage::disk('public')->put($path, $signature);
        
        return $path;
    }
}