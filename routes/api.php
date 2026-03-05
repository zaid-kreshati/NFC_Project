<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NFCController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\InvoiceController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function () {
    return response()->json(['message' => 'welcome']);
});

Route::get('/claim', [NFCController::class, 'claim']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');



Route::middleware('auth:sanctum')->controller(InvoiceController::class)->group(function () {

    Route::post('/invoices', 'store');
    Route::get('/invoices/my', 'myInvoices');
    Route::get('/invoices/user/{id}', 'byUser');
    Route::get('/invoices/{uuid}', 'show');
    Route::post('/invoices/claim/{uuid}', 'claim');
    Route::put('/invoices/{id}', 'update');
    Route::delete('/invoices/{id}', 'destroy');
});
