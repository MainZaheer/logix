@extends('master.layout')
@section('content')

@section('title', 'Brokers')

@php

if (isset($broker->id)) {
    $method = 'patch';
    $action = route('brokers.update', $broker->id);
    $title = 'Update Broker';
} else {
    $method = 'post';
    $action = route('brokers.store');
    $title = 'Add Broker';
}

@endphp

<section class="content-header" style="font-family: cursive;">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body" style="box-shadow: 2px 2px 0px 0px #007bff">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class=" text-primary "><i class="fas fa-user-check"></i> Brokers</h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"> <i class="fa fa-home text-primary"></i> <a
                                    href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Brokers</li>
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
                <h3><a href="{{ route('brokers.index') }}" class="btn btn-primary btn-sm"><i class="fa fa-angle-double-left"></i>
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
                                            value="{{ isset($broker->name) ? $broker->name : old('name') }}">
                                    </div>

                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Email --}}


                                <div class="col-md-6 mb-2">
                                    <label for="email">Email:*</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Enter email"
                                            value="{{ isset($broker->email) ? $broker->email : old('email') }}">
                                    </div>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                {{-- Phone --}}
                                <div class="col-md-6 mb-2">
                                    <label for="phone">Phone Number:*</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input type="number" class="form-control" id="phone" name="phone"
                                            placeholder="Enter Phome Number"
                                            value="{{ isset($broker->phone) ? $broker->phone : old('phone') }}">
                                    </div>
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="col-md-6 mb-2">
                                    <label for="country">Country</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="country" name="country"
                                            placeholder="Enter Country"
                                            value="{{ isset($broker->country) ? $broker->country : old('country') }}">
                                    </div>


                                    @error('country')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label for="state">State</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-volleyball-ball"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="state" name="state"
                                            placeholder="Enter state"
                                            value="{{ isset($broker->state) ? $broker->state : old('state') }}">
                                    </div>

                                    @error('state')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="col-md-6 mb-2">
                                     <label for="city">City</label>

                                     <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-city"></i></span>
                                        </div>
                                         <input type="text" class="form-control" id="city" name="city"
                                            placeholder="Enter city"
                                            value="{{ isset($broker->city) ? $broker->city : old('city') }}">
                                    </div>

                                      @error('city')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                </div>

                                <div class="col-md-6 mb-2">
                                        <label for="zip">Zip</label>

                                        <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-shield-alt"></i></span>
                                        </div>
                                         <input type="text" class="form-control" id="zip" name="zip"
                                            placeholder="Enter zip"
                                            value="{{ isset($broker->zip) ? $broker->zip : old('zip') }}">
                                    </div>
                                    @error('zip')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                </div>

                                <div class="col-md-6 mb-2">
                                        <label for="address">Address</label>
                                            <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-book"></i></span>
                                        </div>
                                         <input type="text" class="form-control" id="address" name="address"
                                            placeholder="Enter Address"
                                            value="{{ isset($broker->address) ? $broker->address : old('address') }}">
                                    </div>

                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                </div>

                                <div class="col-md-12 mt-3">
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
    </div>



@endsection


{{--
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("brokerForm");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        const broker = {};
        formData.forEach((value, key) => {
            broker[key] = value;
        });

        if (navigator.onLine) {
            // Online: Send to server
            saveBrokerOnline(broker);
        } else {
            // Offline: Save to localStorage
            saveBrokerOffline(broker);
        }
    });

    function saveBrokerOnline(broker) {
        fetch("{{ route('brokers.store') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify(broker)
        })
        .then(res => res.json())
        .then(data => {
            alert("Broker saved online.");
            window.location.href = "{{ route('brokers.index') }}";
        })
        .catch(err => {
            console.error("Error saving online. Saving offline...", err);
            saveBrokerOffline(broker);
        });
    }

    function saveBrokerOffline(broker) {
        let brokers = JSON.parse(localStorage.getItem("offline_brokers")) || [];
        brokers.push(broker);
        localStorage.setItem("offline_brokers", JSON.stringify(brokers));
        alert("You are offline. Broker saved locally.");
        // window.location.href = "{{ route('brokers.index') }}";
        form.reset();


    }

    function syncOfflineBrokers() {
        let brokers = JSON.parse(localStorage.getItem("offline_brokers")) || [];
        if (brokers.length === 0) return;

        brokers.forEach((broker, index) => {
            fetch("{{ route('brokers.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify(broker)
            })
            .then(response => response.json())
            .then(data => {
                console.log("Synced:", broker.name);
            })
            .catch(err => {
                console.error("Failed to sync broker:", broker.name);
            });
        });

        // Clear after sync
        localStorage.removeItem("offline_brokers");
    }

    // Sync when internet comes back
    window.addEventListener("online", syncOfflineBrokers);


}); --}}
