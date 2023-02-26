<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
    ];

    public function homeLoan(){
       return $this->hasOne(HomeLoan::class);
    }

    public function cashLoan(){
        return $this->hasOne(CashLoan::class);
    }
//    public function create($request){
//
//        $client =  Client::create([
//            'first_name' => $request['first_name'] ,
//            'last_name' => $request['last_name'],
//            'email' => $request['email'] ?? null,
//            'phone_number' => $request['phone'] ?? null,
//        ]);
//
//        return $client->refresh();
//    }
}
