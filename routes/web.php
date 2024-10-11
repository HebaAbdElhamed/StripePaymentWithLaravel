<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\listController;
use App\Http\Controllers\StripePaymentController;


Route::get('/', [listController::class, 'showItem']);
Route::get('stripe',[StripePaymentController::class,'pay'])->name('stripRoute');