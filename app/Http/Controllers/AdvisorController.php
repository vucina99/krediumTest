<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdvisorController extends Controller
{
    public function home(){
        return view("advisor.auth.home");
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
