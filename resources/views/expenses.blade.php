



<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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
                            {{$expense -> is_settled}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
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
    @elseif(Auth::check() && Auth::user() -> role == 'admin')

    <div id="users-container">
        Select the user whose expenses you want to see <br>
        @foreach($users as $user)
            <a href="#" data-bs-toggle="modal" data-bs-target="#expensesModal-{{$user -> userId}}">
                <div class="user-tile">
                    {{$user -> name}} {{$user -> surname}} <br>
                </div>
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
                                            <td>{{$expense -> description}}</td>
                                            <td>{{$expense -> date}}</td>
                                            <td>{{$expense -> is_settled}}</td>
                                            <td>
                                                @if($expense -> is_settled)
                                                    <span id="unsettle-icon-span"><a href="{{route('unsettleExpense', ['userId' => $user -> userId, 'expenseId' => $expense -> expense_id])}}"><i class="bi bi-arrow-90deg-left"></i></a></span>
                                                @else
                                                    <span id="calculate-icon-span"><a href="{{route('settleTheExpense', ['expenseId' => $expense -> expense_id])}}"><i class="bi bi-calculator"></i></a></span>
                                                @endif
                                                <span id="delete-icon-span"><a href="{{route('deleteExpense', ['userId' => $user -> userId, 'expenseId' => $expense -> expense_id])}}"><i class="bi bi-trash text-dark"></i></a></span>
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
        @endforeach
    </div>
    @endif


</div>





<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>



