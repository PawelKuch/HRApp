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

    <link rel="stylesheet" href="{{ asset('css/forgot-password.css')}}">
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">

</head>
<body>
@include('includes.menu-navigation')

<div class="container d-flex align-items-center justify-content-center">
    <div id="form-div" class="d-flex flex-column justify-content-center">
        <div id="form-header">Type email on which you will receive a new password</div>
        <form>
            @csrf
            <div class="input-group d-flex flex-row">
                <span class="input-span input-group-text form-control bg-dark text-white">email</span>
                <input class="form-control">
            </div>
            <div id="button-div">
                <button class="btn btn-dark" type="submit">Send new password</button>
            </div>
        </form>
    </div>
</div>



@include('includes.footer')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>