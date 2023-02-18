<div id="permissionPopup" class="modal fade" role="dialog" aria-labelledby="modal-title"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title">Permission</h5>
            </div>
                <div class="modal-body"> 
                    <div class="panel panel-default mb-10">
                        <div class="panel-body form-horizontal">
                            <label class="control-label"><span class="txt-dark" id="txt_role_name"></span></label>
                            <div class="pull-right">
                                <button type="button" class="btn btn-default btn-sm" id="btn_clear_access">Clear</button>
                                <button type="button" class="btn btn-success btn-sm" id="btn_all_access">All Permission</button>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default mb-0">
                        <div class="panel-body pa-1">
                            <div class="panel-group accordion-struct mb-0" role="tablist" aria-multiselectable="true" id="accordion">  
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="btn_save_permission" class="btn btn-success btn-sm">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>