@extends('master.layout')
@section('content')

@section('title', 'Shipment List')


    <div class="content">
    <div class="card">
    <div class="card-header">
      <h3 class="card-title"><a href="{{ route('crainCharges.create') }}" class="btn btn-dark">Add Crain Charges</a></h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="crain_charges_table" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>Name</th>
          <th>Description</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>

        </tbody>

      </table>
    </div>
    <!-- /.card-body -->
  </div>


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
            $('#crain_charges_table').DataTable({
            "autoWidth": false,

                processing: true,
                serverSide: true,
                ajax: "{{ route('crainCharges.index') }}",
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'description', name: 'description' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
        });
    </script>


@endsection
