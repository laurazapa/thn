<?php

use Apps\Bookings\Controller\CreateBookingController;
use Apps\Hotels\Controller\GetHotelController;
use Apps\Hotels\Controller\GetHotelUserCountListController;
use Illuminate\Support\Facades\Route;

// Hotel routes
Route::get('/hotels/user-count-list', GetHotelUserCountListController::class);
Route::get('/hotels/{uuid}', GetHotelController::class);

// Booking routes
Route::post('/booking', CreateBookingController::class);
