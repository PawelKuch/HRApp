<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view("welcome");
});

Route::get('/controller', [\App\Http\Controllers\mainTestController::class, 'index']);

Route::get('/create-user-form', [\App\Http\Controllers\mainTestController::class, 'getCreateUserForm'])
    ->middleware(\App\Http\Middleware\AdminMiddleware::class);

Route::post('/create-user-form', [\App\Http\Controllers\mainTestController::class, 'createUser'])
    ->name('create-user')
    ->middleware(\App\Http\Middleware\AdminMiddleware::class);

Route::get('/delete-all-users', [\App\Http\Controllers\mainTestController::class, 'deleteAllUsers']);

Route::get('/delete-user/{id}', [\App\Http\Controllers\mainTestController::class, 'deleteUser']);

Route::get('/main-page', [\App\Http\Controllers\mainTestController::class, 'getMainPage']) -> name('main-page');

Route::get('sign-in', [\App\Http\Controllers\mainTestController::class, 'getSignInPage']);

Route::post('sign-in', [\App\Http\Controllers\mainTestController::class, 'signIn']) -> name('sign-in');

Route::get('/sign-out', [\App\Http\Controllers\mainTestController::class, 'signOut']) -> name('sign-out');

Route::get('/users', [\App\Http\Controllers\mainTestController::class, 'getUsers'])
    -> name('users')
    -> middleware(\App\Http\Middleware\AdminMiddleware::class);

Route::get('edit-user/{userId}', [\App\Http\Controllers\mainTestController::class, 'getEditUserPage'])
    -> name('edit-user')
    -> middleware(\App\Http\Middleware\AdminMiddleware::class);

Route::post('edit-user/{userId}', [\App\Http\Controllers\mainTestController::class, 'editUser'])
    -> name('update-user')
    -> middleware(\App\Http\Middleware\AdminMiddleware::class);

Route::get('block-user/{userId}', [\App\Http\Controllers\mainTestController::class, 'blockUser'])
    -> name('block-user')
    -> middleware(\App\Http\Middleware\AdminMiddleware::class);

Route::get('/work-time/{userId}', [\App\Http\Controllers\mainTestController::class, 'getWorkTimePage'])
    -> name('worktime')
    -> middleware(\App\Http\Middleware\UserMiddleware::class);

Route::post('/work-time/{userId}', [\App\Http\Controllers\mainTestController::class, 'calculateWorkTime'])
    -> name('calculate-work-time')
    -> middleware(\App\Http\Middleware\UserMiddleware::class);

Route::get('/worktimes', [\App\Http\Controllers\mainTestController::class, 'getAllWorkTimes']) -> name('worktimes');

Route::get('/delete-all-worktimes', [\App\Http\Controllers\mainTestController::class, 'deleteAllWorktimes']) -> name('delete-all-worktimes');

Route::get('/unblock-user/{userId}', [\App\Http\Controllers\mainTestController::class, 'unblockUser']) -> name('unblock-user');

Route::get('/expenses/{userId}', [\App\Http\Controllers\mainTestController::class, 'getExpensesPage']) -> name('expenses');

Route::post('/expenses/{userId}', [\App\Http\Controllers\mainTestController::class, 'addExpense']) -> name('add-expense');

Route::get('/settle-expense/{expenseId}', [\App\Http\Controllers\mainTestController::class, 'settleTheExpense'])
    -> name('settleTheExpense')
    -> middleware(\App\Http\Middleware\AdminMiddleware::class);

Route::get('/delete-expense/{userId}/{expenseId}', [\App\Http\Controllers\mainTestController::class, 'deleteExpense'])
    -> name('deleteExpense')
    -> middleware(\App\Http\Middleware\AdminMiddleware::class);

Route::get('/unsettle-expense/{userId}/{expenseId}', [\App\Http\Controllers\mainTestController::class, 'unsettleExpense'])
    -> name('unsettleExpense')
    -> middleware(\App\Http\Middleware\AdminMiddleware::class);

Route::get('usersWorktime', [\App\Http\Controllers\mainTestController::class, 'getUsersWorktimePage'])
    -> name('usersWorktime')
    -> middleware(\App\Http\Middleware\AdminMiddleware::class);

Route::get('user-worktime/{userId}', [\App\Http\Controllers\mainTestController::class, 'getUserWorktimePage'])
    -> name('userWorktime')
    -> middleware(\App\Http\Middleware\AdminMiddleware::class);

