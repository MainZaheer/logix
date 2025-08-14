<div class="modal fade" id="addCustomerNameModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Customer</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data" id="customerForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name">  First Name:* </label>
                                <input type="text" class="form-control" id="first_name" name="first_name"
                                    value="{{ old('first_name') }}" placeholder="Enter First Name">
                                    <span class="text-danger"></span>
                            </div>
                        </div>

                         <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name">  Last Name </label>
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                    value="{{ old('last_name') }}" placeholder="Enter Last Name">

                                    <span class="text-danger"></span>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email"> Email:* </label>
                                <input type="email" class="form-control" id="email"
                                    name="email" value="{{ old('email') }}"
                                    placeholder="Enter Email">

                                    <span class="text-danger"></span>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone"> Phone# </label>
                                <input type="number" class="form-control" id="phone" name="phone"
                                    value="{{ old('phone') }}" placeholder="Enter Phone Number">

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
