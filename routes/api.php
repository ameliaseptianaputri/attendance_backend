<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ToDoListController;
use App\Http\Controllers\UserControllerApi;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('todolist', [ToDoListController::class, "test"])->name("test");
    Route::post('users/profile-image', [UserControllerApi::class, 'uploadProfileImage']);
    Route::get('users/profile', [UserControllerApi::class, 'profile']);
    Route::get('users/update', [UserControllerApi::class, 'update']);
    Route::post('users/change-password', [AuthController::class, 'changePassword']);
    Route::post('users/verify-password', [AuthController::class, 'verifyPassword']);
    Route::post('todolist/store', [ToDoListController::class, 'storeApi'])->name('ToDoList.store');
    Route::put('todolist/{id}/update', [ToDoListController::class, 'updateApi'])->name('ToDoList.update');
    Route::get('/create-document', [ToDoListController::class, 'createDocumentApi'])->name('word.tdl');
});
