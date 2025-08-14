<div class="modal fade" id="addClearingAgent" tabindex="-1" role="dialog" aria-labelledby="addClearingAgentLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document"> <!-- large size -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Clearing Agent</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="clearingAgentForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        {{-- NAME --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Name:*</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter Name">
                                    <span class="text-danger error-message"></span>
                            </div>
                        </div>

                        {{-- Desctiption --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Desctiption</label>
                                <input type="text" class="form-control" id="description" name="description"
                                    placeholder="Desctiption" value="{{ old('description') }}">
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
