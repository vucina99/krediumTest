<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeLoan extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'advisor_id' ,
        'down_payment_amount' ,
        'property_value',
    ];
}
