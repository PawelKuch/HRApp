<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/menu.css">
</head>
<body>
@include('includes.menu-navigation')

<div class="container mt-3">
    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Working hours</th>
                <th>Timetable</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($days as $day)
            <tr>
                <td>{{$day->format('D d M Y')}}</td>
                <td>
                    <form action='{{route('calculate-work-time', ['userId' => $userId])}}' method="post">
                        @csrf
                        <select name="startHour">
                            @foreach($hours as $hour)
                                <option value="{{$hour}}">{{$hour}}</option>
                            @endforeach
                        </select>
                        <select name="startMinute">
                            @foreach($minutes as $minute)
                                <option value="{{$minute}}">{{$minute}}</option>
                            @endforeach
                        </select>
                        <span> -- </span>
                        <select name="endHour">
                            @foreach($hours as $hour)
                                <option value="{{$hour}}">{{$hour}}</option>
                            @endforeach
                        </select>
                        <select name="endMinute">
                            @foreach($minutes as $minute)
                                <option value="{{$minute}}">{{$minute}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" value="{{$day}}" name="date">
                        <button class="btn btn-outline-dark">Confirm</button>
                    </form>
                </td>
                <td>
                    @foreach($workTimes as $workTime)

                        @if($day -> eq($workTime -> date))
                            {{$workTime -> startDate}} - {{$workTime -> endDate}}
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach($workTimes as $workTime)
                        @if($day -> eq($workTime -> date))
                            {{$workTime -> hoursAmount}}
                        @endif
                    @endforeach
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
  date: {{$currentMonth}} <br>
    day: {{$currentMonth -> dayName}}

    <a href="/delete-all-worktimes"><button class="btn btn-dark">delete all worktimes</button></a>
    <a href="/work-time/{{$userId}}/"
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>



