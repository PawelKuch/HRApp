<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view("welcome");
});

Route::get('/controller', [\App\Http\Controllers\mainTestController::class, 'index']);

Route::get('/create-user-form', [\App\Http\Controllers\mainTestController::class, 'getCreateUserForm']);

Route::post('/create-user-form', [\App\Http\Controllers\mainTestController::class, 'createUser'])->name('create-user');

Route::get('/delete-all-users', [\App\Http\Controllers\mainTestController::class, 'deleteAllUsers']);

Route::get('/delete-user/{id}', [\App\Http\Controllers\mainTestController::class, 'deleteUser']);

Route::get('/main-page', [\App\Http\Controllers\mainTestController::class, 'getMainPage']) -> name('main-page');

Route::get('sign-in', [\App\Http\Controllers\mainTestController::class, 'getSignInPage']);

Route::post('sign-in', [\App\Http\Controllers\mainTestController::class, 'signIn']) -> name('sign-in');

Route::get('/sign-out', [\App\Http\Controllers\mainTestController::class, 'signOut']) -> name('sign-out');

Route::get('/users', [\App\Http\Controllers\mainTestController::class, 'getUsers'])
    -> name('users')
    -> middleware(\App\Http\Middleware\AdminMiddleware::class);

Route::get('edit-user/{userId}', [\App\Http\Controllers\mainTestController::class, 'getEditUserPage']) -> name('edit-user');

Route::post('edit-user/{userId}', [\App\Http\Controllers\mainTestController::class, 'editUser']) -> name('update-user');

Route::get('/work-time/{userId}', [\App\Http\Controllers\mainTestController::class, 'getWorkTimePage']) -> name('work-time');

Route::post('/work-time/{userId}', [\App\Http\Controllers\mainTestController::class, 'calculateWorkTime']) -> name('calculate-work-time');

Route::get('/worktimes', [\App\Http\Controllers\mainTestController::class, 'getAllWorkTimes']) -> name('work-times');

Route::get('/delete-all-worktimes', [\App\Http\Controllers\mainTestController::class, 'deleteAllWorktimes']) -> name('delete-all-worktimes');
