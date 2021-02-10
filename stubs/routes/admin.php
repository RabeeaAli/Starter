<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\HomeController;


Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    // your routes
});
