@extends('layouts.app')
@section('title', 'Transaksi Baru')
@section('breadcumb')
    <li><a href="javascript:void()">Transaksi</a></li>
    <li class="active"><span>Transaksi Baru</span></li>
@endsection

@section('content')

<input type="hidden" id="status" name="status" class="form-control" value="{{session()->get('status')}}">
<input type="hidden" id="message" name="message" class="form-control" value="{{session()->get('message')}}">

<div class="row" style="margin-right: -30px; margin-left: -30px;">
    <form method="POST" data-toggle="validator" enctype="multipart/form-data" id="form_data" action="{{ route('transaksi.store') }}" >
    @csrf
        <div class="col-md-8">
            <div class="panel panel-success card-view">
                <div class="panel-heading">
                    <div class="pull-left"><h6 class="panel-title txt-light">Data Transaksi</h6></div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <div class="panel panel-default card-view">
                        <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-account mr-10"></i>Info Pelanggan</h6>
                        <hr class="light-grey-hr mb-0" />

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-5">
                                    <input type="hidden" id="TRANSACTION_ID" name="TRANSACTION_ID" class="form-control" value="">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Nama Pelanggan<span style="color: red">*</span></label>
                                        <input type="text" id="CUSTOMER_NAME" name="CUSTOMER_NAME" class="form-control form-sm" placeholder="Nama Pelanggan" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label class="control-label mb-10">No Telp / No Whatsapp <span style="color: red">*</span></label>
                                        <input type="text" id="CUSTOMER_CONTACT" name="CUSTOMER_CONTACT" class="form-control" placeholder="No Telp / No Whatsapp" maxlength="14" onkeypress="return isNumber(event)" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Jumlah Orang<span style="color: red">*</span></label>
                                        <input type="number" id="CUSTOMER_AMOUNT" name="CUSTOMER_AMOUNT" min='1' class="form-control" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-account mr-10"></i>Info Perjalanan</h6>
                        <hr class="light-grey-hr mb-0" />

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Tanggal Perjalanan<span style="color: red">*</span></label>
                                        <div class="input-group">
                                            <input class="form-control input-daterange-datepicker" id='DATE_FROM_TO' type="text" name="DATE_FROM_TO" autocomplete="off" style="background-color: white" onkeypress="return false" required>
                                            <span class="input-group-addon">
                                                <span class="fa fa-calendar"></span>
                                            </span>
															</div>
                                        <!-- <div class='input-group'>
                                            
                                        </div> -->
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Keterangan Perjalanan</label>
                                        <input class="form-control" id='REMARK' type="text" name="REMARK" placeholder="Keterangan Perjalanan" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Tujuan<span style="color: red">*</span></label>
                                        <input class="form-control" id='DESTINATION' type="text" name="DESTINATION" placeholder="Kota Tujuan" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Bus<span style="color: red">*</span></label>
                                        <select name="TRANSPORT_TYPE" id="TRANSPORT_TYPE" class="selectpicker" data-style="form-control btn-default btn-outline" required>
                                            <option value="">-- Pilih --</option>
                                            @foreach ($data['transport_list'] as $transport)
                                                <option value="{{ $transport->TRANSPORT_CODE }}">{{ $transport->TRANSPORT_CODE }} ( {{ $transport->BUS_SEAT_TYPE }} ) </option>
                                            @endforeach
                                        </select>
                                    </div></div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Supir<span style="color: red">*</span></label>
                                        <select name="DRIVER_ID" id="DRIVER_ID" class="selectpicker" data-style="form-control btn-default btn-outline" required >
                                            <option value="" >-- Pilih --</option>
                                            <option value="SUPIR 001">SUPIR 001</option>
                                            <option value="SUPIR 001">SUPIR 002</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-success card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-light">Data Pembayaran</h6>
                    </div>
                    
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <div class="panel panel-default card-view">
                        <div class="form-group">
                            <label class="control-label" style="width:100%">Bukti Pembayaran <div class="pull-right">
                                <div class="form-group md-bootstrap-select">
                                    <select class="selectpicker" data-style="form-control btn-success btn-outline" name="PAYMENT_METHOD">
                                        <option value='CASH'>CASH</option>
                                        <option value='TRANSFER'>TRANSFER</option>
                                    </select>
                                </div>	
                            </div></label>
                            <input type="file" id="IMG_PAID_PAYMENT" name="IMG_PAID_PAYMENT" class="dropify" data-height="100" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-10">Harga<span style="color: red">*</span></label>
                            <input type="text" class="form-control" id="AMOUNT" name="AMOUNT" maxlength="10" onkeypress="return isNumber(event)" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-10">Bayar<span style="color: red">*</span></label>
                            <input type="text" class="form-control" id="PAID_AMOUNT" name="PAID_AMOUNT"  maxlength="10" onkeypress="return isNumber(event)" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="button-list">
                        <button type="submit" id="btn_save" class="btn btn-success pull-right">PROSES TRANSAKSI</button>
                    <div class="clearfix"></div>
                   </div>
                </div>
            </div>
        </div>
    </form>
</div>

    

@endsection

@section('javascript')
<script type="text/javascript">

    $(document).ready(function() {
        var flash_status = $('#status').val();
        var flash_message = $('#message').val();

        if (flash_status == "success") {
            Swal.fire({   
			    title: "Success",   
                icon: "success", 
			    text: flash_message,
			    timer: 2000,   
                showConfirmButton: false 
            });
        } 

        if (flash_status == "error") {
            Swal.fire({   
			    title: "Error",   
                icon: "error", 
			    text: flash_message,
			    timer: 2000,   
                showConfirmButton: false 
            });
        } 



        $('#DATE_FROM_TO').daterangepicker({
            autoUpdateInput: false,
            drops: "up",
            minDate: new moment(),
            timePicker: false,
            autoApply: true,
            locale: {
                format: 'DD/MM/YYYY'
            }
            
	    }).on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            $(this).focus();
        });

    });

    function isNumber(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    };
    </script>
@endsection
