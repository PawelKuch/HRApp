<?php

namespace App\Services;

use App\Models\Expense;
use App\Models\User;
use App\Repositories\ExpenseRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;


class ExpenseService
{
    protected ExpenseRepository $expenseRepository;
    protected UserService $userService;
    public function __construct(ExpenseRepository $expenseRepository, UserService $userService){
        $this->expenseRepository = $expenseRepository;
        $this->userService = $userService;
    }

    public function createExpense(User $user, $invoiceNo, float $expenseValue, Carbon $expenseDate, $expenseCategory, $expenseDescription)
    {
        $expense = new Expense();
        $expense -> expense_id = str::uuid() -> toString();
        $expense -> user() -> associate($user);
        $expense -> invoice_no = $invoiceNo;
        $expense -> date = $expenseDate;
        $expense -> value = $expenseValue;
        $expense -> category =   $expenseCategory;
        $expense -> description = $expenseDescription;
        $this -> expenseRepository -> saveExpenese($expense);
    }

    public function saveExpense(Expense $expense) : void
    {
        $expense -> save();
    }

    public function getExpensesForUser($userId) : Collection
    {
        $user = $this -> userService -> getUserByUserId($userId);
        return $this->expenseRepository -> getExpensesForUser($user);
    }
    public function getAllExpenses() : \Illuminate\Support\Collection
    {
        return $this -> expenseRepository -> getAllExpenses();
    }

    public function getExpenseByExpenseId($expenseId) : Expense {
        return $this -> expenseRepository -> getExpenseByExpenseId($expenseId);
    }

    public function settleTheExpense($expenseId) : void
    {
        $expense = $this -> expenseRepository -> getExpenseByExpenseId($expenseId);
        $expense -> is_settled = true;
        $expense -> save();
    }

    public function deleteExpense($expenseId) : void {
        $expense = $this -> expenseRepository -> getExpenseByExpenseId($expenseId);
        $this -> expenseRepository -> deleteExpense($expense);
    }

    public function unsettleExpense($expenseId) : void
    {
        $expense = $this -> expenseRepository -> getExpenseByExpenseId($expenseId);
        $expense -> is_settled = false;
        $expense -> save();
    }
}
