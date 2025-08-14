@extends('master.layout')
@section('content')

@section('title', 'Account Details')

<section class="content-header" style="font-family: cursive;">
    <div class="container-fluid">
        <div class="card shadow-sm border-left-primary">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-info-circle"></i> Account Details</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h5><i class="fas fa-user-check text-info"></i> <strong>Account Name:</strong>
                            {{ $account->account_name }}</h5>
                        <h5><i class="fas fa-piggy-bank text-success"></i> <strong>Account Number:</strong>
                            {{ $account->account_number }}</h5>
                        <h5><i class="fas fa-credit-card text-warning"></i> <strong>Account Type:</strong>
                            {{ ucfirst($account->account_type) }}</h5>
                        <h5><i class="fas fa-donate text-danger"></i> <strong>Status:</strong>
                            <span class="badge badge-{{ $account->status == 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($account->status) }}
                            </span>
                        </h5>

                        <h5><i class="fas fa-fas fa-clipboard-check text-primary"></i> <strong> Description:</strong>
                            <span>{{ $account->description}}</span>
                        </h5>


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline card-tabs">
                <div class="card-header" style="padding: 0px 0px 0px 14px;">
                    <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                        <li class="nav-item" style="font-size: 25px;">
                            <a class="nav-link active" id="account_legder" data-toggle="pill" href="#account_legder_tab"
                                role="tab" aria-controls="account_legder_tab" aria-selected="true"><i
                                    class="fas fa-receipt"></i> Legder</a>
                        </li>
                    </ul>

                    <div class="row" style="margin-top: 24px;">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <button type="button" class="btn btn-default float-right" id="daterange-btn">
                                        Date Range:
                                    </button>
                                </div>
                            </div>
                        </div>


                            <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                                <h3 class="blue-heading">Account Summary</h3>
                                <span class="startDate" style="text-align: end;"></span> -
                                <span class="endDate" style="text-align: end;"></span>

                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <td>Opening Balance</td>
                                            @if (isset( $account['transactions']['0']['amount']))
                                                <td class="align-right">₨ {{ $account['transactions']['0']['amount'] }}</td>
                                            @else
                                                <td class="align-right">₨ {{ __("0.00") }}</td>
                                            @endif

                                        </tr>
                                        <tr>
                                            <td><strong>Balance</strong></td>
                                            <td class="ws-nowrap align-right">{{ $account->balance ?? "0.00" }}</td>
                                        </tr>
                                        <tr>

                                        </tr>

                                    </tbody>
                                </table>
                            </div>


                    </div>

                    <input type="hidden" id="start_date">
                    <input type="hidden" id="end_date">
                    <input type="hidden" id="accoun_id" value="{{ $account->id }}">

                </div>



                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-three-tabContent">
                        <div class="tab-pane fade show active" id="account_legder_tab" role="tabpanel"
                            aria-labelledby="account_legder">
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <table id="account_detail_table" class="table table-bordered table-striped nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Payment Ref No.</th>
                                            <th>Job No</th>
                                            <th>Description</th>
                                            <th>Payment Status</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                            <th>Balance</th>
                                            <th>Payment Method</th>
                                            <th>Added by</th>

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
    </div>
</section>



@endsection
@section('script')
<script>
    $(function() {
        let start = moment().startOf('month');
        let end = moment().endOf('month');

        // Update label
        function updateLabel(start, end) {
            $('#daterange-btn').html(
                '<i class="far fa-calendar-alt"></i> ' +
                start.format('MMMM D, YYYY') + ' - ' +
                end.format('MMMM D, YYYY')
            );
            $('#start_date').val(start.format('YYYY-MM-DD'));
            $('#end_date').val(end.format('YYYY-MM-DD'));

            $('.startDate').text(start.format('YYYY-MM-DD'));
            $('.endDate').text(end.format('YYYY-MM-DD'));
        }

        updateLabel(start, end);

        // Init daterangepicker
        $('#daterange-btn').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                    'month').endOf('month')],
                'This Year': [moment().startOf('year'), moment().endOf('year')],
                'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year')
                    .endOf('year')
                ],
            }
        }, function(start, end) {
            updateLabel(start, end);
            account_detail_table.ajax.reload();
        });

         var id = $("#accoun_id").val();
        var account_detail_table = $('#account_detail_table').DataTable({
            scrollX: true,
           "autoWidth": false,
            processing: true,
            serverSide: true,
            pageLength: 100,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            dom: "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],

            ajax: {
                url: "/accounts/details/datatable/" + id, // Replace with your actual route
                data: function(d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                }
            },
            columns: [{
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'transaction_reference',
                    name: 'transaction_reference'
                },
                {
                    data: 'job_no',
                    name: 'job_no'
                },
                {
                    data: 'description',
                    name: 'description',
                },

                {
                    data: "payment_status",
                    name: "payment_status",
                },

                {
                    data: 'debit',
                    name: 'debit'
                },
                {
                    data: 'credit',
                    name: 'credit'
                },

                 {
                    data: 'balance',
                    name: 'balance'
                },

                 {
                    data: 'payment_method',
                    name: 'payment_method'
                },

                {
                    data: 'added_by',
                    name: 'added_by'
                },



            ]
        });
    });
</script>


@endsection
