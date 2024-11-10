<!DOCTYPE html>
<html lang="en">
<head>
    <title>Change email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/user-leaves.css') }}">
    <link rel="stylesheet" href="{{asset('css/menu.css')}}">
</head>
<body>
@include('includes.menu-navigation')
<div class="container">
    <div id="calendar">
        <div class="week">
            @foreach($currentMonthDays as $day)
                <div class="day">{{$day -> day}}</div>
            @endforeach

        </div>
    </div>
    @if($leavesHistory -> isNotEmpty())
    <table id="leaves-history-table" class="table table-bordered">
        <thead>
        <tr><th colspan="5" style="text-align: center;">Your leaves history</th></tr>
        <tr>
            <th>Request date</th>
            <th>From</th>
            <th>To</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($leavesHistory as $leave)
            <tr>
                <td>{{$leave -> created_at -> format("d-M-y")}}</td>
                <td>{{$leave -> from_date}}</td>
                <td>{{$leave -> to_date}}</td>
                <td>{{$leave -> leave_status}}</td>
                <td>cancel your request | edit your request</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @endif

    <table id="pending-leaves-table" class="table">
        <thead>
            <tr>
                <th colspan="4" style="text-align: center;">Pending leave requests</th>
            </tr>
            <tr>
                <th>Request date</th>
                <th>From</th>
                <th>To</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        @foreach($pendingLeaves as $leave)
            <tr>
                <td>{{$leave -> created_at -> format("d-M-y")}}</td>
                <td>{{$leave -> from_date}}</td>
                <td>{{$leave -> to_date}}</td>
                <td>{{$leave -> leave_status}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <a href="#" data-bs-toggle="modal" data-bs-target="#addLeaveRequestModal"><button class="btn btn-outline-primary">Create leave request</button></a>
    <a href="{{route('delete.all.leaves')}}"> <button class="btn btn-dark">Delete all Leaves</button></a>
    Your incoming leaves (leaves that are approved and the date of your absent has not come yet)
</div>
<div id="modal-container">
    <div class="modal fade" id="addLeaveRequestModal" tabindex="-1" aria-labelledby="addLeaveRequestModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div id="modal-title-div">
                        <h1 class="modal-title fs-5" id="addLeaveRequestModalLabel">New leave request</h1>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('user.leaves')}}">
                        @csrf
                        <div class="input-group from-date">
                            <span class="input-group-text form-control mb-3">From</span>
                            <select class='form-control mb-3' name="from_date_day">@foreach($currentMonthDays as $day)<option value='{{$day -> format('d')}}' @if($day -> day == $currentDate -> day) selected @endif>{{$day -> format('d')}}</option>@endforeach</select>
                            <select class='form-control mb-3' name="from_date_month">@foreach($months as $month) <option value='{{$month -> month}}' @if($month -> month == $currentDate -> month) selected @endif>{{$month -> format('F')}}</option> @endforeach</select>
                            <select class='form-control mb-3' name="from_date_year">@foreach($years as $year) <option value='{{$year}}' @if($year == $currentDate -> year) selected @endif>{{$year}}</option>@endforeach</select>
                        </div>
                        <div class="input-group to-date">
                            <span class="input-group-text form-control mb-3">To</span>
                            <select class="form-control mb-3" name="to_date_day">@foreach($currentMonthDays as $day)<option value='{{$day -> format('d')}}' @if($day -> day == $currentDate -> day) selected @endif>{{$day -> format('d')}}</option>@endforeach</select>
                            <select class="form-control mb-3" name="to_date_month">@foreach($months as $month) <option value='{{$month -> month}}' @if($month -> month == $currentDate -> month) selected @endif>{{$month -> format('F')}}</option> @endforeach</select>
                            <select class="form-control mb-3" name="to_date_year">@foreach($years as $year) <option value='{{$year}}' @if($year == $currentDate -> year) selected @endif>{{$year}}</option>@endforeach</select>
                        </div>
                        <button class="btn btn-dark" type="submit">Send</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>
