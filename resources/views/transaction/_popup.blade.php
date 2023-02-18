<div id="detailPopup" class="modal fade" role="dialog" aria-labelledby="modal-title"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title pull-right"># <span id="transaction_id"></span></h6>
                <h5 class="modal-title">Detail Transaksi</h5>
            </div>
            <div class="form-wrap">
                <div class="modal-body pb-0">
                    <div class="panel panel-default card-view pa-15">
                        <div class="row">
                            <div class="col-xs-6">
                                <p class="txt-dark head-font inline-block capitalize-font mb-5">Pelanggan :</p>
                                <address class="mb-15">
                                    <span id="customer_name"></span><br>
                                    <span id="customer_contact"></span><br>
                                    <span id="customer_amount"></span> Orang<br>
                                </address> 
                            </div>
                            <div class="col-xs-6">
                                <p class="txt-dark head-font inline-block capitalize-font">Tujuan Perjalanan :</p>
                                <address class="mb-10">
                                    <span id="destination"></span><br>
                                    <span id="remark"></span><br>
                                </address>
                            </div>
                            <div class="col-xs-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Tanggal Perjalanan</th>
                                                <th>Waktu</th>
                                                <th>Bus</th>
                                                <th>Supir</th>
                                                <th>Kondektur</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td id="date_from_to"></td>
                                                <td id="time"></td>
                                                <td id="transport"></td>
                                                <td id="driver_name"></td>
                                                <td id="kondektur_name"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="col-sm-6 col-sm-offset-6 pa-0">

                                    <span class="txt-dark" >Status Pembayaran <span id="payment_status"></span></span>
                       
                                    <div class="panel panel-default card-view pa-0 pl-10 pr-10 mt-10">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td class="txt-dark pa-10">Harga</th>
                                                    <td class="txt-dark pa-10">:</th>
                                                    <td class="txt-dark pa-10" id="amount"></td>
                                                    
                                                </tr>
                                                <tr>
                                                    <td class="txt-dark pa-10">Dibayar</th>
                                                    <td class="txt-dark pa-10">:</th>
                                                    <td class="txt-dark pa-10"id="paid_payment"></td>
                                                </tr>
                                                <tr>
                                                    <td class="txt-dark pa-10">Sisa</th>
                                                    <td class="txt-dark pa-10">:</th>
                                                    <td class="txt-dark pa-10"id="pending_payment"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        
                                    </div>  
                                    
                                </div> 
                                <div class="col-sm-6 col-sm-offset-6">
                                    <a id="download_paid_img" class="pull-right" target="_blank">
                                        <i class="fa fa-file-image-o" aria-hidden="true"></i> 
                                        <span id="img_paid_payment"></span><br>
                                    </a><br/> 
                                    <a id="download_pending_img" class="pull-right" target="_blank">
                                        <i class="fa fa-file-image-o" aria-hidden="true"></i> 
                                        <span id="img_pending_payment"></span><br>
                                    </a>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>