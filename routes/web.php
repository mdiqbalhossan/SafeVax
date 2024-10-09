<?php

use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'register');

Route::controller(MemberController::class)->group(function () {
    Route::get('/register', 'index')->name('register');
    Route::post('/register', 'store')->name('register.store');
});
