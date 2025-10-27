<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InsuranceApplicationController;

// Health check for Railway
Route::get('/health', function () {
    return response()->json(['status' => 'ok', 'timestamp' => now()]);
});

// Debug route for Railway
Route::get('/debug', function () {
    return response()->json([
        'status' => 'Laravel is working',
        'environment' => app()->environment(),
        'app_key_set' => !empty(config('app.key')),
        'database_configured' => !empty(config('database.connections.pgsql.host')),
        'php_version' => phpversion(),
        'laravel_version' => app()->version(),
    ]);
});

Route::get('/', function () {
    try {
        return redirect()->route('insurance.landing');
    } catch (Exception $e) {
        return response()->json([
            'error' => 'Redirect failed',
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});

// Insurance Application Routes
Route::prefix('insurance')->name('insurance.')->group(function () {
    // Landing page - first step to enter user code
    Route::get('/start', [InsuranceApplicationController::class, 'landing'])->name('landing');
    Route::post('/validate-code', [InsuranceApplicationController::class, 'validateUserCode'])->name('validate-code');
    
    // Application flow - temporarily removing middleware for debugging
    Route::get('/application', [InsuranceApplicationController::class, 'index'])->name('application');
    Route::get('/step/{step}', [InsuranceApplicationController::class, 'showStep'])->name('step');
    Route::post('/step/{step}', [InsuranceApplicationController::class, 'processStep'])->name('step.process');
    Route::post('/application', [InsuranceApplicationController::class, 'store'])->name('store');
    Route::get('/success/{applicationId}', [InsuranceApplicationController::class, 'success'])->name('success');
});
