<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    @vite('resources/js/workTime.js')
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
    <link rel="stylesheet" href="{{asset('css/worktime.css')}}">


</head>
<body>
@include('includes.menu-navigation')


<div class="container mt-3">
    <a href="{{route('worktime', ['userId' => $userId, 'month' => $currentMonth -> copy() -> subMonth() ->  month,
            'year' => $currentMonth -> year, 'action' => 'prev'])}}" class="text-dark"><i class="bi bi-arrow-left"></i></a>

    <select id="month">
        @foreach($previousMonths as $previousMonth)
            <option value="{{$previousMonth['number']}}-{{$previousMonth['year'] }}" @if($previousMonth['name'] == $currentMonth -> format('F Y')) selected @endif>{{$previousMonth['name']}}</option>
        @endforeach
    </select>

    <a href="{{route('worktime', ['userId' => $userId, 'month' => $currentMonth -> copy() -> addMonth() -> month,
            'year' => $currentMonth -> year, 'action' => 'next'])}}" class="text-dark"><i class="bi bi-arrow-right"></i></a>

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
                    <div data-worktime-day="{{$day -> format('d-m-Y')}}" class="worktime-div" id="worktime-div-{{$day}}">
                        <form id="worktime-form-{{$day -> format('d-m-Y')}}" action="{{ route('calculate-work-time', ['userId' => $userId]) }}" method="post">

                        @csrf
                            <div class="input-group d-flex flex-row">
                                <input class="form-control mb-3 mx-3" id="start_time" type="text" name="start_time" value="start time" placeholder="start time">
                                <input class="form-control mb-3 mx-3" id="end_time" type="text" name="end_time" value="end time" placeholder="end time">
                                <input name="worktime_date" type="hidden" value="{{ $day }}">
                            <button class="btn btn-dark form-control mb-3">Confirm</button>
                            </div>
                        </form>
                    </div>
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
                            <div id="hoursAmountDiv-{{$day -> format('d-m-Y')}}">{{$workTime -> hoursAmount}}</div>
                        @endif
                    @endforeach
                </td>
            </tr>
            @endforeach
            <tr class="separator">
                <td colspan="3" class="bg-light">Total hours</td>
                <td class="bg-light"> {{$totalHours}}</td>
            </tr>
        </tbody>
    </table>
  date: {{$currentMonth}} <br>
    day: {{$currentMonth -> dayName}} <br>
    total hours in the given month: {{$totalHours}} <br>
    <a href="/delete-all-worktimes"><button class="btn btn-dark">delete all worktimes</button></a>

</div>

<script>
    window.onload = function () {
        let monthSelect = document.getElementById('month');
        if(monthSelect){
          monthSelect.addEventListener('change', function () {
              let userId = @json($userId).toString();
              let [month, year] = this.value.split('-');

              window.location.href = '/work-time/' + encodeURIComponent(userId) + '?month=' + encodeURIComponent(month) + '&year=' + encodeURIComponent(year);
          });
        }else {
            console.error('monthselect nie został znaleziony');
        }
    };
</script>
@include('includes.footer')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>



