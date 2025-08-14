@extends('master.layout')
@section('content')

@section('title', 'Crain Charges')

<?php

if (isset($crainCharges->id)) {
    $method = 'patch';
    $action = route('crainCharges.update', $crainCharges->id);
    $title = 'Update Crain Charges';
} else {
    $method = 'post';
    $action = route('crainCharges.store');
    $title = 'Add Crain Charges';
}

?>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ $title }}</h3>
                </div>

                <form action="{{ $action }}" method="post">
                    @csrf
                     @if($method === 'patch')
                     @method('PATCH')
                     @endif
                    <div class="card-body">
                        <div class="row">

                            {{-- NAME --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter Name"
                                        value="{{ isset($crainCharges->name) ? $crainCharges->name : old('name') }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                        {{-- Status --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }} selected>Active</option>
                                    </select>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            {{-- Desctiption --}}
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email">Desctiption</label>
                                    <input type="text" class="form-control" id="description" name="description"
                                        placeholder="Desctiption"
                                        value="{{ isset($crainCharges->description) ? $crainCharges->description : old('description') }}">
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>




                            <div class="col-md-12">
                                <div class="float-right">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>

                        </div>



                </form>
            </div>

        </div>
        <!--/.col (left) -->

    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->


@endsection

