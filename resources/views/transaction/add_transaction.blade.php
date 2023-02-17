@extends('layouts.app')
@section('title', 'Transaksi Baru')
@section('breadcumb')
    <li><a href="{{ route('transaksi') }}">Transaksi</a></li>
    <li class="active"><span>Transaksi Baru</span></li>
@endsection

@section('content')

<input type="hidden" id="status" name="status" class="form-control" value="{{session()->get('status')}}">
<input type="hidden" id="message" name="message" class="form-control" value="{{session()->get('message')}}">

<div class="row" style="margin-right: -30px; margin-left: -30px;">
    <form method="POST" data-toggle="validator" enctype="multipart/form-data" id="form_data" action="{{ route('transaksi.store') }}" >
    @csrf
        <div class="col-md-12">
            <div class="panel panel-success card-view">
                <div class="panel-heading">
                    <div class="pull-left"><h6 class="panel-title txt-light">Tambah Transaksi</h6></div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="panel panel-success card-view">
                                <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-account mr-10"></i>Pelanggan</h6>
                                <hr class="light-green-hr mb-10" />

                                <div class="row">
                                    <div class="col-sm-5">
                                        <input type="hidden" id="TRANSACTION_ID" name="TRANSACTION_ID" class="form-control" value="">
                                        <div class="form-group">
                                            <label class="control-label mb-10">Nama Pelanggan<span style="color: red">*</span></label>
                                            <input type="text" id="CUSTOMER_NAME" name="CUSTOMER_NAME" class="form-control form-sm" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label class="control-label mb-10">No Telp / No Whatsapp <span style="color: red">*</span></label>
                                            <input type="text" id="CUSTOMER_CONTACT" name="CUSTOMER_CONTACT" class="form-control" maxlength="14" onkeypress="return isNumber(event)" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label class="control-label mb-10">Jumlah<span style="color: red">*</span></label>
                                            <input type="number" id="CUSTOMER_AMOUNT" name="CUSTOMER_AMOUNT" min='1' class="form-control" placeholder="0" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label class="control-label mb-10">Tanggal Perjalanan<span style="color: red">*</span></label>
                                            <div class="input-group date_range">
                                                <input class="form-control input-daterange-datepicker" id='DATE_FROM_TO' type="text" name="DATE_FROM_TO" placeholder="DD/MM/YYYY - DD/MM/YYYY" autocomplete="off" onkeypress="return false" required>
                                                <span class="input-group-addon">
                                                    <span class="fa fa-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="control-label mb-10 text-left">Jam Kebarangkatan</label>
                                            <div class="input-group time" id="datetimepicker2">
                                                <input id='TIME' type="text" name="TIME" class="form-control" autocomplete="off" placeholder="00:00" onkeypress="return false" required>
                                                <span class="input-group-addon">
                                                    <span class="fa fa-clock-o"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label mb-10">Tujuan<span style="color: red">*</span></label>
                                            <input class="form-control" id='DESTINATION' type="text" name="DESTINATION" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label mb-10">Bus<span style="color: red">*</span></label>
                                            <select name="TRANSPORT_CODE" id="TRANSPORT_CODE" class="selectpicker" data-style="form-control btn-default btn-outline pl-10" required>
                                                <option value="">-- Pilih --</option>
                                                @foreach ($data['transport_list'] as $transport)
                                                    <option value="{{ $transport->TRANSPORT_CODE }}">{{ $transport->TRANSPORT_CODE }} - {{ $transport->TRANSPORT_NAME }} ( {{ $transport->BUS_SEAT_TYPE }} ) </option>
                                                @endforeach
                                            </select>
                                        </div></div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label mb-10">Supir<span style="color: red">*</span></label>
                                            <select name="DRIVER_ID" id="DRIVER_ID" class="selectpicker" data-style="form-control btn-default btn-outline pl-10" required >
                                                <option value="" >-- Pilih --</option>
                                                @foreach ($data['driver_list'] as $driver)
                                                    <option value="{{ $driver->DRIVER_ID }}">{{ $driver->DRIVER_NAME }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label mb-10">Kondektur<span style="color: red">*</span></label>
                                            <select name="KONDEKTUR_ID" id="KONDEKTUR_ID" class="selectpicker" data-style="form-control btn-default btn-outline pl-10" required >
                                                <option value="" >-- Pilih --</option>
                                                @foreach ($data['kondektur_list'] as $kondektur)
                                                    <option value="{{ $kondektur->KONDEKTUR_ID }}">{{ $kondektur->KONDEKTUR_NAME }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label mb-10">Keterangan Perjalanan</label>
                                            <textarea class="form-control" id='REMARK' type="text" name="REMARK" autocomplete="off" rows="4"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="txt-dark mb-10">Note : </p>
                                        <div class="panel panel-default card-view pa-10 pl-30 mb-10" style="border-color:black;">
                                            <ol class="txt-dark mb-0" style="list-style-type:circle">
                                                <li style="font-size:14px">(<span style="color: red">*</span>) form wajib di isi</li>
                                                <li style="font-size:14px">Format upload gambar berupa jpeg, png, jpg </li>
                                                <li style="font-size:14px">Ukuran gambar max 3 mb </li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="panel panel-default card-view">
                                <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-account mr-10"></i>Pembayaran</h6>
                                <hr class="light-green-hr mb-10" />

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label mb-10">Bukti Pembayaran<span style="color: red">*</span></label>
                                            <input type="file" id="IMG_PAID_PAYMENT" name="IMG_PAID_PAYMENT" class="dropify" data-height="100" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label mb-10">Harga Total<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" id="AMOUNT" name="AMOUNT" maxlength="10" placeholder="0" onkeypress="return isNumber(event)" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label mb-10">Bayar<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" id="PAID_PAYMENT" name="PAID_PAYMENT" placeholder="0"  maxlength="10" onkeypress="return isNumber(event)" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label mb-10">Sisa</label>
                                            <input type="text" class="form-control" id="PENDING_PAYMENT" name="PENDING_PAYMENT" placeholder="0" autocomplete="off" readonly >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <hr class="light-green-hr mb-0" />
                            <div class="button-list">
                                <button type="submit" id="btn_save" class="btn btn-success pull-right">PROSES TRANSAKSI</button>
                                <div class="clearfix"></div>
                            </div>
                        </div>
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

        $('#TIME').datetimepicker({
			format: 'HH:mm',
            useCurrent: false,
		});


        $("#AMOUNT").keyup(function(e){
            amount = parseInt($("#AMOUNT").val());
            paid =  parseInt($("#PAID_PAYMENT").val());

            $("#PENDING_PAYMENT").val(amount - paid);
        });

        $("#PAID_PAYMENT").keyup(function(e){
            amount = parseInt($("#AMOUNT").val());
            paid =  parseInt($("#PAID_PAYMENT").val());
            
            $("#PENDING_PAYMENT").val(amount - paid);

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
