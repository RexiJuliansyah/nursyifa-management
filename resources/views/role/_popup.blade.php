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
                    <div class="panel panel-default">
                        <div  class="panel-wrapper collapse in">
                            <div  class="panel-body">
                                <form id="form_add_edit" data-toggle="validator" role="form" action="#">
                                    <div class="form-group">
                                        <label for="role_name" class="control-label mb-10">Role Name<span style="color: red">*</span></label>
                                        <input type="hidden" class="form-control" id="role_id" name="role_id" />
                                        <input type="text" class="form-control" id="role_name" name="role_name" placeholder="Role Name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="role_desc" class="control-label mb-10">Description<span style="color: red">*</span></label>
                                        <textarea rows="5" class="form-control" id="role_desc" name="role_desc" placeholder="Description"></textarea>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" id="btn_save" class="btn btn-primary btn-sm">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>