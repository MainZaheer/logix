@extends('master.layout')
@section('title', 'Shipment List')
@section('content')


<section class="content-header" style="font-family: cursive;">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body" style="box-shadow: 2px 2px 0px 0px #17a2b8">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="text-info"><i class="fas fa-shipping-fast"></i> Shipments </h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"> <i class="fa fa-home text-info"></i> <a
                                class = " text-info"
                                    href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Shipments</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <h3><a href="{{ route('shippings.create') }}" class="btn btn-info btn-sm"><i class="fa fa-plus"></i>
                        Add Shipments</a></h3>
            </div>
        </div>
    </div>
</section>


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="dataTables_wrapper dt-bootstrap4">
                            <table id="ship_table" class="table table-bordered table-striped nowrap" 
                            style="width: 100%;">
                                <thead>
                                    <tr>

                                        <th>Date</th>
                                        <th>Job#</th>
                                        <th>BL#</th>
                                        <th>LC#</th>
                                        <th>Shipping Line</th>
                                        <th>Customer Name</th>
                                        <th>Invoice Amount</th>
                                        <th>Expense Amount</th>
                                        <th>Payment Method</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



    <div class="modal fade" id="invoice-modal" tabindex="-1" role="dialog" aria-labelledby="invoice-modal-label"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="invoice-modal-label">Create Invoice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="" method="POST" id="invoice-form">
                        @csrf
                        <input type="hidden" name="shipment_id" id="shipment-id" value="">
                        <input type="hidden" name="invoice_id" id="invoice-id" value="">
                        <div class="row">

                            <!-- Invoice Info -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Job #:</strong> <span id="job-no"
                                        class="text-primary font-weight-bold"></span><br>
                                    <strong>Bill #:</strong> <span id="bill-no"
                                        class="text-success font-weight-bold"></span><br>
                                    <strong>LC #:</strong> <span id="lc-no" class="text-info font-weight-bold"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="invoice-amount">Invoice Amount</label>
                                    <input type="number" name="invoice_amount" id="invoice-amount" class="form-control"
                                        readonly>
                                </div>
                            </div>

                            <!-- Fuel Info -->
                            <div class="col-md-12">
                                <h5 class="mt-3">Fuel Information</h5>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="fuel_id">Fuel Type</label>
                                        <select name="fuel_id" id="fuel_id" class="form-control select2">
                                            @foreach ($fuels as $fuel)
                                                <option value="{{ $fuel->id }}">{{ $fuel->name }}</option>
                                            @endforeach
                                        </select>
                                        <span id="fuel-error" class="text-danger"></span>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="fuel_amount_percentage">Fuel %</label>
                                        <input type="number" name="fuel_amount_percentage" id="fuel_amount_percentage"
                                            class="form-control" placeholder="Enter %">
                                    </div>

                                    <div class="form-group col-md-4" style="">
                                        <label for="fuel_amount_after_percentage">Fuel Amount</label>
                                        <input type="number" name="fuel_amount_after_percentage"
                                            id="fuel_amount_after_percentage" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- Tax Info -->
                            <div class="col-md-12">
                                <h5 class="mt-3">Tax Information</h5>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="tax_amount_percentage">Tax %</label>
                                        <input type="number" name="tax_amount_percentage" id="tax_amount_percentage"
                                            class="form-control" placeholder="Enter %">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="tax_amount_after_percentage">Tax Amount</label>
                                        <input type="number" name="tax_amount_after_percentage"
                                            id="tax_amount_after_percentage" class="form-control" readonly>
                                    </div>

                                    <div class="form-group col-md-4 ">
                                        <label for="final_amount">Final Amount</label>
                                        <input type="number" name="final_amount" id="final_amount" class="form-control"
                                            readonly>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary mt-3">Create Invoice</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="invoice-printContainer" style="display: none;"></div>
    <div id="invoice-printContainer-receipt" ></div>

    <!-- Modal -->
<div class="modal fade" id="viewShippingModal" tabindex="-1" role="dialog" aria-labelledby="viewShippingLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewShippingLabel">Shipping Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="shipping-detail-body">
        <!-- Partial view will load here -->
        <p class="text-muted">Loading...</p>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        $(document).ready(function() {
            $('#ship_table').DataTable({
                scrollX: true,
               "autoWidth": false,
                processing: true,
                serverSide: true,
                ajax: "{{ route('shippings.index') }}",
                columns: [{
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'job_no',
                        name: 'job_no'
                    },
                    {
                        data: 'bill_no',
                        name: 'bill_no'
                    },
                    {
                        data: 'lc_no',
                        name: 'lc_no'
                    },
                    {
                        data: 'shipping_line',
                        name: 'shipping_line'
                    },
                    {
                        data: 'customer_name',
                        name: 'customer_name'
                    },
                    {
                        data: 'total_invoice_amount',
                        name: 'total_invoice_amount'
                    },
                    {
                        data: 'total_expence_amount',
                        name: 'total_expence_amount'
                    },
                    {
                        data: 'payment',
                        name: 'payment'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center' // optional styling
                    }
                ]
            });
        });

        $('#invoice-form').submit(function(e) {
            e.preventDefault();
            var id = $('#shipment-id').val();
            // alert(id);
            var formData = $(this).serialize();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('shippings.invoice', ':id') }}".replace(':id', id),
                type: "POST",
                data: formData,
                success: function(response) {
                    // console.log(response.html.html_content);
                    toastr.success(response.message);
                    $('#invoice-form')[0].reset();
                    $('#invoice-modal').modal('hide');
                    $('#ship_table').DataTable().ajax.reload();

                    $('#invoice-printContainer').html(response.html.html_content);


                    setTimeout(function() {
                        var printContents = document.getElementById('invoice-printContainer')
                            .innerHTML;
                        var originalContents = document.body.innerHTML;
                        document.body.innerHTML = printContents;
                        window.print();
                        document.body.innerHTML = originalContents;
                        location.reload();
                    }, 500)


                },
                error: function(xhr, status, error) {
                    toastr.error(xhr.responseJSON.message);
                }
            });
        });

        $('#invoice-modal').on('show.bs.modal', function(event) {

            var button = $(event.relatedTarget);
            var shipment_id = button.data('shipment-id');
            var invoice_amount = button.data('invoice-amount');
            var job_no = button.data('job-no');
            var bill_no = button.data('bill-no');
            var lc_no = button.data('lc-no');

            var invoice_id = button.data('invoice-id');
            if (invoice_id) {
                $('#invoice-id').val(invoice_id);
                $('#fuel_id').val(button.data('fuel-id'));
                $('#fuel_amount_percentage').val(button.data('fuel-amount-percentage'));
                $('#fuel_amount_after_percentage').val(button.data('fuel-amount-after-percentage'));
                $('#tax_amount_percentage').val(button.data('tax-amount-percentage'));
                $('#tax_amount_after_percentage').val(button.data('tax-amount-after-percentage'));
                $('#final_amount').val(button.data('final-amount'));
            } else {
            $("#fuel_amount_percentage").val("");
            $("#tax_amount_percentage").val("");
            $("#fuel_amount_after_percentage").val("");
            $("#final_amount").val("");
            $("#tax_amount_after_percentage").val("");
            $('#invoice-id').val("");
            }



            $('#shipment-id').val(shipment_id);
            $('#invoice-amount').val(invoice_amount);
            $('#job-no').text(job_no);
            $('#bill-no').text(bill_no);
            $('#lc-no').text(lc_no);
        });

        $('#fuel_amount_percentage , #tax_amount_percentage').on('change , keyup', function() {
            var invoice_amount = parseFloat($('#invoice-amount').val()) || 0;
            var fuel_percent = parseFloat($('#fuel_amount_percentage').val()) || 0;
            var tax_percent = parseFloat($('#tax_amount_percentage').val()) || 0;

            var fuel_amount = 0;
            var tax_amount = 0;

            // Calculate fuel amount
            if (fuel_percent > 0) {
                fuel_amount = (invoice_amount * fuel_percent) / 100;
                $('#fuel_amount_after_percentage').val(fuel_amount.toFixed(2));
            } else {
                $('#fuel_amount_after_percentage').val('');
            }

            // Calculate tax amount
            if (tax_percent > 0 && fuel_percent > 0) {
                var amount = invoice_amount - fuel_amount;
                tax_amount = (amount * tax_percent) / 100;
                $('#tax_amount_after_percentage').val(tax_amount.toFixed(2));
            } else if (tax_percent > 0) {
                tax_amount = (invoice_amount * tax_percent) / 100;
                $('#tax_amount_after_percentage').val(tax_amount.toFixed(2));
            } else {
                $('#tax_amount_after_percentage').val('');
            }

            var final_amount = invoice_amount - fuel_amount - tax_amount;
            $('#final_amount').val(final_amount.toFixed(2));


        });

        // print receipt
        $(document).on('click', '.print-job', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: "{{ route('shippings.receipt', ':id') }}".replace(':id', id),
                type: "GET",
                success: function(response) {
                const html = response.html.html_content;
                    $('#invoice-printContainer-receipt').html(html);
                    $('#invoice-printContainer-receipt').printThis({
                        debug: false,
                        afterPrint: function() {
                    $('#invoice-printContainer-receipt').empty(); // Hides content after printing/cancel
                }
                    });
            },
                error: function(xhr, status, error) {
                    toastr.error(xhr.responseJSON?.message || 'Something went wrong');
                }
            });
        });

        $(document).on('click', '.view-shipping', function () {
            var id = $(this).data('id');
            $('#shipping-detail-body').html('<p class="text-muted">Loading...</p>');

            $.ajax({
                url: '/shippings/' + id, // Make sure this route exists
                type: 'GET',
                success: function (response) {
                    $('#shipping-detail-body').html(response.html);
                    $('#viewShippingModal').modal('show');
                },
                error: function () {
                    $('#shipping-detail-body').html('<p class="text-danger">Failed to load shipping details.</p>');
                }
            });
        });
    </script>
@endsection
