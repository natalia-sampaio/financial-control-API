<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseReport extends Model
{
    protected $fillable = ['description', 'amount', 'date_of_expense'];
}