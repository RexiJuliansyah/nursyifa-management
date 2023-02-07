@extends('layouts.app')
@section('title', 'Bus Master')
@section('breadcumb')
    <li><a href="javascript:void()">Master</a></li>
    <li class="active"><span>Bus</span></li>
@endsection

@section('content')
<!-- Row -->
<div class="row">
    <div class="panel panel-default">
        <div class="panel-wrapper">
            <div class="panel-body">
                <div class="form-horizontal">
                    <div class="form-group mb-1">
                        <div class="col-sm-12">
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
                                    <label class="control-label mb-10">Jenis Bus</label>
                                    <select name="search_transport_type" id="search_transport_type" class=" form-control">
                                        <option value="">-- All --</option>
                                        @foreach ($data['transport_list'] as $transport)
                                            <option value="{{ $transport->SYSTEM_CD }}">{{ $transport->SYSTEM_VAL }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>	
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">

            <div class="button-list">
                <div class="pull-left">
                    <button type="button" class="btn btn-primary btn-sm" id="btn_add"><span class="fa fa-plus"></span> Add</button>
                    <button type="button" class="btn btn-warning btn-sm" id="btn_edit" disabled><span class="fa  fa-pencil"></span> Edit</button>
                    <button type="button" class="btn btn-danger btn-sm" id="btn_delete" disabled><span class="fa fa-trash"></span> Delete</button>
                </div>
                <div class="pull-right">
                    <button type="button" class="btn btn-default btn-sm" id="btn_clear"><span class="fa fa-close"></span> Clear Filter</button>
                    <button type="button" class="btn btn-primary btn-sm" id="btn_search"><span class="fa fa-search"></span> Search</button>
                </div>
            </div>
            
            <div class="table-wrap">
                <div class="">
                    <table id="table-transport" class="table table-bordered table-hover display" >
                        <thead class="thead-dark">
                            <tr>
                                <th style="width: 0px;">
                                    <input type="checkbox" class="grid-checkbox" name="checkall" id="checkall" style="cursor:pointer"/>
                                </th>
                                <th>Kode Bus</th>
                                <th>Nama Bus</th>
                                <th>Jenis Bus</th>
                                <th>Status</th>
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
<!-- /Row -->
@include('transport._popup')

@endsection

@section('javascript')
    
    @include('transport._javascript')
    <script type="text/javascript">
        var pChecked = null;
        // Table Row Click Event
        $(document).ready(function() {
            $("#checkall").click(function() {
                $(".grid-checkbox").prop("checked", $("#checkall").is(":checked"));
                $(this).is(":checked") ? $(".grid-checkbox").parent().parent().addClass('highlight-row') : $(".grid-checkbox").parent().parent().removeClass('highlight-row');
                $("#btn_edit").prop("disabled", ($("input[name='chkRow']:checked").length == 1) ? false : true);
                $("#btn_delete").prop("disabled", ($("input[name='chkRow']:checked").length == 1) ? false : true);
            });

            $('#table-transport tbody').on('click', 'tr', function () {
                var data = table.row(this).data();
                $("#btn_edit").prop("disabled", ($("input[name='chkRow']:checked").length == 1) ? false : true);
                $("#btn_delete").prop("disabled", ($("input[name='chkRow']:checked").length == 1) ? false : true);

                var checkbox_grid = $('input[name="chkRow"][data-TransportId="'+ data["TRANSPORT_ID"] +'"]');
                checkbox_grid.click();
                if (checkbox_grid.is(":checked")) {
                    checkbox_grid.parent().parent().addClass('highlight-row');
                } else {
                    checkbox_grid.parent().parent().removeClass('highlight-row');
                }
            });
        });
        // End Table Row Click Event
    </script>
@endsection