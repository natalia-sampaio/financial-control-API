<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ExpenseReportRequest;
use App\Models\ExpenseReport;
use App\Repositories\ExpenseReportRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ExpenseReportController
{
    public function __construct(private ExpenseReportRepository $expenseReportRepository)
    {
        
    }

    public function index()
    {
        return ExpenseReport::all();
    }
    
    public function store(ExpenseReportRequest $request)
    {
        $data = $request;
        if ($this->verifyDuplicates($data)) {
            return response()->json([
                'message' => "An expense named '{$data->description}' has already been reported this month."
            ], 444);
        }
        return response()->json($this->expenseReportRepository->add($data), 201);   
    }

    public function show(ExpenseReport $expense)
    {
        return $expense;
    }

    public function update(int $expense, ExpenseReportRequest $request)
    {
        $data = $request;
        if ($this->verifyDuplicates($data, $expense)) {
            return response()->json([
                'message' => "An expense named '{$data->description}' has already been reported this month."
            ], 444);
        }
        $expense = ExpenseReport::where('id', $expense)->update($data->all());
        return response()->json(["success" => "Expense updated.", "expense" => $expense], 200);
    }

    public function destroy(int $expense)
    {
        ExpenseReport::destroy($expense);
        return response()->noContent();
    }

    private function verifyDuplicates(ExpenseReportRequest $request, int $expense = null)
    {
        $data = $request;
        $description = $data->description;
        $dateOfExpense = $data->date_of_expense;
        $monthOfExpense = Carbon::createFromFormat('Y-m-d', $dateOfExpense)->format('m');

        return DB::table('expense_reports')
            ->whereNot('id', $expense)
            ->where('description', $description)
            ->whereMonth('date_of_expense', $monthOfExpense)
            ->exists();
    }
}