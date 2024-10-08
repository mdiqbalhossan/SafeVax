<?php

use App\Models\VaccineCenter;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $vaccineCenters = VaccineCenter::all();
    return view('register', compact('vaccineCenters'));
});
