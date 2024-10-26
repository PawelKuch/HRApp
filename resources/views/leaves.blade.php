<!DOCTYPE html>
<html lang="en">
<head>
    <title>Change email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/leaves.css') }}">
    <link rel="stylesheet" href="{{asset('css/menu.css')}}">
</head>
<body>
@include('includes.menu-navigation')
<div class="container">
    Your leaves history
    <div id="calendar">
        <div class="week">
            @foreach($currentMonthDays as $day)
                <div class="day">{{$day -> day}}</div>
            @endforeach

        </div>
    </div>

    <form method="post" action="{{route('leaves')}}">
        @csrf
        <div class="input-group from-date">
            <span class="input-group-text">From</span>
            <select name="from_date_day">@foreach($currentMonthDays as $day)<option value='{{$day -> format('d')}}' @if($day -> day == $currentDate -> day) selected @endif>{{$day -> format('d')}}</option>@endforeach</select>
            <select name="from_date_month">@foreach($months as $month) <option value='{{$month -> month}}' @if($month -> month == $currentDate -> month) selected @endif>{{$month -> format('F')}}</option> @endforeach</select>
            <select name="from_date_year">@foreach($years as $year) <option value='{{$year}}' @if($year == $currentDate -> year) selected @endif>{{$year}}</option>@endforeach</select>
        </div>
        <div class="input-group to-date">
            <span class="input-group-text">To</span>
            <select name="to_date_day">@foreach($currentMonthDays as $day)<option value='{{$day -> format('d')}}' @if($day -> day == $currentDate -> day) selected @endif>{{$day -> format('d')}}</option>@endforeach</select>
            <select name="to_date_month">@foreach($months as $month) <option value='{{$month -> month}}' @if($month -> month == $currentDate -> month) selected @endif>{{$month -> format('F')}}</option> @endforeach</select>
            <select name="to_date_year">@foreach($years as $year) <option value='{{$year}}' @if($year == $currentDate -> year) selected @endif>{{$year}}</option>@endforeach</select>
        </div>
        <button class="btn btn-dark" type="submit">Send</button>
    </form>

    pending requests
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Request date</th>
                <th>From</th>
                <th>To</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($leaves as $leave)
            <tr>
                <td>{{$leave -> created_at -> format("d-M-y")}}</td>
                <td>{{$leave -> from_date}}</td>
                <td>{{$leave -> to_date}}</td>
                <td>{{$leave -> leave_status}}</td>
                <td>Action</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    Your incoming leaves
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>
