<?php

use App\Http\Controllers\AttendanceModelController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ToDoListController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('template');
});

// Authentication routes
Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Attendance routes
    Route::get('/pages', [AttendanceModelController::class, 'index'])->name('pages');
    Route::post('/store', [AttendanceModelController::class, 'store'])->name('store');
    Route::patch('/update/{id}', [AttendanceModelController::class, 'update'])->name('update');
    Route::get('/attendance/create-document', [AttendanceModelController::class, 'createDocument'])->name('word.attendance');

    Route::get('/user', [UserController::class, 'index'])->name('user.index');
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
    
    Route::put('/todolist/{id}/updateStatus', [ToDoListController::class, 'updateStatus'])->name('ToDoList.updateStatus');
    Route::post('/todolist/{id}/pesan', [ToDoListController::class, 'pesan'])->name('ToDoList.pesan');

    Route::get('/create-document', [ToDoListController::class, 'createDocumentWeb'])->name('word.tdl');
});
