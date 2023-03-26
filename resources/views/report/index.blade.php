@extends('layouts.app')
@section('title', 'Report')
@section('breadcumb')
    <li>Report</li>
    <li class="active"><span>Report Transaksi</span></li>
@endsection

@section('content')
    <!-- Row -->
    <div class="row">
        <div class="panel panel-success card-view mt-10">
            <div class="panel-heading pt-10 pb-10">
                <div class="pull-left">
                    <h6 class="panel-title txt-light">Report Transaksi</h6>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="panel-body">
                <div class="panel panel-success card-view ma-0 pt-10 pb-10">

                    <div class="row">
                        <div class="col-sm-4">
                            <label class="control-label mb-10">Bus</label>
                            <select name="search_transport_code" id="search_transport_code" class="selectpicker"
                                data-style="form-control btn-default btn-outline">
                                <option value="">-- Semua --</option>
                                @foreach ($data['transport_list'] as $transport)
                                    <option value="{{ $transport->TRANSPORT_CODE }}">{{ $transport->TRANSPORT_CODE }} -
                                        {{ $transport->TRANSPORT_NAME }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label class="control-label mb-10">Pelanggan</label>
                            <input type="text" class="form-control" id="search_customer" name="search_customer"
                                placeholder="Pelanggan" value="">
                        </div>
                        <div class="col-sm-4">
                            <label class="control-label mb-10">Tujuan</label>
                            <input type="text" class="form-control" id="search_destination" name="search_destination"
                                placeholder="Tujuan" value="">
                        </div>
                    </div>
                    <div class="row" style="margin-top: 15px">
                        <div class="col-sm-4">
                            <label class="control-label mb-10">Pembayaran</label>
                            <select name="search_payment_status" id="search_payment_status" class="selectpicker"
                                data-style="form-control btn-default btn-outline">
                                <option value="">-- Semua --</option>
                                <option value="0">DANA PERTAMA</option>
                                <option value="1">LUNAS</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label class="control-label mb-10">Status Transaksi</label>
                            <select name="search_transaction_status" id="search_transaction_status" class="selectpicker"
                                data-style="form-control btn-default btn-outline">
                                <option value="">-- Semua --</option>
                                @foreach ($data['transaksi_status_list'] as $transport)
                                    <option value="{{ $transport->SYSTEM_CD }}">{{ $transport->SYSTEM_VAL }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label class="control-label mb-10">Tanggal Transaksi</label>
                            <input class="form-control input-daterange-datepicker" id='DATE_FROM_TO' type="text"
                                name="DATE_FROM_TO" placeholder="DD/MM/YYYY - DD/MM/YYYY" autocomplete="off"
                                onkeypress="return false">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="button-list">
                                <div class="pull-left">
                                    <button type="button" class="btn btn-success btn-sm left-icon pr-10 pl-10"
                                        id="btn_export_excel" style="display: none"><i class="fa fa-file-excel-o"></i> Export
                                        Excel</button>
                                    <button type="button" class="btn btn-danger btn-sm center-icon pr-10 pl-10"
                                        id="btn_export_pdf" style="display: none"><i class="fa fa-file-pdf-o"></i> Export
                                        PDF</button>
                                </div>
                                <div class="pull-right">
                                    <button type="button" class="btn btn-default btn-icon btn-sm left-icon pr-10 pl-10"
                                        id="btn_clear">Clear</button>
                                    <button type="button" class="btn btn-success btn-icon btn-sm left-icon pr-10 pl-10"
                                        id="btn_search"><i class="fa fa-search"></i>Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default card-view ma-0 mt-10 pt-0" id="table_container" style="display: none">
                    <table id="table-report" class="table-bordered display table">
                        <thead class="thead-dark">
                            <tr>
                                <th style="width: 0px;">#</th>
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

                    <hr class="light-green-hr mb-10" />
                </div>
            </div>

        </div>
    </div>
    <!-- /Row -->
@endsection

@section('javascript')

    @include('report._javascript')
    <script type="text/javascript">
        var pChecked = null;
        // Table Row Click Event
        $(document).ready(function() {
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

            $('#table-report tbody').on('click', 'tr', function() {
                var data = table.row(this).data();

                var checkbox_grid = $('input[name="chkRow"][data-TransactionId="' + data["TRANSACTION_ID"] +
                    '"]');
                checkbox_grid.click();
                if (checkbox_grid.is(":checked")) {
                    $(".grid-checkbox").prop("checked", false);
                    $(".grid-checkbox").parent().parent().removeClass('highlight-row');
                    checkbox_grid.parent().parent().removeClass('highlight-row');
                    checkbox_grid.prop("checked", false)
                } else {
                    $(".grid-checkbox").prop("checked", false);
                    $(".grid-checkbox").parent().parent().removeClass('highlight-row');
                    checkbox_grid.parent().parent().addClass('highlight-row');
                    checkbox_grid.prop("checked", true)
                }
            });
        });
        // End Table Row Click Event
    </script>
@endsection
