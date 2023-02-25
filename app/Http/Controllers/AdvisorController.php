<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdvisorController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();

    }

    public function home(){
        return view("advisor.auth.home");
    }
    public function clients(){
        return view("advisor.auth.clients");
    }
    public function logout(){
        Auth::logout();
        return redirect('/');
    }

    public function createClient(){
        return view("advisor.auth.create_client");
    }

    public function createClientSystem(CreateClientRequest $request){
        $this->client->create($request);

        Session::flash('success', 'New client has been added successfully.');

        return redirect("/");
    }
}
