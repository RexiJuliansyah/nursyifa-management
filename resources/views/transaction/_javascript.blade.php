<script type="text/javascript">
    var gScreenMode = null;
    var gChecked = null;
    var gTransportId = null;

    var table = $("#table-transaksi").DataTable({
        ordering: false,
        serverSide: true,
        responsive: true,

        ajax: {
            url: "{{ route('transaksi.datatable') }}",
            data: function(d) {
                d.system_type = $("#search_system_type").val();
                d.system_val = $("#search_system_val").val();
            }
        },
        columns: [
            { data: 'checkbox', className: 'text-center', name: 'checkbox' },
            { data: 'TRANSACTION_ID', name: 'TRANSACTION_ID', className: 'text-left' },
            { data: 'TRANSPORT_CODE', name: 'TRANSPORT_CODE', className: 'text-center' },
            { data: 'CUSTOMER_NAME', name: 'CUSTOMER_NAME', className: 'text-center', },
            { data: 'DESTINATION', name: 'DESTINATION', className: 'text-center'},
            { data: 'DATE_FROM_TO', name: 'DATE_FROM_TO', className: 'text-center', width: "210px", },
            { data: 'STATUS', name: 'STATUS', className: 'text-center' },
            { data: 'CREATED_BY', name: 'CREATED_BY' },
            { data: 'CREATED_DATE', name: 'CREATED_DATE' },
        ]

    });

    $(document).ready(function() {

        $("#btn_delete").on("click", function() {
            onDeletePrepare();
        });

    });

    function onDeletePrepare() {
        var isHaveChecked = false;
        gChecked = 0;
        $("input[name='chkRow']").each(function() {
            if ($(this).prop('checked')) {
                isHaveChecked = true;
                gChecked = gChecked + 1;
                gTransactionId = $(".grid-checkbox-body:checked").attr('data-TransactionId');
            }
        });

        Swal.fire({
            title: 'Yakin akan menghapus transaksi ini?',
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
            url: "{{ route('transaksi.delete') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "DELETE",
            dataType: 'json',
            traditional: true,
            data: {
                'TRANSACTION_ID': gTransactionId
            },
            success: function(response) {
                if ($.isEmptyObject(response.error)) {
                    Swal.fire({   
                        title: "Success",   
                        icon: "success", 
                        text: response.message,
                        timer: 2000,   
                        showConfirmButton: false 
                    });
                    table.draw();
                    $('#btn_edit').css("display", "none");
                    $('#btn_delete').css("display", "none");
                    $('#btn_detail').css("display", "none");
                    $('#btn_complete').css("display", "none");
                    $('#btn_reject').css("display", "none");
                } else {
                    Swal.fire({   
                        title: "Error",   
                        icon: "error", 
                        text: response.error,
                        timer: 2000,   
                        showConfirmButton: false 
                    });
                    table.draw();
                    $('#btn_edit').css("display", "none");
                    $('#btn_delete').css("display", "none");
                    $('#btn_detail').css("display", "none");
                    $('#btn_complete').css("display", "none");
                    $('#btn_reject').css("display", "none");
                }
            },
            error: function(err) {
                toastr.error('Not Allowed')
            }
        })
    }

</script>