@extends('master.layout')
@section('content')

@section('title', 'Tracker Charges')
<section class="content-header" style="font-family: cursive;">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body" style="box-shadow: 2px 2px 0px 0px #007bff">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class=" text-primary "><i class="fas fa-truck"></i> Tracker Charges</h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"> <i class="fa fa-home text-primary"></i> <a
                                    href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Tracker Charges</li>
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
                <h3><a href="{{ route('trackerCharges.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>
                        Tracker Charges</a></h3>
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
                            <table id="tracker_charges_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                             <th>Name</th>
                                              <th>Status</th>
                                             <th>Description</th>

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
            $('#tracker_charges_table').DataTable({
               "autoWidth": false,
                processing: true,
                serverSide: true,
                ajax: "{{ route('trackerCharges.index') }}",
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'status', name: 'status' },
                    { data: 'description', name: 'description' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
        });
    </script>


@endsection
