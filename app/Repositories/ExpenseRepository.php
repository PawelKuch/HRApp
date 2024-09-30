<?php

namespace App\Repositories;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class ExpenseRepository
{
    public function saveExpenese(Expense  $expense) : bool
    {
        if($expense -> save()){
            return true;
        }
        return false;
    }

    public function getExpensesForUser(User $user) : Collection
    {
        return Expense::where('user_id', $user -> id) -> get();
    }
    public function getAllExpenses() : Collection
    {
        return Expense::all();
    }
}
