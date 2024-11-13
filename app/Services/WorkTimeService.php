<?php

namespace App\Services;

use App\Models\User;
use App\Models\WorkTime;
use App\Repositories\WorkTimeRepository;
use Carbon\Carbon;
use Carbon\Month;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class WorkTimeService {
    protected WorkTimeRepository $workTimeRepository;
    protected UserService $userService;

    public function __construct(WorkTimeRepository $workTimeRepository, UserService $userService) {
    $this -> workTimeRepository = $workTimeRepository;
    $this -> userService = $userService;
    }

    public function createWorkTime(User $user, $startDate, $endDate, $hoursAmountTime, $date) : bool
    {
        $workTime = new WorkTime();
        $workTime -> user() -> associate($user);
        $workTime -> startDate = $startDate -> format('H:i');
        $workTime -> endDate = $endDate ->format('H:i');
        $workTime -> hoursAmount = $hoursAmountTime;
        $workTime -> date = $date;

        if($this ->workTimeRepository -> saveWorkTime($workTime)){
            return true;
        }
        return false;
    }

    public function getWorkTimeByIdOfUser($id) : \Illuminate\Support\Collection
    {
        try {
            return $this->workTimeRepository -> getWorkTimesByIdOfUser($id);
        } catch (ModelNotFoundException $e){
            Log::error($e -> getMessage());
            return collect();
        }
    }


    public function calculateHoursAmount($startDateInput, $endDateInput) : string
    {
        $hoursAmount = $startDateInput -> diffInHours($endDateInput);
        $minutesAmount = $startDateInput -> diffInMinutes($endDateInput) % 60;

        return Carbon::createFromTime($hoursAmount, $minutesAmount) -> format('H:i');
    }

    public function getStartDate($startHourInput, $startMinuteInput) : Carbon
    {
        $startHour = (int) explode(':', $startHourInput)[0];
        $startMinute = (int) explode(':', $startMinuteInput)[1];
        return Carbon::createFromTime($startHour, $startMinute);
    }

    public function getEndDate($endHourInput, $endMinuteInput) : Carbon{
        $endHour = (int) explode(':',$endHourInput)[0];
        $endMinute = (int) explode(':', $endMinuteInput)[1];
        return Carbon::createFromTime($endHour, $endMinute);
    }

    public function getAllWorkTimes() : Collection
    {
        return $this->workTimeRepository -> getAllWorkTimes();
    }

    public function deleteAllWorkTimes() : bool
    {
        if($this->workTimeRepository -> deleteAllWorkTimes()){
            return true;
        }
        return false;
    }

    public function getDaysArray($date) : array
    {
        $days = [];
        $daysInMonth = $date -> daysInMonth;
        $year = $date -> year;
        $month = $date -> month;
        for($day = 1; $day <= $daysInMonth; $day++){
            $days[] = Carbon::create($year, $month, $day);
        }
        return $days;
    }

    public function get24HoursArray() : array
    {
        $hour = 0;
        $hours = [];
        while($hour < 24){
            $hours[] = Carbon::createFromTime($hour, 0) -> format('H:i');
            $hour++;
        }
        return $hours;
    }

    public function getMinutesArray() : array
    {
        $minutes = [];
        $minute = 0;
        while($minute < 60){
            $minutes[] = Carbon::createFromTime(0, $minute) -> format('H:i');
            $minute++;
        }
        return $minutes;
    }

    public function getTotalMonthlyHoursForUser(User $user, int $year, int $month) : float {
        $workTimes = $this -> workTimeRepository -> getMonthlyWorkTimesForUser($user, $year, $month);

        $totalHours = 0;
        foreach ($workTimes as $workTime) {
            $hours = (float) explode(':', $workTime -> hoursAmount)[0];
            $minutes = (float) explode(':', $workTime -> hoursAmount)[1];
            $totalTime = $hours + $minutes/60;
            $totalHours += $totalTime;
        }
        return $totalHours;
    }

    public function getPreviousMonthsRange(Carbon $date) : array {
        $months = [];
        for ($i = 4; $i>-1; $i--){
            $monthName = $date -> copy() -> subMonths($i) -> format('F Y');
            $monthNumber = $date -> copy() -> subMonths($i) -> month;
            $year = $date -> copy() -> subMonths($i) -> year;
            $months [] = ['name'=> $monthName, 'number'=> $monthNumber, 'year' => $year];
        }
        return $months;
    }

    public function getNextMonthsRange(Carbon $date) : array
    {
        $months = [];
        for ($i = 1; $i<5; $i++){
            $monthName = $date -> copy() -> addMonths($i) -> format('F Y');
            $monthNumber = $date -> copy() -> addMonths($i) -> month;
            $year = $date -> copy() -> addMonths($i) -> year;
            $months [] = ['name'=> $monthName, 'number'=> $monthNumber, 'year'=> $year];
        }
        return $months;
    }

    public function getMonthsRange(Carbon $date) : array
    {
        $previousAndPresentMonth = $this->getPreviousMonthsRange($date);
        $nextMonths = $this->getNextMonthsRange($date);
        return array_merge($previousAndPresentMonth, $nextMonths);
    }

}

