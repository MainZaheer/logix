@extends('master.layout')
@section('content')

@section('title', 'Customer')

<?php

if (isset($customer->id)) {
    $method = 'patch';
    $action = route('customers.update', $customer->id);
    $title = 'Update Customer';
} else {
    $method = 'post';
    $action = route('customers.store');
    $title = 'Add Customer';
}

?>

<section class="content-header" style="font-family: cursive;">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body" style="box-shadow: 2px 2px 0px 0px #17a2b8">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class=" text-info "><i class="fas fa-user-check"></i> Customers</h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"> <i class="fa fa-home text-info"></i>
                                <a class = " text-info" href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Customers</li>
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
                <h3><a href="{{ route('customers.index') }}" class="btn btn-info btn-sm"><i class="fa fa-angle-double-left"></i>
                        Back</a></h3>
            </div>
        </div>
    </div>
</section>


<section class="content">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
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

                            <div class="col-md-4 mb-2">
                                <label for="first_name">First Name:*</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="first_name"
                                        placeholder="Enter First Name"
                                        value="{{ isset($customer->first_name) ? $customer->first_name : old('first_name') }}">
                                    </div>

                                    @error('first_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="col-md-4 mb-2">
                                <label for="last_name">Last Name:*</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-injured"></i></span>
                                        </div>
                                         <input type="text" class="form-control" name="last_name"
                                        placeholder="Enter Last Name"
                                        value="{{ isset($customer->last_name) ? $customer->last_name : old('last_name') }}">
                                    </div>

                                    @error('last_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                 <div class="col-md-4 mb-2">
                                <label for="email">Email:*</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input type="email" class="form-control"  name="email"
                                        placeholder="Enter Email"
                                        value="{{ isset($customer->email) ? $customer->email : old('email') }}">
                                    </div>

                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                 <div class="col-md-4 mb-2">
                                <label for="phone">Phone Number</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                     <input type="number" class="form-control" name="phone"
                                        placeholder="Enter Last Name"
                                        value="{{ isset($customer->phone) ? $customer->phone : old('phone') }}">
                                    </div>

                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>




                        {{-- Status --}}

                         <div class="col-md-4 mb-2">
                                    <label for="status">Status</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-id-badge"></i></span>
                                        </div>
                                     <select name="status" id="status" class="form-control">
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }} selected>Active</option>
                                    </select>
                                    </div>

                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                         </div>


                            <div class="col-md-12 mt-3">
                                    <div class="float-right">
                                        <button type="submit" class="btn btn-info btn-sm">Submit</button>
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
</section>


@endsection

