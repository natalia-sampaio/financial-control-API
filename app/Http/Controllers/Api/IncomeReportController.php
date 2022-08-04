<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\IncomeReportRequest;
use App\Http\Requests\IncomeRequest;
use App\Repositories\IncomeReportRepository;

class IncomeReportController
{
    public function __construct(private IncomeReportRepository $incomeReportRepository)
    {
        
    }
    
    public function store(IncomeReportRequest $request)
    {
        $data = $request;
        return response()->json($this->incomeReportRepository->add($data), 201);
    }
}