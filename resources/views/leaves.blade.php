<!DOCTYPE html>
<html lang="en">
<head>
    <title>Change email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/leaves.css') }}">
    <link rel="stylesheet" href="{{asset('css/menu.css')}}">
    @vite('resources/js/leaves.js')
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
@include('includes.menu-navigation')
<div class="container">



    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Request date</th>
                <th>From</th>
                <th>To</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($leaves as $leave)
            <tr>
                <td>{{$leave -> created_at -> format("d-M-y")}}</td>
                <td>{{$leave -> from_date}}</td>
                <td>{{$leave -> to_date}}</td>
                <td>{{$leave -> leave_status}}</td>
                @if($leave -> leave_status == 'approved')
                <td><a href="{{route('move.back.the.leave.request', ['leaveId' => $leave -> id])}}"><i class="bi bi-arrow-left"></i></a></td>
                @else
                    <td> {{$leave -> user_name}} </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

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




<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>
