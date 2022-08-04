<?php

namespace App\Repositories;

use App\Http\Requests\IncomeReportRequest;

interface InterfaceIncomeReportRepository
{
    public function add(IncomeReportRequest $request);
}