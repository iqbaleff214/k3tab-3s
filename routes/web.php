<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->as('admin.')->group(function() {
    Route::get('/', [\App\Http\Controllers\Admin\PageController::class, 'index'])->name('dashboard');

    Route::resource('tool', \App\Http\Controllers\Admin\ToolController::class);
    Route::post('tool/import', [\App\Http\Controllers\Admin\ToolController::class, 'import'])->name('tool.import');

    Route::resource('consumable', \App\Http\Controllers\Admin\ConsumableController::class);
    Route::post('consumable/import', [\App\Http\Controllers\Admin\ConsumableController::class, 'import'])->name('consumable.import');

    Route::resource('user', \App\Http\Controllers\Admin\UserController::class);
    Route::post('user/import', [\App\Http\Controllers\Admin\UserController::class, 'import'])->name('user.import');
});

Route::middleware(['auth', 'role:mechanic'])->prefix('mechanic')->as('mechanic.')->group(function() {
    Route::get('/', [\App\Http\Controllers\Mechanic\PageController::class, 'index'])->name('dashboard');

    Route::get('/tool/data', [\App\Http\Controllers\Mechanic\PageController::class, 'data'])->name('tool.data');
});
