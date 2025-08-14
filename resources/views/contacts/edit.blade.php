@extends('master.layout')
@section('title', 'Update Contact')
@section('content')

    <section class="content-header" style="font-family: cursive;">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body" style="box-shadow: 2px 2px 0px 0px #adb5bd">
                    <div class="row">
                        <div class="col-sm-6">
                            <h5 class=" text-secondary "><i class="fas fa-address-book"></i> Contacts</h5>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"> <i class="fa fa-home text-secondary"></i> <a
                                        class = " text-secondary" href="{{ route('dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active">Contacts</li>
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
                    <h3><a href="{{ route('contacts.index') }}" class="btn btn-secondary btn-sm"><i
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
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Update Contact</h3>
                        </div>

                        <form action="{{ route('contacts.update', $contact->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">

                                    {{-- Name --}}
                                    <div class="col-md-4 mb-2">
                                        <label for="name">Name:*</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="name" id="name"
                                                value="{{ old('name', $contact->name) }}">
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
                                            <input type="email" class="form-control" name="email" id="email"
                                                value="{{ old('email', $contact->email) }}">
                                        </div>

                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    {{-- Type --}}

                                    <div class="col-md-4 mb-2">
                                        <label for="type">Type:*</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fab fa-firefox-browser"></i></span>
                                            </div>
                                            <select class="form-control" name="type" id="type">
                                                <option value="sender"
                                                    {{ old('type', $contact->type) === 'sender' ? 'selected' : '' }}>Sender
                                                </option>
                                                <option value="recipient"
                                                    {{ old('type', $contact->type) === 'recipient' ? 'selected' : '' }}>
                                                    Recipient</option>
                                            </select>
                                        </div>

                                        @error('type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>



                                    {{-- Phone --}}
                                    <div class="col-md-4 mb-2">
                                        <label for="phone">Phone Number</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="phone" id="phone"
                                                value="{{ old('phone', $contact->phone) }}">
                                        </div>

                                        @error('phone')
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
                                                placeholder="Enter Country"
                                                value="{{ old('country', $contact->country) }}">
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
                                                <span class="input-group-text"><i
                                                        class="fas fa-volleyball-ball"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="state" id="state"
                                                value="{{ old('state', $contact->state) }}">
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
                                                placeholder="Enter City" value="{{ old('city', $contact->city) }}">
                                        </div>

                                        @error('city')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>



                                    {{-- zip code --}}
                                    <div class="col-md-4 mb-2">
                                        <label for="zip">Zip Code</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-shield-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="zip" name="zip"
                                                placeholder="Enter Zip" value="{{ old('zip', $contact->zip) }}">
                                        </div>
                                        @error('zip')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Address --}}
                                    <div class="col-md-4 mb-2">
                                        <label for="address">Address</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-book"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="address" name="address"
                                                placeholder="Enter Address"
                                                value="{{ old('address', $contact->address) }}">
                                        </div>

                                        @error('address')
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
                                                    {{ old('status', $contact->status) == 'inactive' ? 'selected' : '' }}>
                                                    Inactive</option>
                                                <option value="active"
                                                    {{ old('status', $contact->status) == 'active' ? 'selected' : '' }}>
                                                    Active</option>
                                            </select>
                                        </div>

                                        @error('status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <div class="float-right">
                                            <button type="submit" class="btn btn-secondary  btn-sm">Submit</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
