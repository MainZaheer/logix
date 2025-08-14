<div class="container-fluid">
    <!-- Shipment Summary -->
    <div class="card border-primary mb-3">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Shipment Summary</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3" style="background-color: #f8d7da;"><strong>Date:</strong>
                    {{ $shipping->date ?? '-' }}</div>
                <div class="col-md-3" style="background-color: #d1ecf1;"><strong>Job#:</strong>
                    {{ $shipping->job_no ?? '-' }}</div>
                <div class="col-md-3" style="background-color: #d4edda;"><strong>IMPORT/EXPORT#:</strong>
                    {{ $shipping->import_export ?? '-' }}</div>

                <div class="col-md-3" style="background-color: #fff3cd;"><strong>BL#:</strong>
                    {{ $shipping->bill_no ?? '-' }}</div>
                <div class="col-md-3" style="background-color: #e2e3e5;"><strong>LC#:</strong>
                    {{ $shipping->lc_no ?? '-' }}</div>
                <div class="col-md-3" style="background-color: #f1d4d4;"><strong>Shipping Line:</strong>
                    {{ $shipping->shipping_line ?? '-' }}</div>

                <div class="col-md-3" style="background-color: #d4d9f1;"><strong>Customer:</strong>
                    {{ optional($shipping->customer)->first_name }} {{ optional($shipping->customer)->last_name }}</div>

                @if ($shipping->payment == 'cash')
                    <div class="col-md-3" style="background-color: #daf5d1;"><strong>Payment:</strong>
                        {{ __('TOPAY') }}</div>
                @else
                    <div class="col-md-3" style="background-color: #f5dad1;"><strong>Payment:</strong>
                        {{ __('CREDIT') }}</div>
                @endif

                <div class="col-md-3" style="background-color: #d1e7f5;"><strong>Clearing Agent:</strong>
                    {{ optional($shipping->agent)->name ?? '-' }}</div>
                <div class="col-md-3" style="background-color: #f7d4f1;"><strong>Gate Pass:</strong>
                    {{ optional($shipping->gatePass)->name ?? '-' }}</div>
            </div>

        </div>
    </div>

    <!-- Shipment Details Table -->
    <div class="card">
        <div class="card-header bg-success text-white">
            <h6 class="mb-0">Shipment Details</h6>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered m-0">
                <thead class="thead-light">
                    <tr>
                        <th>packges no</th>
                        <th>Description</th>
                        <th>Bilty Number</th>
                        <th>Sendar</th>
                        <th>Recipient</th>
                        <th>From location</th>
                        <th>To location</th>
                        <th>Vehicle no</th>
                        <th>Driver no</th>
                        <th>Expence Amount</th>
                        <th>Invoice Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($shipping->details as $index => $detail)
                        <tr>
                            <td>{{ $detail->no_of_packges }}</td>
                            <td>{{ $detail->description ?? '-' }}</td>
                            <td>{{ $detail->bilty_number ?? '-' }}</td>
                            <td>{{ $detail->sendar->name ?? '-' }}</td>
                            <td>{{ $detail->recipient->name ?? '-' }}</td>
                            <td>{{ $detail->from_location ?? '-' }}</td>
                            <td>{{ $detail->to_location ?? '-' }}</td>
                            <td>{{ $detail->vehicle_no ?? '-' }}</td>
                            <td>{{ $detail->driver_no ?? '-' }}</td>
                            <td>{{ $detail->bilty_expence_amount ?? '-' }}</td>
                            <td>{{ $detail->bilty_invoice_amount ?? '-' }}</td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No shipment details available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>



    {{-- Invoice Details --}}
    <div class="card border-primary mb-3">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0">Invoice Details</h5>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col-md-3""><strong>Invoice:</strong>{{ $shipping->invoice->invoice_no ?? '-' }}</div>
                <div class="col-md-3""><strong>Invoice Date:</strong> {{ $shipping->invoice->invoice_date ?? '-' }}
                </div>
                <div class="col-md-3""><strong>Invoice Amount#:</strong>{{ $shipping->invoice->invoice_amount ?? '-' }}
                </div>

                <div class="col-md-3""><strong>Fuel Name#:</strong> {{ $shipping->invoice->fuel->name ?? '-' }}</div>


                <div class="col-md-3""><strong>Fuel%:</strong>{{ $shipping->invoice->fuel_amount_percentage ?? '-' }}
                </div>

                <div class="col-md-3""><strong>Tax%:</strong>{{ $shipping->invoice->tax_amount_percentage ?? '-' }}
                </div>

                <div class="col-md-3""><strong>Final Amount:</strong>{{ $shipping->invoice->final_amount ?? '-' }}
                </div>

            </div>

        </div>
    </div>

</div>
