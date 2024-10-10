<?php

use App\Http\Controllers\MemberController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'register');

Route::controller(MemberController::class)->group(function () {
    Route::get('/register', 'index')->name('register');
    Route::post('/register', 'store')->name('register.store');
    Route::get('/success/{member}', 'success')->name('register.success');
});

Route::controller(SearchController::class)->group(function () {
    Route::get('/search', 'index')->name('search');
    Route::post('/search/result', 'result')->name('search.result');
});
