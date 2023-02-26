<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AdvisorController;


Route::pattern('id', '^\d+$'); //proveravamo da li je svaki prosledjeni id integer
Route::group(['prefix' => 'advisor', 'middleware' => 'auth'], function () {

    Route::get('/home', [AdvisorController::class , 'home']);


    //clients
    Route::get('/clients', [AdvisorController::class , 'clients']);
    Route::get('/create/client', [AdvisorController::class , 'createClient']);
    Route::post('/create/client', [AdvisorController::class , 'createClientSystem']);
    Route::delete('/delete/client/{id}', [AdvisorController::class , 'deleteClient']);
    Route::get('/edit/client/{id}', [AdvisorController::class , 'showEdit']);
    Route::patch('/edit/client/{id}', [AdvisorController::class , 'editClient']);
    Route::patch('/cash/loan/{id}', [AdvisorController::class , 'cashLoan']);
    Route::patch('/home/loan/{id}', [AdvisorController::class , 'homeLoan']);

    //reports
    Route::get('/reports', [AdvisorController::class , 'reports']);



//    logout
    Route::post('/logout', [AdvisorController::class , 'logout']);

});
