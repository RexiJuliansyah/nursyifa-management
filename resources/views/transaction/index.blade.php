@extends('layouts.app')
@section('title', 'Transaksi')
@section('breadcumb')
    <li><a href="javascript:void()">Transaksi</a></li>
    <li class="active"><span>List Transaksi</span></li>
@endsection


@section('content')
<!-- Row -->
<div class="row">
    <div class="panel panel-success card-view">

        <div class="panel-heading">
            <div class="pull-left">
                <h6 class="panel-title txt-light">List Transaksi</h6>
            </div>
            <div class="clearfix"></div>
        </div>
        
        <div class="panel-body">
                <div class="panel panel-default card-view ma-0 pt-10 pb-10">
                    <div class="row">
                        <div class="col-sm-4">
                            <label class="control-label mb-10">Tanggal</label>
                            <input type="text" class="form-control" id="search_system_type" name="search_system_type" placeholder="System Type" value="">
                        </div>
                        <div class="col-sm-4">
                            <label class="control-label mb-10">Kode Transaksi</label>
                            <input type="text" class="form-control" id="search_system_val" name="search_system_val" placeholder="System Value" value="">
                        </div>
                        <div class="col-sm-4">
                            <label class="control-label mb-10">Nama Pelanggan</label>
                            <input type="text" class="form-control" id="search_system_val" name="search_system_val" placeholder="System Value" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="button-list">
                                <div class="pull-left">
                                    <button type="button" class="btn btn-success btn-sm" id="btn_add"><span class="fa fa-plus"></span> Tambah Transaksi</button>
                                    <!-- <button type="button" class="btn btn-warning btn-sm" id="btn_edit" disabled><span class="fa  fa-pencil"></span> Edit</button>
                                    <button type="button" class="btn btn-danger btn-sm" id="btn_delete" disabled><span class="fa fa-trash"></span> Delete</button> -->
                                </div>
                                <div class="pull-right">
                                    <button type="button" class="btn btn-default btn-sm" id="btn_clear"><span class="fa fa-close"></span> Clear Filter</button>
                                    <button type="button" class="btn btn-primary btn-sm" id="btn_search"><span class="fa fa-search"></span> Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default card-view ma-0 mt-10 pt-0">
                    <table id="table-transaksi" class="table table-bordered display" >
                        <thead class="thead-dark">
                            <tr>
                                <th>Kode Transaksi</th>
                                <th>Pelanggan</th>
                                <th>Tujuan Perjalanan</th>
                                <th>Tanggal Perjalanan</th>
                                <!-- <th>Harga</th> -->
                                <th>Status Transaksi</th>
                                <th>Dibuat Oleh</th>
                                <th>Dibuat Tanggal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>

        </div>
    </div>
</div>
<!-- /Row -->


@endsection

@section('javascript')

@include('transaction._javascript')
    
    <script type="text/javascript">
        var pChecked = null;
        // Table Row Click Event
        // $(document).ready(function() {
        //     $("#checkall").click(function() {
        //         $(".grid-checkbox").prop("checked", $("#checkall").is(":checked"));
        //         $(this).is(":checked") ? $(".grid-checkbox").parent().parent().addClass('highlight-row') : $(".grid-checkbox").parent().parent().removeClass('highlight-row');
        //         $("#btn_edit").prop("disabled", ($("input[name='chkRow']:checked").length == 1) ? false : true);
        //         $("#btn_delete").prop("disabled", ($("input[name='chkRow']:checked").length == 1) ? false : true);
        //     });

        //     $('#table-system tbody').on('click', 'tr', function () {
        //         var data = table.row(this).data();
        //         $("#btn_edit").prop("disabled", ($("input[name='chkRow']:checked").length == 1) ? false : true);
        //         $("#btn_delete").prop("disabled", ($("input[name='chkRow']:checked").length == 1) ? false : true);

        //         var checkbox_grid = $('input[name="chkRow"][data-SystemType="'+ data["SYSTEM_TYPE"] +'"][data-SystemCd="'+ data["SYSTEM_CD"] +'"]');
        //         checkbox_grid.click();
        //         if (checkbox_grid.is(":checked")) {
        //             checkbox_grid.parent().parent().addClass('highlight-row');
        //         } else {
        //             checkbox_grid.parent().parent().removeClass('highlight-row');
        //         }
        //     });
        // });
        // End Table Row Click Event
    </script>
@endsection