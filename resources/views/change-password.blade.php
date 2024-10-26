<!DOCTYPE html>
<html lang="en">
<head>
    <title>Change password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/menu.css')}}">
</head>
<body>
@include('includes.menu-navigation')
<div class="container">

    <form action="{{route('change.password', ['userId' => Auth::user() -> userId])}}" method="post">
        @csrf
        <div class="input-group">
            <span class="input-group-text">New password</span>
            <input id="new-password" name='new_password' type="password">
        </div>
        <div class="input-group">
            <span class="input-group-text">Confirm new password</span>
            <input id="new-password-confirmation" name="new_password_confirmation" type="password">
        </div>
        <div class="input-group">
            <span class="input-group-text">Current password</span>
            <input id="current-password" name="current_password" type="password">
        </div>
        <button id="change-password-button" type="submit">Change password</button>
    </form>
    user email is: {{$email}}
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>
