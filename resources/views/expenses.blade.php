



<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="{{asset('css/menu.css')}}">
    <link rel="stylesheet" href="{{asset('css/expenses.css')}}">
</head>
<body>
@include('includes.menu-navigation')

<div class="container mt-3">
    @if(Auth::check() && Auth::user() -> role == 'user')
        <div id="table-container">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Invoice no</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($expensesForUser as $expense)
                    <tr>
                        <td>
                            {{$expense -> invoice_no}}
                        </td>
                        <td>
                            {{$expense -> category}}
                        </td>
                        <td>
                            {{$expense -> description}}
                        </td>
                        <td>
                            {{$expense -> date}}
                        </td>
                        <td>
                            {{$expense -> status}}
                        </td>
                        <td>
                            Action
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @elseif(Auth::check() && Auth::user() -> role == 'admin')
        Select the user whose expenses you want to see <br>

        @foreach($users as $user)
            <a href="#" data-bs-toggle="modal" data-bs-target="#expensesModal-{{$user -> userId}}">
                {{$user -> name}} {{$user -> surname}} <br>
            </a>


            <div class="modal fade" id="expensesModal-{{$user -> userId}}" tabindex="-1" aria-labelledby="expensesModal-{{$user -> userId}}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div id="modal-title-div">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">{{$user -> name}} {{$user -> surname}}'s expenses</h1>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table bordered-table">
                                <thead>
                                    <tr>
                                        <th>Invoice no</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($expenses as $expense)
                                    @if($expense -> user_id == $user -> id)
                                        <tr>
                                            <td>{{$expense -> invoice_no}}</td>
                                            <td>{{$expense -> category}}</td>
                                            <td>{{$expense -> descirption}}</td>
                                            <td>{{$expense -> date}}</td>
                                            <td>{{$expense -> status}}</td>
                                            <td>Action</td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    @endif

    <div id="form-div">
        <form action='{{route('add-expense', ['userId' => Auth::user() -> userId])}}' method="post" name="expenseForm">
            @csrf
            <input name="invoiceNo" placeholder="invoiceNo">
            <input name="category" placeholder="category">
            <input name="value" placeholder="value">
            <input name="description" placeholder="description">
            <button type="submit" class="btn btn-dark">Add expense</button>
        </form>
    </div>
</div>



@foreach($expenses as $expense)
    {{$expense}}
@endforeach


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>



