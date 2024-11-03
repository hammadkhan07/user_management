<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/delete/user/{id}', [DashboardController::class, 'delete'])->name('delete.user')->middleware('Admin');
    Route::post('/change/password', [DashboardController::class, 'changepassword'])->name('change.password')->middleware('Admin');
    Route::get('/edit/user', [DashboardController::class, 'edituser'])->name('edit.user')->middleware('Admin');
    Route::post('/update/user/{id}', [DashboardController::class, 'updateuser'])->name('update.user')->middleware('Admin');
});
