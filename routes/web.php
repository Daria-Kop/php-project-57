<?php

use App\Http\Controllers\LabelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskStatusController;

Route::get('/', static function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('task_statuses', TaskStatusController::class)
    ->names([
        'store' => 'status.create',
        'create' => 'status.build',
        'edit' => 'status.edit',
        'update' => 'status.update',
        'destroy' => 'status.destroy',
        'index' => 'status.index',
    ]);

Route::resource('tasks', TaskController::class)
    ->names([
        'store' => 'task.create',
        'create' => 'task.build',
        'edit' => 'task.edit',
        'update' => 'task.update',
        'destroy' => 'task.destroy',
        'index' => 'task.index',
        'show' => 'task.show',
    ]);

Route::resource('labels', LabelController::class)
    ->names([
        'store' => 'label.create',
        'create' => 'label.build',
        'edit' => 'label.edit',
        'update' => 'label.update',
        'destroy' => 'label.destroy',
        'index' => 'label.index',
        'show' => 'label.show',
    ]);

require __DIR__ . '/auth.php';
