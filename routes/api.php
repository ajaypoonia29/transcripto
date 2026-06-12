<?php

use App\Http\Controllers\CRM\LeadController;
use App\Http\Controllers\Payments\SubscriptionController;
use App\Http\Controllers\CMS\HomepageSectionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider, and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// CRM Lead Routes
Route::get('/leads', [LeadController::class, 'index'])
    ->name('api.leads.index');
Route::post('/leads', [LeadController::class, 'store'])
    ->name('api.leads.store');
Route::put('/leads/{id}', [LeadController::class, 'update'])
    ->name('api.leads.update');

// Payments Subscription Routes
Route::get('/subscriptions', [SubscriptionController::class, 'index'])
    ->name('api.subscriptions.index');
Route::post('/subscriptions/initialize', [SubscriptionController::class, 'initialize'])
    ->name('api.subscriptions.initialize');

// CMS Layout Routes
Route::get('/homepage-sections', [HomepageSectionController::class, 'index'])
    ->name('api.homepage-sections.index');
Route::put('/homepage-sections/{sectionKey}', [HomepageSectionController::class, 'update'])
    ->name('api.homepage-sections.update');

// Coaching Domain Routes
Route::get('/coaching/members', [\App\Http\Controllers\Coaching\CoachingController::class, 'members'])
    ->name('api.coaching.members');
Route::get('/coaching/dashboard', [\App\Http\Controllers\Coaching\CoachingController::class, 'dashboard'])
    ->name('api.coaching.dashboard');
Route::post('/coaching/check-in', [\App\Http\Controllers\Coaching\CoachingController::class, 'checkIn'])
    ->name('api.coaching.check-in');
Route::post('/coaching/assign', [\App\Http\Controllers\Coaching\CoachingController::class, 'assign'])
    ->name('api.coaching.assign');

