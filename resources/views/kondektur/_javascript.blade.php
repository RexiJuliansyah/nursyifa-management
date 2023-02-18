<script type="text/javascript">
    var gScreenMode = null;
    var gChecked = null;
    var gKondekturId = null;

    var table = $("#table-kondektur").DataTable({
        ordering: false,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('kondektur.datatable') }}",
            data: function(d) {
                d.kondektur_name = $("#search_kondektur_name").val();
                d.kondektur_status = $("#search_kondektur_status").val();
            }
        },
        columns: [
            { data: 'checkbox', className: 'text-center', name: 'checkbox' },
            { data: 'KONDEKTUR_ID', name: 'KONDEKTUR_ID', className: 'text-left' },
            { data: 'KONDEKTUR_NAME', name: 'KONDEKTUR_NAME', className: 'text-left', },
            { data: 'NO_TELP_KONDEKTUR', name: 'NO_TELP_KONDEKTUR', className: 'text-left'},
            { data: 'STS_KONDEKTUR', name: 'STS_KONDEKTUR', className: 'text-center' }
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

            $("#search_kondektur_name").val("");
            $("#search_kondektur_status").val("").trigger('change');


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
        $(".modal-title").text("Add Kondektur");
        clearAddEdit();
    }

    function setScreenToEditMode() {
        gScreenMode = 'EDIT';
        $(".modal-title").text("Edit Kondektur");
        clearAddEdit();
    }

    function clearAddEdit() {
        $('.form-group').removeClass('has-error has-danger');
        $("#kondektur_name").val(""); 
        $("#no_telp").val(""); 
        $("#kondektur_status").val("").trigger('change');
    }

    function onAddPrepare() {
        setScreenToAddMode();
        $('#addEditPopup').modal('show');
        $('#addEditPopup').on('shown.bs.modal', function() {
            $('#kondektur_name').focus();
        });
    }

    function onEditPrepare() {
        var isHaveChecked = false;
        gChecked = 0;
        $("input[name='chkRow']").each(function() {
            if ($(this).prop('checked')) {
                isHaveChecked = true;
                gChecked = gChecked + 1;
                gKondekturId = $(".grid-checkbox-body:checked").attr('data-KondekturId');
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
            'KONDEKTUR_ID': $("#kondektur_id").val(),
            'KONDEKTUR_NAME': $("#kondektur_name").val(),
            'NO_TELP_KONDEKTUR': $("#no_telp").val(),
            'KONDEKTUR_STATUS': $("#kondektur_status").val(),
        };

        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('kondektur.store') }}",
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
            url: "{{ route('kondektur.getbykey') }}",
            dataType: 'json',
            traditional: true,
            data: {
                'KONDEKTUR_ID': gKondekturId
            },
            success: function(result) {
                $("#kondektur_id").val(result.KONDEKTUR_ID);
                $("#kondektur_name").val(result.KONDEKTUR_NAME);
                $("#no_telp").val(result.NO_TELP_KONDEKTUR);
                $("#kondektur_status").val(result.KONDEKTUR_STATUS).trigger('change');

                $("#addEditPopup").modal('show');
                $('#addEditPopup').on('shown.bs.modal', function() {
                    $('#kondektur_name').focus();
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
                gKondekturId = $(".grid-checkbox-body:checked").attr('data-KondekturId');
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
            url: "{{ route('kondektur.delete') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "DELETE",
            dataType: 'json',
            traditional: true,
            data: {
                'KONDEKTUR_ID': gKondekturId
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
