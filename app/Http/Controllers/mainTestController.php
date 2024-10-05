<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\WorkTimeRepository;
use App\Services\ExpenseService;
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
    protected WorkTimeRepository $workTimeRepository;
    protected ExpenseService $expenseService;

    public function __construct(UserService $userService, WorkTimeService $workTimeService, ExpenseService $expenseService) {
        $this->userService = $userService;
        $this->workTimeService = $workTimeService;
        $this->expenseService = $expenseService;
    }


   public function getMainPage() : View {
        return view('main-page');
   }

   public function getSignInPage() : View
   {
       return view('sign-in');
   }

    public function signIn(Request $request):\Illuminate\Http\RedirectResponse
    {
        $credentials = $request -> validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email']) -> first();
        if(!$user -> is_blocked && Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('main-page'));
        }else if ($user -> is_blocked) {
            return back()->withErrors(['userBlocked' => 'The account connected to the given email is blocked. If you consider it as a mistake, contact the administrator please']);
        }
        return back()->withErrors(['credentials' => 'The provided credentials do not match our records.']);
    }

   public function createUser(Request $request):\Illuminate\Http\RedirectResponse
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
        }else {
            $workTimes = collect();
            Log::info('user null');
        }
        $previousMonths = $this -> workTimeService -> getPreviousMonthsRange($currentMonth);

        return view('worktime', ['userId' => $userId]) -> with(['currentMonth' => $currentMonth, 'days' => $days, 'hours' => $hours, 'minutes' => $minutes , 'workTimes' =>$workTimes, 'action' => $action, 'totalHours' => $totalHours, 'previousMonths' => $previousMonths]);
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
}
