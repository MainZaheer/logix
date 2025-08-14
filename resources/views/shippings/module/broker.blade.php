<div class="modal fade" id="createBrokerModal" tabindex="-1" role="dialog" aria-labelledby="createBrokerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document"> <!-- large size -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Broker</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="brokerForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        {{-- NAME --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name:*</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter Name">
                                    <span class="text-danger error-message"></span>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email:*</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter Email">
                                    <span class="text-danger error-message"></span>
                            </div>
                        </div>

                        {{-- Phone --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Phone#</label>
                                <input type="number" class="form-control" id="phone" name="phone"
                                    placeholder="Enter Phone">
                                    <span class="text-danger error-message"></span>
                            </div>
                        </div>

                        {{-- Country --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" id="country" name="country"
                                    placeholder="Enter Country">
                                    <span class="text-danger error-message"></span>
                            </div>
                        </div>

                        {{-- State --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="state">State</label>
                                <input type="text" class="form-control" id="state" name="state"
                                    placeholder="Enter State">
                                    <span class="text-danger error-message"></span>
                            </div>
                        </div>

                        {{-- City --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="city" name="city"
                                    placeholder="Enter City">
                                    <span class="text-danger error-message"></span>
                            </div>
                        </div>

                        {{-- Zip --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zip">Zip</label>
                                <input type="text" class="form-control" id="zip" name="zip"
                                    placeholder="Enter Zip">
                                    <span class="text-danger error-message"></span>
                            </div>
                        </div>

                        {{-- Address --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address"
                                    placeholder="Enter Address">
                                    <span class="text-danger error-message"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


