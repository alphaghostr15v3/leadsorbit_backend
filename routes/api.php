<?php

use App\Http\Controllers\Api\ContentController;
use App\Http\Controllers\Api\ApiAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/services', [ContentController::class, 'getServices']);
Route::get('/portfolio', [ContentController::class, 'getPortfolio']);
Route::get('/blog', [ContentController::class, 'getBlog']);
Route::get('/testimonials', [ContentController::class, 'getTestimonials']);
Route::get('/team', [ContentController::class, 'getTeam']);
Route::post('/leads', [ContentController::class, 'storeLead']);

// Auth routes
Route::post('/login', [ApiAuthController::class, 'login']);
Route::post('/logout', [ApiAuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', [ApiAuthController::class, 'me'])->middleware('auth:sanctum');

// Protected Admin CRUD routes
Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
    // Services
    Route::post('/services', [ContentController::class, 'storeService']);
    Route::put('/services/{id}', [ContentController::class, 'updateService']);
    Route::delete('/services/{id}', [ContentController::class, 'deleteService']);

    // Portfolio
    Route::post('/portfolio', [ContentController::class, 'storePortfolio']);
    Route::put('/portfolio/{id}', [ContentController::class, 'updatePortfolio']);
    Route::delete('/portfolio/{id}', [ContentController::class, 'deletePortfolio']);

    // Blog
    Route::post('/blog', [ContentController::class, 'storeBlog']);
    Route::put('/blog/{id}', [ContentController::class, 'updateBlog']);
    Route::delete('/blog/{id}', [ContentController::class, 'deleteBlog']);

    // Testimonials
    Route::post('/testimonials', [ContentController::class, 'storeTestimonial']);
    Route::put('/testimonials/{id}', [ContentController::class, 'updateTestimonial']);
    Route::delete('/testimonials/{id}', [ContentController::class, 'deleteTestimonial']);

    // Team
    Route::post('/team', [ContentController::class, 'storeTeamMember']);
    Route::put('/team/{id}', [ContentController::class, 'updateTeamMember']);
    Route::delete('/team/{id}', [ContentController::class, 'deleteTeamMember']);
});
