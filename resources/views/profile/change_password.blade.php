@extends('master.layout')
@section('content')

@section('title', 'Change Password')

<section class="content-header" style="font-family: cursive;">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body" style="box-shadow: 2px 2px 0px 0px #17a2b8">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class=" text-info "><i class="fas fa-bug"></i> Update Password</h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"> <i class="fa fa-home text-info"></i>
                                <a class="text-info" href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Update Password</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="content">
<div class="container-fluid mt-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Change Password</h3>
                </div>

                <form action="{{ route('user.change_password') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="row">

                            {{-- Current Password--}}

                            <div class="col-md-4 mb-2">
                                    <label for="old_passwrod">Current Password:*</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-fingerprint"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="current_password" name="current_password" required>
                                    </div>

                                   @error('current_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                             </div>




                            {{-- New Password --}}

                            <div class="col-md-4 mb-2">
                                 <label for="new_password">New Password:*</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-lock"></i></span>
                                        </div>
                                        <input type="password" class="form-control" id="new_password" name="new_password"required>
                                    </div>

                                   @error('new_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                             </div>


                            {{-- Confirm Password --}}

                             <div class="col-md-4 mb-2">
                                 <label for="passwrod">Confirm Password:*</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-shield"></i></span>
                                        </div>
                                        <input type="password" class="form-control" id="passwrod" name="new_password_confirmation"required>
                                    </div>

                                   @error('new_password_confirmation')
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
@section('script')
<script>

@if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif

</script>
@endsection
