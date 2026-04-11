<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\POSController;
use App\Http\Middleware\CheckPosMiddleware;


Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
    Route::delete('/delete_account', 'deleteAccount')->middleware('auth:sanctum');
});

Route::middleware(CheckPosMiddleware::class)->group(function () {
    Route::post('/invoices', [InvoiceController::class, 'store']);
});

Route::post('/pos', [POSController::class, 'createPOS'])->middleware('auth:sanctum')->middleware('role:admin');
Route::put('/pos/{id}', [POSController::class, 'toggleStatus'])->middleware('auth:sanctum')->middleware('role:admin');
Route::delete('/pos/{id}', [POSController::class, 'deletePOS'])->middleware('auth:sanctum')->middleware('role:admin');



Route::middleware('auth:sanctum')->controller(InvoiceController::class)->group(function () {

    Route::get('/invoices/my', 'myInvoices');
    Route::get('/invoices/user/{id}', 'byUser');
    Route::get('/invoices/{uuid}', 'show');
    Route::post('/invoices/claim/{uuid}', 'claim');
    Route::put('/invoices/{id}', 'update');
    Route::delete('/invoices/{id}', 'destroy');
});
