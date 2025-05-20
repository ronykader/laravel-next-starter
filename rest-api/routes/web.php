<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'Rest Api Starter Version: 1.0.0';
});
Route::get('/login', function () {
    return 'Unauthorized';
})->name('login');
