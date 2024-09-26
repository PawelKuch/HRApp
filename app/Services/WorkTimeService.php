<?php

namespace App\Services;

use App\Models\User;
use App\Models\WorkTime;
use App\Repositories\WorkTimeRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class WorkTimeService {
    protected WorkTimeRepository $workTimeRepository;

    public function __construct(WorkTimeRepository $workTimeRepository) {
    $this -> workTimeRepository = $workTimeRepository;
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

    public function calculateHoursAmount($startHourInput, $startMinuteInput, $endHourInput, $endMinuteInput) : string
    {
        $startHour = (int) explode(':', $startHourInput)[0];
        $startMinute = (int) explode(':', $startMinuteInput)[1];
        $endHour = (int) explode(':',$endHourInput)[0];
        $endMinute = (int) explode(':', $endMinuteInput)[1];

        $startDate = Carbon::createFromTime($startHour, $startMinute);
        $endDate = Carbon::createFromTime($endHour, $endMinute);
        $minutes = $startDate -> diffInMinutes($endDate);

        $hoursAmount = floor($minutes / 60);
        $minutesAmount = $minutes % 60;

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

}

