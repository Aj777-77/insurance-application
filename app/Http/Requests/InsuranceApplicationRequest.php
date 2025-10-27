<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsuranceApplicationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'full_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'house_building' => 'required|string|max:255',
            'road' => 'required|string|max:255',
            'block' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'has_flat' => 'boolean',
            'flat_number' => 'nullable|string|max:50',
            'floor_number' => 'nullable|string|max:50',
            'device_brand' => 'required|string|max:255',
            'device_model' => 'required|string|max:255',
            'imei_number' => 'required|string|size:15',
            'purchase_date' => 'required|date',
            'purchase_price' => 'required|numeric|min:0',
            'insurance_type' => 'required|in:accidental-damage,extended-warranty',
            'service_period' => 'required|string',
            'device_images.*' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'purchase_receipt' => 'required|file|mimes:jpeg,jpg,png,pdf|max:2048',
            'signature_name' => 'required|string|max:255',
            'signature_data' => 'required|string',
            'terms_agreement' => 'required|accepted',
        ];
    }

    public function messages()
    {
        return [
            'full_name.required' => 'Full name is required.',
            'contact_number.required' => 'Contact number is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'house_building.required' => 'House/Building number is required.',
            'road.required' => 'Road is required.',
            'block.required' => 'Block is required.',
            'city.required' => 'City is required.',
            'device_brand.required' => 'Device brand is required.',
            'device_model.required' => 'Device model is required.',
            'imei_number.required' => 'IMEI number is required.',
            'imei_number.size' => 'IMEI number must be exactly 15 digits.',
            'purchase_date.required' => 'Purchase date is required.',
            'purchase_price.required' => 'Purchase price is required.',
            'insurance_type.required' => 'Insurance type is required.',
            'service_period.required' => 'Service period is required.',
            'device_images.*.required' => 'Device images are required.',
            'device_images.*.image' => 'Device images must be image files.',
            'device_images.*.mimes' => 'Device images must be in JPEG, JPG, or PNG format.',
            'device_images.*.max' => 'Each device image must not exceed 2MB.',
            'purchase_receipt.required' => 'Purchase receipt is required.',
            'purchase_receipt.mimes' => 'Receipt must be in JPEG, JPG, PNG, or PDF format.',
            'purchase_receipt.max' => 'Receipt file must not exceed 2MB.',
            'signature_name.required' => 'Signature name is required.',
            'signature_data.required' => 'Digital signature is required.',
            'terms_agreement.accepted' => 'You must agree to the terms and conditions.',
        ];
    }
}