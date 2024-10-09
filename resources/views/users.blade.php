<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="css/menu.css">
</head>
<body>
@include('includes.menu-navigation')

<div class="container mt-3">
    <div id="table-container">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Name</th>
                <th>Surname</th>
                <th>User ID</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->surname}}</td>
                    <td>{{$user->userId}}</td>
                    <td>@if(!($user -> role == 'admin') && $user -> is_blocked) Blocked @else Active @endif </td>
                    <td>
                        @if($user -> role == 'admin')
                            -
                        @else
                            <a href='delete-user/{{$user->userId}}'><i class="bi bi-trash text-dark"></i></a>
                            <a href="{{ route('edit-user', ['userId' => $user -> userId]) }}"><i class="bi bi-pencil text-dark"></i></a>
                            @if($user -> is_blocked == 1)
                                <a href="unblock-user/{{$user -> userId}}"><i class="bi bi-unlock text-success"></i></a>
                            @else
                                <a href="{{ route('block-user', ['userId' => $user -> userId] )}}"><i class="bi bi-ban text-danger"></i></a>
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @if(Auth::user() -> role == 'admin')
        <a href='{{route('create-user')}}'><button class="btn btn-dark">Create user</button></a>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>
