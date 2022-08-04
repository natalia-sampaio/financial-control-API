<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\IncomeReportRequest;
use App\Models\IncomeReport;
use App\Repositories\IncomeReportRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class IncomeReportController
{
    public function __construct(private IncomeReportRepository $incomeReportRepository)
    {
        
    }

    public function index()
    {
        return IncomeReport::all();
    }
    
    public function store(IncomeReportRequest $request)
    {
        $data = $request;
        
        $description = $data->description;
        
        $date = $data->date_of_income;
        $monthOfIncome = Carbon::createFromFormat('Y-m-d', $date)->format('m');
        
        $verificationQuery = DB::table('income_reports')
            ->where('description', $description)
            ->whereMonth('date_of_income', $monthOfIncome)
            ->exists();

        if ($verificationQuery) {
            return response()->json([
                'message' => "An income named '{$data->description}' has already been reported this month."
            ], 444);
        };
        
        return response()->json($this->incomeReportRepository->add($data), 201);   
    }

    public function show(IncomeReport $income)
    {
        return $income;
    }
}