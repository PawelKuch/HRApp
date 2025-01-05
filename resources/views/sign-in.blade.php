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

    <link rel="stylesheet" href="{{ asset('css/sign-in.css')}}">
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">

    <script src="js/app.js"></script>
</head>
<body>
@include('includes.menu-navigation')
<div class="container d-flex flex-row justify-content-center">
    <div id="news-container" class="d-flex flex-row justify-content-center">
        <div id="main-news">
            <p>
                We are here to support your business.
                You can find plenty of things that you can improve with us.
                Take real control over the all things and matters along your company and let us be your partner in business.
            </p>
            <img src="{{asset('img/news.png')}}" class="mt-3"/>
        </div>
    </div>

    <div id="sign-in-container" class="d-flex justify-content-center flex-column">
        <div id="sign-in-header" class="d-flex flex-column justify-content-center mb-5">
            <h1>Log in below to get further</h1>
            <div id="login-data">
                Address email: admin@admin.com <br>
                Password: admin
            </div>
        </div>
        <div id="form-div">
            <form id="sign-in-form" action="{{route('sign-in')}}" method="POST">
                @csrf
                <div class="input-group">
                    <div style="display: flex; flex-direction: row; justify-content: center;">
                        <span class="input-span input-group-text mb-3 bg-dark text-white"> email </span>
                        <input class="form-control mb-3" id="email" name="email">
                    </div>
                    <div style="display: flex; flex-direction: row; justify-content: center;">
                        <span class="input-span input-group-text mb-3 bg-dark text-white"> password </span>
                        <input class="form-control mb-3" type="password" id="password" name="password">
                    </div>
                </div>
                <div id="button-div" class="d-flex justify-content-center flex-row">
                    <button id="sign-in-button" class="btn btn-dark mx-2" type="submit" name="sign-in-button">SIGN IN </button>
                    <a href="/forgot-password"><div id="forgot_password_div" class="form-control mx-2 bg-dark text-white">FORGOT PASSWORD</div></a>
                </div>
            </form>
        </div>

    </div>
    @error('credentials')
    <div class="alert alert-danger">{{$message}}</div>
    @enderror
    @error('userBlocked')
    <div class="alert alert-danger">{{$message}}</div>
    @enderror
</div>

@include('includes.footer')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>




</body>
</html>
