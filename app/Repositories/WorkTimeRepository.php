<?php

namespace App\Repositories;

use App\Models\WorkTime;

class WorkTimeRepository {

    public function saveWorkTime(WorkTime $workTime) : bool
    {
        if($workTime->save()){
            return true;
        }
        return false;
    }


}

