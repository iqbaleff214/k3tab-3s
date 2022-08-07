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

Route::get('short/toolkeeper', function() {
    $user = \App\Models\User::where('role', 'TOOLKEEPER')->first();
    Auth::login($user);
    return redirect()->route('home')->with('info', 'demonstration purposes only!');
});

Route::get('short/serviceman', function() {
    $user = \App\Models\User::where('role', 'SERVICEMAN')->first();
    Auth::login($user);
    return redirect()->route('home')->with('info', 'demonstration purposes only!');
});

Auth::routes();

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
Route::post('/truncate', [\App\Http\Controllers\Admin\PageController::class, 'truncate'])->name('truncate')->middleware('auth');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->as('admin.')->group(function() {
    Route::get('/', [\App\Http\Controllers\Admin\PageController::class, 'index'])->name('dashboard');

    Route::resource('tool', \App\Http\Controllers\Admin\ToolController::class);
    Route::post('/tool/export', [\App\Http\Controllers\Admin\ToolController::class, 'export'])->name('tool.export');
    Route::post('tool/import', [\App\Http\Controllers\Admin\ToolController::class, 'import'])->name('tool.import');

    Route::resource('consumable', \App\Http\Controllers\Admin\ConsumableController::class);
    Route::post('consumable/export', [\App\Http\Controllers\Admin\ConsumableController::class, 'export'])->name('consumable.export');
    Route::post('consumable/import', [\App\Http\Controllers\Admin\ConsumableController::class, 'import'])->name('consumable.import');

    Route::resource('user', \App\Http\Controllers\Admin\UserController::class);
    Route::post('user/import', [\App\Http\Controllers\Admin\UserController::class, 'import'])->name('user.import');
});

Route::middleware(['auth', 'role:serviceman'])->prefix('serviceman')->as('serviceman.')->group(function() {
    Route::get('/', [\App\Http\Controllers\Serviceman\PageController::class, 'index'])->name('dashboard');

    Route::get('/tool', [\App\Http\Controllers\Serviceman\ToolController::class, 'index'])->name('tool.index');
    Route::get('/tool/data', [\App\Http\Controllers\Serviceman\ToolController::class, 'data'])->name('tool.data');
    Route::get('/tool/{tool}', [\App\Http\Controllers\Serviceman\ToolController::class, 'show'])->name('tool.show');
    Route::post('/tool/{tool}/order', [\App\Http\Controllers\Serviceman\ToolController::class, 'order'])->name('tool.order');

    Route::get('/consumable', [\App\Http\Controllers\Serviceman\ConsumableController::class, 'index'])->name('consumable.index');
    Route::get('/consumable/data', [\App\Http\Controllers\Serviceman\ConsumableController::class, 'data'])->name('consumable.data');
    Route::get('/consumable/{consumable}', [\App\Http\Controllers\Serviceman\ConsumableController::class, 'show'])->name('consumable.show');
    Route::post('/consumable/{consumable}/order', [\App\Http\Controllers\Serviceman\ConsumableController::class, 'order'])->name('consumable.order');


    Route::prefix('request')->as('request.')->group(function() {

        Route::get('/tool', [\App\Http\Controllers\Serviceman\PageController::class, 'request_tool'])->name('tool.index');

        Route::get('/consumable', [\App\Http\Controllers\Serviceman\PageController::class, 'request_consumable'])->name('consumable.index');

    });
});

Route::middleware(['auth', 'role:supervisor'])->prefix('supervisor')->as('supervisor.')->group(function() {
    Route::get('/', [\App\Http\Controllers\Supervisor\PageController::class, 'index'])->name('dashboard');

    Route::post('/tool/export', [\App\Http\Controllers\Supervisor\ToolController::class, 'export'])->name('tool.export');
    Route::resource('tool', \App\Http\Controllers\Supervisor\ToolController::class)->only(['index', 'show']);
    Route::post('consumable/export', [\App\Http\Controllers\Supervisor\ConsumableController::class, 'export'])->name('consumable.export');
    Route::resource('consumable', \App\Http\Controllers\Supervisor\ConsumableController::class)->only(['index', 'show']);
    Route::resource('user', \App\Http\Controllers\Supervisor\UserController::class)->only(['index', 'show']);
});

Route::middleware(['auth', 'role:toolkeeper'])->prefix('toolkeeper')->as('toolkeeper.')->group(function() {
    Route::get('/', [\App\Http\Controllers\Toolkeeper\PageController::class, 'index'])->name('dashboard');

    Route::resource('tool', \App\Http\Controllers\Toolkeeper\ToolController::class)->except(['destroy', 'create', 'store']);
    Route::resource('consumable', \App\Http\Controllers\Toolkeeper\ConsumableController::class)->except(['destroy', 'create', 'store']);
    Route::resource('user', \App\Http\Controllers\Toolkeeper\UserController::class)->only(['index', 'show']);

    Route::prefix('request')->as('request.')->group(function() {

        Route::get('/tool', [\App\Http\Controllers\Toolkeeper\RequestToolController::class, 'index'])->name('tool.index');
        Route::post('/tool/export', [\App\Http\Controllers\Toolkeeper\RequestToolController::class, 'export'])->name('tool.export');
        Route::put('/tool/{tool}', [\App\Http\Controllers\Toolkeeper\RequestToolController::class, 'update'])->name('tool.update');

        Route::get('/consumable', [\App\Http\Controllers\Toolkeeper\RequestConsumableController::class, 'index'])->name('consumable.index');
        Route::post('/consumable/export', [\App\Http\Controllers\Toolkeeper\RequestConsumableController::class, 'export'])->name('consumable.export');
        Route::put('/consumable/{consumable}', [\App\Http\Controllers\Toolkeeper\RequestConsumableController::class, 'update'])->name('consumable.update');

    });
});

Route::get('/about', [\App\Http\Controllers\HomeController::class, 'about'])->name('about')->middleware('auth');
