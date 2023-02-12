@extends('layouts.app')
@section('title', 'Menu Setting')
@section('breadcumb')
    <li><a href="javascript:void()">Settings</a></li>
    <li class="active"><span>Menu</span></li>
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
                                <div class="col-sm-6">
                                    <label class="control-label mb-10">Menu Name</label>
                                    <input type="text" class="form-control" id="menu_name_search" name="menu_name_search" placeholder="Menu Name" value="">
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label mb-10">Menu Type</label>
                                    <select name="type" id="type" class="selectpicker" data-style="form-control btn-default btn-outline">
                                        <option value="">-- All --</option>
                                        <option value="1">Menu</option>
                                        <option value="2">Sub Menu</option>
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
        <div class="panel-wrapper collapse in">
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
                        <table id="table-menu" class="table table-bordered table-hover display" >
                            <thead class="thead-dark">
                                <tr>
                                    <th style="width: 0px;">#</th>
                                    <th>Menu ID</th>
                                    <th>Menu Name</th>
                                    <th>Menu URL</th>
                                    <th>Menu Icon</th>
                                    <th>Menu Parent</th>
                                    <th>Sequence</th>
                                    <th>Created Date</th>
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
</div>
<!-- /Row -->

@include('menu._popup')

@endsection

@section('javascript')
    
    @include('menu._javascript')
    <script type="text/javascript">
        var pChecked = null;
        // Table Row Click Event
        $(document).ready(function() {
            $('#table-menu tbody').on('click', 'tr', function () {
                var data = table.row(this).data();
                var checkbox_grid = $('input[name="chkRow"][data-MenuId="'+ data["MENU_ID"] +'"]');
                
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