@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Row -->
        <div class="row pt-10" style="display: flex; justify-content: end;">
            <div class="col-sm-2 pr-0">
                <div class="form-group pull-right" style="padding-top: 11px">
                    <label class="control-label">Tanggal Transaksi</label>
                </div>
            </div>
            <div class="col-sm-3 pl-0">
                <div class="form-group">
                    <div class="input-group date_range">
                        <input class="form-control input-daterange-datepicker" id='DATE_FROM_TO' type="text"
                            name="DATE_FROM_TO" placeholder="DD/MM/YYYY - DD/MM/YYYY" autocomplete="off"
                            onkeypress="return false" required>
                        <span class="input-group-addon">
                            <span class="fa fa-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-1 pl-0">
                <div class="form-group pull-left" style="padding-top: 3px; padding-left:9px">
                    <button type="button" class="btn btn-success btn-icon btn-sm left-icon pr-10 pl-10" id="btn_search"><i
                            class="fa fa-search"></i>Search</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper in collapse">
                        <div class="panel-body pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-8 data-wrap-left pl-0 pr-0 text-center">
                                            <span class="txt-dark counter block"><span
                                                    class="counter-anim">{{ $data['transport_list_count'] }}</span></span>
                                            <span class="weight-500 uppercase-font block">Jumlah Bis</span>
                                        </div>
                                        <div class="col-xs-4 data-wrap-right pl-0 pr-0 text-center">
                                            <i class="fa fa-bus data-right-rep-icon txt-light-grey"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper in collapse">
                        <div class="panel-body pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-8 data-wrap-left pl-0 pr-0 text-center">
                                            <span class="txt-dark counter block"><span
                                                    class="counter-anim">{{ $data['driver_list_count'] + $data['kondektur_list_count'] }}</span></span>
                                            <span class="weight-500 uppercase-font block">Supir + Kondektur</span>
                                        </div>
                                        <div class="col-xs-4 data-wrap-right pl-0 pr-0 text-center">
                                            <i class="fa fa-users data-right-rep-icon txt-light-grey"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper in collapse">
                        <div class="panel-body pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-8 data-wrap-left pl-0 pr-0 text-center">
                                            <span class="txt-dark counter block"><span class="counter-anim"
                                                    id="transaction_count"></span></span>
                                            <span class="weight-500 uppercase-font block">Total Transaksi</span>
                                        </div>
                                        <div class="col-xs-4 data-wrap-right pl-0 pr-0 text-center">
                                            <i class="fa fa-exchange data-right-rep-icon txt-light-grey"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper in collapse">
                        <div class="panel-body pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-8 data-wrap-left pl-0 pr-0 text-center">
                                            <span class="txt-dark counter block"><span class="counter-anim"
                                                    id="total_price"></span></span>
                                            <span class="weight-500 uppercase-font block">Total Pembayaran</span>
                                        </div>
                                        <div class="col-xs-4 data-wrap-right pl-0 pr-0 text-center">
                                            <i class="fa fa-usd data-right-rep-icon txt-light-grey"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Row -->
        <!-- Row -->
        <div class="row">
            <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
                <div class="panel panel-default card-view panel-refresh">
                    <div class="refresh-container">
                        <div class="la-anim-1"></div>
                    </div>
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Grafik Transaksi</h6>
                        </div>
                        <div class="pull-right">
                            <a href="#" class="pull-left refresh mr-15 inline-block">
                                <i class="zmdi zmdi-replay"></i>
                            </a>
                            <a href="#" class="pull-left full-screen mr-15 inline-block">
                                <i class="zmdi zmdi-fullscreen"></i>
                            </a>
                            <div class="pull-left dropdown inline-block">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false"
                                    role="button"><i class="zmdi zmdi-more-vert"></i></a>
                                <ul class="dropdown-menu bullet dropdown-menu-right" role="menu">
                                    <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i
                                                class="icon wb-reply" aria-hidden="true"></i>Devices</a></li>
                                    <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i
                                                class="icon wb-share" aria-hidden="true"></i>General</a></li>
                                    <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i
                                                class="icon wb-trash" aria-hidden="true"></i>Referral</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper in collapse">
                        <div id="e_chart_1" class="" style="height:350px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <div class="panel card-view">
                    <div class="panel-heading small-panel-heading relative">
                        <div class="pull-left">
                            <h6 class="panel-title">Pembayaran</h6>
                        </div>
                        <div class="clearfix"></div>
                        <div class="head-overlay"></div>
                    </div>
                    <div class="panel-wrapper in collapse">
                        <div class="panel-body row pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-6 data-wrap-left pl-0 pr-0 text-center">
                                            <span class="block"><i
                                                    class="zmdi zmdi-check txt-success font-18 mr-5"></i><span
                                                    class="weight-500 uppercase-font">Lunas</span></span>
                                            <span class="txt-dark counter block"><span class="counter-anim"
                                                    id="total_lunas_price"></span></span>
                                        </div>
                                        <div class="col-xs-6 data-wrap-left pl-0 pr-0 text-center">
                                            <span class="block"><i
                                                    class="zmdi zmdi-time-interval txt-warning font-18 mr-5"></i><span
                                                    class="weight-500 uppercase-font">Belum Dibayar</span></span>
                                            <span class="txt-dark counter block"><span class="counter-anim"
                                                    id="total_pending_price"></span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel card-view">
                    <div class="panel-heading small-panel-heading relative">
                        <div class="pull-left">
                            <h6 class="panel-title">Transaksi</h6>
                        </div>
                        <div class="clearfix"></div>
                        <div class="head-overlay"></div>
                    </div>
                    <div class="panel-wrapper in collapse">
                        <div class="panel-body row pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-3 data-wrap-left pr-0 text-center">
                                            <span class="block"><i
                                                    class="zmdi zmdi-time-interval txt-warning font-18 mr-5"></i><span
                                                    class="weight-500 uppercase-font"
                                                    style="font-size: 13px">Pending</span></span>
                                            <span class="txt-dark counter block" id="pending_count"></span>
                                        </div>
                                        <div class="col-xs-3 data-wrap-left text-center">
                                            <span class="block"><i
                                                    class="zmdi zmdi-swap-vertical txt-primary font-18 mr-5"></i><span
                                                    class="weight-500 uppercase-font"
                                                    style="font-size: 13px">Aktif</span></span>
                                            <span class="txt-dark counter block" id="active_count"></span>
                                        </div>
                                        <div class="col-xs-3 data-wrap-left text-center" style="padding-left: 5px">
                                            <span class="block"><i
                                                    class="zmdi zmdi-close txt-danger font-18 mr-5"></i><span
                                                    class="weight-500 uppercase-font"
                                                    style="font-size: 13px">Cancel</span></span>
                                            <span class="txt-dark counter block" id="cancel_count"></span>
                                        </div>
                                        <div class="col-xs-3 data-wrap-left pl-0 text-center">
                                            <span class="block"><i
                                                    class="zmdi zmdi-check txt-success font-18 mr-5"></i><span
                                                    class="weight-500 uppercase-font"
                                                    style="font-size: 13px">Selesai</span></span>
                                            <span class="txt-dark counter block" id="complete_count"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Row -->
        <!-- Row -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Data Transaksi</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper in collapse">
                        <div class="panel-body">
                            <div class="pull-right">
                                <button type="button" class="btn btn-success btn-sm left-icon pr-10 pl-10"
                                    id="btn_export_excel"><i class="fa fa-file-excel-o"></i> Export
                                    Excel</button>
                                <button type="button" class="btn btn-danger btn-sm center-icon pr-10 pl-10"
                                    id="btn_export_pdf"><i class="fa fa-file-pdf-o"></i> Export
                                    PDF</button>
                            </div>
                            <table id="table-report" class="table-bordered display table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Kode Transaksi</th>
                                        <th>Pelanggan</th>
                                        <th>Bus</th>
                                        <th>Tujuan</th>
                                        <th>Tanggal Perjalanan</th>
                                        <th>Pembayaran</th>
                                        <th>Status Transaksi</th>
                                        <th>Harga</th>
                                        <th>Dibayar</th>
                                        <th>Dibuat Oleh</th>
                                    </tr>
                                </thead>
                                <tbody style="cursor:pointer">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Row -->


    </div>
@endsection

@section('javascript')
    <script src="{{ asset('admin') }}/vendors/jquery.sparkline/dist/jquery.sparkline.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var date = new Date();
            var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
            var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);

            $('#DATE_FROM_TO').daterangepicker({
                autoUpdateInput: false,
                timePicker: false,
                autoApply: true,
                locale: {
                    format: 'DD/MM/YYYY'
                }

            }).on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format(
                    'DD/MM/YYYY'));
                $(this).focus();
            });

            $("#DATE_FROM_TO").val(moment(firstDay).format('DD/MM/YYYY') + ' - ' + moment(lastDay).format(
                'DD/MM/YYYY'));
        });
    </script>
    @include('dashboard.admin._javascript')
@endsection
