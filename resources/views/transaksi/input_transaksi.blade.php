@extends('layouts.app')
@section('title', 'Transaksi Baru')
@section('breadcumb')
    <li><a href="javascript:void()">Transaksi</a></li>
    <li class="active"><span>Transaksi Baru</span></li>
@endsection

@section('content')
    <div class="row" style="margin-right: -30px; margin-left: -30px;">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Data Transaksi</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <div class="panel panel-default card-view">
                        <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-account mr-10"></i>Info Customers</h6>
                        <hr class="light-grey-hr mb-0"/>
                        <div class="panel-body">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label mb-10">Input</label>
                                    <input type="text" id="firstName" class="form-control form-sm" placeholder="Input">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label mb-10">Input</label>
                                    <input type="text" id="firstName" class="form-control" placeholder="Input">
                                </div>
                            </div>
                        </div>

                        <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-account mr-10"></i>Info Details</h6>
                        <hr class="light-grey-hr mb-0"/>

                        <div class="panel-body">
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label mb-10" for="exampleInputuname_1">Input</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="icon-user"></i>
                                        </div>
                                        <input type="text" class="form-control" id="exampleInputuname_1" placeholder="Input">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label mb-10" for="exampleInputEmail_1">Input</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="icon-envelope-open"></i>
                                        </div>
                                        <input type="email" class="form-control" id="exampleInputEmail_1" placeholder="Input">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label mb-10" for="exampleInputEmail_1">Input</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="icon-envelope-open"></i>
                                        </div>
                                        <input type="email" class="form-control" id="exampleInputEmail_1" placeholder="Input">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label mb-10" for="exampleInputEmail_1">Input</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="icon-envelope-open"></i>
                                        </div>
                                        <input type="email" class="form-control" id="exampleInputEmail_1" placeholder="Input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Total</h6>
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
                            <table class="table  mb-0">
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

                <div class="panel-footer ">
                    <div class="button-list">
                        <button type="submit" id="btn_save" class="btn btn-primary pull-right mb-10 mr-10">Proses Transaksi</button>
                        <div class="clearfix"></div>
                    </div>
                </div>

               

            </div>
        </div>
    </div>

@endsection
