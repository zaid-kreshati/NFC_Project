<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\InvoiceController;


Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
    Route::delete('/delete_account', 'deleteAccount')->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->controller(InvoiceController::class)->group(function () {

    Route::post('/invoices', 'store');
    Route::get('/invoices/my', 'myInvoices');
    Route::get('/invoices/user/{id}', 'byUser');
    Route::get('/invoices/{uuid}', 'show');
    Route::post('/invoices/claim/{uuid}', 'claim');
    Route::put('/invoices/{id}', 'update');
    Route::delete('/invoices/{id}', 'destroy');
});
