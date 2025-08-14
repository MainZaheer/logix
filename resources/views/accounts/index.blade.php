@extends('master.layout')
@section('content')

@section('title', 'Account List')

<section class="content-header" style="font-family: cursive;">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body" style="box-shadow: 2px 2px 0px 0px #dc3545">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="text-danger"><i class="fas fa-coins"></i> Accounts</h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"> <i class="fa fa-home text-danger"></i>
                                <a class="text-danger"
                                    href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Accounts</li>
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
                <h3><a href="{{ route('accounts.create') }}" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i>
                        Add Accounts</a></h3>
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
                            <table id="account_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                       <th>Name</th>
                                        <th>Account Number</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        {{-- <th>Opening Balance</th> --}}
                                        <th>Status</th>
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

@endsection
@section('script')
<script>

@if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif

        $(document).ready(function () {
            $('#account_table').DataTable({
               "autoWidth": false,
                processing: true,
                serverSide: true,
                ajax: "{{ route('accounts.index') }}",
                columns: [
                    { data: 'account_name', name: 'account_name' },
                    { data: 'account_number', name: 'account_number' },
                    { data: 'account_type', name: 'account_type' },
                    { data: 'balance', name: 'balance' },
                    // { data: 'opening_belance', name: 'opening_belance' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
        });


    </script>


@endsection
