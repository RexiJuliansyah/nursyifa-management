@extends('layouts.app')
@section('title', 'Transaksi')
@section('breadcumb')
    <li>Transaksi</li>
    <li class="active"><span>List Transaksi</span></li>
@endsection


@section('content')

<input type="hidden" id="status" name="status" class="form-control" value="{{session()->get('status')}}">
<input type="hidden" id="message" name="message" class="form-control" value="{{session()->get('message')}}">

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
                            <label class="control-label mb-10">Kode Transaksi</label>
                            <input type="text" class="form-control" id="search_system_val" name="search_system_val" placeholder="System Value" value="">
                        </div>
                        <div class="col-sm-4">
                            <label class="control-label mb-10">Nama Pelanggan</label>
                            <input type="text" class="form-control" id="search_system_val" name="search_system_val" placeholder="System Value" value="">
                        </div>
                        <div class="col-sm-4">
                            <label class="control-label mb-10">Tanggal</label>
                            <input type="text" class="form-control" id="search_system_type" name="search_system_type" placeholder="System Type" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="button-list">
                                <div class="pull-left">
                                    <a href="{{ route('transaksi.baru') }}" type="button" class="btn btn-success btn-icon left-icon" id="btn_add"><i class="fa fa-plus"></i> Tambah Transaksi</a>
                                    <button href="#" type="button" class="btn btn-warning btn-icon left-icon" id="btn_edit" style="display:none"><i class="fa fa-pencil"></i><span>Edit</span></button>
                                    <button href="#" type="button" class="btn btn-danger btn-icon left-icon" id="btn_delete" style="display:none"><i class="fa fa-trash"></i><span>Delete</span></button>
                                </div>
                                <div class="pull-right">
                                    <button href="#" type="button" class="btn btn-default btn-icon left-icon txt-dark " id="btn_detail" style="display:none"><i class="fa fa-eye"></i><span>Detail</span></button>
                                    <button href="#" type="button" class="btn btn-success btn-icon left-icon" id="btn_complete" style="display:none"><i class="fa fa-check"></i><span>Selesai</span></button>
                                    <button href="#" type="button" class="btn btn-danger btn-icon left-icon" id="btn_reject" style="display:none"><i class="fa fa-close"></i><span>Batal</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default card-view ma-0 mt-10 pt-0">
                    <table id="table-transaksi" class="table table-bordered display" >
                        <thead class="thead-dark">
                            <tr>
                                <th style="width: 0px;">#</th>
                                <th>Kode Transaksi</th>
                                <th>Bus</th>
                                <th>Pelanggan</th>
                                <th>Tujuan</th>
                                <th>Tanggal Perjalanan</th>
                                <th>Status</th>
                                <th>Dibuat Oleh</th>
                                <th>Dibuat Tanggal</th>
                            </tr>
                        </thead>
                        <tbody style="cursor:pointer">
                            
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

            $('#table-transaksi tbody').on('click', 'tr', function () {
                var data = table.row(this).data();

                var checkbox_grid = $('input[name="chkRow"][data-TransactionId="'+ data["TRANSACTION_ID"] +'"]');

                if (checkbox_grid.is(":checked")) {
                    $(".grid-checkbox").prop("checked", false);
                    $(".grid-checkbox").parent().parent().removeClass('highlight-row');

                    checkbox_grid.parent().parent().removeClass('highlight-row');
                    checkbox_grid.prop("checked", false)

                    $('#btn_edit').css("display", "none");
                    $('#btn_delete').css("display", "none");
                    $('#btn_detail').css("display", "none");
                    $('#btn_complete').css("display", "none");
                    $('#btn_reject').css("display", "none");
                } else {
                    $(".grid-checkbox").prop("checked", false);
                    $(".grid-checkbox").parent().parent().removeClass('highlight-row');

                    checkbox_grid.parent().parent().addClass('highlight-row');
                    checkbox_grid.prop("checked", true)

                    $('#btn_detail').css("display", "inline-block");

                    if(data["TRANSACTION_STATUS"] == 1) {
                        $('#btn_complete').css("display", "inline-block");
                        $('#btn_reject').css("display", "inline-block");
                    } else {
                        $('#btn_edit').css("display", "none");
                        $('#btn_delete').css("display", "none");
                        $('#btn_complete').css("display", "none");
                        $('#btn_reject').css("display", "none");
                    }

                    if(data["TRANSACTION_STATUS"] == 0) {
                        $('#btn_edit').css("display", "inline-block");
                        $('#btn_delete').css("display", "inline-block");
                    } else {
                        $('#btn_edit').css("display", "none");
                        $('#btn_delete').css("display", "none");
                    }
                }
            });

        });

    </script>
@endsection