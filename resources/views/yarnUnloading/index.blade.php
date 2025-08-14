@extends('master.layout')
@section('content')

@section('title', 'Shipment List')


    <div class="content">
    <div class="card">
    <div class="card-header">
      <h3 class="card-title"><a href="{{ route('yarnUnloading.create') }}" class="btn btn-dark">Add Yarn Unloading</a></h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="yarn_unloading_table" class="table table-bordered table-striped">
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
            $('#yarn_unloading_table').DataTable({
               "autoWidth": false,
                processing: true,
                serverSide: true,
                ajax: "{{ route('yarnUnloading.index') }}",
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
