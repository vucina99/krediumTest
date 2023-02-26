<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $clients = Client::all();
        return view("advisor.auth.clients" , compact('clients'));
    }
    public function logout(){
        Auth::logout();
        return redirect('/');
    }

    public function createClient(){
        return view("advisor.auth.create_client");
    }

    public function createClientSystem(CreateClientRequest $request){
        DB::table('clients')->insert([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone,
        ]);

        $request->session()->flash('success', 'New client has been added successfully.');

        return back();
    }

    public function deleteClient($id){
        $client = Client::find($id);
        if(!$client){
            return redirect('/advisor/clients');
        }
        Session::flash('success', 'The client was successfully deleted.');
        $client->delete();

        return redirect('/advisor/clients');
    }
}
