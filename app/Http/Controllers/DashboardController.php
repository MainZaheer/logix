<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Customer;
use App\Models\Broker;
use App\Models\Shipping;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {

        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to access the dashboard.');
        }

        $business_id = request()->session()->get('user.business_id');
        $customerCount = Customer::where('business_id', $business_id)->count();
        $activeAccount = Account::where('business_id', $business_id)->where('status', 'active')->count();
        $broker = Broker::where('business_id', $business_id)->count();


        return view('dashboard' , compact('customerCount' , 'activeAccount' , 'broker'));
    }

          public function getChartData(Request $request)
                {
               $business_id = request()->session()->get('user.business_id');
                $start = $request->start_date;
                $end = $request->end_date;

                $period = \Carbon\CarbonPeriod::create($start, $end);

                $labels = [];
                $expenses = [];
                $invoices = [];

                foreach ($period as $date) {
                    $labels[] = $date->format('Y-m-d');

                    $dailyExpense = Shipping::where('business_id', $business_id)->whereDate('created_at', $date)->sum('total_expence_amount');
                    $dailyInvoice = Shipping::where('business_id', $business_id)->whereDate('created_at', $date)->sum('total_invoice_amount');

                    $expenses[] = $dailyExpense;
                    $invoices[] = $dailyInvoice;
                }

                return response()->json([
                    'labels' => $labels,
                    'expenses' => $expenses,
                    'invoices' => $invoices
                ]);
            }





}
