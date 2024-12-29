<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/users.css') }}">
    @vite('resources/js/users.js')

</head>
<body>
@include('includes.menu-navigation')

<div class="container mt-5">
    <h2 class="text-center mb-4">User Management</h2>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Surname</th>
                <th>User ID</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->surname }}</td>
                    <td>{{ $user->userId }}</td>
                    <td>
                            <span class="badge {{ $user->is_blocked && $user->role !== 'admin' ? 'bg-danger' : 'bg-success' }}">
                                {{ $user->is_blocked && $user->role !== 'admin' ? 'Blocked' : 'Active' }}
                            </span>
                    </td>
                    <td>
                        @if($user->role === 'admin')
                            <span class="text-muted">-</span>
                        @else
                            <a href='delete-user/{{ $user->userId }}' class="text-dark me-2">
                                <i class="bi bi-trash"></i>
                            </a>
                            <a href="{{ route('edit-user', ['userId' => $user->userId]) }}" class="text-dark me-2">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @if($user->is_blocked)
                                <a href="unblock-user/{{ $user->userId }}" class="text-success me-2">
                                    <i class="bi bi-unlock"></i>
                                </a>
                            @else
                                <a href="{{ route('block-user', ['userId' => $user->userId]) }}" class="text-danger">
                                    <i class="bi bi-ban"></i>
                                </a>
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    @if(Auth::user()->role === 'admin')
        <div class="text-end">
            <button data-bs-toggle="modal" data-bs-target="#create-user-modal" class="btn btn-dark">Create User</button>
        </div>
    @endif
</div>


<div class="modal fade" id="create-user-modal" tabindex="-1" aria-labelledby="create-user-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div id="modal-title-div">
                    <h1 class="modal-title fs-5">Create User</h1>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="create-user-form" action="{{route('create-user')}}" method="POST">
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
                            <span class="input-group-text form-control mb-3">Email</span><input class="form-control mb-1"name="email" placeholder="example@email.com">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="submit-form-button" class="btn btn-outline-dark mb-3" type="submit">Create</button>
                <button type="button" class="btn btn-secondary mb-3" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@include('includes.footer')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>
