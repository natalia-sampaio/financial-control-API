<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeReport extends Model
{
    protected $fillable = ['description', 'amount', 'date_of_income'];
}