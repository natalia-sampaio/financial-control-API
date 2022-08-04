<?php

namespace App\Repositories;

use App\Http\Requests\IncomeReportRequest;
use App\Models\IncomeReport;
use Illuminate\Support\Facades\DB;

class IncomeReportRepository implements InterfaceIncomeReportRepository
{
    public function add(IncomeReportRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $incomeReport = IncomeReport::create([
                'description' => $request->description,
                'amount' => $request->amount,
                'date_of_income' => $request->date_of_income
            ]);

            return $incomeReport;
        });
    }
}