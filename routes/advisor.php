<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AdvisorController;


Route::pattern('id', '^\d+$'); //proveravamo da li je svaki prosledjeni id integer
Route::group(['prefix' => 'advisor', 'middleware' => 'auth'], function () {

    Route::get('/home', [AdvisorController::class , 'home']);

    Route::post('/logout', [AdvisorController::class , 'logout']);

});
