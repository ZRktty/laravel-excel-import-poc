<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', [DevController::class, 'test']);
