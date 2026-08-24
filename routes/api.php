<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContactMailController;

Route::post('/send-contact-email', [ContactMailController::class, 'sendMail']);
