<?php

use App\Http\Middleware\UserMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view("welcome");
});

Route::get('/controller', [\App\Http\Controllers\mainTestController::class, 'index']);

Route::get('/create-user-form', [\App\Http\Controllers\mainTestController::class, 'getCreateUserForm'])
    ->middleware(\App\Http\Middleware\AdminMiddleware::class);

Route::get('/', [\App\Http\Controllers\mainTestController::class, 'getMainPage']);

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

Route::get('user-settings/{userId}', [\App\Http\Controllers\mainTestController::class, 'getUserSettingsPage'])
    -> name('user.settings')
    -> middleware(\App\Http\Middleware\UserMiddleware::class);

Route::get('your-account/{userId}', [\App\Http\Controllers\mainTestController::class, 'getYourAccountPage'])
    -> name('your.account')
    -> middleware(UserMiddleware::class);

Route::get('change-password', [\App\Http\Controllers\mainTestController::class, 'getChangePasswordPage'])
    -> name('change.password')
    -> middleware(UserMiddleware::class);

Route::post('change-password', [\App\Http\Controllers\mainTestController::class, 'changePassword'])
    -> middleware(UserMiddleware::class);


Route::get('change-email', [\App\Http\Controllers\mainTestController::class, 'getChangeEmailPage'])
    -> name('change.email')
    -> middleware(UserMiddleware::class );

Route::post('change-email', [\App\Http\Controllers\mainTestController::class, 'changeEmail'])
    -> middleware(UserMiddleware::class);

Route::get('leaves', [\App\Http\Controllers\mainTestController::class, 'getLeavesPage'])
    -> name('leaves')
    -> middleware(UserMiddleware::class);

Route::post('get-pending-leaves-for-user', [\App\Http\Controllers\mainTestController::class, 'getPendingLeavesForUserFromFetch']);
Route::post('get-approved-incoming-leaves-for-user', [\App\Http\Controllers\mainTestController::class, 'getApprovedAndIncomingLeavesForUserFromFetch']);
Route::post('get-leaves-history-for-user', [\App\Http\Controllers\mainTestController::class, 'getLeavesHistoryForUserFromFetch']);

Route::get('user-leaves', [\App\Http\Controllers\mainTestController::class, 'getUserLeavesPage'])
    -> name('user.leaves')
    -> middleware(\App\Http\Middleware\UserMiddleware::class);


Route::post('user-leaves', [\App\Http\Controllers\mainTestController::class, 'addLeave'])
    -> middleware(UserMiddleware::class);

Route::get('delete-all-leaves', [\App\Http\Controllers\mainTestController::class, 'deleteAllLeaves'])
    -> name('delete.all.leaves');
    //-> middleware(\App\Http\Middleware\AdminMiddleware::class);

Route::get('approve-leave-request', [\App\Http\Controllers\mainTestController::class, 'approveLeaveRequest'])
    -> name('approve.leave.request')
    -> middleware(\App\Http\Middleware\AdminMiddleware::class);

Route::get('move-back-the-leave-request', [\App\Http\Controllers\mainTestController::class, 'moveBackTheLeave'])
    -> name('move.back.the.leave.request')
    -> middleware(\App\Http\Middleware\AdminMiddleware::class);

Route::get('cancel-leave-request', [\App\Http\Controllers\mainTestController::class, 'cancelLeaveRequest'])
    -> name('cancel.leave.request')
    -> middleware(UserMiddleware::class);

Route::post('edit.leave.request', [\App\Http\Controllers\mainTestController::class, 'editLeaveRequest'])
    -> name('edit.leave.request')
    -> middleware(UserMiddleware::class);

