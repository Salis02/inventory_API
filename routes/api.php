<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\TransaksiController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Api\UserController;

// Tambahkan ini di bagian atas file Anda
Route::get('/', function () {
    return response()->json([
        'message' => 'Welcome to the Inventory API!',
        'version' => '1.0',
        'endpoints' => [
            '/api/barangs' => 'GET|POST',
            '/api/transaksis' => 'GET|POST',
            '/api/user' => 'GET|POST',
            
        ]
    ]);
});

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth:sanctum', 'role:admin,operator'])->group(function () {
    Route::apiResource('barangs', BarangController::class);
    Route::apiResource('transaksis', TransaksiController::class)->except(['update']);
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::apiResource('users', UserController::class);
});


