<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\IncomeReportRequest;
use App\Models\IncomeReport;
use App\Repositories\IncomeReportRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Prophecy\Call\Call;

class IncomeReportController
{
    public function __construct(private IncomeReportRepository $incomeReportRepository)
    {
        
    }

    public function index(Request $request)
    {
        $data = $request;
        $query = IncomeReport::query();
        if($data->has('description')) {
            $query->where('description', 'LIKE', "%$data->description%");
        }
        return $query->get();
    } 
    
    public function store(IncomeReportRequest $request)
    {
        $data = $request;
        if ($this->verifyDuplicates($data)) {
            return response()->json([
                'message' => "An income named '{$data->description}' has already been reported this month."
            ], 444);
        }
        return response()->json($this->incomeReportRepository->add($data), 201);   
    }

    public function show(IncomeReport $income)
    {
        return $income;
    }

    public function showIncomeOfTheMonth(int $year, int $month)
    {
        return IncomeReport::whereMonth('date_of_income', $month)
                ->whereYear('date_of_income', $year)
                ->get();
    }

    public function update(int $income, IncomeReportRequest $request)
    {
        $data = $request;
        if ($this->verifyDuplicates($data, $income)) {
            return response()->json([
                'message' => "An income named '{$data->description}' has already been reported this month."
            ], 444);
        }
        $income = IncomeReport::where('id', $income)->update($data->all());
        return response()->json(["success" => "Income updated.", "income" => $income], 200);
    }

    public function destroy(int $income)
    {
        IncomeReport::destroy($income);
        return response()->noContent();
    }

    private function verifyDuplicates(IncomeReportRequest $request, int $income = null)
    {
        $data = $request;
        $description = $data->description;
        $dateOfIncome = $data->date_of_income;
        $monthOfIncome = Carbon::createFromFormat('Y-m-d', $dateOfIncome)->format('m');

        return DB::table('income_reports')
            ->whereNot('id', $income)
            ->where('description', $description)
            ->whereMonth('date_of_income', $monthOfIncome)
            ->exists();
    }
}