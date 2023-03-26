<script type="text/javascript">
    var table = table = $("#table-report").DataTable({
        ordering: false,
        serverSide: true,
        responsive: true,

        ajax: {
            url: "{{ route('report.datatable') }}",
            data: function(d) {
                d.DATE_FROM_TO = $('#DATE_FROM_TO').val();
            }
        },
        columns: [
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

    $(document).ready(function() {
        onSearch();

        $("#btn_search").on("click", function() {
            onSearch();
        });

        $("#btn_export_excel").on("click", function(e) {
            onExportExcel();
        });
    });

    function onSearch() {
        getChartData();
        table.draw();
        getTransactionCount();
    }

    function getTransactionCount() {
        $.ajax({
            type: "GET",
            url: "{{ route('transaksi.getByDateRangeForDashboard') }}",
            dataType: 'json',
            traditional: true,
            data: {
                'DATE_FROM_TO': $('#DATE_FROM_TO').val()
            },
            success: function(result) {
                $('#transaction_count').html(result.TRANSACTION_COUNT);
                $('#total_price').html(result.TOTAL_PRICE);

                $('#total_lunas_price').html(result.TOTAL_LUNAS_PRICE);
                $('#total_pending_price').html(result.TOTAL_PENDING_PRICE);

                $('#pending_count').html(result.PENDING_TRANSACTION_COUNT);
                $('#active_count').html(result.ACTIVE_TRANSACTION_COUNT);
                $('#cancel_count').html(result.CANCEL_TRANSACTION_COUNT);
                $('#complete_count').html(result.COMPLETE_TRANSACTION_COUNT);
            }
        });

    }

    function getChartData() {
        $.ajax({
            type: "GET",
            url: "{{ route('home.getChartData') }}",
            dataType: 'json',
            traditional: true,
            data: {
                'DATE_FROM_TO': $('#DATE_FROM_TO').val()
            },
            success: function(result) {
                console.log(result);
                initChart(result);
            }
        });

    }


    function initChart(result) {
        /*Dashboard Init*/

        "use strict";

        /*****E-Charts function start*****/
        var echartsConfig = function() {
            if ($('#e_chart_1').length > 0) {
                var eChart_1 = echarts.init(document.getElementById('e_chart_1'));
                var option = {
                    // color: ['#fd7397', '#d36ee8', '#119dd2', '#667add'],
                    tooltip: {
                        trigger: 'axis',
                        backgroundColor: 'rgba(33,33,33,1)',
                        borderRadius: 0,
                        padding: 10,
                        axisPointer: {
                            type: 'cross',
                            label: {
                                backgroundColor: 'rgba(33,33,33,1)'
                            }
                        },
                        textStyle: {
                            color: '#fff',
                            fontStyle: 'normal',
                            fontWeight: 'normal',
                            fontFamily: "'Roboto', sans-serif",
                            fontSize: 12
                        }
                    },
                    toolbox: {
                        show: true,
                        orient: 'vertical',
                        left: 'right',
                        top: 'center',
                        showTitle: false,
                        feature: {
                            mark: {
                                show: true
                            },
                            magicType: {
                                show: true,
                                type: ['line', 'bar', 'stack', 'tiled']
                            },
                            restore: {
                                show: true
                            },
                        }
                    },
                    grid: {
                        left: '3%',
                        right: '10%',
                        bottom: '3%',
                        containLabel: true
                    },
                    xAxis: [{
                        type: 'category',
                        data: result.DATE_ARRAY,
                        axisLabel: {
                            textStyle: {
                                color: '#878787',
                                fontFamily: "'Roboto', sans-serif",
                                fontSize: 12
                            }
                        },
                    }],
                    yAxis: [{
                        type: 'value',
                        minInterval: 1,
                        axisLabel: {
                            textStyle: {
                                color: '#878787',
                                fontFamily: "'Roboto', sans-serif",
                                fontSize: 12
                            }
                        },
                        splitLine: {
                            show: false,
                        },
                        ticks: {
                            callback: function(val) {
                                return Number.isInteger(val) ? val : null;
                            }
                        }
                    }],
                    series: result.BAR_ARRAY
                };

                eChart_1.setOption(option);
                eChart_1.resize();
            }
        }
        /*****E-Charts function end*****/

        /*****Sparkline function start*****/
        var sparklineLogin = function() {
            if ($('#sparkline_6').length > 0) {
                $("#sparkline_6").sparkline([12, 4, 7, 3, 8, 6, 8, 5], {
                    type: 'bar',
                    width: '100%',
                    height: '124',
                    barWidth: '3',
                    resize: true,
                    barSpacing: '10',
                    barColor: '#667add',
                    highlightSpotColor: '#667add'
                });
            }
            if ($('#sparkline_7').length > 0) {
                $("#sparkline_7").sparkline([5, 4, 24], {
                    type: 'pie',
                    width: '100',
                    height: '100',
                    sliceColors: ['#d36ee8', '#119dd2', '#667add'],
                });
            }
        }
        /*****Sparkline function end*****/

        /*****Resize function start*****/
        var sparkResize, echartResize;
        $(window).on("resize", function() {
            /*Sparkline Resize*/
            clearTimeout(sparkResize);
            sparkResize = setTimeout(sparklineLogin, 200);

            /*E-Chart Resize*/
            clearTimeout(echartResize);
            echartResize = setTimeout(echartsConfig, 300);
        }).resize();
        /*****Resize function end*****/

        /*****Function Call start*****/
        sparklineLogin();
        echartsConfig();
        /*****Function Call end*****/
    }

    function onExportExcel() {
        var query = {
            'DATE_FROM_TO': $('#DATE_FROM_TO').val()
        }

        var url = "{{ URL::to('report-export-excel') }}?" + $.param(query)

        window.location = url;
    }
</script>
