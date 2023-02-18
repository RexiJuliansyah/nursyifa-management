@extends('layouts.app')
@section('title', 'Role Permission')
@section('breadcumb')
    <li><a href="javascript:void()">Settings</a></li>
    <li class="active"><span>Role Permission</span></li>
@endsection


@section('content')
<!-- Row -->
<div class="row">
    <div class="panel panel-success card-view mt-10">
        <div class="panel-heading pt-10 pb-10">
            <div class="pull-left">
                <h6 class="panel-title txt-light">Hak Akses Setting</h6>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="panel-body">
            <div class="panel panel-success card-view ma-0 pt-0 pb-10">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="button-list">
                            <div class="pull-left">
                                <button type="button" class="btn btn-success btn-sm left-icon pr-10 pl-10" id="btn_add"><i class="fa fa-plus"></i> Tambah</button>
                                <button type="button" class="btn btn-warning btn-sm center-icon pr-10 pl-10" id="btn_edit" disabled><i class="fa fa-pencil"></i></button>
                                <button type="button" class="btn btn-danger btn-sm center-icon pr-10 pl-10" id="btn_delete" disabled><i class="fa fa-trash"></i></button>
                            </div>
                            <div class="pull-right">
                                <button type="button" class="btn btn-success btn-sm left-icon pr-10 pl-10" id="btn_permission" disabled><i class="fa fa-lock"></i> Permission</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default card-view ma-0 mt-10 pt-0">
                <table id="table-role" class="table table-bordered table-hover display">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 0px;">#</th>
                            <th>Role Name</th>
                            <th>Role Description</th>
                            <th>Created By</th>
                            <th>Created Date</th>
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

@include('role._popup')
@include('role._popupPermission')


@endsection

@section('javascript')
    
    @include('role._javascript')
    <script type="text/javascript">
        var pChecked = null;
        // Table Row Click Event
        $(document).ready(function() {
            $("#checkall").click(function() {
                $(".grid-checkbox").prop("checked", $("#checkall").is(":checked"));
                $(this).is(":checked") ? $(".grid-checkbox").parent().parent().addClass('highlight-row') : $(".grid-checkbox").parent().parent().removeClass('highlight-row');
                $("#btn_edit").prop("disabled", ($("input[name='chkRow']:checked").length == 1) ? false : true);
                $("#btn_delete").prop("disabled", ($("input[name='chkRow']:checked").length == 1) ? false : true);
                $("#btn_permission").prop("disabled", ($("input[name='chkRow']:checked").length == 1) ? false : true);
            });

            $('#table-role tbody').on('click', 'tr', function () {
                var data = table.row(this).data();
                var checkbox_grid = $('input[name="chkRow"][data-RoleId="'+ data["ROLE_ID"] +'"]');

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
                $("#btn_permission").prop("disabled", ($("input[name='chkRow']:checked").length == 1) ? false : true);
            });
        });
        // End Table Row Click Event


        $(document).on("change", "input[name=permissionChkRow]", function() {
            $("#checkAll").prop("checked", $('.grid-checkbox-permission:not(#checkAll)').not(':checked').length == 0);
            var parentId = $(this).attr('data-parentId');
            var menuId = $(this).attr('data-menuId');
            
            if (this.checked) {
                if (parentId != 0) {
                    $('input[name=permissionChkRow][data-menuId="' + parentId + '"]').prop('checked', true);
                } else {
                    $('input[name=permissionChkRow][data-parentId="' + menuId + '"]').prop('checked', true);
                }
                $("#checkAll").prop("checked", $('.grid-checkbox-permission:not(#checkAll)')
                    .not(':checked').length == 0);
            } else {
                if (parentId != 0) {
                    if ($('input[name=permissionChkRow][data-parentId="' + parentId +'"]:checked').length == 0) {
                        $('input[name=permissionChkRow][data-menuId="' + parentId + '"]').prop('checked', false);
                    }
                } else {
                    $('input[name=permissionChkRow][data-parentId="' + menuId + '"]').prop('checked', false);
                }
            }
        });

        $(document).on("click", "#btn_all_access", function() {
            $("input[name=permissionChkRow]").prop("checked", true);
        });

        $(document).on("click", "#btn_clear_access", function() {
            $("input[name=permissionChkRow]").prop("checked", false);
        });
        btn_clear_access
    </script>
@endsection