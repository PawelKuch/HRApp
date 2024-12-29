<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="{{asset('css/menu.css')}}">
    <link rel="stylesheet" href="{{asset('css/users-worktime.css')}}">
</head>
<body>
@include('includes.menu-navigation')

<div class="container mt-3">
        <div id="users-container">
            <h4 class="my-4">Select the user whose work time you want to see </h4>
            @foreach($users as $user)
                <a href='{{route('userWorktime', ['userId' => Auth::user()-> userId, 'month' => \Carbon\Carbon::now() -> month, 'year' => \Carbon\Carbon::now() -> year]) }}'>
                    <div class="user-tile">{{$user -> name}} {{$user -> surname}}</div>
                </a>
            @endforeach
        </div>
</div>




@include('includes.footer')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>



