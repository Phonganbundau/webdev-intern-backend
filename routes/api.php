<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiemThiController;

Route::prefix('diem-thi')->group(function () {
    Route::get('/tra-cuu/{sbd}', [DiemThiController::class, 'traCuu']);
    Route::get('/thong-ke', [DiemThiController::class, 'thongKe']);
    Route::get('/top10-khoi-a', [DiemThiController::class, 'top10KhoiA']);
});

Route::get('/debug', function () {
    return response()->json(['message' => 'API is working']);
});