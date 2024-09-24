<?php

namespace App\Services;

use App\Models\User;
use App\Models\WorkTime;
use App\Repositories\WorkTimeRepository;

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
}

