@extends('master.layout')
@section('content')

@section('title', 'Update Job')

 <section class="content-header" style="font-family: cursive;">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body" style="box-shadow: 2px 2px 0px 0px #17a2b8">
                    <div class="row">
                        <div class="col-sm-6">
                            <h5 class="text-info"><i class="fas fa-shipping-fast"></i> Record Shipment </h5>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"> <i class="fa fa-home text-info"></i> <a class = " text-info"
                                        href="{{ route('dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active">Record Shipment</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<section class="content">
    <div class="container-fluid">
<form action="" method="post" id="shipmentEditForm">
    @csrf
    <input type="hidden" value="{{ $shipment->id }}" id="shipment_id">


    <div class="card card-light">
        <div class="card-header">
            <h3 class="card-title">Edit Job</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            {{-- Row 1 --}}
            <div class="row">
                {{-- Date --}}
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="date">Date <span style="color: red">*</span></label>
                        <input type="date" class="form-control" id="date" name="date"
                            value="{{ isset($shipment->date) ? date('Y-m-d', strtotime($shipment->date)) : old('date') }}">

                        <span class="text-danger error-message"></span>

                    </div>
                </div>

                {{-- Job No. --}}
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="job_no">Job No.</label>
                        <input type="text" class="form-control" id="job_no" name="job_no" readonly
                            value="{{ isset($shipment->job_no) ? $shipment->job_no : old('job_no') }}">
                        <span class="job_number" style="font-family: monospace;color: gray;">Job number auto
                            genrate</span><br>
                        <span class="text-danger error-message"></span>
                    </div>
                </div>



                {{-- IMPORT/EXPORT --}}
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="import_export">IMPORT/EXPORT <span style="color: red">*</span></label>
                        <select name="import_export" id="import_export" class="form-control select2">
                            <option value="">Select IMPORT/EXPORT</option>
                            <option value="import" {{ $shipment->import_export == 'import' ? 'selected' : '' }}>IMPORT
                            </option>
                            <option value="export" {{ $shipment->import_export == 'export' ? 'selected' : '' }}>EXPORT
                            </option>

                        </select>
                        <span class="text-danger error-message"></span>

                    </div>
                </div>


                {{-- Bill No. --}}
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="bill_no">CRO/BL #</label>
                        <input type="text" class="form-control" id="bill_no" name="bill_no"
                            value="{{ isset($shipment->bill_no) ? $shipment->bill_no : old('bill_no') }}">


                        <span class="text-danger error-message"></span>

                    </div>
                </div>


                {{-- L/C No. --}}
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="lc_no">LC #</label>
                        <input type="text" class="form-control" id="lc_no" name="lc_no"
                            value="{{ isset($shipment->lc_no) ? $shipment->lc_no : old('lc_no') }}">
                        <span class="text-danger error-message"></span>

                    </div>
                </div>

                {{-- SHIPPING LINE --}}
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="shipping_line">Shipping Line</label>
                        <input type="text" class="form-control" id="shipping_line" name="shipping_line"
                            value="{{ isset($shipment->shipping_line) ? $shipment->shipping_line : old('shipping_line') }}">

                        <span class="text-danger error-message"></span>

                    </div>
                </div>


                <div class="col-md-3">
                    <div class="form-group">
                        <label for="gate_pass_id">Gate Pass <span style="color: red">*</span></label>
                        <div class="input-group">
                            <select class="form-control select2" id="gatePass_id" name="gate_pass_id">
                                <option value="">Select Gate Pass</option>
                                @foreach ($gatepasses as $gatepass)
                                    <option
                                        value="{{ $gatepass->id }}"{{ $shipment->gate_pass_id == $gatepass->id ? 'selected' : '' }}>
                                        {{ $gatepass->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button type="button" id="gatePassBtn" class="btn btn-outline-primary"
                                    data-toggle="modal" data-target="#addGatePassModal">
                                    +
                                </button>
                            </div>
                        </div>
                        <span class="text-danger error-message"></span>

                    </div>
                </div>


                <div class="col-md-3">
                    <div class="form-group">
                        <label for="clearingAgent_id">Clearing Agent <span style="color: red">*</span></label>

                        <div class="input-group">
                            <select class="form-control select2" id="clearingAgent_id" name="clearing_agent_id">
                                <option value="">Select Clearing Agent</option>
                                @foreach ($clearingagents as $clearingAgent)
                                    <option value="{{ $clearingAgent->id }}"
                                        {{ $shipment->clearing_agent_id == $clearingAgent->id ? 'selected' : '' }}>
                                        {{ $clearingAgent->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button type="button" id="ClearingAgentbtn" class="btn btn-outline-primary"
                                    data-toggle="modal" data-target="#addClearingAgent">
                                    +
                                </button>
                            </div>
                        </div>
                        <span class="text-danger error-message"></span>

                    </div>
                </div>



                {{-- Customer --}}

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="customer_id">Customer Name <span style="color: red">*</span></label>
                        <div class="input-group">
                            <select class="form-control select2" id="customer_id" name="customer_id">
                                <option value="">Select Customer Name</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                        {{ $shipment->customer_id == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->first_name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button type="button" id="Customertbtn" class="btn btn-outline-primary"
                                    data-toggle="modal" data-target="#addCustomerNameModal">
                                    +
                                </button>
                            </div>
                        </div>
                        <span class="text-danger error-message"></span>

                    </div>
                </div>

                {{-- Payment Method --}}

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="payment">Payment Methods <span style="color: red">*</span></label>
                        <select name="payment" id="payment" class="form-control select2">
                            <option value="">Select Payment</option>
                            <option value="credit" {{ $shipment->payment == 'credit' ? 'selected' : '' }}>PAID
                            </option>
                            <option value="cash" {{ $shipment->payment == 'cash' ? 'selected' : '' }}>TOPAY</option>

                        </select>
                        <span class="text-danger error-message"></span>

                    </div>
                </div>


                {{-- Container Type --}}
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="container_type">Container Type <span style="color: red">*</span></label>
                        <input type="text" class="form-control" id="container_type" name="container_type"
                            value="{{ isset($shipment->container_type) ? $shipment->container_type : old('container_type') }}">
                        <span class="text-danger error-message"></span>

                    </div>
                </div>

                {{-- Container Number --}}
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="container_number">Container Number <span style="color: red">*</span></label>
                        <select class="form-control select2 container_number" id="container_number"
                            name="container_number">
                            <option value="">Select Container Number</option>
                            @for ($i = 1; $i <= 50; $i++)
                                <option value="{{ $i }}"
                                    {{ $shipment->container_number == $i ? 'selected' : '' }}>{{ $i }}
                                </option>
                            @endfor
                        </select>
                        {{-- <input type="hidden" name="container_number_hide" id="hide_container_number"> --}}
                        <span class="text-danger error-message"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-light" id="conatinerDive" style="display: none;">
        <div class="card-body">
            <div class="row" id="containerInputs">

            </div>
            <Button type="button" class="btn btn-success" id="btnSave">Save <span
                    id="saveSuccess"></span></Button>

        </div>
    </div>



    {{-- Package Information --}}

    <div class="card card-light">
        <div class="card-header">
            <h4 class="card-title"><i class="fa fa-bookmark" style="color:#36bea6"></i> Bilty Details
            </h4>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <div class="card-body" id="field-container">
            @foreach ($shipment->details as $detail)
                <input type="hidden" name="detail_id[]" value="{{ $detail->id }}">
                <div class="row field-group bilty-expense-group bilty_expense_group_{{ $loop->index }}">
                    {{-- No. of Packages --}}
                    <div class="col-md-3 package-field">
                        <div class="form-group">
                            <label for="no_of_packges">No. of Packages <span style="color: red">*</span></label>
                            <input type="text" class="form-control no_of_packges" name="no_of_packges[]"
                                value="{{ isset($detail->no_of_packges) ? $detail->no_of_packges : old('no_of_packges') }}">
                            <span class="text-danger error-message"></span>

                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="description">Package Description <span style="color: red">*</span></label>
                            <input type="text" class="form-control" name="description[]"
                                value="{{ isset($detail->description) ? $detail->description : old('description') }}">


                            <span class="text-danger error-message"></span>

                        </div>
                    </div>



                    {{-- Bilty Number --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="bilty_number">Bilty# <span style="color: red">*</span></label>
                            <input type="text" class="form-control bilty_number" id="bilty_number"
                                name="bilty_number[]"
                                value="{{ isset($detail->bilty_number) ? $detail->bilty_number : old('bilty_number') }}">
                            <span class="text-danger error-message"></span>

                        </div>
                    </div>


                    {{-- Sendar --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="sendar_id">Sender Name <span style="color: red">*</span></label>
                            <div class="input-group sender-group">
                                <select name="sendar_id[]" id="sendar_id" class="form-control select2 sendar_id">
                                    <option value="">Select Sender Name</option>
                                    @foreach ($sendars as $sender)
                                        <option value="{{ $sender->id }}"
                                            {{ $detail->sendar_id == $sender->id ? 'selected' : '' }}>
                                            {{ $sender->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-primary open-sender-modal"
                                        data-toggle="modal" data-target="#senderModal">
                                        +
                                    </button>
                                </div>
                            </div>

                            <span class="text-danger error-message"></span>



                        </div>
                    </div>

                    {{-- Recipient --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="recipient_id">Recipient Name <span style="color: red">*</span></label>
                            <div class="input-group recipient-group">

                                <select name="recipient_id[]" id="recipient_id"
                                    class="form-control select2 recipient_id">
                                    <option value="">Select Recipient Name</option>
                                    @foreach ($recipients as $recipient)
                                        <option value="{{ $recipient->id }}"
                                            {{ $detail->recipient_id == $recipient->id ? 'selected' : '' }}>
                                            {{ $recipient->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="input-group-append open-recipient-modal">
                                    <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                        data-target="#recipientModal">
                                        +
                                    </button>
                                </div>
                            </div>
                            <span class="text-danger error-message"></span>

                        </div>
                    </div>

                    {{-- FROM LOCATION --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="from_location">From Location <span style="color: red">*</span></label>
                            <input type="text" class="form-control" name="from_location[]"
                                value="{{ isset($detail->from_location) ? $detail->from_location : old('from_location') }}">

                            <span class="text-danger error-message"></span>

                        </div>
                    </div>

                    {{-- TO LOCATION --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="to_location">To Location <span style="color: red">*</span></label>
                            <input type="text" class="form-control" name="to_location[]"
                                value="{{ isset($detail->to_location) ? $detail->to_location : old('to_location') }}">

                            <span class="text-danger error-message"></span>

                        </div>
                    </div>

                    {{-- Broker Dropdown --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="broker_id">Broker <span style="color: red">*</span></label>
                            <div class="input-group broker-group">
                                <select class="form-control select2 broker_id" name="broker_id[]">
                                    <option value="">Select Broker</option>
                                    @foreach ($brokers as $broker)
                                        <option value="{{ $broker->id }}"
                                            {{ $detail->broker_id == $broker->id ? 'selected' : '' }}>
                                            {{ $broker->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="input-group-append open-broker-modal">
                                    <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                        data-target="#createBrokerModal">
                                        +
                                    </button>
                                </div>
                            </div>
                            <span class="text-danger error-message"></span>

                        </div>
                    </div>

                    {{-- Vehicle --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="vehicle_no">Vehicle Number <span style="color: red">*</span></label>
                            <input type="text" class="form-control" name="vehicle_no[]"
                                value="{{ isset($detail->vehicle_no) ? $detail->vehicle_no : old('vehicle_no') }}">
                            <span class="text-danger error-message"></span>

                        </div>
                    </div>


                    {{-- Driver No. --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="driver_no">Vehicle Driver <span style="color: red">*</span></label>
                            <input type="text" class="form-control" name="driver_no[]"
                                value="{{ isset($detail->driver_no) ? $detail->driver_no : old('driver_no') }}">

                            <span class="text-danger error-message"></span>

                        </div>
                    </div>


                    {{-- VEHICLE FREIGHT link with booker --}}
                    <div class="col-md-3">
                        <div class="form-group expense-group">
                            <label for="booker_vhicle_freight_amount">VEHICLE FREIGHT</label>

                            <input type="number" class="form-control booker_vhicle_freight_amount"
                                id="booker_vhicle_freight_amount" name="booker_vhicle_freight_amount[]"
                                value="{{ isset($detail->booker_vhicle_freight_amount) ? $detail->booker_vhicle_freight_amount : old('booker_vhicle_freight_amount', 0) }}">
                            <span class="text-danger error-message"></span>

                        </div>
                    </div>








                    @php
                        $selectedContainers = is_array($detail->bilty_container_number)
                            ? $detail->bilty_container_number
                            : json_decode($detail->bilty_container_number ?? '[]', true);
                    @endphp



                    <div class="col-md-3 row-warap">
                        <div class="form-group">
                            <label for="bilty_container_number">Bilty Container Number <span style="color: red">*</span></label>

                            <select class="form-control bilty_container_number select2"
                                name="bilty_container_number[{{ $loop->index }}][]" multiple="multiple"
                                style="width:100%;">

                                @foreach ($selectedContainers as $container)
                                    <option value="{{ $container }}" selected>{{ $container }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>




                    {{-- MT Return place --}}
                    <div class="col-md-3">
                        <div class="form-group expense-group">
                            <label for="mt_return_place">MT Return Place</label>
                            <input type="text" class="form-control mt_return_place" id="mt_return_place"
                                name="mt_return_place[]"
                                value="{{ old('mt_return_place.' . $loop->index, $detail->mt_return_place ?? '') }}">
                            <span class="text-danger error-message"></span>
                        </div>
                    </div>


                    {{--   MT CHARGES link with booker --}}
                    <div class="col-md-3">
                        <div class="form-group expense-group">
                            <label for="booker_mt_charges_amount"> MT CHARGES </label>
                            <input type="number" class="form-control booker_mt_charges_amount"
                                id="booker_mt_charges_amount" name="booker_mt_charges_amount[]"
                                value="{{ isset($detail->booker_mt_charges_amount) ? $detail->booker_mt_charges_amount : old('booker_mt_charges_amount', 0) }}">

                            <span class="text-danger error-message"></span>

                        </div>
                    </div>


                    {{-- Gate pass charges link with gate pass --}}

                    <div class="col-md-3">
                        <div class="form-group expense-group">
                            <label for="mt_return_place">Gate Pass Charges</label>
                            <input type="number" class="form-control gate_pass_amount" id="gate_pass_amount"
                                name="gate_pass_amount[]"
                                value="{{ isset($detail->gate_pass_amount) ? $detail->gate_pass_amount : old('gate_pass_amount', 0) }}">

                            <span class="text-danger error-message"></span>

                        </div>
                    </div>


                    {{-- LIFTER CHARGES --}}
                    <div class="col-md-3">
                        <div class="form-group expense-group">
                            <label for="lifter_charges_id">Lifter/Crane Charges</label>
                            <div class="input-group lifter_charges_group">
                                <select class="form-control select2 lifter_charges_id" id="lifter_charges_id"
                                    name="lifter_charges_id[]">
                                    <option value="">Select Lifter Charges</option>
                                    @foreach ($lifterCharges as $lif)
                                        <option value="{{ $lif->id }}"
                                            {{ $detail->lifter_charges_id == $lif->id ? 'selected' : '' }}>
                                            {{ $lif->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="input-group-append open-lifter-charges-modal">
                                    <button type="button" id="lifterChargesBtn" class="btn btn-outline-primary"
                                        data-toggle="modal" data-target="#addLifterCharges">
                                        +
                                    </button>
                                </div>
                            </div>
                            <span class="text-danger error-message"></span>


                            <input type="number" class="form-control lifter_charges_amount"
                                id="lifter_charges_amount" name="lifter_charges_amount[]"
                                value="{{ isset($detail->lifter_charges_amount) ? $detail->lifter_charges_amount : old('lifter_charges_amount', 0) }}">


                        </div>
                    </div>


                    {{-- Labour CHARGES --}}
                    <div class="col-md-3">
                        <div class="form-group expense-group">
                            <label for="labour_charges_id">Labour Charges</label>
                            <div class="input-group labour_charges_group">
                                <select class="form-control select2 labour_charges_id" id="labour_charges_id"
                                    name="labour_charges_id[]">
                                    <option value="">Select Labour Charges</option>
                                    @foreach ($labourCharges as $lab)
                                        <option value="{{ $lab->id }}"
                                            {{ $detail->labour_charges_id == $lab->id ? 'selected' : '' }}>
                                            {{ $lab->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="input-group-append open-labour-charges-modal">
                                    <button type="button" id="labourChargesBtn" class="btn btn-outline-primary"
                                        data-toggle="modal" data-target="#addLabourCharges">
                                        +
                                    </button>
                                </div>
                            </div>
                            <span class="text-danger error-message"></span>


                            <input type="number" class="form-control labour_charges_amount"
                                id="labour_charges_amount" name="labour_charges_amount[]"
                                value="{{ isset($detail->labour_charges_amount) ? $detail->labour_charges_amount : old('labour_charges_amount', 0) }}">


                        </div>
                    </div>

                    {{-- LOCAL CHARGES --}}
                    <div class="col-md-3">
                        <div class="form-group expense-group">
                            <label for="local_charges_id">Local Charges</label>
                            <div class="input-group local_charges_group">
                                <select class="form-control select2 local_charges_id" id="local_charges_id"
                                    name="local_charges_id[]">
                                    <option value="">Select Local Charges</option>
                                    @foreach ($localCharges as $localc)
                                        <option value="{{ $localc->id }}"
                                            {{ $detail->local_charges_id == $localc->id ? 'selected' : '' }}>
                                            {{ $localc->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="input-group-append open_local_charges_modal">
                                    <button type="button" id="localChargesBtn" class="btn btn-outline-primary"
                                        data-toggle="modal" data-target="#addLocalCharges">
                                        +
                                    </button>
                                </div>
                            </div>
                            <span class="text-danger error-message"></span>


                            <input type="number" class="form-control local_charges_amount" id="local_charges_amount"
                                name="local_charges_amount[]"
                                value="{{ isset($detail->local_charges_amount) ? $detail->local_charges_amount : old('local_charges_amount', 0) }}">


                        </div>
                    </div>

                    {{-- PARTY COMMISION CHARGES --}}

                    <div class="col-md-3">
                        <div class="form-group expense-group">
                            <label for="party_commission_charges_id">Party Commission <span style="color: red">*</span></label>
                            <div class="input-group party_commission_charges_group">
                                <select class="form-control select2 party_commission_charges_id"
                                    id="party_commission_charges_id" name="party_commission_charges_id[]">
                                    <option value="">Select Party Commission Charges</option>
                                    @foreach ($partyCommissionCharges as $partyc)
                                        <option value="{{ $partyc->id }}"
                                            {{ $detail->party_commission_charges_id == $partyc->id ? 'selected' : '' }}>
                                            {{ $partyc->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="input-group-append open_party_commission_charges_modal">
                                    <button type="button" id="partyCommissionChargesBtn"
                                        class="btn btn-outline-primary" data-toggle="modal"
                                        data-target="#addPartyCommissionCharges">
                                        +
                                    </button>
                                </div>
                            </div>
                            <span class="text-danger error-message"></span>


                            <input type="number" class="form-control party_commision_charges_amount"
                                id="party_commision_charges_amount" name="party_commision_charges_amount[]"
                                value="{{ isset($detail->party_commision_charges_amount) ? $detail->party_commision_charges_amount : old('party_commision_charges_amount', 0) }}">


                        </div>
                    </div>

                    {{-- TRACKER CHARGES --}}

                    <div class="col-md-3">
                        <div class="form-group expense-group">
                            <label for="tracker_charges_id">Tracker Charges <span style="color: red">*</span></label>
                            <div class="input-group tracker_charges_group">
                                <select class="form-control select2 tracker_charges_id" id="tracker_charges_id"
                                    name="tracker_charges_id[]">
                                    <option value="">Select Tracker Charges</option>
                                    @foreach ($trackerCharges as $trackerc)
                                        <option value="{{ $trackerc->id }}"
                                            {{ $detail->tracker_charges_id == $trackerc->id ? 'selected' : '' }}>
                                            {{ $trackerc->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="input-group-append open_tracker_charges_modal">
                                    <button type="button" id="trackerChargesBtn" class="btn btn-outline-primary"
                                        data-toggle="modal" data-target="#addTrackerCharges">
                                        +
                                    </button>
                                </div>
                            </div>
                            <span class="text-danger error-message"></span>


                            <input type="number" class="form-control tracker_charges_amount"
                                id="tracker_charges_amount" name="tracker_charges_amount[]"
                                value="{{ isset($detail->tracker_charges_amount) ? $detail->tracker_charges_amount : old('tracker_charges_amount', 0) }}">

                        </div>
                    </div>

                    {{-- OTHER CHARGES --}}

                    <div class="col-md-3">
                        <div class="form-group expense-group">
                            <label for="other_charges_id">Other Charges</label>
                            <div class="input-group other_charges_group">
                                <select class="form-control select2 other_charges_id" id="other_charges_id"
                                    name="other_charges_id[]">
                                    <option value="">Select Other Charges</option>
                                    @foreach ($otherCharges as $otherc)
                                        <option value="{{ $otherc->id }}"
                                            {{ $detail->other_charges_id == $otherc->id ? 'selected' : '' }}>
                                            {{ $otherc->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="input-group-append open_other_charges_modal">
                                    <button type="button" id="otherChargesBtn" class="btn btn-outline-primary"
                                        data-toggle="modal" data-target="#addOtherCharges">
                                        +
                                    </button>
                                </div>
                            </div>
                            <span class="text-danger error-message"></span>


                            <input type="number" class="form-control other_charges_amount" id="other_charges_amount"
                                name="other_charges_amount[]"
                                value="{{ isset($detail->other_charges_amount) ? $detail->other_charges_amount : old('other_charges_amount', 0) }}">
                        </div>
                    </div>

                    {{-- Expence Amount --}}

                    <div class="col-md-3">

                        <div class="form-group expense-group">
                            <label for="expence_amount">Expence Amount</label>
                            <input type="number" class="form-control expence_amount"
                                name="bilty_expence_amount[]"
                                value="{{ isset($detail->bilty_expence_amount) ? $detail->bilty_expence_amount : old('bilty_expence_amount', 0) }}"
                                readonly>
                        </div>
                    </div>

                    {{-- Invoice Amount --}}
                    <div class="col-md-3">
                        <div class="form-group expense-group">
                            <label for="invoice_amount">Invoice Amount <span style="color: red">*</span></label>
                            <input type="number" class="form-control bilty_invoice_amount"
                                name="bilty_invoice_amount[]"
                                value="{{ isset($detail->bilty_invoice_amount) ? $detail->bilty_invoice_amount : old('invoice_amount', 0) }}">
                        </div>
                    </div>

                    {{-- To-Pay Amount --}}
                    <div class="col-md-3">
                        <div class="form-group expense-group">
                            <label for="to_pay_amount">To-Pay Amount</label>
                            <input type="number" class="form-control bilty_to_pay_amount"
                                name="bilty_to_pay_amount[]"
                                value="{{ isset($detail->bilty_to_pay_amount) ? $detail->bilty_to_pay_amount : old('to_pay_amount', 0) }}">
                        </div>
                    </div>

                    {{-- Total Amount --}}

                    @php

                        $total =
                            $detail->bilty_invoice_amount -
                            $detail->bilty_expence_amount -
                            $detail->bilty_to_pay_amount;

                    @endphp


                    {{-- Total Amount --}}
                    <div class="col-md-12">
                        <div class="form-group expense-group">
                            <label for="total_amount">Total Amount</label>
                            <p>Invoice Amount - TO-PAY BILL AMOUNT - Total Expence Charegs</p>
                            <input type="text" class="form-control bilty_total_amount" name="bilty_total_amount[]"
                                value="{{ $detail->bilty_invoice_amount . '- ' . $detail->bilty_expence_amount . '- ' . $detail->bilty_to_pay_amount . '= ' . $total }}"
                                readonly>
                        </div>
                    </div>


                </div>

                {{-- <hr class="head-line" style="background:#000000; height:1px; border:none; margin:10px 0;"> --}}
            @endforeach

        </div>
    </div>

    <label for="expence_amount" style="display: none;"> total_expence_amount
        <input type="hidden" name="total_expence_amount" class="total_expence_amount"
            value="{{ $shipment->total_expence_amount }}">
    </label>
    <label for="total_invoice_amount" style="display: none;">total_invoice_amount

        <input type="hidden" name="total_invoice_amount" class="total_invoice_amount"
            value="{{ $shipment->total_invoice_amount }}">
    </label>
    <label for="total_to_pay_amount" style="display: none;">total_to_pay_amount
        <input type="hidden" name="total_to_pay_amount" class="total_to_pay_amount"
            value="{{ $shipment->total_to_pay_amount }}">
    </label>
    {{-- Buttons --}}
    {{-- Submit Button --}}
    <div class="col-md-12 text-left mb-5">
        <button type="button" class="btn btn-success btn-sm" id="addMoreBtn">+ Add More</button>
        <button type="submit" class="btn btn-info btn-sm">Update Shipment</button>

    </div>


</form>


@include('shippings.module.broker')
@include('shippings.module.gatepass')
@include('shippings.module.cleaning_agent')
@include('shippings.module.sender')
@include('shippings.module.recipient')
@include('shippings.module.lifter_charges')
@include('shippings.module.labour_charges')
@include('shippings.module.local_charges')
@include('shippings.module.party_commission_charges')
@include('shippings.module.tracker_charges')
@include('shippings.module.other_charges')
@include('shippings.module.customers')

<div class="printContainer" style="display: none;"></div>

    </div>
</section>

@endsection
@section('script')

<script src="{{ asset('shipment.js') }}"></script>


@endsection
