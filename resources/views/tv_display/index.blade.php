<!DOCTYPE html>
<html lang="en">
<head>
    <title> PO Nursyifa | Jadwal Keberangkatan</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{asset('admin')}}/favicon.ico">
	<link rel="icon" href="{{asset('admin')}}/favicon.ico" type="image/x-icon">

    <link href="{{asset('admin')}}/vendors/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('admin')}}/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>

    <link href="{{ asset('css_display') }}/style_tv.css" rel="stylesheet" type="text/css">
</head>

<body onload="realTime()">

<div class="header">
  <div class="row">
		<div class="col-sm-3 text-left">
            <img src="{{ asset('css_display') }}/logo_tv.png" width="300px" height="80px" alt="brand"  />
		</div>
  		<div class="col-sm-6 text-center ">
          <span class="tgl">JADWAL KEBERANGKATAN</span> <br/>
          <span class="bulan" id="bulan"></span>
  		</div>
  		<div class="col-sm-3 text-right">
  			<div class="jam" id="jam"></div>
  		</div>
  	</div>
</div>
      
<div class="container-fluid text-center" id="schedule" style="margin-top:10px;">
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <table id="selection-datatable" class="table table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="width: 0px;">NO</th>
                            <th>NO TRANSAKSI</th>
                            <th>TANGGAL</th>
                            <th>JAM</th>
                            <th>TUJUAN</th>
                            <th>NAMA DRIVER</th>
                            <th>NAMA KONDEKTUR</th>
                            <th>BUS</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <footer class="footer container-fluid pl-30 pr-30 mb-0">
        <div class="row">
            <div class="col-12">
                <h4 style="color: white;">2023 &copy; Perusahaan Otobus Nursyifa
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="icon-mid bi bi-box-arrow-left me-2"></i> Keluar
                    </a>
                </h4>
                
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </footer>
</div>

</body>

<!-- js  -->

<script src="{{asset('admin')}}/vendors/bower_components/jquery/dist/jquery.min.js"></script>
<script src="{{asset('admin')}}/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="{{asset('admin')}}/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
		
    function realTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        h = checkTime(h);
        m = checkTime(m);
        s = checkTime(s);
        
        var date = today.getDate();
        var month = today.getMonth();
        var montharr =["JANUARI","FEBRUARI","MARET","APRIL","MEI","JUNI","JULI","AGUSTUS","SEPTEMBER","OKTOBER","NOVEMBER","DESEMBER"];
        
        month=montharr[month];
        var year = today.getFullYear();
    
        document.getElementById('bulan').innerHTML =  month + " " + year;
        document.getElementById('jam').innerHTML = h + ":" + m + ":" + s;

        setTimeout(realTime, 1000);
    }
    function checkTime(i) {
        if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
        return i;
    }


    $(document).ready(function() {
        var table = $('#selection-datatable').DataTable({
            ordering: false,
            serverSide: true,
            responsive: true,
            lengthChange: false,
            searching: false,
            paging: false,
            info: false,
            responsive:true,

        ajax: {
            url: "{{ route('schedule.datatable') }}",
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'TRANSACTION_ID', name: 'TRANSACTION_ID', className: 'text-left' },
            { data: 'DATE_FROM', name: 'DATE_FROM', className: 'text-center', },
            { data: 'TIME', name: 'TIME', className: 'text-center', },   
            { data: 'DESTINATION', name: 'DESTINATION', className: 'text-center'},
            { data: 'DRIVER_NAME', name: 'DRIVER_NAME', className: 'text-center', },   
            { data: 'KONDEKTUR_NAME', name: 'KONDEKTUR_NAME', className: 'text-center', },   
            { data: 'TRANSPORT_CODE', name: 'TRANSPORT_CODE', className: 'text-center', },   
            { data: 'STATUS', name: 'STATUS', className: 'text-center' },
        ]
        });

        setInterval(function () {
            table.draw();
        }, 60000);


    });
  
</script>

</html>
