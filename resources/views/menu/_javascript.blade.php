<script type="text/javascript">
    var gScreenMode = null;
    var gChecked = null;
    var gMenuId = null;

    var table = $("#table-menu").DataTable({
        ordering: false,
        serverSide: true,
        responsive: true,
        fixedHeader: true,
        ajax: {
            url: "{{ route('menu.datatable') }}",
            data: function(d) {
                d.menu_name = $("#menu_name_search").val();
                d.type = $("#type").val();
            }
        },
        columns: [
            { data: 'checkbox', className: 'text-center', name: 'checkbox' },
            { data: 'MENU_ID', visible:false, searchable: false, },
            { data: 'MENU_NAME', name: 'MENU_NAME', className: 'text-left' },
            { data: 'MENU_URL', name: 'MENU_URL', className: 'text-left' },
            { data: 'MENU_ICON', name: 'MENU_ICON', className: 'text-left' },
            { data: 'PARENT_ID', name: 'PARENT_ID', className: 'text-left' },
            { data: 'SEQUENCE', name: 'SEQUENCE', className: 'text-center' },
            { data: 'UPDATED_DATE', name: 'UPDATED_DATE' }
        ],
        fnDrawCallback: function (oSettings) {
            $('#datagrid tbody > tr').removeClass('selected');
            $('.grid-checkbox').not(this).prop('checked', false);

            $("#btn_edit").prop("disabled", ($("[name='chkRow']:checked").length == 1) ? false : true);
            $("#btn_delete").prop("disabled", ($("[name='chkRow']:checked").length == 1) ? false : true);
        },
        order: [[2, "DESC"]]

    });
    $(document).ready(function() {

        $("#parent_id").select2({placeholder: "Menu Parent"});
        
        
        if ($("input[value=Parent]").is(':checked')) {
            $("#parent_id").attr("disabled", true);
            $("#parent_id").css("background-color", "grey");
            $('#parent_id').val(null).trigger('change');
            
        }

        $("input[value=Parent]").click(function(e) {
            $("#parent_id").attr("disabled", true);
            $('#parent_id').val(null).trigger('change');
        });

        $("input[value=Child]").click(function(e) {
            $("#parent_id").attr("disabled", false);
            $("#parent_id").select2({
                placeholder: "Menu Parent",
                ajax: {
                    url: "{{ route('menu.menuSelect2') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1
                        }
                    },
                    cache: true
                }
            });
            $('#parent_id').val($('#parent_id option:eq(0)').val()).trigger('change');
        });
        
        $("#btn_add").on("click", function() {
            onAddPrepare();
        });

        $("#btn_edit").on("click", function() {
            onEditPrepare();
        });

        $("#btn_delete").on("click", function() {
            onDeletePrepare();
        });
        
        $("#btn_clear").on("click", function() {
            setProgressLine();
            $("#menu_name_search").val("");
            $("#type").val("");
            table.draw();
        });
        
        $("#btn_search").on("click", function() {
            setProgressLine();
            table.draw();
        });

        $("#btn_save").on("click", function(e) {
            setProgressLine();
            OnSaveAddEdit();
        });

        $("#btn_export").on("click", function(e) {
            setProgressLine();
            $.fileDownload("{{ route('menu.export') }}", {
                data: {
                    "menu_name" : $("#menu_name_search").val(),
                    "menu_type" : $("#type").val(),
                },
            })
        });
    });

    function setScreenToAddMode() {
        clearAddEdit();
        $(".modal-title").text("Add Master Menu");
        
    }

    function setScreenToEditMode() {
        clearAddEdit();
        $(".modal-title").text("Edit Master Menu");
    }

    function clearAddEdit() {
        $('.form-group').removeClass('has-error has-danger');

        $("#menu_id").val("");
        $("#menu_name").val("");
        $("#menu_url").val("");
        $("#parent_id").val("");
        $("#menu_sequence").val("");
        $("#menu_icon").val("");
        $("input[value=Parent]").trigger("click");
        if ($("input[value=Parent]").is(':checked')) {
            $("#parent_id").attr("disabled", true);
        }
    }

    function onAddPrepare() {
        setScreenToAddMode();
        $('#addEditPopup').modal('show');
        $('#addEditPopup').on('shown.bs.modal', function() {
            $('#menu_name').focus();
        });
    }

    function onEditPrepare() {
        var isHaveChecked = false;
        gChecked = 0;
        $("input[name='chkRow']").each(function() {
            if ($(this).prop('checked')) {
                isHaveChecked = true;
                gChecked = gChecked + 1;
                gMenuId = $(".grid-checkbox-body:checked").attr('data-MenuId');
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
        var ids = [];
        gChecked = 0;
        $("input[name='chkRow']").each(function() {
            if ($(this).prop('checked')) {
                isHaveChecked = true;
                gChecked = gChecked + 1;
                gMenuId = $(this).attr('data-MenuId');
                ids.push(gMenuId);
            }
        });

        Swal.fire({
            title: 'Yakin akan menghapus data ini?',
            icon: 'warning',
            showCancelButton: true,
            buttonsStyling:false,
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-default mr-10',
            },
            confirmButtonText: 'Delete',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                setProgressLine();
                onConfirmDelete();
            }
        });

    }

    function onSuccessEdit() {
        setScreenToEditMode();

        $.ajax({
            type: "GET",
            url: "{{ route('menu.getbykey') }}",
            dataType: 'json',
            traditional: true,
            data: {
                'MENU_ID': gMenuId
            },
            success: function(result) {

                $("#menu_id").val(result.MENU_ID);
                $("#menu_name").val(result.MENU_NAME);
                $("#menu_sequence").val(result.SEQUENCE);
                $("#menu_icon").val(result.MENU_ICON);
                $("#menu_url").val(result.MENU_URL);

                if (result.PARENT_ID != '0') {
                    $("input[value=Child]").trigger("click");
                    $("#parent_id").attr("disabled", false);
                    $("#parent_id").val(result.PARENT_ID).trigger('change');
                }

                $("#addEditPopup").modal('show');
                $('#addEditPopup').on('shown.bs.modal', function() {
                    $('#menu_name').focus();
                });
            }
        });

    }

    function OnSaveAddEdit() {
        //$('#form_add_edit').submit();
        $('#btn_save').prop('disabled', true);
        $('#btn_save').html('<i class="fa fa-spin fa-spinner mr-10 "></i>Saving');

        var form_data = {
            'MENU_ID': $("#menu_id").val(),
            'MENU_NAME': $("#menu_name").val(),
            'PARENT_ID': $("#parent_id").val(),
            'SEQUENCE': $("#menu_sequence").val(),
            'MENU_ICON': $("#menu_icon").val(),
            'MENU_URL': $("#menu_url").val(),
        };

        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('menu.store') }}",
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

    function onConfirmDelete(ids) {
        $.ajax({
            url: "{{ route('menu.delete') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "DELETE",
            dataType: 'json',
            traditional: true,
            data: {
                ids:ids
            },
            success: function(response) {
                if ($.isEmptyObject(response.error)) {
                    table.draw();
                    // getMenuTree();
                    toastr.success(response.message)
                } else {
                    table.draw();
                    toastr.error(response.error)
                }
            },
            error: function(err) {
                toastr.error('Not Allowed')
            }
        })
    }

    // function setIconPicker(icon_name) {
    //     (async () => {
    //         const response = await fetch(
    //             "{{asset('admin')}}/vendors/bower_components/iconpicker-master/dist/iconsets/bootstrap5.json"
    //         )
    //         const result = await response.json()
    //         iconpicker = new Iconpicker(document.querySelector(".iconpicker"), {
    //             icons: result,
    //             showSelectedIn: document.querySelector(".selected-icon"),
    //             defaultValue: icon_name,
    //         });
    //         iconpicker.set() // Set as empty
    //         iconpicker.set(icon_name) // Reset with a value
    //     })()
    // }

    function isNumber(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    };

    // function getMenuTree() {
    //     var data = [];
    //     $.ajax({
    //         url: "{{ route('menu.getmenutree') }}",
    //         method: "POST",
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         success: function(response) {
    //             if ($.isEmptyObject(response.error)) {
    //                 $.each(response.menus, function(key, val) {
    //                     if (val.PARENT_ID === 0) {
    //                         var parent = new Object();
    //                         parent.text = val.MENU_NAME;
    //                         parent.icon = val.MENU_ICON;
    //                         parent.state = {
    //                             'opened': true
    //                         };
    //                         parent.children = [];

    //                         var child = response.menus.filter(item => item.PARENT_ID === val
    //                             .MENU_ID);
    //                         $.each(child, function(k, v) {
    //                             var child = new Object();
    //                             child.text = v.MENU_NAME;
    //                             child.icon = v.MENU_ICON;
    //                             parent.children.push(child);
    //                         })
    //                         data.push(parent);
    //                     }
    //                 });

    //                 $("#data").jstree("destroy");
    //                 $('#data').jstree({
    //                     'core': {
    //                         'data': data
    //                     }
    //                 });
    //             } else {
    //                 alert(response.error);
    //             }
    //         }
    //     });
    // }

    
</script>
