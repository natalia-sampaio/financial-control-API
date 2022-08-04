<?php

namespace App\Repositories;

use App\Http\Requests\ExpenseReportRequest;

interface InterfaceExpenseReportRepository
{
    public function add(ExpenseReportRequest $request);
}