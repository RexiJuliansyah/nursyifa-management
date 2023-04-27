<div id="addEditPopup" class="modal fade" role="dialog" aria-labelledby="modal-title"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title"></h5>
            </div>
            <div class="form-wrap">
                <div class="modal-body">
                    <div class="panel panel-default card-view">
                        <div class="panel-wrapper collapse in">
                            <form id="form_add_edit" data-toggle="validator" role="form" action="#">
                                <div class="form-group">
                                    <label for="kondektur_name" class="control-label mb-10">Nama Kondektur<span style="color: red">*</span></label>
                                    <input type="hidden" id="kondektur_id" name="kondektur_id" class="form-control" value="">
                                    <input type="text" class="form-control" id="kondektur_name" name="kondektur_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="no_telp" class="control-label mb-10">No Telp / Whatsapp<span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="no_telp" name="no_telp"  required>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" id="btn_save" class="btn btn-success btn-sm">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>