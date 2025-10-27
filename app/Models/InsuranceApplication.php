<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'user_code',
        'full_name',
        'contact_number',
        'email',
        'house_building',
        'road',
        'block',
        'city',
        'postal_code',
        'has_flat',
        'flat_number',
        'floor_number',
        'device_brand',
        'device_model',
        'imei_number',
        'purchase_date',
        'purchase_price',
        'insurance_type',
        'service_period',
        'device_images',
        'purchase_receipt',
        'signature_name',
        'signature_path',
        'terms_agreement',
        'status',
    ];

    protected $casts = [
        'has_flat' => 'boolean',
        'terms_agreement' => 'boolean',
        'purchase_date' => 'date',
        'purchase_price' => 'decimal:2',
        'device_images' => 'array',
        'insurance_type' => 'array',
        'service_period' => 'array',
    ];

    public function getDeviceImagesAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }

    public function setDeviceImagesAttribute($value)
    {
        $this->attributes['device_images'] = is_array($value) ? json_encode($value) : $value;
    }
}