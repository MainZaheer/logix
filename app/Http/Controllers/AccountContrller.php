<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountContrller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $business_id = $request->session()->get('user.business_id');

            $data = Account::with(['transactions'])->where('business_id', $business_id)->get();


            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if ($row->status == 'active') {
                        return '<p class="badge badge-primary">Active</p>';
                    } else {
                        return '<p class="badge badge-danger">Inactive</p>';
                    }
                })

                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('accounts.edit', $row->id) . '" class="btn btn-primary btn-sm">Edit</a>';
                    $btn .= ' <form action="' . route('accounts.destroy', $row->id) . '" method="POST" style="display:inline;">
                                ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                                <button type="submit" class="btn btn-danger btn-sm delete-btn">Delete</button>
                              </form>';

                    $btn .= '<a href="' . route('accounts.details', $row->id) . '" class="btn btn-warning btn-sm account-details-btn">
                                    Account Details
                                    </a>';
                    return $btn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('accounts.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('accounts.create_or_update');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $request->validate([
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255|unique:accounts,account_number',
            'account_type' => 'required|string|max:15',
            'status' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();
            // Create a new account
            $business_id = $request->session()->get('user.business_id');
            $user_id = Auth::id();

            $account = new Account();
            $account->business_id = $business_id;
            $account->user_id = $user_id;
            $account->account_name = $request->account_name;
            $account->account_number = $request->account_number;
            $account->account_type = $request->account_type;
            $account->balance = $request->balance ?? 0;
            $account->status = $request->status;
            $account->description = $request->description;
            $account->save();

            // if ($request->balance > 0) {
            $transaction = new Transaction();
            $transaction->account_id = $account->id;
            $transaction->business_id =  $business_id;
            $transaction->user_id = $user_id;
            $transaction->transaction_reference = 'OB-' . time();
            $transaction->payment_method = 'opening_balance'; // or null
            $transaction->payment_type = 'opening_balance';
            $transaction->amount = $request->balance ?? 0;
            $transaction->description = 'Opening balance';
            $transaction->transaction_date =  now()->setTimezone('Asia/Karachi');
            $transaction->save();
            // }

            DB::commit();
            return redirect()->route('accounts.index')->with('success', 'Account created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Failed to create account: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $account = Account::with(['transactions' => function ($q) {
            $q->where('payment_type', 'opening_balance');
        }])->findOrFail($id);


        return view('accounts.create_or_update', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255|unique:accounts,account_number,' . $id,
            'account_type' => 'required|string|max:15',
            'status' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();
            // Create a new account
            $business_id = $request->session()->get('user.business_id');
            $user_id = Auth::id();

            $account = Account::where('business_id', $business_id)->where('id', $id)->first();
            $account->business_id = $business_id;
            $account->user_id = $user_id;
            $account->account_name = $request->account_name;
            $account->account_number = $request->account_number;
            $account->account_type = $request->account_type;
            // $account->balance = $request->balance ?? 0.00;
            $account->status = $request->status;
            $account->description = $request->description;
            $account->save();

            if ($request->balance > 0) {
                $new_opening_balance = (float)$request->balance;
                $existing_transaction = Transaction::where('business_id', $business_id)
                    ->where('account_id', $id)
                    ->where('payment_type', 'opening_balance')->first();

                $old_opening_balance = $existing_transaction ? $existing_transaction->amount : 0;

                $difference         = $new_opening_balance - $old_opening_balance;

                openingBalanceHistory($id,  $old_opening_balance,  $difference,  $new_opening_balance);

                if ($existing_transaction) {
                    $transaction = $existing_transaction;
                } else {

                    $transaction = new Transaction();
                    $transaction->account_id = $account->id;
                    $transaction->business_id =  $business_id;
                    $transaction->user_id = $user_id;
                    $transaction->transaction_reference = 'OB-' . time();
                    $transaction->payment_method = 'opening_balance'; // or null
                    $transaction->payment_type = 'opening_balance';
                    $transaction->amount = $request->balance;
                    $transaction->description = 'Opening balance';
                    $transaction->transaction_date =  now()->setTimezone('Asia/Karachi')->format('Y-m-d H:i:s');

                    $transaction->save();
                }

                $transaction->amount = $new_opening_balance; // opeining balance
                $transaction->save();

                $account->balance += $difference;
                $account->save();
            }

            DB::commit();
            return redirect()->route('accounts.index')->with('success', 'Account Updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Failed to create account: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function accountDetails(Request $request, $id)
    {

        $business_id = $request->session()->get('user.business_id');
        $account = Account::with(['transactions' => function ($q) use ($business_id) {
            $q->where('payment_type', 'opening_balance');
        }])->where('id', $id)
            ->where('business_id', $business_id)
            ->firstOrFail();

        return view('accounts.details', compact('account'));
    }


    public function getAccountTransactions(Request $request, $id)
    {


        // dd( $request->all());
        if ($request->ajax()) {

            $business_id = $request->session()->get('user.business_id');
            $startDate = $request->get('start_date');
            $endDate = $request->get('end_date');

            $query = Transaction::with(['model', 'shipping', 'user', 'account'])
                ->where('account_id', $id)
                ->where('business_id', $business_id)
                ->whereNotNull('shipping_id');

            if (!empty($startDate) && !empty($endDate)) {
                $start = date('Y-m-d 00:00:00', strtotime($startDate));
                $end = date('Y-m-d 23:59:59', strtotime($endDate));
                $query->whereBetween('transaction_date', [$start, $end]);
            }

            // Get sorted list
            $transactions = $query->orderBy('transaction_date', 'asc')->get();

            $opening_balance = Transaction::where('account_id', $id)
                ->where('business_id', $business_id)
                ->where('transaction_date', '<', date('Y-m-d 00:00:00', strtotime($startDate)))
                ->selectRaw("
                SUM(CASE WHEN payment_type = 'credit' OR payment_type = 'opening_balance' THEN amount ELSE 0 END) -
                SUM(CASE WHEN payment_type = 'debit' THEN amount ELSE 0 END) as balance
            ")
                ->value('balance') ?? 0;

            $running_balance = $opening_balance;


            $transactions = Transaction::where('account_id', $id)
                ->where('business_id', $business_id)
                ->whereBetween('transaction_date', [
                    date('Y-m-d 00:00:00', strtotime($startDate)),
                    date('Y-m-d 23:59:59', strtotime($endDate))
                ])
                ->orderBy('transaction_date')
                ->orderBy('id')
                ->get();


            $transactions = $transactions->map(function ($txn) use (&$running_balance) {
                if (in_array($txn->payment_type, ['credit', 'opening_balance'])) {
                    $running_balance += $txn->amount;
                } elseif ($txn->payment_type === 'debit') {
                    $running_balance -= $txn->amount;
                }

                $txn->running_balance = $running_balance;
                return $txn;
            });


            return DataTables::of($transactions)
                ->addIndexColumn()
                ->addColumn('date', function ($row) {
                    return $row->transaction_date ? date('d-m-Y h:i A', strtotime($row->transaction_date)) : '';
                })
                ->addColumn('added_by', function ($row) {
                    return $row->user->name;
                })
                ->addColumn('job_no', function ($row) {
                    if ($row->shipping) {
                        return '<p class="badge bg-primary" style = "font-size: 15px;">' . $row->shipping->job_no . '</p>';
                    }
                })
                ->addColumn('description', function ($row) {
                    if ($row->payment_type === 'opening_balance') {
                        return 'Opening Balance';
                    }
                    $type = $row->model_type;
                    return getModalTypeNames($type, $row);
                })

                ->addColumn('payment_status', function ($row) {
                    if ($row->payment_status == "Paid") {
                        return '<span class="badge badge-success">Paid</span>';
                    } elseif ($row->payment_status == "OverDue") {
                        return '<span class="badge badge-danger">OverDue</span>';
                    } elseif ($row->payment_status == 'Partial') {
                        return '<span class="badge badge-info">Partial</span>';
                    } else {
                        return '--';
                    }
                })

                ->addColumn('payment_method', function ($row) {
                    if ($row->payment_method == "bank") {
                        return '<p><strong>Bank: </strong>' . $row->account->account_name . '</p>';
                    } elseif ($row->payment_method == "opening_balance") {
                        return '<p><strong>Opening Balance: </strong>' . $row->account->account_name . '</p>';
                    } else {
                        return '--';
                    }
                })

                ->addColumn('debit', function ($row) {
                    return $row->payment_type == "debit" ? $row->amount : '--';
                })
                ->addColumn('credit', function ($row) {
                    return $row->payment_type == "credit" ? $row->amount : '--';
                })
                ->addColumn('balance', fn($row) => number_format($row->running_balance, 2))

                ->rawColumns(['date', 'job_no', 'description', 'payment_status', 'debit', 'credit', 'added_by', 'balance', 'payment_method'])
                ->make(true);
        }
    }
}
