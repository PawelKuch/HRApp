<?php

namespace App\Repositories;

use App\Models\Leave;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class LeaveRepository {

    public function saveLeave(Leave $leave) : void
    {
        $leave -> save();
    }

    public function deleteLeave(Leave $leave)
    {
        $leave -> delete();
    }

    public function getAllLeaves() : Collection
    {
        return Leave::all();
    }

    public function getLeaveByLeaveId($leaveId) : Leave {
        return Leave::where('leave_id', $leaveId) -> first();
    }

    public function getLeavesByIdOfUser($userId) : Collection {
        return Leave::where('user_id', $userId) -> get();
    }

    public function getLeavesByIdOfUserAndOlderThanGivenDate($userId, $date) : Collection
    {
        return Leave::where('user_id', $userId) ->
            where('created_at' < $date) -> get();
    }
}
