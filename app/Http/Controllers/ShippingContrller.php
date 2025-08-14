<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShipmentRequest;
use App\Models\Broker;
use App\Models\ClearingAgent;
use App\Models\Contact;
use App\Models\CrainCharges;
use App\Models\Customer;
use App\Models\Fuel;
use App\Models\GatePass;
use App\Models\Goodownrent;
use App\Models\Invoice;
use App\Models\LabourCharges;
use App\Models\LifterCharges;
use App\Models\LocalCharges;
use App\Models\OtherCharges;
use App\Models\PartyCommissionCharges;
use App\Models\ShipmentDetail;
use App\Models\Shipping;
use App\Models\TrackerCharges;
use App\Models\YarnUnloading;
use App\Utils\ShippingUtil;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;



class ShippingContrller extends Controller
{

    protected $shippingUtil;

    public function __construct(ShippingUtil $shippingUtil)
    {
        $this->shippingUtil = $shippingUtil;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $busines_id = session()->get('user.business_id');

        if ($request->ajax()) {

            $data = Shipping::with('customer', 'invoice')->where('business_id', $busines_id)->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $html = '
                    <div class="btn-group">

                        <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-expanded="false">
                        Action
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                      <div class="dropdown-menu">
                           <a class="dropdown-item view-shipping" href="javascript:void(0)" data-id="' . $row->id . '">
                            <i class="fa fa-eye text-primary mr-1"></i> View
                        </a>
                            <a class="dropdown-item" href="' . route('shippings.edit', $row->id) . '">
                                <i class="fa fa-edit text-warning mr-1"></i> Edit
                            </a>';

                    if ($row->invoice != null) {
                        $html .= '<a class="dropdown-item print-job" href="#" data-id="' . $row->id . '">
                                    <i class="fa fa-print text-success mr-1"></i> Print
                                </a>

                                <a class="dropdown-item invoice-job" href="#" data-toggle="modal" data-target="#invoice-modal"
                                        data-id="' . $row->id . '"
                                        data-shipment-id="' . $row->id . '"
                                        data-invoice-amount="' . $row->total_invoice_amount . '"
                                        data-total-expence-amount="' . $row->total_expence_amount . '"
                                        data-job-no="' . $row->job_no . '"
                                        data-bill-no="' . $row->bill_no . '"
                                        data-lc-no="' . $row->lc_no . '"
                                        data-date="' . $row->date . '"
                                        data-invoice-id="' . $row->invoice->id . '"
                                        data-fuel-id="' . $row->invoice->fuel_id . '"
                                        data-fuel-amount-percentage="' . $row->invoice->fuel_amount_percentage . '"
                                        data-fuel-amount-after-percentage="' . $row->invoice->fuel_amount_after_percentage . '"
                                        data-tax-amount-percentage="' . $row->invoice->tax_amount_percentage . '"
                                        data-tax-amount-after-percentage="' . $row->invoice->tax_amount_after_percentage . '"
                                        data-final-amount="' . $row->invoice->final_amount . '"

                                        >
                                        <i class="fas fa-file-invoice text-success mr-1"></i> Update Invoice
                                    </a>';
                    }


                    if ($row->invoice == null) {
                        $html .= '
                                    <a class="dropdown-item invoice-job" href="#" data-toggle="modal" data-target="#invoice-modal"
                                        data-id="' . $row->id . '"
                                        data-shipment-id="' . $row->id . '"
                                        data-invoice-amount="' . $row->total_invoice_amount . '"
                                        data-total-expence-amount="' . $row->total_expence_amount . '"
                                        data-job-no="' . $row->job_no . '"
                                        data-bill-no="' . $row->bill_no . '"
                                        data-lc-no="' . $row->lc_no . '"
                                        data-date="' . $row->date . '">
                                        <i class="fas fa-file-invoice text-success mr-1"></i> Create invoice
                                    </a>';
                    }

                    // Delete form
                    $html .= '
                        <form action="' . route('shippings.destroy', $row->id) . '" method="POST" onsubmit="return confirm(\'Are you sure?\')">
                            ' . csrf_field() . method_field("DELETE") . '
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fa fa-trash mr-1"></i> Delete
                            </button>
                        </form>
                        </div>
                    </div>';

                    return $html;
                })

                ->addColumn('payment', function ($row) {
                    if ($row->payment == 'credit') {
                        return '<p class="badge badge-pill badge-primary">PAID</p>';
                    } else {
                        return '<p class="badge badge-pill badge-success">TOPAY</p>';
                    }
                })

                ->addColumn('customer_name', function ($row) {
                    $customer  =  $row->customer->first_name . " " . $row->customer->last_name;
                    return $customer;
                })

                ->addColumn('job_no', function ($row) {
                    return '<p class="badge badge-pill badge-info">' . $row->job_no . '</p>';
                })

                ->rawColumns(['action', 'payment', 'job_no', 'customer_name'])
                ->make(true);
        }

        $fuels = Fuel::where('business_id', $busines_id)->select('id', 'name')->get();

        return view('shippings.index', compact('fuels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $business_id = request()->session()->get('user.business_id');

      $brokers = Broker::where('business_id', $business_id)->select('id', 'name')->get();
        $gatepasses = GatePass::where('business_id', $business_id)->where('status', 'active')->select('id', 'name')->get();
        $clearingagents = ClearingAgent::where('business_id', $business_id)->where('status', 'active')->select('id', 'name')->get();
        $labourCharges = LabourCharges::where('business_id', $business_id)->where('status', 'active')->select('id', 'name')->get();
        $lifterCharges = LifterCharges::where('business_id', $business_id)->where('status', 'active')->select('id', 'name')->get();
        $localCharges = LocalCharges::where('business_id', $business_id)->where('status', 'active')->select('id', 'name')->get();
        $otherCharges = OtherCharges::where('business_id', $business_id)->where('status', 'active')->select('id', 'name')->get();
        $partyCommissionCharges = PartyCommissionCharges::where('business_id', $business_id)->where('status', 'active')->select('id', 'name')->get();
        $trackerCharges = TrackerCharges::where('business_id', $business_id)->where('status', 'active')->select('id', 'name')->get();
        $sendars = Contact::where('type', 'sender')->where('business_id', $business_id)->where('status', 'active')->select('id', 'name')->get();
        $recipients = Contact::where('type', 'recipient')->where('business_id', $business_id)->where('status', 'active')->select('id', 'name')->get();
        $customers = Customer::where('business_id', $business_id)->where('status', 'active')->select('id', 'first_name')->get();
        return view('shippings.create', compact(
            'brokers',
            'gatepasses',
            'clearingagents',
            'sendars',
            'recipients',
            'labourCharges',
            'lifterCharges',
            'localCharges',
            'otherCharges',
            'partyCommissionCharges',
            'trackerCharges',
            'customers'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShipmentRequest $request)
    {
        // dd($request->all());
        try {

            $user_id = session()->get('user.id');
            $business_id = session()->get('user.business_id');

            DB::beginTransaction();


            $input = $request->only([
                'date',
                'job_no',
                'import_export',
                'bill_no',
                'lc_no',
                'shipping_line',
                "container_number",
                'gate_pass_id',
                'clearing_agent_id',
                'customer_id',
                'container_type',
                'payment',
                'total_invoice_amount',
                'total_to_pay_amount',
                'total_expence_amount',
            ]);
            $job_number = $this->getJobNumber($input['job_no'],  $business_id);
            $input['job_no'] = $job_number;
            $input['user_id'] = $user_id;
            $input['business_id'] = $business_id;
            $shipment = Shipping::create($input);

            $data = $request->all();
            $count = count($data['bilty_number']);
            for ($i = 0; $i < $count; $i++) {

                ShipmentDetail::create([
                    'no_of_packges' => $data['no_of_packges'][$i],
                    'description' => $data['description'][$i],
                    'bilty_number' => $data['bilty_number'][$i],
                    'sendar_id' => $data['sendar_id'][$i],
                    'recipient_id' => $data['recipient_id'][$i],
                    'from_location' => $data['from_location'][$i],
                    'to_location' => $data['to_location'][$i],
                    'broker_id' => $data['broker_id'][$i] ?? null,
                    'vehicle_no' => $data['vehicle_no'][$i],
                    'driver_no' => $data['driver_no'][$i],
                    'booker_vhicle_freight_amount' => $data['booker_vhicle_freight_amount'][$i],
                    'mt_return_place' => $data['mt_return_place'][$i] ?? null,
                    'booker_mt_charges_amount' => $data['booker_mt_charges_amount'][$i],
                    'gate_pass_amount' => $data['gate_pass_amount'][$i],
                    'lifter_charges_id' => $data['lifter_charges_id'][$i],
                    'lifter_charges_amount' => $data['lifter_charges_amount'][$i],
                    'labour_charges_id' => $data['labour_charges_id'][$i],
                    'labour_charges_amount' => $data['labour_charges_amount'][$i],
                    'local_charges_id' => $data['local_charges_id'][$i],
                    'local_charges_amount' => $data['local_charges_amount'][$i],
                    'party_commission_charges_id' => $data['party_commission_charges_id'][$i],
                    'party_commision_charges_amount' => $data['party_commision_charges_amount'][$i],
                    'tracker_charges_id' => $data['tracker_charges_id'][$i],
                    'tracker_charges_amount' => $data['tracker_charges_amount'][$i],
                    'other_charges_id' => $data['other_charges_id'][$i],
                    'other_charges_amount' => $data['other_charges_amount'][$i],
                    'shipment_id' => $shipment->id,
                    'bilty_container_number' => $data['bilty_container_number'][$i],
                    'bilty_expence_amount' => $data['bilty_expence_amount'][$i],
                    'bilty_invoice_amount' => $data['bilty_invoice_amount'][$i],
                    'bilty_to_pay_amount' => $data['bilty_to_pay_amount'][$i],
                ]);
            }

            DB::commit();


            $receipt = $this->receiptContent($business_id, $shipment->id, null);

            $data = [
                'success' => true,
                'message' => 'Job created successfully.',
                'html' => $receipt
            ];
            return response()->json($data);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency('File:' . $e->getFile() . 'Line:' . $e->getLine() . 'Message:' . $e->getMessage());
            return response()->json(['error' => true, 'message' => 'Something went wrong. ' . $e->getMessage() . ' ' . $e->getLine()]);
        }
    }






    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $shipping = Shipping::with(['customer', 'details.sendar' , 'details.recipient' , 'gatePass' , 'agent' , 'invoice.fuel'])
                                    ->findOrFail($id);

        $html = view('shippings.show', compact('shipping'))->render();

        return response()->json(['html' => $html]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $business_id = request()->session()->get('user.business_id');
        $brokers = Broker::where('business_id', $business_id)->select('id', 'name')->get();
        $gatepasses = GatePass::where('business_id', $business_id)->where('status', 'active')->select('id', 'name')->get();
        $clearingagents = ClearingAgent::where('business_id', $business_id)->where('status', 'active')->select('id', 'name')->get();
        $labourCharges = LabourCharges::where('business_id', $business_id)->where('status', 'active')->select('id', 'name')->get();
        $lifterCharges = LifterCharges::where('business_id', $business_id)->where('status', 'active')->select('id', 'name')->get();
        $localCharges = LocalCharges::where('business_id', $business_id)->where('status', 'active')->select('id', 'name')->get();
        $otherCharges = OtherCharges::where('business_id', $business_id)->where('status', 'active')->select('id', 'name')->get();
        $partyCommissionCharges = PartyCommissionCharges::where('business_id', $business_id)->where('status', 'active')->select('id', 'name')->get();
        $trackerCharges = TrackerCharges::where('business_id', $business_id)->where('status', 'active')->select('id', 'name')->get();
        $sendars = Contact::where('type', 'sender')->where('business_id', $business_id)->where('status', 'active')->select('id', 'name')->get();
        $recipients = Contact::where('type', 'recipient')->where('status', 'active')->where('business_id', $business_id)->select('id', 'name')->get();
        $customers = Customer::where('business_id', $business_id)->where('status', 'active')->select('id', 'first_name')->get();

        $shipment = Shipping::with('details')->where('business_id', $business_id)->where('id', $id)->first();
        $allContainers = [];
        foreach ($shipment->details as $bilty) {
            $number = $bilty->bilty_container_number;
            $allContainers[] = $number;
        }
        //    dd($allContainers);



        return view('shippings.edit', compact(
            'brokers',
            'gatepasses',
            'clearingagents',
            'sendars',
            'recipients',
            'labourCharges',
            'lifterCharges',
            'localCharges',
            'otherCharges',
            'partyCommissionCharges',
            'trackerCharges',
            'customers',
            'shipment',
            'allContainers'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ShipmentRequest $request, string $id)
    {
        // dd($request->all());
        try {

            $user_id = session()->get('user.id');
            $business_id = session()->get('user.business_id');

            DB::beginTransaction();


            $input = $request->only([
                'date',
                'job_no',
                'import_export',
                'bill_no',
                'container_number',
                'lc_no',
                'shipping_line',
                'gate_pass_id',
                'clearing_agent_id',
                'customer_id',
                'container_type',
                'payment',
                'total_invoice_amount',
                'total_to_pay_amount',
                'total_expence_amount',

            ]);
            //    $input['container_number'] = !empty($request->container_number) ?  $request->container_number : $request->container_number_hide;
            $input['user_id'] = $user_id;
            $input['business_id'] = $business_id;
            $shipment = Shipping::findOrFail($id);

            $shipment->update($input);


            $data = $request->all();
            foreach ($data['bilty_number'] as $i => $biltyNumber) {
                $detailId = $data['detail_id'][$i] ?? null;
                $detailData = [
                    'no_of_packges' => $data['no_of_packges'][$i],
                    'description' => $data['description'][$i],
                    'bilty_number' => $biltyNumber,
                    'sendar_id' => $data['sendar_id'][$i],
                    'recipient_id' => $data['recipient_id'][$i],
                    'from_location' => $data['from_location'][$i],
                    'to_location' => $data['to_location'][$i],
                    'broker_id' => $data['broker_id'][$i] ?? null,
                    'vehicle_no' => $data['vehicle_no'][$i],
                    'driver_no' => $data['driver_no'][$i],
                    'booker_vhicle_freight_amount' => $data['booker_vhicle_freight_amount'][$i],
                    'mt_return_place' => $data['mt_return_place'][$i] ?? null,
                    'booker_mt_charges_amount' => $data['booker_mt_charges_amount'][$i],
                    'gate_pass_amount' => $data['gate_pass_amount'][$i],
                    'lifter_charges_id' => $data['lifter_charges_id'][$i],
                    'lifter_charges_amount' => $data['lifter_charges_amount'][$i],
                    'labour_charges_id' => $data['labour_charges_id'][$i],
                    'labour_charges_amount' => $data['labour_charges_amount'][$i],
                    'local_charges_id' => $data['local_charges_id'][$i],
                    'local_charges_amount' => $data['local_charges_amount'][$i],
                    'party_commission_charges_id' => $data['party_commission_charges_id'][$i],
                    'party_commision_charges_amount' => $data['party_commision_charges_amount'][$i],
                    'tracker_charges_id' => $data['tracker_charges_id'][$i],
                    'tracker_charges_amount' => $data['tracker_charges_amount'][$i],
                    'other_charges_id' => $data['other_charges_id'][$i],
                    'other_charges_amount' => $data['other_charges_amount'][$i],
                    'bilty_container_number' => $data['bilty_container_number'][$i],
                    'shipment_id' => $id,
                    'bilty_expence_amount' => $data['bilty_expence_amount'][$i],
                    'bilty_invoice_amount' => $data['bilty_invoice_amount'][$i],
                    'bilty_to_pay_amount' => $data['bilty_to_pay_amount'][$i],
                ];

                if ($detailId) {

                    ShipmentDetail::where('id', $detailId)->update($detailData);
                } else {
                    ShipmentDetail::create($detailData);
                }
            }

            DB::commit();


            $receipt = $this->receiptContent($business_id, $shipment->id, null);

            $data = [
                'success' => true,
                'message' => 'Job Update successfully.',
                'html' => $receipt
            ];
            return response()->json($data);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency('File:' . $e->getFile() . 'Line:' . $e->getLine() . 'Message:' . $e->getMessage());
            return response()->json(['error' => true, 'message' => 'Something went wrong. ' . $e->getMessage() . ' ' . $e->getLine()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }



    public function getJobNumber($job,  $business_id)
    {


        $year = Carbon::now()->format('Y');
        $lastNumber = DB::table('shippings')
            ->select(DB::raw("MAX(CAST(SUBSTRING(job_no, 10) AS UNSIGNED)) as max_job_no"))
            ->where('business_id', $business_id)
            ->where('job_no', 'LIKE', "JOB-$year-%")
            ->value('max_job_no');

        $nextNumber = $lastNumber ? $lastNumber + 1 : 1;

        return  $job_no = 'JOB-' . $year . '-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }


    private function receiptContent($business_id, $shipment_id, $printer_type = null)
    {


        $output = [
            'is_enabled' => false,
            'print_type' => 'browser',
            'html_content' => null,
            'printer_config' => [],
            'data' => [],
        ];

        $output['is_enabled'] = true;

        $receipt_details = $this->shippingUtil->getReceiptDetails($business_id, $shipment_id);

        $output['html_content'] = view('shippings.print', compact('receipt_details'))->render();

        return $output;
    }

    public function invoice(Request $request, $id)
    {

        // dd($request->all() , $id);
        if ($request->ajax()) {

            try {

                $user_id = session()->get('user.id');
                $business_id = session()->get('user.business_id');
                DB::beginTransaction();

                $invoice = Invoice::where('shipment_id', $id)->first();

                if (!empty($invoice)) {
                    $invoice->update($request->except('invoice_id', 'shipment_id'));
                } else {
                    $input = $request->only([
                        'shipment_id',
                        'fuel_id',
                        'invoice_amount',
                        'fuel_amount_percentage',
                        'fuel_amount_after_percentage',
                        'tax_amount_percentage',
                        'tax_amount_after_percentage',
                        'final_amount',
                        'user_id',
                        'business_id',
                        'invoice_date',
                    ]);
                    $input['invoice_amount'] = $request->invoice_amount ?? 0;
                    $input['fuel_amount_percentage'] = $request->fuel_amount_percentage ?? 0;
                    $input['fuel_amount_after_percentage'] = $request->fuel_amount_after_percentage ?? 0;
                    $input['tax_amount_percentage'] = $request->tax_amount_percentage ?? 0;
                    $input['tax_amount_after_percentage'] = $request->tax_amount_after_percentage ?? 0;
                    $input['final_amount'] = $request->final_amount ?? 0;
                    $input['user_id'] = $user_id;
                    $input['business_id'] = $business_id;
                    $input['shipment_id'] = $id;
                    $input['invoice_date'] = now();

                    $input['invoice_no'] = $this->generateInvoiceNumber();

                    $invoice = Invoice::create($input);
                }

                DB::commit();

                $receipt = $this->receiptInvoucePrint($business_id, $invoice->id, null);

                $data = [
                    'success' => true,
                    'message' => 'Invoice created successfully.',
                    'html' => $receipt
                ];

                return response()->json($data);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['error' => true, 'message' => 'Something went wrong. ' . $e->getMessage() . ' ' . $e->getLine()]);
            }
        }
    }


            function generateInvoiceNumber() {
            $datePart = now()->format('dmy');

            $lastInvoice = DB::table('invoices')
                ->whereDate('created_at', Carbon::today())
                ->orderBy('id', 'desc')
                ->first();

            if ($lastInvoice && str_starts_with($lastInvoice->invoice_no, $datePart)) {
                $lastCounter = (int)substr($lastInvoice->invoice_no, 6); // get last 3 digits
                $newCounter = str_pad($lastCounter + 1, 3, '0', STR_PAD_LEFT);
            } else {
                $newCounter = '001';
            }

            return $datePart . $newCounter;
        }


    public function printReceipt(Request $request, $id)
    {
        if ($request->ajax()) {
            $business_id = session()->get('user.business_id');

            $invoice = Invoice::where('shipment_id', $id)->where('business_id', $business_id)->first();

            if ($invoice) {
                $receipt = $this->receiptInvoucePrint($business_id, $invoice->id, null);
                $data = [
                    'success' => true,
                    'message' => 'Invoice created successfully.',
                    'html' => $receipt
                ];
                return response()->json($data);
            } else {
                return response()->json(['error' => true, 'message' => 'Invoice not found.']);
            }
        }
    }


    private function receiptInvoucePrint($business_id, $invoice_id, $printer_type = null)
    {


        $output = [
            'is_enabled' => false,
            'print_type' => 'browser',
            'html_content' => null,
            'printer_config' => [],
            'data' => [],
        ];

        $output['is_enabled'] = true;

        $receipt = $this->shippingUtil->getInvoiceDetails($business_id, $invoice_id);

        $output['html_content'] = view('shippings.receipt.invoice', compact('receipt'))->render();

        return $output;
    }
}
