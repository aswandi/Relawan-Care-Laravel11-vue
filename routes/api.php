<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VolunteerAuthController;
use App\Http\Controllers\Api\VolunteerApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Volunteer authentication routes
Route::prefix('volunteer')->group(function () {
    Route::post('login', [VolunteerAuthController::class, 'login']);
    Route::post('logout', [VolunteerAuthController::class, 'logout'])->middleware('auth:volunteer');
    Route::get('profile', [VolunteerAuthController::class, 'profile'])->middleware('auth:volunteer');
});

// Protected volunteer routes
Route::middleware(['auth:volunteer'])->prefix('volunteer')->group(function () {
    // Beneficiaries
    Route::get('beneficiaries', [VolunteerApiController::class, 'getBeneficiaries']);
    Route::get('beneficiaries/{id}', [VolunteerApiController::class, 'getBeneficiary']);
    
    // Aid sessions and types
    Route::get('aid-sessions', [VolunteerApiController::class, 'getAidSessions']);
    Route::get('aid-types', [VolunteerApiController::class, 'getAidTypes']);
    
    // Activities
    Route::post('activities', [VolunteerApiController::class, 'storeActivity']);
    Route::get('activities', [VolunteerApiController::class, 'getActivities']);
    Route::get('activities/{id}', [VolunteerApiController::class, 'getActivity']);
    
    // Administrative regions
    Route::get('regions/kecamatan/{kabupaten_id}', [VolunteerApiController::class, 'getKecamatan']);
    Route::get('regions/desa/{kecamatan_id}', [VolunteerApiController::class, 'getDesa']);
});