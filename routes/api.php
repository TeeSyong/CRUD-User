<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('{user}', [UserController::class, 'show']);
    Route::put('{user}', [UserController::class, 'update']);
    Route::delete('{user}', [UserController::class, 'destroy']);
    Route::post('bulk-delete', [UserController::class, 'bulkDelete']);
    Route::get('export/excel', [UserController::class, 'exportExcel']);
});