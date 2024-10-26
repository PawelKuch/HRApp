<!DOCTYPE html>
<html lang="en">
<head>
    <title>Change email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/create-user-form.css') }}">
    <link rel="stylesheet" href="css/menu.css">
</head>
<body>
@include('includes.menu-navigation')
<div class="container">
    <form method="post" action="{{route('change.email')}}">
        @csrf
        <div class="input-group">
            <span class="input-group-text">New address email</span>
            <input name="email">
        </div>
        <div class="input-group">
            <span class="input-group-text">Password</span>
            <input name="password">
        </div>
        <button class="btn btn-dark" type="submit">Change email</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>
