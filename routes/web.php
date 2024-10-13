<?php

use App\Http\Controllers\AttendanceModelController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ToDoListController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('landing-page');
});

// Authentication routes
Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Attendance routes
    Route::get('/attendance', [AttendanceModelController::class, 'index'])->name('attendance');
    Route::post('/store', [AttendanceModelController::class, 'store'])->name('store');
    Route::patch('/update/{id}', [AttendanceModelController::class, 'update'])->name('update');
    Route::get('/attendance/create-document', [AttendanceModelController::class, 'createDocument'])->name('word.attendance');

    Route::resource('users', UserController::class);
    Route::get('/user/{id}', [UserController::class, 'show'])->name('show.user');
    Route::put('/user/updateStatus/{id}', [UserController::class, 'updateStatus'])->name('user.updateStatus');
    Route::post('/user/pesan/{id}', [UserController::class, 'pesan'])->name('user.pesan');

    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::get('/user/show/{id}', [UserController::class, 'show'])->name('show.user');

    Route::get('/ToDoList/index', [ToDoListController::class, 'index'])->name('ToDoList.index');
    Route::get('/todolist/create', [ToDoListController::class, 'create'])->name('ToDoList.create');
    Route::post('/todolist/store', [ToDoListController::class, 'storeWeb'])->name('ToDoList.store');
    Route::get('/todolist/{todolist}/edit', [ToDoListController::class, 'edit'])->name('ToDoList.edit');
    Route::put('/todolist/{todolist}/update', [ToDoListController::class, 'updateWeb'])->name('ToDoList.update');
    Route::delete('/todolist/{id}/delete', [ToDoListController::class, 'destroy'])->name('ToDoList.destroy');
    Route::post('/todo/{id}/add-note', [ToDoListController::class, 'addNote'])->name('ToDoList.addNote');

    Route::put('/todolist/{id}/updateStatus', [ToDoListController::class, 'updateStatus'])->name('ToDoList.updateStatus');
    Route::post('/todolist/{id}/pesan', [ToDoListController::class, 'pesan'])->name('ToDoList.pesan');

    Route::get('/create-document', [ToDoListController::class, 'createDocumentWeb'])->name('word.tdl');

    Route::resource('tasks', TaskController::class);
    Route::post('tasks/{task}/markAsRead', [TaskController::class, 'markAsRead'])->name('tasks.markAsRead');
});
