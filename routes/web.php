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

    Route::get('/tool', [\App\Http\Controllers\Mechanic\ToolController::class, 'index'])->name('tool.index');
    Route::get('/tool/data', [\App\Http\Controllers\Mechanic\ToolController::class, 'data'])->name('tool.data');
    Route::get('/tool/{tool}', [\App\Http\Controllers\Mechanic\ToolController::class, 'show'])->name('tool.show');
    Route::post('/tool/{tool}/order', [\App\Http\Controllers\Mechanic\ToolController::class, 'order'])->name('tool.order');

    Route::get('/consumable', [\App\Http\Controllers\Mechanic\ConsumableController::class, 'index'])->name('consumable.index');
    Route::get('/consumable/data', [\App\Http\Controllers\Mechanic\ConsumableController::class, 'data'])->name('consumable.data');
    Route::get('/consumable/{consumable}', [\App\Http\Controllers\Mechanic\ConsumableController::class, 'show'])->name('consumable.show');
    Route::post('/consumable/{consumable}/order', [\App\Http\Controllers\Mechanic\ConsumableController::class, 'order'])->name('consumable.order');
});

Route::middleware(['auth', 'role:supervisor'])->prefix('supervisor')->as('supervisor.')->group(function() {
    Route::get('/', [\App\Http\Controllers\Supervisor\PageController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'role:toolman'])->prefix('toolman')->as('toolman.')->group(function() {
    Route::get('/', [\App\Http\Controllers\Toolman\PageController::class, 'index'])->name('dashboard');

    Route::resource('tool', \App\Http\Controllers\Toolman\ToolController::class)->except(['destroy', 'create', 'store']);
    Route::resource('consumable', \App\Http\Controllers\Toolman\ConsumableController::class)->except(['destroy', 'create', 'store']);

    Route::prefix('request')->as('request.')->group(function() {

        Route::get('/tool', [\App\Http\Controllers\Toolman\RequestToolController::class, 'index'])->name('tool.index');
        Route::put('/tool/{tool}', [\App\Http\Controllers\Toolman\RequestToolController::class, 'update'])->name('tool.update');

        Route::get('/consumable', [\App\Http\Controllers\Toolman\RequestConsumableController::class, 'index'])->name('consumable.index');
        Route::put('/consumable/{consumable}', [\App\Http\Controllers\Toolman\RequestConsumableController::class, 'update'])->name('consumable.update');

    });
});
