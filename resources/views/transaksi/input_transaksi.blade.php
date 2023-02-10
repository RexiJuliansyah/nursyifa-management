@extends('layouts.app')
@section('title', 'Transaksi Baru')
@section('breadcumb')
    <li><a href="javascript:void()">Transaksi</a></li>
    <li class="active"><span>Transaksi Baru</span></li>
@endsection

@section('content')
    <div class="row" style="margin-right: -30px; margin-left: -30px;">
        <div class="col-md-8">
            <div class="panel panel-success card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-light">Data Transaksi</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <div class="panel panel-default card-view">
                        <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-account mr-10"></i>Info Customers</h6>
                        <hr class="light-grey-hr mb-0" />

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Input<span style="color: red">*</span></label>
                                        <input type="text" id="firstName" class="form-control form-sm" placeholder="Input">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Input<span style="color: red">*</span></label>
                                        <input type="text" id="firstName" class="form-control" placeholder="Input">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-account mr-10"></i>Info Details</h6>
                        <hr class="light-grey-hr mb-0" />

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">Tanggal Keberangkatan<span style="color: red">*</span></label>
                                        <div class='input-group date'  >
                                            <input class="form-control input-daterange-datepicker" id='date' type="text" name="daterange" autocomplete="off" readonly style="background:white;">
                                            <span class="input-group-addon">
                                                <span class="fa fa-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="transport_type" class="control-label mb-10">Tujuan<span style="color: red">*</span></label>
                                        <select name="transport_type" id="transport_type" class="selectpicker" data-style="form-control btn-default btn-outline">
                                            <option value="">-- Pilih --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label mb-10" for="exampleInputEmail_1">Bus<span style="color: red">*</span></label>
                                        <select name="transport_type" id="transport_type" class="selectpicker" data-style="form-control btn-default btn-outline">
                                            <option value="">-- Pilih --</option>
                                        </select>
                                    </div></div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label mb-10" for="exampleInputEmail_1">Supir<span style="color: red">*</span></label>
                                        <select name="transport_type" id="transport_type" class="selectpicker" data-style="form-control btn-default btn-outline">
                                            <option value="">-- Pilih --</option>
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
                        <h6 class="panel-title txt-light">Total</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">Harga</div>
                            <input type="text" class="form-control" id="exampleInputuname" placeholder="153">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-5">
                            <div class="input-group-addon">Bayar</div>
                            <input type="text" class="form-control" id="exampleInputuname" placeholder="153">
                        </div>
                        <span class="pull-right">
                            <div class="radio-inline pl-0">
                                <div class="radio radio-success">
                                    <input type="radio" name="radio" id="radio1" value="option1" checked>
                                    <label for="radio1">Lunas</label>
                                </div>
                            </div>
                            <div class="radio-inline pl-0">
                                <div class="radio radio-warning">
                                    <input type="radio" name="radio" id="radio2" value="option2">
                                    <label for="radio2">DP</label>
                                </div>
                            </div>
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="control-label mt-20 mb-10">Bukti Pembayaran</label>
                        <input type="file" id="input-file-now" class="dropify" data-height="100">
                    </div>

                    <div class="table-wrap">
                        <div class="table-responsive">
                            <table class="mb-0 table">
                                <tbody>
                                    <tr>
                                        <td>Total</td>
                                        <td class="text-right">#######</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="panel-footer">
                    <div class="button-list">
                        <button type="submit" id="btn_save" class="btn btn-success pull-right mb-10 mr-10">Proses Transaksi</button>
                        <div class="clearfix"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    

@endsection

@section('javascript')
<script type="text/javascript">

    $(document).ready(function() {
        $('#date').daterangepicker({
            autoUpdateInput: false,
            minDate: new moment(),
            timePicker: false,
            autoApply: true
	    }).on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD MMM YYYY') + ' - ' + picker.endDate.format('DD MMM YYYY'));
        });

    });
    </script>
@endsection
