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
                                    <label for="transport_code" class="control-label mb-10">Kode Bus<span style="color: red">*</span></label>
                                    <input type="hidden" id="transport_id" name="transport_id" class="form-control" value="">
                                    <input type="text" class="form-control" id="transport_code" name="transport_code" placeholder="Kode Bus" required>
                                </div>
                                <div class="form-group">
                                    <label for="transport_name" class="control-label mb-10">Nama Bus<span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="transport_name" name="transport_name" placeholder="Nama Bus" required>
                                </div>
                                <div class="form-group">
                                    <label for="transport_type" class="control-label mb-10">Jenis Bus<span style="color: red">*</span></label>
                                    <select name="transport_type" id="transport_type" class="selectpicker" data-style="form-control btn-default btn-outline">
                                        <option value="">-- Pilih --</option> 
                                        @foreach ($data['transport_list'] as $transport)
                                            <option value="{{ $transport->SYSTEM_CD }}">{{ $transport->SYSTEM_VAL }}</option>
                                        @endforeach
                                    </select>
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