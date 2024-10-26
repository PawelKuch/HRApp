<?php

namespace App\Services;

use App\Models\Leave;
use App\Repositories\LeaveRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class LeaveService {

    protected LeaveRepository $leaveRepository;

    public function __construct(LeaveRepository $leaveRepository) {
        $this -> leaveRepository = $leaveRepository;
    }

    public function createLeave($user, $fromDate, $toDate)
    {

        $leave = new Leave();
        $leave -> leave_id = str::uuid() -> toString();
        $leave -> user() -> associate($user);
        $leave -> from_date = $fromDate;
        $leave -> to_date = $toDate;
        $leave -> leave_status = false;
        $this -> leaveRepository -> saveLeave($leave);
    }

    public function getAllLeaves() : Collection
    {
        return $this -> leaveRepository -> getAllLeaves();
    }

    public function getLeaveByLeaveId($leaveId) : Leave
    {
        return $this -> leaveRepository -> getLeaveByLeaveId($leaveId);
    }

    public function getLeavesByIdOfUser($userId) : Collection {
        return $this -> leaveRepository -> getLeavesByIdOfUser($userId);
    }

    public function getLeavesByIdOfUserAndGivenDate($userId, $date) : Collection
    {
        return $this -> leaveRepository -> getLeavesByIdOfUserAndOlderThanGivenDate($userId, $date);
    }

}
