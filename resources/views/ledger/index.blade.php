@extends('master.layout')
@section('content')

@section('title', 'Ledgers')


<section class="content-header" style="font-family: cursive;">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body" style="box-shadow: 2px 2px 0px 0px #007bff">
                <div class="row">
                    <div class="col-md-3">
                        <label>Type <span class="text-danger">*</span></label>
                        <select id="type_selector" class="form-control select2">
                            <option value="">Select Type</option>
                            <option value="customer">Customer</option>
                            <option value="broker">Broker</option>
                            <option value="gate_pass">Gate Pass</option>
                            <option value="labour">labour Chrges</option>
                            <option value="local">Local Charges</option>
                            <option value="lifter">Lifter Charges</option>
                            <option value="other">Other Charges</option>
                            <option value="party_commission">Party Commission</option>
                            <option value="tracker">Tracker Charges</option>
                            <option value="clearing_agent">Clearing Agent</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Name <span class="text-danger">*</span></label>
                        <select id="type_id_selector" class="form-control select2"  multiple>

                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dataTables_wrapper dt-bootstrap4">
                            <table id="payable_legder" class="table table-bordered table-striped nowrap" style="widows: 100%;">
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>Date</th>
                                        <th>JOB NO.</th>
                                        <th>Bilty Number</th>
                                        <th>Type</th>
                                        <th>Party Name</th>
                                        <th>Payment Status</th>
                                        <th>Total Amount</th>
                                        <th>Total Paid</th>
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




{{-- Modal --}}

<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Add Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('ledger.store') }}" method="POST" id="paymentForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="shipping_id" id="shipping_id">
                    <input type="hidden" name="type" id="type">
                    <input type="hidden" name="type_id" id="type_id">
                    <input type="hidden" name="ledger_type" id="ledger_type">
                    <input type="hidden" name="model_type" id="model_type">



                    <div class="row">
                        <div class="col-md-6">
                            <div class="well">
                                <strong>Type:<span class="type"></span></strong>
                                <br>
                                <strong>Party Name:<span class="party-name"></span></strong>
                                <br>
                                <strong>Total amount:<span class="total_amount"></span></strong>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="well">
                                <strong>Job# : <span class="job_no"></span></strong>
                                <br>
                                <strong>Date : <span class="job_date"></span></strong>
                                <br>
                                <strong>Payment Note: <span class="payment_note">--</span></strong>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Payment Method:*</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-money-bill-alt" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <select class="form-control" id="payment_method" name="payment_method" required>
                                        <option value="cash" selected>Cash</option>
                                        <option value="bank">Bank</option>
                                        <option value="cheque">Cheque</option>
                                        <option value="online">Online</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Paid on:*</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="datetime-local" class="form-control" id="paid_on" name="paid_on"
                                        required>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Amount:*</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-money-bill-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control amount" name="amount" required>
                                    <input type="hidden" class="form-control" id="total_amount" name="total_amount"
                                        required>

                                </div>

                            </div>
                        </div>


                    </div>

                    <div class="row" id="bank_details" style="display: none;">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cheque_number">Bank Account:*</label>
                                <select name="account_id" id="account_id" class="form-control select2">
                                    <option value="">Select Account</option>
                                    @foreach ($accounts as $ac)
                                        <option value="{{ $ac->id }}">{{ $ac->account_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="remarks">Payment Note</label>
                        <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /.modal -->


@endsection
@section('script')
<script>
    $(".select2").select2({

    });
    @if (session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if (session('error'))
        toastr.error("{{ session('error') }}");
    @endif

    $(document).ready(function() {
        let table = $('#payable_legder').DataTable({
            scrollX: true,
            "autoWidth": false,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('ledger.index') }}",
                data: function(d) {
                    d.type = $('#type_selector').val();
                    d.type_id = $('#type_id_selector').val();
                    d.ledger_type = new URLSearchParams(window.location.search).get('ledgerType');
                }
            },
            columns: [

                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'date',
                    name: 'date',

                },
                {
                    data: 'job_no',
                    name: 'job_no',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'bilty_container_number',
                    name: 'bilty_container_number',

                },

                {
                    data: 'type',
                    name: 'type',

                },

                {
                    data: 'party_name',
                    name: 'party_name'
                },
                {
                    data: 'status',
                    name: 'status'
                },

                {
                    data: 'total_amount',
                    name: 'total_amount'
                },

                {
                    data: 'paid_amount',
                    name: 'paid_amount'
                },


            ],

            language: {
                emptyTable: "Please select Type and Name to view ledger"
            }
        });


        function initMultiSelect() {
        $('#type_id_selector').select2({
            placeholder: "Select Name",
            closeOnSelect: true,
            allowClear: true
        });

        // Handle Select All
        $('#type_id_selector').on('select2:select', function (e) {
            if (e.params.data.id === "all") {
                let allValues = $("#type_id_selector option:not([value='all'])").map(function () {
                    return $(this).val();
                }).get();
                $('#type_id_selector').val(allValues).trigger('change');
            }
        });

        $('#type_id_selector').on('select2:unselect', function (e) {
            if (e.params.data.id === "all") {
                $('#type_id_selector').val(null).trigger('change');
            }
        });
    }

    // Load names when type changes
    $('#type_selector').change(function () {
        let selectedType = $(this).val();
        $('#type_id_selector').empty().append(`<option>Loading...</option>`);

        if (selectedType) {
            $.get("{{ route('ledger.type.names') }}", { type: selectedType }, function (data) {
                $('#type_id_selector').empty();
                $('#type_id_selector').append(`<option value="all">Select All</option>`);
                $.each(data, function (i, item) {
                    $('#type_id_selector').append(
                        `<option value="${item.id}">${item.name}</option>`
                    );
                });
                initMultiSelect();
            });
        } else {
            $('#type_id_selector').html(`<option value="">Select Type First</option>`);
        }
    });

    // Reload table when selection changes
    $('#type_id_selector').change(function () {
        table.ajax.reload();
    });
    });


    // Modal payable

    $(document).on('click', '.paybale-ledger , .receivable-ledger', function(e) {
        e.preventDefault();
        let shipping_id = $(this).data('id');
        let type = $(this).data('type');
        let type_id = $(this).data('type-id');
        let job_no = $(this).data('job-no');
        let date = $(this).data('date');
        let party_name = $(this).data('party-name');
        let total_amount = $(this).data('total-amount');
        let ledger_type = $(this).data('ledger-type');
        let model_type = $(this).data('model-type');
        let paid_amount = $(this).data('paid-amount');


        //    console.log(paid_amount , total_amount);

        $('#paymentModal').find('#paid_on').val(getLocalDateTime());
        $('#paymentModal').find('#shipping_id').val(shipping_id);
        $('#paymentModal').find('#type').val(type);
        $('#paymentModal').find('#type_id').val(type_id);
        $('#paymentModal').find('#job_no').val(job_no);
        $('#paymentModal').find('#date').val(date);
        $('#paymentModal').find('#party_name').val(party_name);
        $('#paymentModal').find('#total_amount').val(total_amount);
        $('#paymentModal').find('#ledger_type').val(ledger_type);
        $('#paymentModal').find('#model_type').val(model_type);

        $('#paymentModal').find('.type').text(type);
        $('#paymentModal').find('.party-name').text(party_name);
        $('#paymentModal').find('.total_amount').text(total_amount);
        $('#paymentModal').find('.amount').val(paid_amount);
        $('#paymentModal').find('.job_no').text(job_no);
        $('#paymentModal').find('.job_date').text(date);
        $('#paymentModal').modal('show');
    });


    $(document).on('change', '#payment_method', function() {
        var paymentMethod = $(this).val();
        if (paymentMethod === 'bank') {
            $('#bank_details').show();
        } else {
            $('#bank_details').hide();
            $('#account_id').val('').trigger('change');
        }
    });

    function getLocalDateTime() {
        const now = new Date();
        const offset = now.getTimezoneOffset();
        const local = new Date(now.getTime() - offset * 60000);
        return local.toISOString().slice(0, 16);
    }


    $('#paymentForm').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    // Reset the form
                    $('#remarks').val('');
                    $('#paymentModal').modal('hide');
                    $('#bank_details').hide();
                    $("#payment_method").val('cash').trigger('change');
                    $('#account_id').val('').trigger('change');
                    $('#payable_legder').DataTable().ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    toastr.error(xhr.responseJSON.message);
                } else {
                    toastr.error("An error occurred while processing your request.");
                }

            }
        });
    });
</script>


@endsection

@section('css')

@endsection
