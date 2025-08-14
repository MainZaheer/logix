@extends('master.layout')
@section('content')

@section('title', 'Accounts')

<?php

if (isset($account->id)) {
    $method = 'patch';
    $action = route('accounts.update', $account->id);
    $title = 'Update Account';
} else {
    $method = 'post';
    $action = route('accounts.store');
    $title = 'Add Account';
}

?>


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
                                <a class="text-danger" href="{{ route('dashboard') }}">Home</a>
                            </li>
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
                <h3><a href="{{ route('accounts.index') }}" class="btn btn-danger btn-sm"><i
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
                <div class="card card-danger">
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

                                <div class="col-md-4 mb-2">
                                    <label for="account_name">Account Name:*</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-landmark"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="account_name" name="account_name"
                                            placeholder="Enter Account Name"
                                            value="{{ isset($account->account_name) ? $account->account_name : old('account_name') }}">
                                    </div>
                                    @error('account_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>



                                {{-- Account Number --}}

                                 <div class="col-md-4 mb-2">
                                    <label for="account_number">Account Number:*</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-credit-card"></i></span>
                                        </div>
                                        <input type="number" class="form-control" id="account_number"
                                            name="account_number" placeholder="Enter Account Number"
                                            value="{{ isset($account->account_number) ? $account->account_number : old('account_number') }}">
                                    </div>
                                    @error('account_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                </div>





                                {{-- Account Type --}}

                                 <div class="col-md-4 mb-2">
                                    <label for="account_type">Account Type:*</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-book"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="account_type" name="account_type"
                                            placeholder="Enter Account Type"
                                            value="{{ isset($account->account_type) ? $account->account_type : old('account_type') }}">
                                    </div>
                                     @error('account_type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                </div>


                                {{-- Opeing Balance --}}

                                <div class="col-md-4 mb-2">
                                    <label for="balance">Opeing Balance</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-money-check-alt"></i></span>
                                        </div>

                                        <input type="text" class="form-control" id="balance" name="balance"
                                            placeholder="Enter Opeing Balance"
                                            value="{{ isset($account->transactions[0]['amount']) ? $account->transactions[0]['amount'] : old('balance') }}"
                                            @if (!empty($account->transactions[0]['amount']) && $account->transactions[0]['amount'] > 0) readonly @endif>
                                    </div>

                                        @error('balance')
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




                                {{-- Description --}}

                                <div class="col-md-4 mb-2">
                                    <label for="description">Description</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-receipt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="description" name="description"
                                            placeholder="Enter description"
                                            value="{{ isset($account->description) ? $account->description : old('description') }}">
                                    </div>
                                     @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                </div>



                                <div class="col-md-12 mt-3">
                                    <div class="float-right">
                                        <button type="submit" class="btn btn-danger btn-sm">Submit</button>
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
