@extends('master.layout')
@section('content')

@section('title', 'FUELS')

<?php

if (isset($fuel->id)) {
    $method = 'patch';
    $action = route('fuels.update', $fuel->id);
    $title = 'Update Fuels';
} else {
    $method = 'post';
    $action = route('fuels.store');
    $title = 'Add Fuels';
}

?>

<section class="content-header" style="font-family: cursive;">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body" style="box-shadow: 2px 2px 0px 0px #007bff">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class=" text-primary "><i class="fas fa-gas-pump"></i> Fuel</h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"> <i class="fa fa-home text-primary"></i> <a
                                    href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Fuel</li>
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
                <h3><a href="{{ route('fuels.index') }}" class="btn btn-primary btn-sm"><i
                            class="fa fa-angle-double-left"></i>
                        Back</a></h3>
            </div>
        </div>
    </div>
</section>



<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ $title }}</h3>
                    </div>

                    <form action="{{ $action }}" method="post">
                        @csrf
                        @if ($method === 'patch')
                            @method('PATCH')
                        @endif
                        <div class="card-body">
                            <div class="row">

                                {{-- NAME --}}

                                <div class="col-md-6 mb-2">
                                    <label for="name">Name:*</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Enter Name"
                                            value="{{ isset($fuel->name) ? $fuel->name : old('name') }}">
                                    </div>

                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>




                                {{-- Status --}}
                                <div class="col-md-6 mb-2">
                                    <label for="status">Status</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-id-badge"></i></span>
                                        </div>
                                        <select name="status" id="status" class="form-control">
                                            <option value="inactive"
                                                {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}
                                                selected>Active</option>
                                        </select>
                                    </div>

                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Desctiption --}}

                                <div class="col-md-6 mb-2">
                                    <label for="description">Desctiption</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-file-signature"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="description" name="description"
                                            placeholder="Desctiption"
                                            value="{{ isset($fuel->description) ? $fuel->description : old('description') }}">
                                    </div>

                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <div class="float-right">
                                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
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
