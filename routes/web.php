<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\AdministrativeRegionController;
use App\Http\Controllers\AidTypeController;
use App\Http\Controllers\AidSessionController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\BeneficiaryGroupController;

// Public routes
Route::get('/', function () {
    return redirect('/login');
});

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Master Data Routes
    Route::resource('volunteers', VolunteerController::class);
    Route::resource('beneficiaries', BeneficiaryController::class);
    Route::get('/beneficiaries-import', [BeneficiaryController::class, 'import'])->name('beneficiaries.import');
    Route::post('/beneficiaries-import', [BeneficiaryController::class, 'importExcel'])->name('beneficiaries.import.excel');
    Route::get('/beneficiaries-template', [BeneficiaryController::class, 'downloadTemplate'])->name('beneficiaries.template');
    Route::resource('beneficiary-groups', BeneficiaryGroupController::class);
    Route::resource('administrative-regions', AdministrativeRegionController::class);
    Route::get('/administrative-regions/kabupaten/{kabupaten_id}/kecamatan', [AdministrativeRegionController::class, 'showKecamatan'])->name('administrative-regions.kecamatan');
    Route::get('/administrative-regions/kecamatan/{kecamatan_id}/desa', [AdministrativeRegionController::class, 'showDesa'])->name('administrative-regions.desa');
    
    // Aid Management Routes
    Route::resource('aid-types', AidTypeController::class);
    Route::resource('aid-sessions', AidSessionController::class);
    
    // Activity Routes
    Route::resource('activities', ActivityController::class)->only(['index', 'show']);
    
    // Report Routes
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/summary', [ReportController::class, 'summary'])->name('summary');
        Route::get('/distribution', [ReportController::class, 'distribution'])->name('distribution');
        Route::get('/volunteers', [ReportController::class, 'volunteers'])->name('volunteers');
    });
    
    // AJAX routes for cascading dropdowns
    Route::get('/volunteers/kecamatan/{kabupaten_id}', [VolunteerController::class, 'getKecamatan']);
    Route::get('/volunteers/desa/{kecamatan_id}', [VolunteerController::class, 'getDesa']);
    Route::get('/beneficiaries/kecamatan/{kabupaten_id}', [BeneficiaryController::class, 'getKecamatan']);
    Route::get('/beneficiaries/desa/{kecamatan_id}', [BeneficiaryController::class, 'getDesa']);
});
