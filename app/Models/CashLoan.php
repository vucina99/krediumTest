<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashLoan extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'user_id' ,
        'loan_amount'
    ];
}
