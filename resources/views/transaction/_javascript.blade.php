<script type="text/javascript">
    var gScreenMode = null;
    var gChecked = null;

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
            { data: 'TRANSACTION_ID', name: 'TRANSACTION_ID', className: 'text-left' },
            { data: 'CUSTOMER_NAME', name: 'CUSTOMER_NAME', className: 'text-center', },
            { data: 'DESTINATION', name: 'DESTINATION', className: 'text-left'},
            { data: 'DATE_FROM_TO', name: 'DATE_FROM_TO', className: 'text-left' },
            // { data: 'AMOUNT', name: 'DATE_FROM', className: 'text-left' },
            { data: 'TRANSACTION_STATUS', name: 'TRANSACTION_STATUS', className: 'text-left' },
            { data: 'CREATED_BY', name: 'CREATED_BY' },
            { data: 'CREATED_DATE', name: 'CREATED_DATE' },
            { data: 'ACTION', name: 'ACTION' }
        ]

    });

</script>