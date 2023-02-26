<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TaskController;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        //return Inertia::render('Dashboard');
        return redirect(route('tasks.index', ['team' => auth()->user()->currentTeam]), 303);
    })->name('dashboard');

    Route::controller(TaskController::class)->group(function () {
        Route::get('teams/{team}/tasks', 'index')->name('tasks.index');
        Route::get('teams/{team}/tasks/create', 'create')->name('tasks.create');
        Route::get('teams/{team}/tasks/{task}', 'show')->name('tasks.show');
        Route::post('teams/{team}/tasks', 'store')->name('tasks.store');
    });
});
