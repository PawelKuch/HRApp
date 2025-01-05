<!DOCTYPE html>
<html lang="en">
<head>
    <title>Change email</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    @vite('resources/js/userLeaves.js')
    <link rel="stylesheet" href="{{ asset('css/user-leaves.css') }}">
    <link rel="stylesheet" href="{{asset('css/menu.css')}}">

</head>
<body>
@include('includes.menu-navigation')
<div class="container">
    <a href="#" data-bs-toggle="modal" data-bs-target="#addLeaveRequestModal"><button class="btn btn-outline-primary mt-3">Create leave request</button></a>

    @if($leavesHistory -> isNotEmpty())
    <table id="leaves-history-table" class="table table-bordered">
        <thead>
        <tr><th colspan="5" style="text-align: center;">Your leaves history</th></tr>
        <tr>
            <th>Request date11</th>
            <th>From</th>
            <th>To</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach($leavesHistory as $leave)
            <tr>
                <td>{{$leave -> created_at -> format('d-m-y')}}</td>
                <td>{{$leave -> from_date -> format('d-m-y')}}</td>
                <td>{{$leave -> to_date -> format('d-m-y')}}</td>
                <td>
                    @if($leave -> leave_status === 'approved')
                        <div class="badge bg-success">approved</div>
                    @else
                        <div class="badge bg-danger">denied</div>
                    @endif</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @endif

    <table id="pending-leaves-table" class="table">
        <thead>
            <tr>
                <th colspan="4" style="text-align: center;">Pending leave requests</th>
            </tr>
            <tr>
                <th>Request date</th>
                <th>From</th>
                <th>To</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($pendingLeaves as $leave)
            <tr>
                <td>{{$leave -> created_at -> format("d-m-Y")}}</td>
                <td>{{$leave -> from_date -> format("d-m-Y")}}</td>
                <td>{{$leave -> to_date -> format("d-m-Y")}}</td>
                <td>
                    <div class="badge bg-warning">{{$leave -> leave_status}}</div>
                </td>
                <td><a href="{{route('cancel.leave.request', ['leaveId' => $leave -> leave_id])}}" class="text-danger"> <i class="bi bi-trash"></i></a> ||
                    <a href="#" class="editBtn" data-bs-toggle="modal" data-bs-target="#editLeaveRequestModal_{{$leave -> leave_id}}" data-leaveId="{{$leave -> leave_id}}"><i class="bi bi-pencil"></i></a>
                </td>
            </tr>
            <div class="modal fade" id="editLeaveRequestModal_{{$leave -> leave_id}}" tabindex="-1" aria-labelledby="editLeaveRequestModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div id="modal-title-div">
                                <h1 class="modal-title fs-5" id="editLeaveRequestModalLabel">Edit leave request</h1>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div>

                            </div>
                            <form method="post" action="{{route('edit.leave.request', ['leaveId' => $leave -> leave_id])}}">
                                @csrf
                                <div class="input-group from-date">
                                    <span class="input-group-text form-control mb-3">From</span>
                                    <input class="form-control mb-3" type="text" id="from_date_datepicker" name="from_date" value="dd-mm-yyyy">
                                </div>
                                <div class="input-group to-date">
                                    <span class="input-group-text form-control mb-3">To</span>
                                    <input class="form-control mb-3" type="text" id="to_date_picker" name="to_date" value="dd-mm-yyyy">
                                </div>
                                <button class="btn btn-dark" type="submit">Update</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </tbody>
    </table>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="3" style="text-align: center;">Incoming leaves</th>
            </tr>
            <tr>
                <th>Request date</th>
                <th>From date</th>
                <th>To date</th>
                <th>Leave status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($confirmedIncomingLeaves as $leave)
                <tr>
                    <td>{{$leave -> created_at -> format('d-m-Y')}}</td>
                    <td>{{$leave -> from_date}}</td>
                    <td>{{$leave -> to_date -> format('d-m-Y')}}</td>
                    <td><div class="badge bg-succes">{{$leave -> leave_status}}</div></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div id="modal-container">
    <div class="modal fade" id="addLeaveRequestModal" tabindex="-1" aria-labelledby="addLeaveRequestModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div id="modal-title-div">
                        <h1 class="modal-title fs-5" id="addLeaveRequestModalLabel">New leave request</h1>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>

                    </div>
                    <form method="post" action="{{route('user.leaves')}}">
                        @csrf
                        <div class="input-group from-date">
                            <span class="input-group-text form-control mb-3">From</span>
                            <input class="form-control mb-3" type="text" id="from_date_datepicker" name="from_date" value="dd-mm-yyyy">
                        </div>
                        <div class="input-group to-date">
                            <span class="input-group-text form-control mb-3">To</span>
                            <input class="form-control mb-3" type="text" id="to_date_picker" name="to_date" value="dd-mm-yyyy">
                        </div>
                        <button class="btn btn-dark" type="submit">Send</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="editLeaveRequestModalContainer">

</div>
@include('includes.footer')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>


</body>
</html>
