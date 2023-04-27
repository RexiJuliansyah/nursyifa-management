@extends('layouts.app')
@section('title', 'Bus Master')
@section('breadcumb')
    <li><a href="javascript:void()">Master</a></li>
    <li class="active"><span>Bus</span></li>
@endsection

@section('content')
<!-- Row -->
<div class="row">
    <div class="panel panel-success card-view mt-10">
        <div class="panel-heading pt-10 pb-10">
            <div class="pull-left">
                <h6 class="panel-title txt-light">List Data Bus</h6>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="panel-body">
            <div class="panel panel-success card-view ma-0 pt-10 pb-10">
                
                <div class="row">
                    <div class="col-sm-4">
                        <label class="control-label mb-10">Kode Bus</label>
                        <input type="text" class="form-control" id="search_transport_code" name="search_transport_code" placeholder="Kode Bus" value="">
                    </div>
                    <div class="col-sm-4">
                        <label class="control-label mb-10">Nama Bus</label>
                        <input type="text" class="form-control" id="search_transport_name" name="search_transport_name" placeholder="Nama Bus" value="">
                    </div>
                    <div class="col-sm-4">
                        <label class="control-label mb-10">Tipe Seat</label>
                        <select name="search_transport_type" id="search_transport_type" class="selectpicker" data-style="form-control btn-default btn-outline">
                            <option value="">-- Semua --</option>
                            @foreach ($data['transport_list'] as $transport)
                                <option value="{{ $transport->SYSTEM_CD }}">{{ $transport->SYSTEM_VAL }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="button-list">
                            <div class="pull-left">
                                <button type="button" class="btn btn-success btn-sm left-icon pr-10 pl-10" id="btn_add"><i class="fa fa-plus"></i> Tambah</button>
                                <button type="button" class="btn btn-warning btn-sm center-icon pr-10 pl-10" id="btn_edit" disabled><i class="fa fa-pencil"></i></button>
                                <button type="button" class="btn btn-danger btn-sm center-icon pr-10 pl-10" id="btn_delete" disabled><i class="fa fa-trash"></i></button>
                            </div>
                            <div class="pull-right">
                                <button type="button" class="btn btn-default btn-icon btn-sm left-icon pr-10 pl-10" id="btn_clear">Clear</button>
                                <button type="button" class="btn btn-success btn-icon btn-sm left-icon pr-10 pl-10" id="btn_search"><i class="fa fa-search"></i>Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default card-view ma-0 mt-10 pt-0">
                <table id="table-transport" class="table table-bordered table-hover display" >
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 0px;">#</th>
                            <th>Kode Bus</th>
                            <th>Nama Bus</th>
                            <th>Tipe Seat</th>
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
@include('transport._popup')

@endsection

@section('javascript')
    
    @include('transport._javascript')
    <script type="text/javascript">
        var pChecked = null;
        // Table Row Click Event
        $(document).ready(function() {
            $('#table-transport tbody').on('click', 'tr', function () {
                var data = table.row(this).data();

                var checkbox_grid = $('input[name="chkRow"][data-TransportId="'+ data["TRANSPORT_ID"] +'"]');
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

                $("#btn_edit").prop("disabled", ($("input[name='chkRow']:checked").length == 1) ? false : true);
                $("#btn_delete").prop("disabled", ($("input[name='chkRow']:checked").length == 1) ? false : true);
            });
        });
        // End Table Row Click Event
    </script>
@endsection