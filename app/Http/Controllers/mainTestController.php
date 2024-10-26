<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ExpenseService;
use App\Services\LeaveService;
use App\Services\UserService;
use App\Services\WorkTimeService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;



class mainTestController extends Controller
{
    protected UserService $userService;
    protected WorkTimeService $workTimeService;
    protected ExpenseService $expenseService;
    protected LeaveService $leaveService;

    public function __construct(UserService $userService, WorkTimeService $workTimeService, ExpenseService $expenseService, LeaveService $leaveService) {
        $this->userService = $userService;
        $this->workTimeService = $workTimeService;
        $this->expenseService = $expenseService;
        $this -> leaveService = $leaveService;
    }


   public function getMainPage() : View {
        return view('main-page');
   }

   public function getSignInPage() : View
   {
       return view('sign-in');
   }

    public function signIn(Request $request) : RedirectResponse
    {
        $credentials = $request -> validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email']) -> first();

        if($user){
            if(!$user -> is_blocked && Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended(route('main-page'));
            }elseif ($user -> is_blocked && Auth::attempt($credentials)){
                Auth::logout();
                return back() -> withErrors(['userBlocked' => "An account connected to the given address email has been blocked. Please, contact the administrator if you consider it as a mistake."]);
            }
            return back()->withErrors(['credentials' => 'The provided credentials do not match our records.']);
        }
        return back()->withErrors(['credentials' => 'The provided credentials do not match our records.']);
    }

   public function createUser(Request $request) : RedirectResponse
    {
        $data = $request -> all();
        $name = $data['name'];
        $surname = $data['surname'];
        $email = $data['email'];
        $password = Hash::make($data['password']);
        if($this -> userService -> createUser($name, $surname, $email, $password)){
            return redirect()->route('users') -> with('message', 'User has been created!');
        }
        return redirect()->route('users') -> withErrors('message','Something went wrong!');
    }

    public function getCreateUserForm() : View
    {
        return view('create-user-form');
    }

    public function getUsers(): View{
        $users = $this -> userService -> getUsers();
        return view('users', ['users' => $users]);
    }

    public function deleteAllUsers(): RedirectResponse {
        DB::table('users')->delete();
        return redirect() -> route('create-user');
    }

    public function deleteUser($id): RedirectResponse {
        $user = User::findByUserId($id);
        if($user){
            $user -> delete();
        }else {Log::info("User not found. ID: " . $id);}
        return redirect() -> route('users');
    }

    public function getEditUserPage($userId) : View
    {
        $user = $this -> userService -> getUserByUserId($userId);
        return view('edit-user', ['user' => $user]);
    }

    public function editUser($userId, Request $request) : RedirectResponse
    {
        $user = $this ->userService -> getUserByUserId($userId);
        $data = $request->validate([
            'name' => ['required'],
            'surname' => ['required'],
            'email' => ['required', 'email'],
        ]);

        $this -> userService -> updateUser($user, $data);
        return redirect() -> route('edit-user', $userId);
    }

    public  function  blockUser($userId) : RedirectResponse
    {
        $this -> userService -> blockUser($userId);
        return redirect() -> route('users');
    }

    public function unblockUser($userId) : RedirectResponse
    {
        $this -> userService -> unblockUser($userId);
        return redirect() -> route('users');
    }

    public function signOut(Request $request): RedirectResponse
    {
        Auth::logout();
        $request -> session() -> invalidate();
        $request -> session() ->regenerateToken();
        return redirect() -> route('main-page');
    }

    public function getWorkTimePage($userId, Request $request) : View
    {
        $month = $request -> query('month', Carbon::now()->month);
        $year = $request -> query('year', Carbon::now()->year);

        $action = $request -> input('action', null);

        if($action === 'prev' && $month == 1) {
            $year = $year - 1;
        }else if($action === 'next' && $month == 12){
            $year = $year + 1;
        }

        $currentMonth = Carbon::create($year, $month, 1);

        $days = $this -> workTimeService -> getDaysArray($currentMonth);

        $hours = $this -> workTimeService -> get24HoursArray();
        $minutes = $this -> workTimeService -> getMinutesArray();
        $totalHours = 0;
        if($user = $this -> userService -> getUserByUserId($userId)){
            $idOfUser = $user -> id;
            $workTimes = $this -> workTimeService -> getWorkTimeByIdOfUser($idOfUser);
            $totalHours = $this -> workTimeService -> getTotalMonthlyHoursForUser($user, $month, $year);
            $userName = $user -> name;
            $userSurname = $user -> surname;
        }else {
            $workTimes = collect();
            Log::info('user null');
            $userName = '';
            $userSurname = '';
        }

        $previousMonths = $this -> workTimeService -> getMonthsRange($currentMonth);

        return view('worktime', ['userId' => $userId]) -> with(['currentMonth' => $currentMonth, 'days' => $days, 'hours' => $hours, 'minutes' => $minutes , 'workTimes' =>$workTimes, 'action' => $action, 'totalHours' => $totalHours, 'previousMonths' => $previousMonths, 'userName' => $userName, 'userSurname' => $userSurname]);
    }

    public function calculateWorkTime(Request $request, $userId) : RedirectResponse
    {
        $startHour = $request -> input('startHour', 0);
        $startMinute = $request -> input('startMinute', 0);
        $endHour = $request -> input('endHour', 0);
        $endMinute = $request -> input('endMinute', 0);
        $workTimeDate = $request -> input('date');

        $startDate = $this -> workTimeService -> getStartDate($startHour, $startMinute);
        $endDate = $this -> workTimeService -> getEndDate($endHour, $endMinute);
        $hoursAmountTime = $this -> workTimeService -> calculateHoursAmount($startHour, $startMinute, $endHour, $endMinute);


        $user = $this -> userService -> getUserByUserId($userId);
        $this -> workTimeService -> createWorkTime($user, $startDate, $endDate, $hoursAmountTime, $workTimeDate);

        return redirect() -> route('worktime', ['userId' => $userId]);
    }

    public function getAllWorkTimes() : View{
        $workTimes = $this -> workTimeService -> getAllWorkTimes();
        return view('worktimes', ['workTimes' => $workTimes]);
    }

    public function deleteAllWorktimes() : RedirectResponse{
        $this -> workTimeService -> deleteAllWorkTimes();
        return redirect() -> route('worktimes');
    }

    public function getExpensesPage($userId) : View
    {
        $expensesForUser = $this -> expenseService -> getExpensesForUser($userId);
        $users = $this -> userService -> getUsers();
        $expenses = $this -> expenseService -> getAllExpenses();
        //dd($columns);
        return view('expenses', ['expensesForUser' => $expensesForUser,'expenses' => $expenses ,'users' => $users]);
    }

    public function addExpense($userId, Request $request) : RedirectResponse
    {
        $data = $request -> all();
        $user = $this -> userService -> getUserByUserId($userId);
        if($user){
            Log::warning("user found");
            $userId = $user -> userId;
        }else {
            Log::warning("user not found");
            $userId = 0;
        }
        //$date = (Carbon::now() -> year, Carbon::now() -> month, Carbon::now() -> month, Carbon::now() -> day);
        $date = Carbon::now();
        $this -> expenseService -> createExpense($user, $data['invoiceNo'], $data['value'], $date, $data['category'], $data['description']);
        return redirect() -> route('expenses', ['userId' => $userId]);
    }

    public function settleTheExpense($expenseId) : RedirectResponse
    {
        $expense = $this->expenseService -> getExpenseByExpenseId($expenseId);
        $expense -> is_settled = true;
        $user = User::find($expense -> user_id);
        $userId = $user -> userId;
        $this -> expenseService -> saveExpense($expense);
        return redirect() -> route('expenses', ['userId' => $userId]);
    }

    public function deleteExpense($userId, $expenseId) : RedirectResponse
    {
        $this -> expenseService -> deleteExpense($expenseId);
        return redirect() -> route('expenses', ['userId' => $userId]);
    }

    public function unsettleExpense($userId, $expenseId) : RedirectResponse
    {
        $this -> expenseService -> unsettleExpense($expenseId);
        return redirect() -> route('expenses', ['userId' => $userId]);
    }

    public function getUsersWorktimePage() : View
    {
        return view('users-worktime', ['users' => $this -> userService -> getUsers()]);
    }

    public function getUserWorktimePage($userId, Request $request) : View
    {
        $month = $request -> query('month', Carbon::now()->month);
        $year = $request -> query('year', Carbon::now()->year);

        $action = $request -> input('action', null);

        if($action === 'prev' && $month == 1) {
            $year = $year - 1;
        }else if($action === 'next' && $month == 12){
            $year = $year + 1;
        }

        $currentMonth = Carbon::create($year, $month, 1);

        $days = $this -> workTimeService -> getDaysArray($currentMonth);

        $hours = $this -> workTimeService -> get24HoursArray();
        $minutes = $this -> workTimeService -> getMinutesArray();
        $totalHours = 0;
        if($user = $this -> userService -> getUserByUserId($userId)){
            $idOfUser = $user -> id;
            $workTimes = $this -> workTimeService -> getWorkTimeByIdOfUser($idOfUser);
            $totalHours = $this -> workTimeService -> getTotalMonthlyHoursForUser($user, $month, $year);
            $userName = $user -> name;
            $userSurname = $user -> surname;
        }else {
            $workTimes = collect();
            Log::info('user null');
            $userName = '';
            $userSurname = '';
        }

        $previousMonths = $this -> workTimeService -> getMonthsRange($currentMonth);

        return view('user-worktime', ['userId' => $userId]) -> with(['currentMonth' => $currentMonth, 'days' => $days, 'hours' => $hours, 'minutes' => $minutes , 'workTimes' =>$workTimes, 'action' => $action, 'totalHours' => $totalHours, 'previousMonths' => $previousMonths, 'userName' => $userName, 'userSurname' => $userSurname]);
    }

    public function getUserSettingsPage($userId) : VIew
    {
        return view('user-settings', ['userId' => $userId]);
    }

    public function getYourAccountPage($userId) : View {
        return view('your-account', ['userId' => $userId]);
    }

    public function getChangePasswordPage($userId) : View
    {
        $user = $this -> userService -> getUserByUserId($userId);
        $email = $user -> email;
        return view('change-password', ['email' => $email]);
    }

    public function changePassword($userId, Request $request) : RedirectResponse
    {
        $data = $request -> validate(
            [
                'current_password' => 'required',
                'new_password' => 'required | confirmed',
            ]);

        $currentPassword = $data['current_password'];
        $newPassword = $data['new_password'];
        $passwordFromDB = Auth::user() -> password;
        if(!Hash::check($currentPassword, $passwordFromDB)) {
                return redirect() -> route('change-password', ['userId' => $userId]) -> withErrors(['incorrectPassword' => 'Incorrect password. You cannot change the one!',
                    'incorrectNewPassword' => 'New password and confirm new password do not match.']);
        }
        $this -> userService -> changePassword($userId, $newPassword);
        return redirect() -> route('change.password', ['userId' => $userId]);
    }

    public function getChangeEmailPage() : View
    {
        return view('change-email');
    }

    public function changeEmail(Request $request) : RedirectResponse
    {
        $data = $request -> validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $password = $data['password'];
        $newEmail = $data['email'];
        $passwordFromDB = Auth::user() -> password;
        if(!Hash::check($password, $passwordFromDB)){
            return redirect() -> route('change.email') -> withErrors(['IncorrectPassword' => 'Wrong password! You cannot change the email!']);
        }
        $this -> userService -> changeEmail(Auth::user() -> userId, $newEmail);
        return redirect() -> route('change.email');
    }

    public function getLeavesPage() : View
    {
        $leaves = $this -> leaveService -> getAllLeaves();
        return view('leaves', ['leaves' => $leaves]);
    }

    public function addLeave(Request $request) : RedirectResponse
    {

        return redirect() -> route('leaves');
    }

    public function getUserLeavesPage(Request $request) : View{
        $currentDate = Carbon::now();
        $fromDateDay = $request -> input('from_date_day');
        $fromDateMonth = $request -> input('from_date_month');
        $fromDateYear = $request -> input('from_date_year');

        $toDateDay = $request -> input('to_date_day');
        $toDateMonth = $request -> input('to_date_month');
        $toDateYear = $request -> input('to_date_year');

        $fromDate = Carbon::createFromDate($fromDateYear, $fromDateMonth,$fromDateDay);
        $toDate = Carbon::createFromDate($toDateYear, $toDateMonth, $toDateDay);

        $user = Auth::user();
        $this -> leaveService ->createLeave($user, $fromDate, $toDate);

        $currentMonthDays = $this -> workTimeService -> getDaysArray($currentDate);
        $currentMonth = $currentDate -> month;
        $currentYear = $currentDate -> year;

        $months = [];
        for($i = 1; $i < 13; $i++)
        {
            $months[] = Carbon::createFromDate(2024, $i, 1);
        }

        $years = [];
        $startYear = 2000;
        $endYear = $currentYear + 5;
        for($i = $startYear; $i <= $endYear; $i++){
            $years[] = $i;
        }

        $id = $user -> id;
        $leaves = $this -> leaveService -> getLeavesByIdOfUserAndGivenDate($id, $currentDate); //tutaj zmienić, że nie porownuje z created_at a z from date i z to date
        //$leaves = $this -> leaveService -> getLeavesByIdOfUser($id);
        return view('user-leaves', ['leaves' => $leaves,'currentDate' => $currentDate, 'currentMonthDays' => $currentMonthDays, 'currentMonth' => $currentMonth, 'currentYear' => $currentYear, 'years' => $years,'months' => $months]);
    }
}


