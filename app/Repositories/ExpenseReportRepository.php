<?php

namespace App\Repositories;

use App\Http\Requests\ExpenseReportRequest;
use App\Models\ExpenseReport;
use Illuminate\Support\Facades\DB;

class ExpenseReportRepository implements InterfaceExpenseReportRepository
{
    public function add(ExpenseReportRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $data = [
                'description' => $request->description,
                'amount' => $request->amount,
                'date_of_expense' => $request->date_of_expense,
            ];
            
            if (filled($request->category_id)) {
                $data['category_id'] = $request->category_id;
            }

            $expenseReport = ExpenseReport::create($data);

            return $expenseReport;
        });
    }
}