<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WorkTime;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;


class mainTestController extends Controller
{
    public function index() : JsonResponse{
        /*$user = new User([
            'name' => 'name11',
            'surname' => 'surname',
            'email' => 'test1@test.com',
            'password' => 'password',
        ]);*/

        $user = new User();

        $user -> fill([
            'name' => 'Pawel',
            'surname' => 'Kucharskim',
            'email' => 'mailsada',
            'password' => "haslow"]);
        $email = $user -> getAttribute('email');
        //return response() -> json($user);
        $userArray = $user -> toArray();
        $userArray['email'] = $email;
        $jsonUserArray = json_encode($userArray);
        return response()-> json($jsonUserArray);
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

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended(route('main-page'));
        }
        return back()->withErrors(['credentials' => 'The provided credentials do not match our records.']);
    }

   public function createUser(Request $request):\Illuminate\Http\RedirectResponse
    {
        $user = new User();
        $randomUserId = Str::uuid() ->toString();
        $data = $request -> all();
        $user -> userId = $randomUserId;
        $user -> name = $data['name'];
        $user -> surname = $data['surname'];
        $user -> email = $data['email'];
        $user -> password = Hash::make($data['password']);
        $user -> save();

        return redirect()->route('users'); //users to nazwa route czyli w web.php -> name()
    }

    public function getCreateUserForm() : View
    {
        return view('create-user-form');
    }

    public function getUsers():\Illuminate\View\View{
        $users = User::all();
        return view('users', ['users' => $users]);
    }

    public function deleteAllUsers():\Illuminate\Http\RedirectResponse {
        DB::table('users')->delete();
        return redirect() -> route('create-user');
    }

    public function deleteUser($id):\Illuminate\Http\RedirectResponse {
        $user = User::findByUserId($id);
        if($user){
            $user -> delete();
        }else {Log::info("User not found. ID: " . $id);}
        return redirect() -> route('create-user');
    }

    public function getEditUserPage($userId) : View
    {
        $user = User::findByUserId($userId);
        return view('edit-user', ['user' => $user]);
    }

    public function editUser($userId, Request $request) : RedirectResponse
    {
        $user = User::findByUserId($userId);
        $data = $request->validate([
            'name' => ['required'],
            'surname' => ['required'],
            'email' => ['required', 'email'],
        ]);
        $user -> name = $data['name'];
        $user -> surname = $data['surname'];
        $user -> email  = $data['email'];
        $user -> save();
        return redirect() -> route('edit-user', $userId);
    }

    public function signOut(Request $request):\Illuminate\Http\RedirectResponse
    {
        Auth::logout();
        $request -> session() -> invalidate();
        $request -> session() ->regenerateToken();
        return redirect() -> route('main-page');
    }

    public function getWorkTimePage($userId) : View
    {

        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        $currentMonth = Carbon::create($year, $month, 1);
        $daysInMonth = $currentMonth -> daysInMonth;
        $days = [];
        for($day = 1; $day <= $daysInMonth; $day++){
            $days[] = Carbon::create($year, $month, $day);
        }
        $hour = 0;
        $hours = [];
        while($hour < 24){
            $hours[] = Carbon::createFromTime($hour, 0) -> format('H:i');
            $hour++;
        }
        $minute = 0;
        $minutes = [];
        while($minute < 61){
            $minutes[] = Carbon::createFromTime(0, $minute) -> format('H:i');
            $minute++;
        }

        if($user = User::findByUserId($userId)){
            $workTimes = WorkTime::where('user_id', $user -> id) -> get();
            if($workTimes == null){
                Log::info("WorkTime not found");
                /*$hoursAmount = '';
                $jsonData = '';
                $date = '';*/
            }else {
                //$hoursAmount = $workTime -> hoursAmount;
                //$jsonData = json_encode($workTime);
                //$date = $workTime -> date;*/
                $p = 'k';
            }
        }else {
            $hoursAmount = 0;
            $jsonData = json_encode(0);
            $workTimes = [];
            Log::info('user null');
        }

        return view('work-time', ['userId' => $userId, 'currentMonth' => $currentMonth, 'days' => $days, 'hours' => $hours, 'minutes' => $minutes , 'workTimes' =>$workTimes]);
    }

    public function calculateWorkTime(Request $request, $userId) : RedirectResponse
    {
        $startHour = (int) explode(':', $request -> input('startHour'))[0];
        $startMinute = (int) explode(':', $request -> input('startMinute'))[1];

        $endHour = (int) explode(':', $request -> input('endHour'))[0];
        $endMinute = (int) explode(':', $request -> input('endMinute'))[1];
        $dateFromInput = $request -> input('date');
        $date = Carbon::createFromDate($dateFromInput);

        $startDate = Carbon::createFromTime($startHour, $startMinute);
        $endDate = Carbon::createFromTime($endHour, $endMinute);
        $minutes = $startDate -> diffInMinutes($endDate);

        $hoursAmount = floor($minutes / 60);
        $minutesAmount = $minutes % 60;

        $hoursAmountTime = Carbon::createFromTime($hoursAmount, $minutesAmount) -> format('H:i');

        $user = User::findByUserId($userId);
        $workTime = new WorkTime();
        $workTime -> user() -> associate($user);
        $workTime -> startDate = $startDate -> format('H:i');
        $workTime -> endDate = $endDate ->format('H:i');
        $workTime -> hoursAmount = $hoursAmountTime;
        $workTime -> date = $dateFromInput;

        Log::info('calculated wywołane');
        $workTime -> save();
        return redirect() -> route('work-time', ['userId' => $userId]);
    }

    public function getAllWorkTimes() : View{
        $workTimes = WorkTime::all();
        return view('worktimes', ['workTimes' => $workTimes]);
    }

    public function deleteAllWorktimes() : RedirectResponse{
        DB::table('work_times')->delete();
        return redirect() -> route('work-times');
    }

}
