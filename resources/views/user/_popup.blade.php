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
                                        <label for="username" class="control-label mb-10">Username<span style="color: red">*</span></label>
                                        <input type="hidden" class="form-control" id="user_id" name="user_id" />
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="full_name" class="control-label mb-10">Fullname<span style="color: red">*</span></label>
                                        <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Fullname"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="control-label mb-10">Email<span style="color: red">*</span></label>
                                        <input type="text" class="form-control" id="email" name="email" placeholder="Email"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="control-label mb-10">Password<span style="color: red">*</span></label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
                                    </div>
                                    <div class="form-group">
                                        <label for="role_id" class="control-label mb-10">Role<span style="color: red">*</span></label>
                                        <select class="selectpicker" data-style="form-control btn-default btn-outline" id="role_id" name="role_id">
                                            <option value="" disabled selected>-- Pilih --</option>
                                            @foreach ($data['role_list'] as $role)
                                                <option value="{{ $role->ROLE_ID }}">{{ $role->ROLE_NAME }}</option>
                                            @endforeach
                                            
                                        </select>
                                    </div>
                                </form>
                            </div>
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