<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Domains\ManageUser\ManageUserController;
use App\Http\Controllers\Domains\ManageUser\ApiDataTable;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Dashboard Route
Route::middleware(['auth', 'role:Administrator'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/management/users', [ManageUserController::class, 'index'])->name('manage.users');
    Route::get('/management/users/datatable', [ApiDataTable::class, 'getUsersData'])->name('manage.users.datatable');
});

require __DIR__.'/auth.php';
