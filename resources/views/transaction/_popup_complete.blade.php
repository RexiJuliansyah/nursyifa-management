<div id="completePopup" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="modal-title"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title pull-right"># <span id="transaction_id_text"></span></h6>
                <h5 class="modal-title">Transaksi</h5>
            </div>
            <form method="POST" data-toggle="validator" enctype="multipart/form-data" id="expense-upload" action="javascript:void(0)" >
                <div class="form-wrap">
                    <div class="modal-body pb-0">
                        <div class="panel panel-default card-view">
                            <h6 class="txt-dark capitalize-font"><i class="fa fa-info-circle mr-10"></i>Masukan Biaya Pengeluaran jika ada</h6>
                            
                            <hr class="light-green-hr mb-10" />

                            <div class="row">
                                <div class="col-sm-7">
                                    <input type="hidden" id="TRANSACTION_ID_EX" name="TRANSACTION_ID_EX" class="form-control" value="">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Pengeluaran<span style="color: red">*</span></label>
                                        <input type="text" class="form-control" id="EXPENSE_NAME" name="EXPENSE_NAME" placeholder="Jenis Pengeluaran" autocomplete="off" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-10">Jumlah (Rp.)<span style="color: red">*</span></label>
                                        <input type="number" class="form-control" id="EXPENSE_AMOUNT" name="EXPENSE_AMOUNT" placeholder="0" autocomplete="off" required>
                                    </div>

                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Bukti Pengeluaran<span style="color: red">*</span></label>
                                        <input type="file" id="EXPENSE_IMG" name="EXPENSE_IMG" class="dropify" data-height="120" required>
                                        <span class="help-block">Format gambar jpeg, png, jpg. maksimal 3 mb </span>
                                    </div>
                                    <div class="form-group pull-right pr-0">
                                        <button type="submit" class="btn btn-primary btn-sm btn-icon left-icon pr-10 pl-10" id="btn_add_expense"><i class="fa fa-check"></i><span>Save</span>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12 pt-0">
                                    <table id="table-expense" class="table table-bordered display" style=" width:100%; margin-bottom:15px;" >
                                        <thead class="thead-dark">
                                            <tr>
                                                <th style="width: 0px;">#</th>
                                                <th>Jenis Pengeluaran</th>
                                                <th>Jumlah (Rp.)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="4" class="text-center">Belum Ada Data Pengeluaran</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2" style="text-align:right !important;">Total : </th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        </div>
                    <div class="modal-footer pt-0">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success btn-sm btn-icon left-icon pr-10 pl-10" id="btn_complete_save"><i class="fa fa-check"></i><span>Selesaikan Transaksi</span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="confirmPopup" class="modal fade" role="dialog" aria-labelledby="modal-title"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title pull-right"># <span id="transaction_id_sms"></span></h6>
                <h5 class="modal-title">Transaksi</h5>
            </div>
            <form method="POST" data-toggle="validator" action="javascript:void(0)" >
                <div class="form-wrap">
                    <div class="modal-body pb-0">
                        <div class="panel panel-default card-view">
                            <h6 class="txt-dark capitalize-font"><i class="fa fa-info-circle mr-10"></i>Konfirmasi Transaksi ini?</h6>
                            
                            <hr class="light-green-hr mb-10" />

                            <div class="row">
                                
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Nama Pelanggan</label>
                                        <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-10">No Telepon</label>
                                        <input type="text" class="form-control" id="nomor_pelanggan" name="nomor_pelanggan" required autocomplete="off">
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-10">Jalwal Keberangkatan</label>
                                        <input type="text" class="form-control" id="jadwal_keberangkatan" name="jadwal_keberangkatan" readonly >
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Template SMS</label>
                                        <textarea class="form-control" id='template_sms' type="text" name="template_sms" style="word-wrap: break-word; resize: vertical;" rows="11" readonly></textarea>
                                    </div>
                                </div>

                                <div class="col-sm-12 mb-10">
                                    Notifikasi SMS akan dikirimkan, setelah anda mengkonfirmasi Transaksi ini.
                                </div>
                            </div>
                        </div>
                        </div>
                    <div class="modal-footer pt-0">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm btn-icon left-icon pr-10 pl-10" id="btn_confirm_sms"><i class="fa fa-check"></i><span>Konfirmasi</span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
