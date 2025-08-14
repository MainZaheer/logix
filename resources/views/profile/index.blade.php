@extends('master.layout')
@section('content')

@section('title', 'Profile Update')

<section class="content-header" style="font-family: cursive;">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body" style="box-shadow: 2px 2px 0px 0px #17a2b8">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class=" text-info "><i class="fas fa-users"></i> Profile Update</h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"> <i class="fa fa-home text-info"></i>
                                <a class="text-info" href="{{ route('dashboard') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Profile Update</li>
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
                        <h3 class="card-title">Profile Update</h3>
                    </div>

                    <form action="{{ route('user.profile.update') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                {{-- fas fa-user-secret --}}
                                {{-- NAME --}}

                                <div class="col-md-4 mb-2">
                                    <label for="name">Name:*</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-secret"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Enter Name"
                                            value="{{ isset($user->name) ? $user->name : old('name') }}" required>
                                    </div>

                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="col-md-4 mb-2">
                                    <label for="email">Email:*</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Enter Email"
                                            value="{{ isset($user->email) ? $user->email : old('email') }}" required>
                                    </div>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Country --}}

                                <div class="col-md-4 mb-2">
                                    <label for="country">Country</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="country" name="country"
                                            placeholder="Enter country"
                                            value="{{ isset($business->country) ? $business->country : old('country') }}">
                                    </div>

                                    @error('country')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- State --}}

                                <div class="col-md-4 mb-2">
                                    <label for="state">State</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-volleyball-ball"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="state" name="state"
                                            placeholder="Enter State"
                                            value="{{ isset($business->state) ? $business->state : old('state') }}">
                                    </div>

                                    @error('state')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- City --}}

                                <div class="col-md-4 mb-2">
                                    <label for="city">City</label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-city"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="city" name="city"
                                            placeholder="Enter City"
                                            value="{{ isset($business->city) ? $business->city : old('city') }}">
                                    </div>

                                    @error('city')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="col-md-12">
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
    @if (session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if (session('error'))
        toastr.error("{{ session('error') }}");
    @endif
</script>
@endsection
