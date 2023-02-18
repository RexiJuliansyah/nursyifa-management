@extends('layouts.app')
@section('title', 'Transaksi')
@section('breadcumb')
    <li>Transaksi</li>
    <li class="active"><span>List Transaksi</span></li>
@endsection


@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-success card-view">

                <div class="panel-heading">
                    <div class="pull-left"><h6 class="panel-title txt-light">Data Transaksi</h6></div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <div class="calendar-wrap mt-20">
                    <div id="calendar"></div>
                    </div>
                </div>
            </div>
    </div>	
</div>	

<div id="detailCalenderPopup" class="modal fade" role="dialog" aria-labelledby="modal-title"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"># <span id="transaction_id"></span></h6>
            </div>
            <div class="form-wrap">
                <div class="modal-body pb-0">
                    <div class="panel panel-default card-view pa-15">
                        <div class="row">
                            <div class="col-xs-6">
                                <p class="txt-dark head-font inline-block capitalize-font mb-5">Pelanggan :</p>
                                <address class="mb-15">
                                    <span id="customer_name"></span><br>
                                    <span id="customer_contact"></span><br>
                                    <span id="customer_amount"></span> Orang<br>
                                </address> 
                            </div>
                            <div class="col-xs-6">
                                <p class="txt-dark head-font inline-block capitalize-font">Tujuan Perjalanan :</p>
                                <address class="mb-10">
                                    <span id="destination"></span><br>
                                    <span id="remark"></span><br>
                                </address>
                            </div>
                            <div class="col-xs-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Tanggal Perjalanan</th>
                                                <th>Waktu</th>
                                                <th>Bus</th>
                                                <th>Supir</th>
                                                <th>Kondektur</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td id="date_from_to"></td>
                                                <td id="time"></td>
                                                <td id="transport"></td>
                                                <td id="driver_name"></td>
                                                <td id="kondektur_name"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('javascript')
<script type="text/javascript">
    $(document).ready(function() {
        var transaction = @json($data['events']);
        $('#calendar').fullCalendar({
            header: {
                left: 'prev',
                center: 'title',
                right:'next'
            },
            editable: false,
            droppable: false,
            eventLimit: true,
            eventRender: function(event, element, view)
            {
                if(event.color == 'blue' || event.color == 'red' || event.color == 'green') {
                    element.css("color", "white");
                } else {
                    element.css("color", "black");
                }
                
                element.css("font-weight", "normal");
                element.css("cursor", "pointer");
                element.css("font-size", "14px");
                element.text(event.id + ' - ' +  event.title);
            },
            events: transaction,
            eventClick: function (event) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('calender.getbykey') }}",
                    dataType: 'json',
                    traditional: true,
                    data: {
                        'TRANSACTION_ID': event.id
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

                        $("#detailCalenderPopup").modal('show');
                    }
                });


                
            }
            
        });
    });
</script>
@endsection
