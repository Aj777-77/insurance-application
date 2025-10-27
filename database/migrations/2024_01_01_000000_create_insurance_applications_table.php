<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('insurance_applications', function (Blueprint $table) {
            $table->id();
            $table->string('application_id')->unique();
            $table->string('user_code')->index(); // User code from landing page
            
            // Personal Information
            $table->string('full_name');
            $table->string('contact_number');
            $table->string('email');
            
            // Address Information
            $table->string('house_building');
            $table->string('road');
            $table->string('block');
            $table->string('city');
            $table->string('postal_code')->nullable();
            $table->boolean('has_flat')->default(false);
            $table->string('flat_number')->nullable();
            $table->string('floor_number')->nullable();
            
            // Device Information
            $table->string('device_brand');
            $table->string('device_model');
            $table->string('imei_number');
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_price', 10, 2)->nullable();
            
            // Insurance Information
            $table->enum('insurance_type', ['accidental-damage', 'extended-warranty']);
            $table->string('service_period');
            
            // File Uploads
            $table->json('device_images')->nullable();
            $table->string('purchase_receipt')->nullable();
            
            // Signature
            $table->string('signature_name');
            $table->string('signature_path')->nullable();
            $table->boolean('terms_agreement')->default(false);
            
            // Application Status
            $table->enum('status', ['pending', 'approved', 'rejected', 'processing'])->default('pending');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('insurance_applications');
    }
};