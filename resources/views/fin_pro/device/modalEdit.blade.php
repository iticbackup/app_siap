<div class="modal fade modalEdit" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="exampleModalCenterTitle">Edit Device</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-update" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="edit_dev_id" id="edit_dev_id">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Device Name</label>
                            <input type="text" name="edit_device_name" class="form-control" id="edit_device_name" placeholder="Device Name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Device</label>
                            <select name="edit_device_id" id="edit_device_id" class="form-control">
                                <option value="">-- Pilih Device --</option>
                                @foreach ($dev_ids as $dev_id)
                                <option value="{{ $dev_id->id_type.'|'.$dev_id->dev_type }}">{{ $dev_id->type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Serial Number</label>
                            <input type="text" name="edit_sn" id="edit_sn" class="form-control" placeholder="Serial Number">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Activation Code</label>
                            <input type="text" name="edit_activation_code" id="edit_activation_code" class="form-control" placeholder="Activation Code">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">IP Address</label>
                            <input type="text" name="edit_ip_address" id="edit_ip_address" class="form-control" placeholder="IP Address">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Comm Type</label>
                            <select name="edit_comm_type" id="edit_comm_type" class="form-control">
                                <option value="">-- Pilih Comm Type --</option>
                                <option value="0">Ethernet</option>
                                <option value="1">USB</option>
                                <option value="2">Serial</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Layar</label>
                            <select name="edit_layar" id="edit_layar" class="form-control">
                                <option value="">-- Pilih Layar Device --</option>
                                <option value="0">TFT</option>
                                <option value="1">Black & White</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Ethernet Port</label>
                            <input type="text" name="edit_ethernet_port" id="edit_ethernet_port" class="form-control" placeholder="Ethernet Port">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-soft-primary btn-sm">Update</button>
                <button type="button" class="btn btn-soft-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>