<!DOCTYPE html>
<html lang="en">
<head>
    <title>Change email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1.10.4/dayjs.min.js"></script>


    <link rel="stylesheet" href="{{ asset('css/leaves.css') }}">
    <link rel="stylesheet" href="{{asset('css/menu.css')}}">
    @vite('resources/js/leaves.js')
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
@include('includes.menu-navigation')
<div id="approve_leave_request" data-approve-leave-url="{{route('approve.leave.request', ['leaveId' => ''])}}"></div>
<div id="move_back_leave_request" data-move-back-leave-url="{{route('move.back.the.leave.request', ['leaveId' => ''])}}"></div>
<div class="container">

    @foreach($users as $user)
        <div class="user-container">
            <div class="user" data-user-id="{{$user -> id}}">{{$user -> name}}</div>
            <div class="leaves_category_container_{{$user -> id}} hidden">
                <div class="category_tile pending_leaves_tile_{{$user -> id}}">pending leaves</div>
                <div class="category_tile approved_incoming_leaves_tile_{{$user -> id}}">Approved incoming leaves</div>
                <div class="category_tile leaves_history_tile_{{$user -> id}}">Leaves history</div>
            </div>
            <div class="pending_leaves_{{$user -> id}} hidden">

                <table class="table bordered-table" id="pending_leaves_table_{{$user -> id}}">
                    <thead>
                        <tr>
                            <th class='table_title' colspan="4"></th>
                        </tr>
                        <tr>
                            <th>Id</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="body_pending_leaves_table">

                    </tbody>
                </table>
            </div>
        </div>
    @endforeach

    <a href="{{route('delete.all.leaves')}}"> <button class="btn btn-dark">Delete all Leaves</button></a>
</div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>
