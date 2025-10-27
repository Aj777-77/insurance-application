<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InsuranceApplicationController;

Route::get('/', function () {
    return redirect()->route('insurance.landing');
});

// Insurance Application Routes
Route::prefix('insurance')->name('insurance.')->group(function () {
    // Landing page - first step to enter user code
    Route::get('/start', [InsuranceApplicationController::class, 'landing'])->name('landing');
    Route::post('/validate-code', [InsuranceApplicationController::class, 'validateUserCode'])->name('validate-code');
    
    // Application flow - requires user code in session
    Route::middleware('check.user.code')->group(function () {
        Route::get('/application', [InsuranceApplicationController::class, 'index'])->name('application');
        Route::get('/step/{step}', [InsuranceApplicationController::class, 'showStep'])->name('step');
        Route::post('/step/{step}', [InsuranceApplicationController::class, 'processStep'])->name('step.process');
        Route::post('/application', [InsuranceApplicationController::class, 'store'])->name('store');
        Route::get('/success/{applicationId}', [InsuranceApplicationController::class, 'success'])->name('success');
    });
});
