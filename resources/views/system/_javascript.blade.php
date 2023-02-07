<script type="text/javascript">
    var gScreenMode = null;
    var gChecked = null;
    var gSystemType = null;
    var gSystemCd = null;

    var table = $("#table-system").DataTable({
        ordering: false,
        serverSide: true,
        responsive: true,
        searching: false,
        ajax: {
            url: "{{ route('system.datatable') }}",
            data: function(d) {
                d.system_type = $("#search_system_type").val();
                d.system_val = $("#search_system_val").val();
            }
        },
        columns: [
            { data: 'checkbox', className: 'text-center', name: 'checkbox' },
            { data: 'SYSTEM_TYPE', name: 'MENU_NAME', className: 'text-left' },
            { data: 'SYSTEM_CD', name: 'SYSTEM_CD', className: 'text-center', },
            { data: 'SYSTEM_VAL', name: 'SYSTEM_VAL', className: 'text-left'},
            { data: 'SYSTEM_DESC', name: 'SYSTEM_DESC', className: 'text-left' },
            { data: 'CREATED_BY', name: 'CREATED_BY' },
            { data: 'CREATED_DATE', name: 'CREATED_DATE' }
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
        
        $("#btn_clear").on("click", function() {
            setProgressLine();
            $("#search_system_type").val("");
            $("#search_system_val").val("");
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

        //auto search with enter button
        $("#search_system_type").on("keyup", function (e) {
            if (e.keyCode === 13) {
                e.preventDefault();
                $("#btn_search").click();
            }
        });
    });

    function setScreenToAddMode() {
        gScreenMode = 'ADD';
        $(".modal-title").text("Add Master System");
        $("#system_type").attr('readonly', false);
        $("#system_cd").attr('readonly', false);
        clearAddEdit();
    }

    function setScreenToEditMode() {
        gScreenMode = 'EDIT';
        $(".modal-title").text("Edit Master Menu");
        $("#system_type").attr('readonly', true);
        $("#system_cd").attr('readonly', true);
        clearAddEdit();
    }

    function clearAddEdit() {
        $('.form-group').removeClass('has-error has-danger');
        $("#system_type").val("");
        $("#system_cd").val("");
        $("#system_val").val("");
        $("#system_desc").val("");
    }

    function onAddPrepare() {
        setScreenToAddMode();
        $('#addEditPopup').modal('show');
        $('#addEditPopup').on('shown.bs.modal', function() {
            $('#system_type').focus();
        });
    }

    function onEditPrepare() {
        var isHaveChecked = false;
        gChecked = 0;
        $("input[name='chkRow']").each(function() {
            if ($(this).prop('checked')) {
                isHaveChecked = true;
                gChecked = gChecked + 1;
                gSystemType = $(".grid-checkbox-body:checked").attr('data-SystemType');
                gSystemCd = $(".grid-checkbox-body:checked").attr('data-SystemCd');
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
                gSystemType = $(".grid-checkbox-body:checked").attr('data-SystemType');
                gSystemCd = $(".grid-checkbox-body:checked").attr('data-SystemCd');
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

    function onSuccessEdit() {
        setScreenToEditMode();

        $.ajax({
            type: "GET",
            url: "{{ route('system.getbykey') }}",
            dataType: 'json',
            traditional: true,
            data: {
                'SYSTEM_TYPE': gSystemType,
                'SYSTEM_CD': gSystemCd
            },
            success: function(result) {
                $("#system_type").val(result.SYSTEM_TYPE);
                $("#system_cd").val(result.SYSTEM_CD);
                $("#system_val").val(result.SYSTEM_VAL);
                $("#system_desc").val(result.SYSTEM_DESC);

                $("#addEditPopup").modal('show');
                $('#addEditPopup').on('shown.bs.modal', function() {
                    $('#system_val').focus();
                });
            }
        });

    }

    function OnSaveAddEdit() {
        $('#btn_save').prop('disabled', true);
        $('#btn_save').html('<i class="fa fa-spin fa-spinner mr-10 "></i>Saving');

        var form_data = {
            'MODE': gScreenMode,
            'SYSTEM_TYPE': $("#system_type").val(),
            'SYSTEM_CD': $("#system_cd").val(),
            'SYSTEM_VAL': $("#system_val").val(),
            'SYSTEM_DESC': $("#system_desc").val(),
        };

        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('system.store') }}",
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
            url: "{{ route('system.delete') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "DELETE",
            dataType: 'json',
            traditional: true,
            data: {
                'SYSTEM_TYPE': gSystemType,
                'SYSTEM_CD': gSystemCd
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


    function isNumber(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    };

    
</script>
