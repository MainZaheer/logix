<style>
    #invoice-printContainer {
        font-family: Arial, sans-serif;
        font-size: 13px;
        margin: 20px;
        color: #000;
    }

    .title {
        text-align: center;
        font-weight: bold;
        font-size: 30px;
        margin-bottom: 5px;
        color: #6e6363;
    }

    .ntn,
    .we-carry {
        font-size: 18px;
        margin-bottom: 5px;
    }

    .invoice-box {
        width: 100%;
        max-width: 900px;
        margin: auto;
        padding: 20px;

    }

    .center {
        text-align: center;
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 5px;

    }

    .invoice-title {
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        border: 1px solid #000;
        padding: 4px 0;
        margin: 10px 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
    }

    table,
    th,
    td {
        border: 1px solid #000;
    }

    th,
    td {
        padding: 5px;
        text-align: center;
        vertical-align: middle;
    }

    .no-border {
        border: none;
    }

    .bold {
        font-weight: bold;
    }

    .section-title {
        font-weight: bold;
        text-align: left;
        padding-left: 5px;
    }

    .total-row td {
        font-weight: bold;
        text-align: right;
    }

    .bottom-table td {
        text-align: left;
        padding-left: 10px;
    }

    .bottom-table td:last-child {
        text-align: right;
        padding-right: 10px;
    }
</style>


<div class="invoice-box" id="invoice-printContainer">

    <div class="header">
        <div class="title">AL-USMAN LOGISTICS</div>
        <div class="ntn">NTN: 2878956-3</div>
        <div class="we-carry">We Carry your Dream</div>
    </div>

    <br><br>



    <table border="1" cellspacing="0" cellpadding="5" width="100%"
        style="border-collapse: collapse; font-family: Arial; font-size: 13px;">
        {{-- <tr class="center">
            <td colspan="12" style="padding: 40px;">IDEAL TRADING CO</td>
        </tr> --}}


        @php
            $form = [];
            $to = [];
            $description = [];
            foreach ($receipt->shipment->details as $detail) {
                $from = is_array($detail['from_location']) ? $detail['from_location'] : [$detail['from_location']];
                $form[] = implode(' , ', $from);
                $toLoc = is_array($detail['to_location']) ? $detail['to_location'] : [$detail['to_location']];
                $to[] = implode(' , ', $toLoc);
                $desc = is_array($detail['description']) ? $detail['description'] : [$detail['description']];
                $description[] = implode(' , ', $desc);
            }
            $name = $receipt->shipment->customer->first_name . ' ' . $receipt->shipment->customer->last_name;
        @endphp

        <tr>
            <th>CLIENT</th>
            <td colspan="3">{{ $name }}</td>
            <th colspan="2" rowspan="5" style="text-align: center; font-weight: bold; font-size: 18px;">INVOICE
            </th>
            <th>FROM</th>
            <td colspan="5">{{ implode(' , ', $form) }}</td>
        </tr>
        <tr>
            <th>AGENT</th>
            <td colspan="3">{{ $receipt->shipment->agent->name }}</td>
            <th>TO</th>
            <td colspan="5">{{ implode(' , ', $to) }}</td>
        </tr>
        <tr>
            <th>BL NO</th>
            <td colspan="3">{{ $receipt->shipment->bill_no }}</td>
            <th colspan="2">JOB No</th>
            <td colspan="5">{{ $receipt->shipment->job_no }}</td>

        </tr>
        <tr>
            <th>L/C NO</th>
            <td colspan="3">{{ $receipt->shipment->lc_no }}</td>
            <th colspan="2">Invoice Date</th>
            <td colspan="5">{{ date('Y-m-d', strtotime($receipt->invoice_date)) }}</td>

        </tr>

        <tr>
            <td colspan="5"></td>
            <th colspan="2">Invoice No.</th>
            <td colspan="5"> {{ $receipt->invoice_no }}</td>

        </tr>

        <tr>
            <th colspan="2">Description</th>
            <td colspan="10">{{ implode(' , ', $description) }}</td>
        </tr>

            <tr class="bold">
            <th colspan="2">VEHICLE NO.</th>
            <th colspan="2">BILTY NO</th>
            <th colspan="2">CONTAINER NO.</th>
            <th colspan="5">BILL AMOUNT</th>
        </tr>


                @foreach ($receipt->shipment->details as $detail)
                <tr>



                    <td colspan="2">{{ $detail->vehicle_no }}</td>
                    <td colspan="2">{{ $detail->bilty_number }}</td>
                    <td colspan="2">
                        {{ is_array($detail->bilty_container_number)
                            ? implode(' , ', $detail->bilty_container_number)
                            : $detail->bilty_container_number }}
                    </td>

                    @php
                        $invoice = $detail->bilty_invoice_amount - $detail->bilty_expence_amount
                    @endphp


                    <td colspan="5" style="text-align: right;">{{ $invoice }}</td>
                </tr>

                @endforeach


                @php
                $totalNetAmount = 0;
                foreach ($receipt->shipment->details as $detail) {
                    $netAmount = $detail->bilty_invoice_amount - $detail->bilty_expence_amount;
                    $totalNetAmount += $netAmount;
                }
            @endphp



        <!-- Totals -->
        <tr class="total-row">

            <td colspan="10">Total Freight Amount</td>
            <td>{{ $receipt->shipment->total_expence_amount }}</td>
        </tr>
        <tr class="total-row">
            <td colspan="10">W/Tax</td>
            <td>{{ $receipt->tax_amount_percentage }}%</td>
        </tr>

        <tr class="total-row">
            <td colspan="10">Fuel Received {{ $receipt->fuel_amount_percentage }}% </td>
            {{-- <td>{{ $receipt->fuel_amount_after_percentage }}</td> --}}
        </tr>
        <tr class="total-row">
            <td colspan="10">NET BILL AMOUNT :</td>
            <td> {{ $totalNetAmount }}</td>
        </tr>
    </table>
</div>
