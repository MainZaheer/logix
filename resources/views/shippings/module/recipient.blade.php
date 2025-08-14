<div class="modal fade" id="recipientModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create a new Recipient/Client</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data" id="recipientForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name"> Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name') }}" placeholder="Enter Name">
                                    <span class="text-danger error-message"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email_address"> Email </label>
                                <input type="email" class="form-control" id="email"
                                    name="email" value="{{ old('email') }}"
                                    placeholder="Enter Email">
                                    <span class="text-danger error-message"></span>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone"> Phone Number </label>
                                <input type="number" class="form-control" id="phone"
                                    name="phone" value="{{ old('phone') }}"
                                    placeholder="Enter Phone Number">
                                    <span class="text-danger"></span>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="country"> Country</label>
                                <input type="text" class="form-control" id="country"
                                    name="country" value="{{ old('country') }}"
                                    placeholder="Enter Country">
                                    <span class="text-danger"></span>

                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="state"> State</label>
                                <input type="text" class="form-control" id="state"
                                    name="state" value="{{ old('state') }}"
                                    placeholder="Enter State">
                                <span class="text-danger"></span>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city"> City</label>
                                <input type="text" class="form-control" id="city" name="city"
                                    value="{{ old('city') }}" placeholder="Enter City">
                                         <span class="text-danger"></span>

                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zip"> Zip</label>
                                <input type="text" class="form-control" id="zip" name="zip"
                                    value="{{ old('zip') }}" placeholder="Enter Zip">
                                     <span class="text-danger"></span>

                            </div>
                        </div>

                        {{-- ADDRESS --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address"> Address </label>
                                <input type="text" class="form-control" id="address"
                                    name="address" value="{{ old('address') }}"
                                    placeholder="Enter Country">

                                    <span class="text-danger"></span>

                            </div>
                        </div>


                        {{-- Status --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                        Inactive</option>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}
                                        selected>Active</option>
                                </select>
                                        <span class="text-danger"></span>

                            </div>
                        </div>


                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
