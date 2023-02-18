<div id="addEditPopup" class="modal fade" role="dialog" aria-labelledby="modal-title"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title"></h5>
            </div>
            <div class="form-wrap">
                <div class="modal-body">
                    <form id="form_add_edit" data-toggle="validator" role="form" action="#">
                        <div class="form-group col-md-12">
                            <label for="menu-name" class="control-label mb-10">Menu Name<span style="color: red">*</span></label>
                                <input type="hidden" id="menu_id" name="menu_id" class="form-control" value="">
                                <input type="text" class="form-control" id="menu_name" placeholder="Menu Name" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="menu-type" class="control-label mb-10">Menu Type<span style="color: red">*</span></label>
                                <div class="radio-list">
                                    <div class="radio-inline pl-0">
                                        <span class="radio radio-primary">
                                            <input type="radio" name="menu_type" id="radio_menu_type1" value="Parent" checked>
                                            <label for="radio_menu_type1" class="control-label mb-10">Parent Menu</label>
                                        </span>
                                    </div>
                                    <div class="radio-inline">
                                        <span class="radio radio-primary">
                                            <input type="radio" name="menu_type" id="radio_menu_type2" value="Child">
                                            <label for="radio_menu_type2" class="control-label mb-10">Sub Menu</label>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-8">
                                <label for="message-text" class="control-label mb-10">Menu Parent</label>
                                <select name="parent_id" id="parent_id" class="form-control" required></select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="menu_sequence" class="control-label mb-10">Menu Sequence<span style="color: red">*</span></label>
                                <input type="number" class="form-control" min="1" max="10" id="menu_sequence" placeholder="Menu Sequence" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="menu_sequence" class="control-label mb-10">Menu Icon<span style="color: red">*</span></label>
                                    <input type="text" id="menu_icon" class="form-control" placeholder="Menu Icon" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="menu_url" class="control-label mb-10">Menu URL<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="menu_url" placeholder="Menu URL" required>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btn_save" class="btn btn-success">Save</button>
                    </div>
            </div>
        </div>
    </div>
</div>