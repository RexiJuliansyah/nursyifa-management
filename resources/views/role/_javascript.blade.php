<script type="text/javascript">
    var gScreenMode = null;
    var gChecked = null;
    var gRoleId = null;

    var table = $("#table-role").DataTable({
        ordering: false,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('role.datatable') }}"
        },
        columns: [
            { data: 'checkbox', className: 'text-center', name: 'checkbox' },
            { data: 'ROLE_NAME', name: 'ROLE_NAME', className: 'text-left' },
            { data: 'ROLE_DESC', name: 'ROLE_DESC', className: 'text-left' },
            { data: 'CREATED_BY', name: 'CREATED_BY' },
            { data: 'UPDATED_DATE', name: 'UPDATED_DATE' }
        ]

    });
    $(document).ready(function() {
        
        $("#btn_add").on("click", function() {
            onAddPrepare();
        });

        $("#btn_edit").on("click", function() {
            onEditPrepare();
        });

        $("#btn_delete").on("click", function() {
            onDeletePrepare();
        });

        $("#btn_save").on("click", function(e) {
            OnSaveAddEdit();
        });

        $("#btn_permission").on("click", function(e) {
            onPermissionPrepare();
        });

        $("#btn_save_permission").on("click", function(e) {
            OnSavePermission();
        });
    });

    function setScreenToAddMode() {
        $(".modal-title").text("Add Role System");
        $("#role_name").attr('readonly', false);
        $("#role_desc").attr('readonly', false);
        clearAddEdit();
    }

    function setScreenToEditMode() {
        $(".modal-title").text("Edit Role Menu");
        $("#role_name").attr('readonly', false);
        $("#role_desc").attr('readonly', false);
        clearAddEdit();
    }

    function clearAddEdit() {
        $('.form-group').removeClass('has-error has-danger');
        $("#role_name").val("");
        $("#role_desc").val("");
    }

    function onAddPrepare() {
        setScreenToAddMode();
        $('#addEditPopup').modal('show');
        $('#addEditPopup').on('shown.bs.modal', function() {
            $('#role_name').focus();
        });
    }

    function onEditPrepare() {
        var isHaveChecked = false;
        gChecked = 0;
        $("input[name='chkRow']").each(function() {
            if ($(this).prop('checked')) {
                isHaveChecked = true;
                gChecked = gChecked + 1;
                gRoleId = $(".grid-checkbox-body:checked").attr('data-RoleId');
            }
        });

        if (!isHaveChecked || gChecked > 1) {
            toastr.warning('Pilih satu data untuk mengubah!')
            return;
        } else {
            onSuccessEdit();
        }
    }

    function onDeletePrepare() {
        var isHaveChecked = false;
        gChecked = 0;
        $("input[name='chkRow']").each(function() {
            if ($(this).prop('checked')) {
                isHaveChecked = true;
                gChecked = gChecked + 1;
                gRoleId = $(".grid-checkbox-body:checked").attr('data-RoleId');
            }
        });

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#667ADD',
            cancelButtonColor: '#F44934',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                setProgressLine();
                onConfirmDelete();
            }
        });

    }

    function onPermissionPrepare() {
        var isHaveChecked = false;
        gChecked = 0;
        $("input[name='chkRow']").each(function() {
            if ($(this).prop('checked')) {
                isHaveChecked = true;
                gChecked = gChecked + 1;
                gRoleId = $(".grid-checkbox-body:checked").attr('data-RoleId');
            }
        });

        if (!isHaveChecked || gChecked > 1) {
            toastr.warning('Pilih satu data untuk mengubah perizinan!')
            return;
        } else {
            onSuccessPermission();
        }
    }

    function onSuccessEdit() {
        setScreenToEditMode();

        $.ajax({
            type: "GET",
            url: "{{ route('role.getbykey') }}",
            dataType: 'json',
            traditional: true,
            data: {
                'ROLE_ID': gRoleId
            },
            success: function(result) {
                $("#role_id").val(result.ROLE_ID);
                $("#role_name").val(result.ROLE_NAME);
                $("#role_desc").val(result.ROLE_DESC);

                $("#addEditPopup").modal('show');
                $('#addEditPopup').on('shown.bs.modal', function() {
                    $('#role_name').focus();
                });
            }
        });

    }

    function OnSaveAddEdit() {
        $('#btn_save').prop('disabled', true);
        $('#btn_save').html('<i class="fa fa-spin fa-spinner mr-10 "></i>Saving');

        var form_data = {
            'ROLE_ID': $("#role_id").val(),
            'ROLE_NAME': $("#role_name").val(),
            'ROLE_DESC': $("#role_desc").val()
        };

        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('role.store') }}",
            dataType: 'json',
            traditional: true,
            data: form_data,
            success: function(response) {
                if ($.isEmptyObject(response.error)) {
                    $('#btn_save').prop('disabled', false);
                    $('#btn_save').html('Save');
                    $("#addEditPopup").modal("hide")
                    table.draw();
                    toastr.success(response.message)
                } else {
                    $('#btn_save').prop('disabled', false);
                    $('#btn_save').html('Save');
                    toastr.error(response.error)
                }
            }
        });
    }

    function onConfirmDelete() {
        $.ajax({
            url: "{{ route('role.delete') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "DELETE",
            dataType: 'json',
            traditional: true,
            data: {
                'ROLE_ID': gRoleId
            },
            success: function(response) {
                if ($.isEmptyObject(response.error)) {
                    $('#btn_edit').prop('disabled', true);
                    $('#btn_delete').prop('disabled', true);
                    toastr.success(response.message)
                    table.draw();
                } else {
                    $('#btn_edit').prop('disabled', true);
                    $('#btn_delete').prop('disabled', true);
                    toastr.error(response.error)
                    table.draw();
                }
            },
            error: function(err) {
                toastr.error('Not Allowed')
            }
        })
    }

    function onSuccessPermission() {

        $.ajax({
            type: "GET",
            url: "{{ route('role.getpermission') }}",
            dataType: 'json',
            async: false,
            traditional: true,
            data: {
                'ROLE_ID': gRoleId
            },
            success: function(response) {
                if ($.isEmptyObject(response.error)) {
                    $("#txt_role_name").text("Role Name :  " + response.data_role.ROLE_NAME);
                    $("#accordion").empty();

                    var arrayMenuId = [];
                    for (MENU_ID in response.data_permission) {
                        arrayMenuId.push(response.data_permission[MENU_ID].MENU_ID);
                    }

                    setCollapseItem(response.data_menu, arrayMenuId, gRoleId);
                    
                } else {
                    toastr.error(response.error);
                }
            }
        });

        $("#permissionPopup").modal("show");
    }


    function isNumber(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    };

    function setCollapseItem(data, arrayMenuId, id) {
        $.each(data, function(key, value) {
            if (value.PARENT_ID == 0) {
                if (arrayMenuId.includes(value.MENU_ID)) {
                    checked = "checked";
                } else {
                    checked = "";
                }

                var returnedData = $.grep(data, function(element) {
                    return element.PARENT_ID == value.MENU_ID;
                });

                $("#accordion").append(

                    '<div class="panel panel-default">' +
                    '<div class="panel-heading activestate" role="tab" id="accor_heading' + value.MENU_ID + '">' +
                    '<a role="button" id="btn'+value.MENU_ID+'" aria-expanded="true">' +
                    '<input type="checkbox" class="grid-checkbox grid-checkbox-permission grid-checkbox-body mr-10"' +
                    'name="permissionChkRow" value="' + value.MENU_ID + '" data-roleId="' +
                    id + '" data-parentId="' + value.PARENT_ID + '" data-menuId="' + value.MENU_ID +
                    '" style="cursor: pointer;" ' + checked + '>' + value.MENU_NAME +
                    '</a>'+
                    '</div>'+
                    '<div id="collapse'+value.MENU_ID+'" class="panel-collapse collapse in" role="tabpanel">' +
                    '<div class="panel-body pl-30 pt-0 pb-0 accordion-body' + value.MENU_ID +'"></div>' +
                    '</div>' +
                    '</div>' 
                );

                $("#btn"+ value.MENU_ID).on("click", function() {
                    var checkboxParent = $('input[name=permissionChkRow][data-parentId="' + value.PARENT_ID + '"][data-menuId="' + value.MENU_ID + '"]');
                    checkboxParent.click();
                });

                if (returnedData.length == 0) {
                    $("#collapse"+value.MENU_ID).remove();
                    $("#accor_heading"+ value.MENU_ID).removeClass("activestate");
                } else {
                    $.each(returnedData, function(key, row) {
                        if (arrayMenuId.includes(row.MENU_ID)) {
                            checked = "checked";
                        } else {
                            checked = "";

                        }
                        $(".accordion-body" + value.MENU_ID).append(
                            '<div class="panel-body pa-10">' + 
                            '<input type="checkbox" class="grid-checkbox grid-checkbox-permission grid-checkbox-body mr-10"' +   
                            'name="permissionChkRow" id="checkbox' +row.MENU_ID + '" value="' +row.MENU_ID + 
                            '" data-roleId="' + id + '" data-parentId="' + row.PARENT_ID + '" data-menuId="' + row.MENU_ID +
                            '" style="cursor: pointer;" ' + checked + '>' + 
                            '<label for="checkbox' +row.MENU_ID + '" class="control-label" style="cursor: pointer;">' + row.MENU_NAME + 
                            '</label>' +
                            '</div>'
                        );
                    });
                }
            }
        });
    }

    function OnSavePermission() {
        var data = [];
        var checkboxes = $('input[name=permissionChkRow]:checked')

        $('#btn_save_permission').prop('disabled', true);
        $('#btn_save_permission').html('<i class="fa fa-spin fa-spinner mr-10 "></i>Saving');

        for (var i = 0; i < checkboxes.length; i++) {
            var dtl = new Object();
            dtl.MENU_ID = checkboxes[i].value;
            dtl.ROLE_ID = $('input[name=permissionChkRow]:checked').attr('data-roleId');
            data.push(dtl);
        }

        $.ajax({
            url: "{{ route('role.storepermission') }}",
            method: "POST",
            data: {
                data: data
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if ($.isEmptyObject(response.error)) {
                    $('#btn_save_permission').prop('disabled', false);
                    $('#btn_save_permission').html('Save');
                    $("#permissionPopup").modal("hide")
                    toastr.success(response.message)
                } else {
                    $.each(response.error, function(key, value) {
                        toastr.error(value + "\n");
                    });
                    $('#btn_save_permission').prop('disabled', false);
                    $('#btn_save_permission').html('Save');
                }
                
                
            }
        });
    }

    
</script>
