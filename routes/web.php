<?php

use App\Http\Controllers\OAUthController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/oauth/redirect/', [OAUthController::class, 'redirect'])->name('oauth.redirect');
Route::get('/oauth/callback/', [OAUthController::class, 'callback'])->name('oauth.callback');
