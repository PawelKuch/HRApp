<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/create-user-form.css') }}">
    <link rel="stylesheet" href="css/menu.css">
</head>
<body>
@include('includes.menu-navigation')
<div class="container">
        <div id="create-user-form-container">
                <div id="form-header">
                    Create user
                </div>
                <form action="{{route('create-user')}}" method="POST">
                    @csrf
                    <div class="input-group input-group-fields">
                        <div class="input-group-div">
                            <span class="input-group-text form-control mb-3">Name</span><input class="form-control mb-3" name="name" placeholder="Name">
                        </div>

                        <div class="input-group-div">
                            <span class="input-group-text form-control mb-3">Surname</span><input class="form-control mb-3" name="surname" placeholder="Surname">
                        </div>

                        <div class="input-group-div">
                            <span class="input-group-text form-control mb-3">Password</span><input class="form-control mb-3" name="password" type="password" placeholder="Password">
                        </div>

                        <div class="input-group-div">
                            <span class="input-group-text form-control mb-1">Email</span><input class="form-control mb-1"name="email" placeholder="example@email.com">
                        </div>
                    </div>
                    <div id="submit-btn-div">
                        <button class="btn btn-outline-light mb-3" type="submit">create</button>
                    </div>
                </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>
