<script type="text/javascript">
    var gScreenMode = null;
    var gChecked = null;
    var gDriverId = null;
    var table = null;

    $(document).ready(function() {
        $("#btn_search").on("click", function() {
            setProgressLine();
            $('#table_container').css("display", "block");
            if (table == null) {
                initTable();
            }

            $('#btn_export_excel').css("display", "inline-block");
            $('#btn_export_pdf').css("display", "inline-block");
            table.draw();
        });

        $("#btn_save").on("click", function(e) {
            setProgressLine();
            OnSaveAddEdit();
        });

        $("#btn_clear").on("click", function(e) {
            setProgressLine();
            $('#table_container').css("display", "none");

            $("#search_transport_code").val("").trigger('change');
            $("#search_destination").val("");
            $("#search_customer").val("");

            $("#search_payment_status").val("").trigger('change');
            $("#search_transaction_status").val("").trigger('change');


            $('#btn_export_excel').css("display", "none");
            $('#btn_export_pdf').css("display", "none");
            if (table != null) {
                table.draw();
            }
        });

        $("#btn_export_excel").on("click", function(e) {
            onExportExcel();
        });

    });

    function initTable() {
        table = $("#table-report").DataTable({
            ordering: false,
            serverSide: true,
            responsive: true,

            ajax: {
                url: "{{ route('report.datatable') }}",
                data: function(d) {
                    d.transport_code = $("#search_transport_code").val();
                    d.destination = $("#search_destination").val();
                    d.customer = $("#search_customer").val();
                    d.payment_status = $("#search_payment_status").val();
                    d.transaction_status = $("#search_transaction_status").val();
                    d.DATE_FROM_TO = $('#DATE_FROM_TO').val();
                }
            },
            columns: [{
                    data: 'checkbox',
                    className: 'text-center',
                    name: 'checkbox'
                },
                {
                    data: 'TRANSACTION_ID',
                    name: 'TRANSACTION_ID',
                    className: 'text-left'
                },
                {
                    data: 'CUSTOMER_NAME',
                    name: 'CUSTOMER_NAME',
                    className: 'text-center',
                },
                {
                    data: 'TRANSPORT_CODE',
                    name: 'TRANSPORT_CODE',
                    className: 'text-center'
                },
                {
                    data: 'DESTINATION',
                    name: 'DESTINATION',
                    className: 'text-center'
                },
                {
                    data: 'DATE_FROM_TO',
                    name: 'DATE_FROM_TO',
                    className: 'text-center',
                    width: "210px",
                },
                {
                    data: 'STATUS_PEMBAYARAN',
                    name: 'STATUS_PEMBAYARAN',
                    className: 'text-center'
                },
                {
                    data: 'STATUS',
                    name: 'STATUS',
                    className: 'text-center'
                },
                {
                    data: 'HARGA',
                    name: 'HARGA',
                    className: 'text-center'
                },
                {
                    data: 'DIBAYAR',
                    name: 'DIBAYAR',
                    className: 'text-center'
                },
                {
                    data: 'CREATED_BY',
                    name: 'CREATED_BY',
                    className: 'text-center'
                },
            ]

        });
    }

    function onExportExcel() {
        var query = {
            'transport_code': $("#search_transport_code").val(),
            'destination': $("#search_destination").val(),
            'customer': $("#search_customer").val(),
            'payment_status': $("#search_payment_status").val(),
            'transaction_status': $("#search_transaction_status").val(),
            'DATE_FROM_TO': $('#DATE_FROM_TO').val()
        }


        var url = "{{ URL::to('report-export-excel') }}?" + $.param(query)

        window.location = url;

    }
</script>
