<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\HomeController;

use App\Models\Folder;

Route::group(['middleware' => 'auth'], function() {
    Route::get ("/", [HomeController::class, 'index'])->name('home');
    
    Route::get ('/folders/create', [FolderController::class, 'showCreateForm'])->name('folders.create');
    Route::post('/folders/create', [FolderController::class, 'create']);
    
    Route::group(['middleware' => 'can:view,folder'], function() {
        Route::get ('/folders/{folder}/tasks', [TaskController::class, 'index'])->name('tasks.index');
        
        Route::get ('/folders/{folder}/tasks/create', [TaskController::class, 'showCreateForm'])->name('tasks.create');
        Route::post('/folders/{folder}/tasks/create', [TaskController::class, 'create']);
        
        Route::get ('/folders/{folder}/tasks/{task}/edit', [TaskController::class, 'showEditForm'])->name('tasks.edit');
        Route::post('/folders/{folder}/tasks/{task}/edit', [TaskController::class, 'edit']);
    });
});

Auth::routes();