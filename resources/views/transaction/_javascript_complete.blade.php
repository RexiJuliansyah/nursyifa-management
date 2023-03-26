<script type="text/javascript">
    var TransactionID = 'default';

    var table_expense = $("#table-expense").DataTable({
        ordering: false,
        serverSide: true,
        responsive: true,
        lengthChange: false,
        searching: false,
        paging: false,
        info: false,
        responsive:false,

        ajax: {
            url: "{{ route('expense.datatable') }}",
            data: function(d) {
                d.transaction_id = TransactionID;
            }
        },
        columns: [
            { data: 'ACTION', name: 'ACTION', className: 'text-center' },
            { data: 'EXPENSE_NAME', name: 'EXPENSE_NAME', className: 'text-left'},
            { data: 'EXPENSE_AMOUNT', name: 'EXPENSE_AMOUNT', className: 'text-center'},
        ],
        footerCallback: function (row, data, start, end, display) {
            var api = this.api();
 
            var intVal = function (i) {
                return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };
 
            total = api
                .column(2)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
 
            $(api.column(2).footer()).html(number_format(total));
        }

    });

    $(document).ready(function() {

        $("#btn_complete").on("click", function() {
            onExpensePrepare()
            $("#completePopup").modal('show');
        });

        $("#btn_complete_save").on("click", function() {
            onCompletePrepare();
        });

        $('#expense-upload').on("submit",function(e) {
            e.preventDefault();
            $('#btn_add_expense').html('<i class="fa fa-spin fa-spinner"></i> Saving');

            var formData = new FormData(this);

            $.ajax({
                type:'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ route('expense.store') }}",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: (response) => {
                    if ($.isEmptyObject(response.error)) {
                        $("#EXPENSE_NAME").val('');
                        $("#EXPENSE_AMOUNT").val('');
                        $('.dropify-clear').click(); // reset file input

                        $('#btn_add_expense').html('<i class="fa fa-check"></i>Save');
                        table_expense.draw();
                        toastr.success(response.message)
                   
                    } else {
                        $('#btn_add_expense').html('<i class="fa fa-check"></i>Save');
                        table_expense.draw();
                        toastr.error(response.error)
                        
                    }
                },
                error: function(data){
                    toastr.error('Terjadi Kesalahan!')
                }
            });
        });

    })

    function onExpensePrepare() {
        var isHaveChecked = false;
        gChecked = 0;
        $("input[name='chkRow']").each(function() {
            if ($(this).prop('checked')) {
                isHaveChecked = true;
                gChecked = gChecked + 1;
                TransactionID = $(".grid-checkbox-body:checked").attr('data-TransactionId');
            }
        });

        if (!isHaveChecked || gChecked > 1) {
            toastr.warning('Pilih satu data untuk mengubah!')
            return;
        } else {
            $("#transaction_id_text").text(TransactionID);
            $("#TRANSACTION_ID_EX").val(TransactionID);
            table_expense.draw();
        }
    }

    function deleteExpense(expenseID) {
        var ButtonID = "#deleteEx"+expenseID;
        
        $(ButtonID).html('<i class="fa fa-spin fa-spinner"></i>');

        $.ajax({
            url: "{{ route('expense.delete') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "DELETE",
            dataType: 'json',
            traditional: true,
            data: {
                'EXPENSE_ID': expenseID
            },
            success: function(response) {
                if ($.isEmptyObject(response.error)) {
                    table_expense.draw();
                    toastr.success(response.message)
                } else {
                    table_expense.draw();
                    toastr.error(response.error)
                }
            },
            error: function(err) {
                toastr.error('Terjadi Kesalahan!')
            }
        })
    }

    function onCompletePrepare() {
        Swal.fire({
            title: 
                '<strong>'+TransactionID+'</strong>' +
                '<h5>Selesaikan transaksi? </h5>', 
            icon: 'info',
            html:
                'Transaksi yang telah selesai tidak dapat dirubah, ' +
                'setelah anda menyelesaikan Transaksi ini.',
            showCancelButton: true,
            buttonsStyling:false,
            focusConfirm: false,
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-default mr-10',
            },
            confirmButtonText: 'Selesai',
            cancelButtonText: 'Close',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                setProgressLine();
                onConfirmComplete();
            }
        });
    }

    function onConfirmComplete() {
        $("#completePopup").modal('hide');
        $.ajax({
            url: "{{ route('transaksi.complete') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            dataType: 'json',
            traditional: true,
            data: {
                'TRANSACTION_ID': TransactionID
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
                    setScreenDefault()
                } else {
                    Swal.fire({   
                        title: "Error",   
                        icon: "error", 
                        text: response.error,
                        timer: 2000,   
                        showConfirmButton: false 
                    });

                    table.draw();
                    setScreenDefault()
                }
            },
            error: function(err) {
                toastr.error('Terjadi Kesalahan!')
            }
        })
    }


</script>