<script type="text/javascript">
    var gScreenMode = null;
    var gChecked = null;
    var gDriverId = null;

    var table = $("#table-driver").DataTable({
        ordering: false,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('driver.datatable') }}",
            data: function(d) {
                d.driver_name = $("#search_driver_name").val();
            }
        },
        columns: [
            { data: 'checkbox', className: 'text-center', name: 'checkbox' },
            { data: 'DRIVER_ID', name: 'DRIVER_ID', className: 'text-left' },
            { data: 'DRIVER_NAME', name: 'DRIVER_NAME', className: 'text-left', },
            { data: 'NO_TELP_DRIVER', name: 'NO_TELP_DRIVER', className: 'text-left'}
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

            $("#search_driver_name").val("");

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
        
    });

    function setScreenToAddMode() {
        gScreenMode = 'ADD';
        $(".modal-title").text("Add Supir");
        clearAddEdit();
    }

    function setScreenToEditMode() {
        gScreenMode = 'EDIT';
        $(".modal-title").text("Edit Supir");
        clearAddEdit();
    }

    function clearAddEdit() {
        $('.form-group').removeClass('has-error has-danger');
        $("#driver_name").val(""); 
        $("#no_telp").val(""); 
    }

    function onAddPrepare() {
        setScreenToAddMode();
        $('#addEditPopup').modal('show');
        $('#addEditPopup').on('shown.bs.modal', function() {
            $('#driver_name').focus();
        });
    }

    function onEditPrepare() {
        var isHaveChecked = false;
        gChecked = 0;
        $("input[name='chkRow']").each(function() {
            if ($(this).prop('checked')) {
                isHaveChecked = true;
                gChecked = gChecked + 1;
                gDriverId = $(".grid-checkbox-body:checked").attr('data-DriverId');
            }
        });

        if (!isHaveChecked || gChecked > 1) {
            toastr.warning('Pilih satu data untuk mengubah!')
            return;
        } else {
            onSuccessEdit();
        }
    }


    function OnSaveAddEdit() {
        $('#btn_save').prop('disabled', true);
        $('#btn_save').html('<i class="fa fa-spin fa-spinner mr-10 "></i>Saving');

        var form_data = {
            'MODE': gScreenMode,
            'DRIVER_ID': $("#driver_id").val(),
            'DRIVER_NAME': $("#driver_name").val(),
            'NO_TELP_DRIVER': $("#no_telp").val(),
        };

        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('driver.store') }}",
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

    function onSuccessEdit() {
        setScreenToEditMode();

        $.ajax({
            type: "GET",
            url: "{{ route('driver.getbykey') }}",
            dataType: 'json',
            traditional: true,
            data: {
                'DRIVER_ID': gDriverId
            },
            success: function(result) {
                $("#driver_id").val(result.DRIVER_ID);
                $("#driver_name").val(result.DRIVER_NAME);
                $("#no_telp").val(result.NO_TELP_DRIVER);

                $("#addEditPopup").modal('show');
                $('#addEditPopup').on('shown.bs.modal', function() {
                    $('#driver_name').focus();
                });
            }
        });

    }

    function onDeletePrepare() {
        var isHaveChecked = false;
        gChecked = 0;
        $("input[name='chkRow']").each(function() {
            if ($(this).prop('checked')) {
                isHaveChecked = true;
                gChecked = gChecked + 1;
                gDriverId = $(".grid-checkbox-body:checked").attr('data-DriverId');
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

    function onConfirmDelete() {
        $.ajax({
            url: "{{ route('driver.delete') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "DELETE",
            dataType: 'json',
            traditional: true,
            data: {
                'DRIVER_ID': gDriverId
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
