<?php

namespace App\Http\Controllers;

use App\Http\Requests\CashLoanRequest;
use App\Http\Requests\CreateClientRequest;
use App\Http\Requests\HomeLoanRequest;
use App\Models\CashLoan;
use App\Models\Client;
use App\Models\HomeLoan;
use Carbon\Carbon;
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
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
//        $this->client->create($request);
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

    public function showEdit($id){
        $client = Client::find($id);
        if(!$client){
            return redirect('/advisor/clients');
        }

        return view('advisor.auth.edit_client' , compact('client'));
    }

    public function editClient(CreateClientRequest $request , $id){
        $client = Client::find($id);
        if(!$client){
            return redirect('/advisor/clients');
        }
        $client->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone,
        ]);
        $request->session()->flash('success', 'New client has been updated successfully.');
        return back();
    }

    public function cashLoan(  CashLoanRequest $request , $id){
        $client = Client::find($id);
        if(!$client){
            return redirect('/advisor/clients');
        }

        $cashLoan = CashLoan::where('client_id' , $id)->first();

        if(!$cashLoan){
            CashLoan::create([
                'client_id' => $id,
                'advisor_id' => Auth::user()->id,
                'loan_amount' => $request->loan_amount
            ]);
        }else{
            $cashLoan->loan_amount = $request->loan_amount;
            $cashLoan->advisor_id = Auth::user()->id;
            $cashLoan->save();
        }

        $request->session()->flash('success', 'New cash loan has been added successfully.');
        return back();
    }


    public function homeLoan(  HomeLoanRequest $request , $id){
        $client = Client::find($id);
        if(!$client){
            return redirect('/advisor/clients');
        }

        $cashLoan = HomeLoan::where('client_id' , $id)->first();

        if(!$cashLoan){
            HomeLoan::create([
                'client_id' => $id,
                'advisor_id' => Auth::user()->id,
                'down_payment_amount' => $request->down_payment_amount,
                'property_value' => $request->property_value
            ]);
        }else{
            $cashLoan->down_payment_amount = $request->down_payment_amount;
            $cashLoan->property_value = $request->property_value;
            $cashLoan->advisor_id = Auth::user()->id;
            $cashLoan->save();
        }

        $request->session()->flash('success', 'New home loan has been added successfully.');
        return back();
    }
}
