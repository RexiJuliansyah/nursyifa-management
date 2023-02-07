<script type="text/javascript">
    var gScreenMode = null;
    var gChecked = null;
    var gMenuId = null;

    var table = $("#table-user").DataTable({
        ordering: false,
        serverSide: true,
        responsive: true,
        fixedHeader: true,
        ajax: {
            url: "{{ route('user.datatable') }}",
            data: function(d) {
                d.username = $("#search_username").val();
                d.role_id = $("#search_role").val();
            }
        },
        columns: [
            { data: 'checkbox', className: 'text-center', name: 'checkbox' },
            { data: 'USERNAME', name: 'USERNAME', className: 'text-left' },
            { data: 'FULL_NAME', name: 'FULL_NAME', className: 'text-left' },
            { data: 'EMAIL', name: 'EMAIL', className: 'text-left' },
            { data: 'ROLE_NAME', name: 'ROLE_NAME', className: 'text-left' },
            { data: 'CREATED_BY', name: 'CREATED_BY' },
            { data: 'CREATED_DATE', name: 'CREATED_DATE' }
        ]

    });
    $(document).ready(function() {

        $("#btn_add").on("click", function() {
            setProgressLine();
            onAddPrepare();
        });

        $("#btn_edit").on("click", function() {
            setProgressLine();
            //onEditPrepare();
        });

        $("#btn_delete").on("click", function() {
            setProgressLine();
            //onDeletePrepare();
        });
        
        $("#btn_clear").on("click", function() {
            setProgressLine();
            $("#search_username").val("");
            $("#search_role").val("");
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
        $(".modal-title").text("Add User");
        $("#username").attr('disabled', false);
        $("#full_name").attr('disabled', false);
        $("#email").attr('disabled', false);
        $("#password").attr('disabled', false);
        $("#role_id").attr('disabled', false);
        clearAddEdit();
    }

    function setScreenToEditMode() {
        $(".modal-title").text("Edit User");
        $("#username").attr('disabled', false);
        $("#full_name").attr('disabled', false);
        $("#email").attr('disabled', false);
        $("#password").attr('disabled', false);
        $("#role_id").attr('disabled', false);
        clearAddEdit();
    }

    function clearAddEdit() {
        $('.form-group').removeClass('has-error has-danger');
        $("#username").val("");
        $("#full_name").val("");
        $("#email").val("");
        $("#password").val("");
        $("#role_id").val("");
    }

    function onAddPrepare() {
        setScreenToAddMode();
        $('#addEditPopup').modal('show');
        $('#addEditPopup').on('shown.bs.modal', function() {
            $('#username').focus();
        });
    }





    function OnSaveAddEdit() {
        $('#btn_save').prop('disabled', true);
        $('#btn_save').html('<i class="fa fa-spin fa-spinner mr-10 "></i>Saving');

        var form_data = {
            'USERNAME': $("#username").val(),
            'FULL_NAME': $("#full_name").val(),
            'EMAIL': $("#email").val(),
            'PASSWORD': $("#password").val(),
            'ROLE_ID': $("#role_id").val(),
        };

        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('user.store') }}",
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

</script>