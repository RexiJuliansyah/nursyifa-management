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
            droppable: false, // this allows things to be dropped onto the calendar
            eventLimit: true, // allow "more" link when too many event
            // displayEventTime: false,
            eventRender: function(event, element, view)
            {
                if(event.color == 'blue' || event.color == 'red') {
                    element.css("color", "white");
                } else {
                    element.css("color", "black");
                }
                
                element.css("font-weight", "normal");
                element.css("font-size", "14px");
                element.text(event.id + ' - ' +  event.title);
            },
            events: transaction,
            
        });
    });
</script>
@endsection
