<div id="completePopup" class="modal fade" role="dialog" aria-labelledby="modal-title"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title pull-right"># <span id="transaction_id_p"></span></h6>
                <h5 class="modal-title">Transaksi</h5>
            </div>
            <form method="POST" data-toggle="validator" enctype="multipart/form-data" id="pending-upload" action="javascript:void(0)" >
                <div class="form-wrap">
                    <div class="modal-body pb-0">
                        <div class="panel panel-default card-view">
                            <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-account mr-10"></i>Pelunasan <span id="payment_status_p"></span></h6>
                            
                            <hr class="light-green-hr mb-10" />

                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="hidden" id="TRANSACTION_ID_H" name="TRANSACTION_ID_H" class="form-control" value="">

                                    <div class="form-group">
                                        <label class="control-label mb-10">Bukti Pelunasan<span style="color: red">*</span></label>
                                        <input type="file" id="IMG_PENDING_PAYMENT" name="IMG_PENDING_PAYMENT" class="dropify" data-height="200" required>
                                        <span class="help-block">Format gambar jpeg, png, jpg. Ukuran maksimal 3 mb </span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Harga Total<span style="color: red">*</span></label>
                                        <input type="text" class="form-control" id="AMOUNT" name="AMOUNT" maxlength="10" placeholder="0" readonly required>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-10">Telah Dibayar<span style="color: red">*</span></label>
                                        <input type="text" class="form-control" id="PAID_PAYMENT" name="PAID_PAYMENT" placeholder="0" readonly  required>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-10">Sisa</label>
                                        <input type="text" class="form-control" id="PENDING_PAYMENT" name="PENDING_PAYMENT" placeholder="0" autocomplete="off" readonly readonly >
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    <div class="modal-footer pt-0">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success btn-sm btn-icon left-icon pr-10 pl-10" id="btn_complete"><i class="fa fa-check"></i><span>Selesai</span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>