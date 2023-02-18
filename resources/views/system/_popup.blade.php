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
                                    <label for="system_type" class="control-label mb-10">System Type<span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="system_type" name="system_type" placeholder="System Type" required>
                                </div>
                                <div class="form-group">
                                    <label for="system_cd" class="control-label mb-10">System Code<span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="system_cd" name="system_cd" placeholder="System Code" required>
                                </div>
                                <div class="form-group">
                                    <label for="system_val" class="control-label mb-10">System Value<span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="system_val" name="system_val" placeholder="System Value" required>
                                </div>
                                <div class="form-group">
                                    <label for="system_desc" class="control-label mb-10">Description<span style="color: red">*</span></label>
                                    <textarea rows="5" class="form-control" id="system_desc" name="system_desc" placeholder="Description"></textarea>
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