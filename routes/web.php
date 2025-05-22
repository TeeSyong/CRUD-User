<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\UserViewController;



Route::prefix('admin')->group(function () {
    Route::get('users', [UserViewController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserViewController::class, 'create'])->name('users.create');
    Route::post('users', [UserViewController::class, 'store'])->name('users.store');
    Route::get('users/{user}/edit', [UserViewController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [UserViewController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserViewController::class, 'destroy'])->name('users.destroy');
    Route::post('users/bulkDelete', [UserViewController::class, 'bulkDelete'])->name('users.bulkDelete');
    Route::get('users/exportExcel', [UserViewController::class, 'exportExcel'])->name('users.exportExcel');
});

