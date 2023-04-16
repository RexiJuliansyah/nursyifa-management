<!DOCTYPE html>
<html>

<head>
    <title>PO Nursyifa PDF Report</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 8pt;
        }
    </style>

    <img src="{{ public_path('admin/dist/img/logonav.png') }}" width="200px" height="55px" alt="brand" style="margin: 10px" />
    <center>
        <h4 style="margin-bottom: 35px;">Transaction Report</h4>
    </center>

    <table class='table-bordered table'>
        <thead>
            <tr style="text-align : center">
                <th>Kode Transaksi</th>
                <th>Pelanggan</th>
                <th>Jumlah Penumpang</th>
                <th>Kode Bus</th>
                <th>Nama Bus</th>
                <th>Tujuan</th>
                <th>Tanggal Perjalanan</th>
                <th>Pembayaran</th>
                <th>Status Transaksi</th>
                <th>Harga</th>
                <th>Dibayar</th>
                <th>Total Expense</th>
                <th>Dibuat Oleh</th>
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @foreach ($data as $p)
                <tr>
                    <td>{{ $p->TRANSACTION_ID }}</td>
                    <td>{{ $p->CUSTOMER_NAME }}</td>
                    <td style="text-align : center">{{ $p->CUSTOMER_AMOUNT }}</td>
                    <td>{{ $p->TRANSPORT_CODE }}</td>
                    <td>{{ $p->TRANSPORT_NAME }}</td>
                    <td>{{ $p->DESTINATION }}</td>
                    <td>{{ $p->DATE_FROM_TO }}</td>
                    <td
                        style="{{ $p->PAYMENT_STATUS == 0 ? 'color : #0000FF' : 'color : #008000' }}; text-align : center">
                        {{ $p->PAYMENT_STATUS_VAL }}</td>

                    @if ($p->TRANSACTION_STATUS == 0)
                        <td style="color : #FFA500; text-align : center">{{ $p->STATUS }}</td>
                    @elseif ($p->TRANSACTION_STATUS == 1)
                        <td style="color : #0000FF; text-align : center">{{ $p->STATUS }}</td>
                    @elseif ($p->TRANSACTION_STATUS == 2)
                        <td style="color : #FF0000; text-align : center">{{ $p->STATUS }}</td>
                    @else
                        <td style="color : #008000; text-align : center">{{ $p->STATUS }}</td>
                    @endif

                    <td>{{ $p->AMOUNT }}</td>
                    <td>{{ $p->PAID_PAYMENT }}</td>
                    <td>{{ $p->TOTAL_EXPENSE }}</td>
                    <td>{{ $p->CREATED_BY }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
