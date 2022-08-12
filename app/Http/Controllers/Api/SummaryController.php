<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ExpenseReport;
use App\Models\IncomeReport;

class SummaryController extends Controller
{
    public function showSummaryOfTheMonth(int $year, int $month)
    {
        $income = IncomeReport::whereMonth('date_of_income', $month)
            ->whereYear('date_of_income', $year)
            ->get();
        $totalIncome = $income->sum('amount');
        
        $expense = ExpenseReport::with('category')->whereMonth('date_of_expense', $month)
            ->whereYear('date_of_expense', $year)
            ->get(); 
        $totalExpense = $expense->sum('amount');

        $balance = $totalIncome - $totalExpense;

        $categorizedExpenses = $expense->mapToGroups(function ($item) {
            return [$item->category->name => $item['amount']];
        });
        $categorizedExpenses->transform(function ($item) {
            return $item->reduce(function ($carry, $item) {
                return $carry+$item;
            });
        });

        return response()->json([
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'balance' => $balance,
            'categorized_expenses' => $categorizedExpenses
        ], 200);
    }
}
