<?php

namespace App\Services;

use App\Models\Leave;
use App\Models\User;
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
        $leave -> leave_status = 'pending';
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

    public function deleteAllLeaves() : void
    {
        $this -> leaveRepository -> deleteAllLeaves();
    }

    public function getPendingLeavesByIdOfUser($userId) : Collection
    {

        return $this -> leaveRepository -> getPendingLeavesByIdOfUser($userId);
    }

    public function getConfirmedIncomingLeavesByIdOfUser($idOfUser) : Collection
    {
        return $this -> leaveRepository -> getConfirmedIncomingLeavesByIdOfUser($idOfUser);
    }

    public function getLeavesHistoryByIdOfUser($idOfUser) : Collection
    {
        return $this -> leaveRepository -> getLeavesHistoryByIdOfUser($idOfUser);
    }
    public function getLeaveById($id) : Leave
    {
        return $this -> leaveRepository -> getLeaveById($id);
    }

    public function approveLeave($leaveId) : void
    {
        $leave = $this -> leaveRepository -> getLeaveById($leaveId);
        $leave -> leave_status = 'approved';
        $leave -> save();
    }

    public function moveBackTheLeave($leaveId) : void
    {
        $leave = $this -> leaveRepository -> getLeaveById($leaveId);
        $leave -> leave_status = 'pending';
        $leave -> save();
    }


}
