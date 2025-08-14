@extends('master.layout')
@section('title', 'Dashboard')
@section('content')


    <section class="content-header" style="font-family: cursive;">
        <div class="container-fluid">

            <div class="row mb-3">
                <div class="col-md-6">
                    <h5>Welcome Back {{ auth()->user()->name }} <i class = "fas fa-award" style="color: #ff6600;"> </i></h5>
                </div>

                <div class="col-md-6">
                    <button type="button" class="btn btn-primary float-right btn-sm" id="dashboard-daterange">
                        Filter by date
                    </button>
                </div>
                <input type="hidden" id="start_date">
                <input type="hidden" id="end_date">
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">Total Shipments: <strong>1500</strong></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">Toatl Customer: <strong>{{ $customerCount }}</strong></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">Active Account: <strong>{{ $activeAccount }}</strong></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body">Total Broker: <strong>{{ $broker }}</strong></div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="content" style="font-family: cursive;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline card-tabs">
                        <div class="card-header">
                            <canvas id="invoiceExpenseChart" height="100"></canvas>
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

            function updateLabel(start, end) {
                $('#dashboard-daterange').html(
                    start.format('MMMM D, YYYY') + ' ~ ' + end.format('MMMM D, YYYY')
                );
                $('#start_date').val(start.format('YYYY-MM-DD'));
                $('#end_date').val(end.format('YYYY-MM-DD'));
            }

            updateLabel(start, end);

            let chart;

            function renderChart(labels, expenses, invoices) {
                if (chart) {
                    chart.destroy();
                }

                const ctx = document.getElementById('invoiceExpenseChart').getContext('2d');
                chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                                label: 'Total Expense',
                                data: expenses,
                                borderColor: '#ffc107',
                                backgroundColor: '#ffc107',
                                fill: true
                            },
                            {
                                label: 'Total Invoice',
                                data: invoices,
                                borderColor: '#007bff',
                                backgroundColor: '#007bff',
                                fill: true
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }

            function fetchChartData(start, end) {
                $.ajax({
                    url: '/dashboard/chart-data',
                    type: 'GET',
                    data: {
                        start_date: start.format('YYYY-MM-DD'),
                        end_date: end.format('YYYY-MM-DD'),
                    },
                    success: function(res) {
                        renderChart(res.labels, res.expenses, res.invoices);
                    },
                    error: function() {
                        alert("Error loading chart data.");
                    }
                });
            }

            fetchChartData(start, end);

            $('#dashboard-daterange').daterangepicker({
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
                    .endOf('year')],
                }
            }, function(start, end) {
                updateLabel(start, end);
                fetchChartData(start, end);
            });
        });
    </script>
@endsection
