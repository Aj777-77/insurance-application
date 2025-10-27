<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('insurance_applications', function (Blueprint $table) {
            // Change insurance_type to JSON to store multiple types
            $table->json('insurance_type')->nullable()->change();
            
            // Change service_period to JSON to store multiple service periods
            $table->json('service_period')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('insurance_applications', function (Blueprint $table) {
            // Revert back to enum and string
            $table->dropColumn(['insurance_type', 'service_period']);
            $table->enum('insurance_type', ['accidental-damage', 'extended-warranty'])->after('imei_number');
            $table->string('service_period')->after('insurance_type');
        });
    }
};
