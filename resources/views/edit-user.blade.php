<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <link rel="stylesheet" href="{{asset('css/menu.css')}}">
</head>
<body>
@include('includes.menu-navigation')
<div class="container">
    <div id="sign-in-container">
        <div id="sign-in-header">
            EDIT USER
        </div>
        <form action="{{route('update-user' , ['userId' => $user -> userId])}}" method="POST">
            @csrf
            <div class="input-group d-flex flex-column">
                <div style="display: flex; flex-direction: row; justify-content: center;">
                    <span class="input-span input-group-text mb-3"> email </span>
                    <input class="form-control mb-3" id="email" name="email" value="{{$user -> getAttribute('email')}}">
                </div>
                <div style="display: flex; flex-direction: row; justify-content: center;">
                    <span class="input-span input-group-text mb-3"> name </span>
                    <input class="form-control mb-3" name="name" value="{{$user -> name}}">
                </div>
                <div style="display: flex; flex-direction: row; justify-content: center;">
                    <span class="input-span input-group-text mb-3"> surname </span>
                    <input class="form-control mb-3" name="surname" value="{{$user -> surname}}">
                </div>
            </div>
            <div id="sign-in-button-div">
                <button id="change-data-button" class="btn btn-dark" type="submit">change data</button>
            </div>
        </form>
    </div>
    @error('credentials')
    {{$message}}
    @enderror
</div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>




</body>
</html>
