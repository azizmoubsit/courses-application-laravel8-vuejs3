<?php

use App\Http\Controllers\CourseController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('course/create', [CourseController::class, 'create'])->name('course.create');
    Route::post('course/create', [CourseController::class, 'store'])->name('course.store');
    Route::get('course/edit/{id}', [CourseController::class, 'edit'])->name('course.edit');
    Route::patch('course/edit/{id}', [CourseController::class, 'update'])->name('course.update');
    Route::get('course/{id}', [CourseController::class, 'show'])->name('course.show');
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::post('/toggle-progress', [CourseController::class, 'toggleProgress'])->name('toggle.progress');
});