<div id="completePopup" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="modal-title"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title pull-right"># <span id="transaction_id_p"></span></h6>
                <h5 class="modal-title">Transaksi</h5>
            </div>
            <form method="POST" data-toggle="validator" enctype="multipart/form-data" id="expense-upload" action="javascript:void(0)" >
                <div class="form-wrap">
                    <div class="modal-body pb-0">
                        <div class="panel panel-default card-view">
                            <h6 class="txt-dark capitalize-font"><i class="fa fa-info-circle mr-10"></i>Masukan Biaya Pengeluaran jika ada<span id="payment_status_p"></span></h6>
                            
                            <hr class="light-green-hr mb-10" />

                            <div class="row">
                                <div class="col-sm-7">
                                    <input type="hidden" id="TRANSACTION_ID_E" name="TRANSACTION_ID_E" class="form-control" value="">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Pengeluaran<span style="color: red">*</span></label>
                                        <input type="text" class="form-control" id="EXPENSE_NAME" name="EXPENSE_NAME" maxlength="10" placeholder="Jenis Pengeluaran" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-10">Jumlah (Rp.)<span style="color: red">*</span></label>
                                        <input type="text" class="form-control" id="EXPENSE_AMOUNT" name="EXPENSE_AMOUNT" placeholder="0" required>
                                    </div>

                                   
                                    
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Bukti Pengeluaran<span style="color: red">*</span></label>
                                        <input type="file" id="IMG_EXPENSE" name="IMG_EXPENSE" class="dropify" data-height="120" required>
                                        <span class="help-block">Format gambar jpeg, png, jpg. maksimal 3 mb </span>
                                    </div>
                                    <div class="form-group pull-right pr-0">
                                        <button type="submit" class="btn btn-success btn-sm btn-icon left-icon pr-10 pl-10" id="btn_add_expense"><i class="fa fa-plus"></i><span>Tambah Pengeluaran</span>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12 pt-0">
                                    <table id="table-pengeluaran" class="table table-bordered display" >
                                        <thead class="thead-dark">
                                            <tr>
                                                <th style="width: 0px;">#</th>
                                                <th>Pengeluaran</th>
                                                <th>Jumlah (Rp.)</th>
                                                <th>Bukti</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="4" class="text-center">Belum Ada Data Pengeluaran</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        </div>
                    <div class="modal-footer pt-0">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success btn-sm btn-icon left-icon pr-10 pl-10" id="btn_complete_save"><i class="fa fa-check"></i><span>Selesai</span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>