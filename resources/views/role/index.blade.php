@extends('layouts.app')
@section('title', 'Role Permission')
@section('breadcumb')
    <li><a href="javascript:void()">Settings</a></li>
    <li class="active"><span>Role Permission</span></li>
@endsection


@section('content')
<!-- Row -->
<div class="row">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="button-list">
                <div class="pull-left">
                    <button type="button" class="btn btn-primary btn-sm" id="btn_add"><span class="fa fa-plus"></span> Add</button>
                    <button type="button" class="btn btn-warning btn-sm" id="btn_edit" disabled><span class="fa fa-pencil"></span> Edit</button>
                    <button type="button" class="btn btn-danger btn-sm" id="btn_delete" disabled><span class="fa fa-trash"></span> Delete</button>
                </div>
                <div class="pull-right">
                    <button type="button" class="btn btn-primary btn-sm" id="btn_permission" disabled><span class="fa fa-lock"></span> Permission</button>
                </div>
            </div>
            
            <div class="table-wrap">
                <div class="">
                    <table id="table-role" class="table table-bordered table-hover display">
                        <thead class="thead-dark">
                            <tr>
                                <th style="width: 0px;">
                                    <input type="checkbox" class="grid-checkbox" name="checkall" id="checkall" style="cursor:pointer"/>
                                </th>
                                <th>Role Name</th>
                                <th>Role Description</th>
                                <th>Created By</th>
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
                $("#btn_edit").prop("disabled", ($("input[name='chkRow']:checked").length == 1) ? false : true);
                $("#btn_delete").prop("disabled", ($("input[name='chkRow']:checked").length == 1) ? false : true);
                $("#btn_permission").prop("disabled", ($("input[name='chkRow']:checked").length == 1) ? false : true);

                var checkbox_grid = $('input[name="chkRow"][data-RoleId="'+ data["ROLE_ID"] +'"]');
                checkbox_grid.click();
                if (checkbox_grid.is(":checked")) {
                    checkbox_grid.parent().parent().addClass('highlight-row');
                } else {
                    checkbox_grid.parent().parent().removeClass('highlight-row');
                }
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