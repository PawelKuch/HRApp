<?php

namespace App\Repositories;

use App\Models\Leave;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class LeaveRepository {

    public function saveLeave(Leave $leave) : void
    {
        $leave -> save();
    }

    public function deleteLeave($leaveId)
    {
        $leave = $this -> getLeaveByLeaveId($leaveId);
        $leave -> delete();
    }

    public function deleteAllLeaves() : void{
        Leave::truncate();
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

    public function getPendingLeavesByIdOfUser($userId) : Collection
    {
        $date = Carbon::now();
        return Leave::where('leave_status', 'pending')
            -> where('user_id', $userId)
            -> where('from_date', '>', $date) -> get();
    }

    public function getConfirmedIncomingLeavesByIdOfUser($userId) : Collection
    {
        $currentDate = Carbon::now();
        return Leave::where('user_id', $userId)
            -> where('leave_status', 'approved')
            -> where('from_date', '>', $currentDate)
            -> where('to_date', '>', $currentDate) -> get();
    }

    public function getLeavesHistoryByIdOfUser($userId) : Collection
    {
        $date = Carbon::now();
        return Leave::where('leave_status', 'approved')
            -> where('user_id', $userId)
            -> where('from_date', '<=', $date) -> get();
    }

    public function getLeaveById($id) : Leave
    {
        return Leave::where('id', $id) -> first();
    }

}
