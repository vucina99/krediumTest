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
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Style_Alignment;


class AdvisorController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();

    }

    public function home()
    {
        return view("advisor.auth.home");
    }

    public function clients()
    {
        $clients = Client::all();
        return view("advisor.auth.clients", compact('clients'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function createClient()
    {
        return view("advisor.auth.create_client");
    }

    public function createClientSystem(CreateClientRequest $request)
    {
        DB::table('clients')->insert([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        //I have to use the query builder because Eloquent create for client stops working because of my kdebug, I don't know why
        //        $this->client->create($request);
        $request->session()->flash('success', 'New client has been added successfully.');

        return back();
    }

    public function deleteClient($id)
    {
        $client = Client::find($id);
        if (!$client) {
            return redirect('/advisor/clients');
        }
        //if we delete a client from the database, we also delete all the products it is associated with
        $client->cashLoan()->delete();
        $client->homeLoan()->delete();
        $client->delete();
        Session::flash('success', 'The client was successfully deleted.');


        return redirect('/advisor/clients');
    }

    public function showEdit($id)
    {
        $client = Client::find($id);
        if (!$client) {
            return redirect('/advisor/clients');
        }

        return view('advisor.auth.edit_client', compact('client'));
    }

    public function editClient(CreateClientRequest $request, $id)
    {
        $client = Client::find($id);
        if (!$client) {
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

    public function cashLoan(CashLoanRequest $request, $id)
    {

        $client = Client::find($id);
        if (!$client) {
            return redirect('/advisor/clients');
        }

        $cashLoan = CashLoan::where('client_id', $id)->first();
        //if isset cashLoan we do update, opposite we do create

        if (!$cashLoan) {
            CashLoan::create([
                'client_id' => $id,
                'user_id' => Auth::user()->id,
                'loan_amount' => $request->loan_amount
            ]);
        } else {
            if ($cashLoan->user_id == Auth::user()->id) {
                $cashLoan->loan_amount = $request->loan_amount;
                $cashLoan->save();
            } else {
                return redirect('/advisor/clients');
            }
        }

        $request->session()->flash('success', 'New cash loan has been added successfully.');
        return back();
    }


    public function homeLoan(HomeLoanRequest $request, $id)
    {
        $client = Client::find($id);
        if (!$client) {
            return redirect('/advisor/clients');
        }

        $homeLoan = HomeLoan::where('client_id', $id)->first();
        //if isset $homeLoan we do update, opposite we do create
        if (!$homeLoan) {
            HomeLoan::create([
                'client_id' => $id,
                'user_id' => Auth::user()->id,
                'down_payment_amount' => $request->down_payment_amount,
                'property_value' => $request->property_value
            ]);
        } else {
            if ($homeLoan->user_id == Auth::user()->id) {
                $homeLoan->down_payment_amount = $request->down_payment_amount;
                $homeLoan->property_value = $request->property_value;
                $homeLoan->save();
            } else {
                return redirect('/advisor/clients');
            }

        }

        $request->session()->flash('success', 'New home loan has been added successfully.');
        return back();
    }

    public function reports()
    {
        //get cashLoan
        $cahsLoan = CashLoan::select('loan_amount', DB::raw('null as down_payment_amount'), 'created_at', 'user_id')
            ->addSelect(DB::raw("'cash loan' as type"))
            ->where('user_id', Auth::user()->id);
        //get HomeLoan
        $homeLoan = HomeLoan::select('property_value', 'down_payment_amount', 'created_at', 'user_id')
            ->addSelect(DB::raw("'home loan' as type"))
            ->where('user_id', Auth::user()->id);

        //reports is union two values, because we want one table
        $reports = $cahsLoan->union($homeLoan)->orderBy('created_at', 'desc')->get();

        return view('advisor.auth.reports', compact('reports'));
    }


    function exportToXlsx()
    {

        $cahsLoan = CashLoan::select('loan_amount', DB::raw('null as down_payment_amount'), 'created_at', 'user_id')
            ->addSelect(DB::raw("'cash loan' as type"))
            ->where('user_id', Auth::user()->id);
        $homeLoan = HomeLoan::select('property_value', 'down_payment_amount', 'created_at', 'user_id')
            ->addSelect(DB::raw("'home loan' as type"))
            ->where('user_id', Auth::user()->id);
        $data = $cahsLoan->union($homeLoan)->orderBy('created_at', 'desc')->get();


        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Your Name")
            ->setLastModifiedBy("Your Name")
            ->setTitle("Product Report")
            ->setSubject("Product Report")
            ->setDescription("Product Report")
            ->setKeywords("Product, Report")
            ->setCategory("Product");

        // Add data to worksheet
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Product Type')
            ->setCellValue('B1', 'Product Value')
            ->setCellValue('C1', 'Creation date');
        $row = 2;
        foreach ($data as $value) {
            if ($value->type == 'cash loan') {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $row, $value->type)
                    ->setCellValue('B' . $row, (string)$value->loan_amount)
                    ->setCellValue('C' . $row, $value->created_at->format('Y-m-d H:i:s'));
            } else {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $row, $value->type)
                    ->setCellValue('B' . $row, $value->loan_amount . ' - ' . $value->down_payment_amount)
                    ->setCellValue('C' . $row, $value->created_at->format('Y-m-d H:i:s'));
            }

            $row++;
        }

        // Style worksheet
        $objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Product Report');

        // Create writer
        $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        // Set headers
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="product_report.xlsx"');
        header('Cache-Control: max-age=0');

        // Write file to output stream
        $writer->save('php://output');

    }
}
