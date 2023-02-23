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
            { data: 'CUSTOMER_NAME', name: 'CUSTOMER_NAME', className: 'text-center', },
            { data: 'TRANSPORT_CODE', name: 'TRANSPORT_CODE', className: 'text-center' },
            { data: 'DESTINATION', name: 'DESTINATION', className: 'text-center'},
            { data: 'DATE_FROM_TO', name: 'DATE_FROM_TO', className: 'text-center', width: "210px", },
            { data: 'STATUS_PEMBAYARAN', name: 'STATUS_PEMBAYARAN', className: 'text-center' },       
            { data: 'STATUS', name: 'STATUS', className: 'text-center' },
            { data: 'CREATED_BY', name: 'CREATED_BY', className: 'text-center' },
        ]

    });

    $(document).ready(function() {

        $("#btn_detail").on("click", function() {
            onDetailPrepare();
        });

        $("#btn_confirm").on("click", function() {
            onConfirmPrepare();
        });

        $("#btn_delete").on("click", function() {
            onDeletePrepare();
        });

        $("#btn_lunas").on("click", function() {
            onCompletePrepare();
        });

        $("#btn_complete").on("click", function() {
            $("#completePopup").modal('show');
        });

        $('#pending-upload').on("submit",function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                type:'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ route('transaksi.lunas') }}",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: (response) => {
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
                    $("#bayarPopup").modal('hide');
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
                    // $("#bayarPopup").modal('hide');
                }
                },
                error: function(data){
                    toastr.error('Terjadi Kesalahan!')
                    // $("#bayarPopup").modal('hide');
                }
            });
        });
        
    });

    function onDetailPrepare() {
        var isHaveChecked = false;
        gChecked = 0;
        $("input[name='chkRow']").each(function() {
            if ($(this).prop('checked')) {
                isHaveChecked = true;
                gChecked = gChecked + 1;
                gTransactionId = $(".grid-checkbox-body:checked").attr('data-TransactionId');
            }
        });

        if (!isHaveChecked || gChecked > 1) {
            toastr.warning('Pilih satu data untuk mengubah!')
            return;
        } else {
            getDetailData();
        }
    }

    function onConfirmPrepare() {
        var isHaveChecked = false;
        gChecked = 0;
        $("input[name='chkRow']").each(function() {
            if ($(this).prop('checked')) {
                isHaveChecked = true;
                gChecked = gChecked + 1;
                gTransactionId = $(".grid-checkbox-body:checked").attr('data-TransactionId');
            }
        });

        if (!isHaveChecked || gChecked > 1) {
            toastr.warning('Pilih satu data untuk mengubah!')
            return;
        } else {
            Swal.fire({
                title: 
                    '<strong>'+gTransactionId+'</strong>' +
                    '<h5>Konfirmasi transaksi ini? </h5>', 
                icon: 'info',
                html:
                    'Notifikasi SMS akan dikirimkan kepada <strong>Pelanggan</strong>, ' +
                    'setelah anda mengkonfirmasi Transaksi ini.',
                showCancelButton: true,
                buttonsStyling:false,
                focusConfirm: false,
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-default mr-10',
                },
                confirmButtonText: 'Confirm',
                cancelButtonText: 'Close',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    setProgressLine();
                    onConfirmTransaction();
                }
            });
        }
    }

    function onCompletePrepare() {
        var isHaveChecked = false;
        gChecked = 0;
        $("input[name='chkRow']").each(function() {
            if ($(this).prop('checked')) {
                isHaveChecked = true;
                gChecked = gChecked + 1;
                gTransactionId = $(".grid-checkbox-body:checked").attr('data-TransactionId');
            }
        });

        if (!isHaveChecked || gChecked > 1) {
            toastr.warning('Pilih satu data untuk mengubah!')
            return;
        } else {
            getCompleteData();
        }
    }

    function getDetailData() {
        $.ajax({
            type: "GET",
            url: "{{ route('transaksi.getbykey') }}",
            dataType: 'json',
            traditional: true,
            data: {
                'TRANSACTION_ID': gTransactionId
            },
            success: function(result) {
                $("#transaction_id").text(result.TRANSACTION_ID);
                $("#customer_name").text(result.CUSTOMER_NAME);
                $("#customer_contact").text(result.CUSTOMER_CONTACT);
                $("#customer_amount").text(result.CUSTOMER_AMOUNT);
                $("#destination").text(result.DESTINATION);
                $("#remark").text(result.REMARK);
                $("#date_from_to").text(moment(result.DATE_FROM).format('DD MMM YYYY') + ' - ' + moment(result.DATE_TO).format('DD MMM YYYY'));
                $("#time").text(result.TIME);
                $("#transport").text(result.TRANSPORT_CODE);
                $("#driver_name").text(result.DRIVER_NAME);
                $("#kondektur_name").text(result.KONDEKTUR_NAME);
                $("#amount").text(number_format(result.AMOUNT));
                $("#paid_payment").text(number_format(result.PAID_PAYMENT));
                $("#pending_payment").text(number_format(result.PENDING_PAYMENT));
                $("#img_paid_payment").text(result.IMG_PAID_PAYMENT);

                if(result.PAYMENT_STATUS == 1) {
                    $("#payment_status").html('<span class="label label-success pull-right">LUNAS</span>'); 
                } else {
                    $("#payment_status").html('<span class="label label-primary pull-right">DANA PERTAMA</span>'); 
                }
                $("#img_paid_payment").text(result.IMG_PAID_PAYMENT);
                $("#img_pending_payment").text(result.IMG_PENDING_PAYMENT);
                
                var url_paid = '{{ route("transaksi.image", ":filename") }}';
                var url_pending = '{{ route("transaksi.image", ":filename") }}';

                url_paid = url_paid.replace(':filename', result.IMG_PAID_PAYMENT);
                $("#download_paid_img").attr("href", url_paid);

                url_pending = url_pending.replace(':filename', result.IMG_PENDING_PAYMENT);
                $("#download_pending_img").attr("href", url_pending);

                $("#detailPopup").modal('show');
            }
        });

    }

    function getCompleteData() {
        $.ajax({
            type: "GET",
            url: "{{ route('transaksi.getbykey') }}",
            dataType: 'json',
            traditional: true,
            data: {
                'TRANSACTION_ID': gTransactionId
            },
            success: function(result) {
                $("#transaction_id_p").text(result.TRANSACTION_ID);

                $("#TRANSACTION_ID_H").val(result.TRANSACTION_ID);
                $("#AMOUNT").val(number_format(result.AMOUNT));
                $("#PAID_PAYMENT").val(number_format(result.PAID_PAYMENT));
                $("#PENDING_PAYMENT").val(number_format(result.PENDING_PAYMENT));

                if(result.PAYMENT_STATUS == 1) {
                    $("#payment_status_p").html('<span class="label label-success pull-right">LUNAS</span>'); 
                } else {
                    $("#payment_status_p").html('<span class="label label-primary pull-right">DANA PERTAMA</span>'); 
                }

                $("#bayarPopup").modal('show');
            }
        });

    }

    function onConfirmTransaction() {
        $.ajax({
            url: "{{ route('transaksi.confirm') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            dataType: 'json',
            traditional: true,
            data: {'TRANSACTION_ID': gTransactionId},
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

    function number_format(angka) {
	
        var	number_string = angka.toString(),
            sisa 	= number_string.length % 3,
            rupiah 	= number_string.substr(0, sisa),
            ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
                
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        // Cetak hasil
        return rupiah;
    }

    function setScreenDefault() {
        $('#btn_detail').prop("disabled", true);
        $(".grid-checkbox").prop("checked", false);
        $(".grid-checkbox").parent().parent().removeClass('highlight-row');

        $('#btn_edit').css("display", "none");
        $('#btn_delete').css("display", "none");
        $('#btn_confirm').css("display", "none");
        $('#btn_lunas').css("display", "none");
        $('#btn_complete').css("display", "none");
    }

</script>