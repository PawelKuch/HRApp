<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{asset('css/menu.css')}}">
    <link rel="stylesheet" href="{{asset('css/expenses.css')}}">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <style>

    </style>
</head>
<body>
@include('includes.menu-navigation')

<div class="container mt-4">
    @if(Auth::check() && Auth::user() -> role == 'user')
        <div id="table-container">
            <table class="table table-bordered">
                <thead class="table-dark">
                <tr>
                    <th>Invoice no</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Value (PLN)</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($expensesForUser as $expense)
                    <tr>
                        <td>{{$expense -> invoice_no}}</td>
                        <td>{{$expense -> category}}</td>
                        <td>{{$expense -> description}}</td>
                        <td>{{$expense -> value}}</td>
                        <td>{{$expense -> date}}</td>
                        <td>
                            <div class="badge {{$expense -> is_settled == 1 ? 'bg-success' : 'bg-warning'}}">
                                {{$expense -> is_settled == 1 ? 'settled' : 'unsettled'}}
                            </div></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div id="form-div">
            <form action='{{route('add-expense', ['userId' => Auth::user() -> userId])}}' method="post" name="expenseForm" class="mt-4">
                @csrf
                <div class="mb-3">
                    <input name="invoiceNo" placeholder="Invoice No" class="form-control" required>
                </div>
                <div class="mb-3">
                    <input name="category" placeholder="Category" class="form-control" required>
                </div>
                <div class="mb-3">
                    <input name="value" placeholder="Value" class="form-control" required>
                </div>
                <div class="mb-3">
                    <input name="description" placeholder="Description" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-dark">Add Expense</button>
            </form>
        </div>
    @elseif(Auth::check() && Auth::user() -> role == 'admin')

        <div id="users-container">
            <h4 class="my-4">Select the user whose expenses you want to see:</h4>
            @foreach($users as $user)
                <a href="#" data-bs-toggle="modal" data-bs-target="#expensesModal-{{$user -> userId}}">
                    <div class="user-tile">
                        {{$user -> name}} {{$user -> surname}}
                    </div>
                </a>

                <div class="modal fade" id="expensesModal-{{$user -> userId}}" tabindex="-1" aria-labelledby="expensesModal-{{$user -> userId}}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{$user -> name}} {{$user -> surname}}'s Expenses</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <thead class="table-dark">
                                    <tr>
                                        <th>Invoice No</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Value (PLN)</th>
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
                                                <td>{{$expense -> description}}</td>
                                                <td>{{$expense -> value}}</td>
                                                <td>{{$expense -> date}}</td>
                                                <td>
                                                    <span class="badge {{ $expense -> is_settled == 1 ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $expense ->is_settled == 1 ? 'settled' : 'unsettled' }}
                                                    </span>


                                                <td>
                                                    @if($expense -> is_settled)
                                                        <span id="unsettle-icon-span">
                                                            <a href="{{route('unsettleExpense', ['userId' => $user -> userId, 'expenseId' => $expense -> expense_id])}}">
                                                                <i class="bi bi-arrow-90deg-left"></i>
                                                            </a>
                                                        </span>
                                                    @else
                                                        <span id="calculate-icon-span">
                                                            <a href="{{route('settleTheExpense', ['expenseId' => $expense -> expense_id])}}">
                                                                <i class="bi bi-calculator"></i>
                                                            </a>
                                                        </span>
                                                    @endif
                                                        <span id="delete-icon-span">
                                                            <a href="#" id="delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal-{{$user -> userId}}">
                                                                <i class="bi bi-trash text-dark"></i>
                                                            </a>
                                                        </span>
                                                </td>
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

                <div class="modal fade" id="deleteModal-{{$user -> userId}}" tabindex="-1" aria-labelledby="deleteModal-{{$user -> userId}}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Confirm</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this expense?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <a href="{{route('deleteExpense', ['userId' => $user -> userId, 'expenseId' => $expense -> expense_id])}}"><button type="button" class="btn btn-primary">Confirm</button></a>
                                </div>
                            </div>
                        </div>
                    </div>

            @endforeach
        </div>
    @endif
</div>
@include('includes.footer')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
