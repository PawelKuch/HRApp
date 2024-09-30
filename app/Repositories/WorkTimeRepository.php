<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\WorkTime;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class WorkTimeRepository {

    public function saveWorkTime(WorkTime $workTime) : bool
    {
        if($workTime->save()){
            return true;
        }
        return false;
    }

    public function getWorkTimesByIdOfUser($id) : Collection
    {
        if($workTimes = WorkTime::where('user_id', $id)->get()){
            return $workTimes;
        }
        throw new ModelNotFoundException("Worktime by id of user was not found");
    }

    public function getAllWorkTimes() : Collection
    {
        return WorkTime::all();
    }

    public function deleteAllWorkTimes() : bool
    {
        if(DB::table('work_times')->delete()){
            return true;
        }
        return false;
    }

    public function getMonthlyWorkTimesForUser(User $user, int $month, int $year) : Collection
    {
        return WorkTime::where('user_id', $user->id)
            -> whereYear('date', $year)
            -> whereMonth('date', $month)
            -> get();
    }

}

