<?php

use Apps\Bookings\Controller\CreateBookingListController;
use Apps\Hotels\Controller\GetHotelController;
use Apps\Hotels\Controller\GetHotelUserCountListController;
use Illuminate\Support\Facades\Route;

/**
 * API Routes for the Hotel Booking System.
 *
 * This file defines all the API endpoints for the application.
 * Routes are grouped by their domain (Hotels, Bookings).
 *
 * Available endpoints:
 * - GET /hotels/user-count-list: Get list of hotels with their unique user counts
 * - GET /hotels/{uuid}: Get specific hotel information
 * - POST /booking: Create new booking(s)
 */

// Hotel routes
Route::get('/hotels/user-count-list', GetHotelUserCountListController::class);
Route::get('/hotels/{uuid}', GetHotelController::class);

// Booking routes
Route::post('/bookings', CreateBookingListController::class);
