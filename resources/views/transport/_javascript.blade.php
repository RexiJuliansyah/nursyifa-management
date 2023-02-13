<script type="text/javascript">
    var gScreenMode = null;
    var gChecked = null;
    var gTransportId = null;

    var table = $("#table-transport").DataTable({
        ordering: false,
        serverSide: true,
        responsive: true,
        searching: false,
        ajax: {
            url: "{{ route('transport.datatable') }}",
            data: function(d) {
                d.transport_name = $("#search_transport_name").val();
                d.transport_code = $("#search_transport_code").val();
                d.transport_type = $("#search_transport_type").val();
            }
        },
        columns: [
            { data: 'checkbox', className: 'text-center', name: 'checkbox' },
            { data: 'TRANSPORT_CODE', name: 'TRANSPORT_CODE', className: 'text-left' },
            { data: 'TRANSPORT_NAME', name: 'TRANSPORT_NAME', className: 'text-left', },
            { data: 'BUS_TYPE', name: 'BUS_TYPE', className: 'text-left'},
            { data: 'BUS_STATUS', name: 'BUS_STATUS', className: 'text-center' }
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
            $("#search_transport_name").val("");
            $("#search_transport_code").val("");
            $("#search_transport_type").val("").trigger('change');
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
        $(".modal-title").text("Add Master Bus");
        $("#transport_code").attr('readonly', false);
        clearAddEdit();
    }

    function setScreenToEditMode() {
        gScreenMode = 'EDIT';
        $(".modal-title").text("Edit Master Menu");
        $("#transport_code").attr('readonly', true);
        clearAddEdit();
    }

    function clearAddEdit() {
        $('.form-group').removeClass('has-error has-danger');
        $("#transport_code").val("");
        $("#transport_name").val("");
        $("#transport_type").val("").trigger('change');
        $("#transport_status").val("").trigger('change');
    }

    function onAddPrepare() {
        setScreenToAddMode();
        $('#addEditPopup').modal('show');
        $('#addEditPopup').on('shown.bs.modal', function() {
            $('#transport_code').focus();
        });
    }

    function onEditPrepare() {
        var isHaveChecked = false;
        gChecked = 0;
        $("input[name='chkRow']").each(function() {
            if ($(this).prop('checked')) {
                isHaveChecked = true;
                gChecked = gChecked + 1;
                gTransportId = $(".grid-checkbox-body:checked").attr('data-TransportId');
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
            'TRANSPORT_ID': $("#transport_id").val(),
            'TRANSPORT_CODE': $("#transport_code").val(),
            'TRANSPORT_NAME': $("#transport_name").val(),
            'TRANSPORT_TYPE': $("#transport_type").val(),
            'TRANSPORT_STATUS': $("#transport_status").val(),
        };

        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('transport.store') }}",
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
            url: "{{ route('transport.getbykey') }}",
            dataType: 'json',
            traditional: true,
            data: {
                'TRANSPORT_ID': gTransportId
            },
            success: function(result) {
                $("#transport_id").val(result.TRANSPORT_ID);
                $("#transport_code").val(result.TRANSPORT_CODE);
                $("#transport_name").val(result.TRANSPORT_NAME);
                $("#transport_type").val(result.TRANSPORT_TYPE).trigger('change');
                $("#transport_status").val(result.TRANSPORT_STATUS).trigger('change');

                $("#addEditPopup").modal('show');
                $('#addEditPopup').on('shown.bs.modal', function() {
                    $('#transport_code').focus();
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
                gTransportId = $(".grid-checkbox-body:checked").attr('data-TransportId');
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
            url: "{{ route('transport.delete') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "DELETE",
            dataType: 'json',
            traditional: true,
            data: {
                'TRANSPORT_ID': gTransportId
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
