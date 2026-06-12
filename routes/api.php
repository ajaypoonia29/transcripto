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

// CRM Lead Ingestion Route
Route::post('/leads', [LeadController::class, 'store'])
    ->name('api.leads.store');

// Payments Subscription Initialization Route
Route::post('/subscriptions/initialize', [SubscriptionController::class, 'initialize'])
    ->name('api.subscriptions.initialize');

// CMS Layout Mutation Route
Route::put('/homepage-sections/{sectionKey}', [HomepageSectionController::class, 'update'])
    ->name('api.homepage-sections.update');
