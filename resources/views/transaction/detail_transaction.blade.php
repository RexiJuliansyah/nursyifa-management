@extends('layouts.app')
@section('title', 'Transaksi')

@section('content')

<div class="row">
    <div class="panel panel-success card-view mt-10">

        <div class="panel-heading pt-10 pb-10">
            <div class="pull-left">
                <h6 class="panel-title txt-light">Detail Transaksi #{{ $data['detail_transaction']->TRANSACTION_ID }}</h6>
            </div>
            <div class="clearfix"></div>
        </div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-8">
                    <div class="panel panel-success card-view">
                        <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-account mr-10"></i>Pelanggan</h6>
                        <hr class="light-green-hr mb-10" />

                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label class="control-label">Nama Pelanggan</label>
                                    <input type="text" id="CUSTOMER_NAME" name="CUSTOMER_NAME" class="form-control" style="background-color: white; cursor:default;" value="{{ $data['detail_transaction']->CUSTOMER_NAME }}" readonly>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">No Telp / No Whatsapp </label>
                                    <input type="text" id="CUSTOMER_CONTACT" name="CUSTOMER_CONTACT" class="form-control" style="background-color: white; cursor:default;" value="{{ $data['detail_transaction']->CUSTOMER_CONTACT }}"  readonly>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label">Jumlah Penumpang</label>
                                    <input type="number" id="CUSTOMER_AMOUNT" name="CUSTOMER_AMOUNT" class="form-control" style="background-color: white; cursor:default;" value="{{ $data['detail_transaction']->CUSTOMER_AMOUNT }}"  readonly>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label class="control-label">Tanggal Perjalanan</label>
                                    <div class="input-group date_range">
                                        <input class="form-control input-daterange-datepicker" id='DATE_FROM_TO' type="text" name="DATE_FROM_TO" style="background-color: white; cursor:default;"
                                                value="{{ date('d M Y', strtotime($data['detail_transaction']->DATE_FROM)); }} - {{ date('d M Y', strtotime($data['detail_transaction']->DATE_TO)); }}"  readonly>
                                        <span class="input-group-addon">
                                            <span class="fa fa-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label">Jam</label>
                                    <div class="input-group time" id="datetimepicker2">
                                        <input id='TIME' type="text" name="TIME" class="form-control" style="background-color: white; cursor:default;" value="{{ $data['detail_transaction']->TIME }}" readonly>
                                        <span class="input-group-addon">
                                            <span class="fa fa-clock-o"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Tujuan</label>
                                    <input class="form-control" style="background-color: white; cursor:default;" id='DESTINATION' type="text" name="DESTINATION" 
                                        value="{{ $data['detail_transaction']->DESTINATION }}" readonly>
                                </div>
                            </div>
                        </div>

                        <br />
                            <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-info mr-10"></i>Operasional</h6>
                            <hr class="light-green-hr mb-10" />

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Bus</label>
                                    <input class="form-control" style="background-color: white; cursor:default;" id='TRANSPORT_CODE' type="text" name="TRANSPORT_CODE" value="{{ $data['detail_transaction']->TRANSPORT_CODE }}" readonly>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Supir</label>
                                    <input class="form-control" style="background-color: white; cursor:default;" id='DRIVER_NAME' type="text" name="DRIVER_NAME" value="{{ $data['detail_transaction']->DRIVER_NAME }}" readonly>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Kondektur</label>
                                    <input class="form-control" style="background-color: white; cursor:default;" id='KONDEKTUR_NAME' type="text" name="KONDEKTUR_NAME" value="{{ $data['detail_transaction']->KONDEKTUR_NAME }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if( count($data['detail_expense']) > 0)
                        <div class="panel panel-success card-view">
                            <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-info mr-10"></i>Pengeluaran</h6>
                            <hr class="light-green-hr mb-10" />

                            <table class="table table-bordered display" style=" width:100%;" >
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Jenis Pengeluaran</th>
                                        <th>Jumlah Pengeluaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['detail_expense'] as $key => $item)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $item->EXPENSE_NAME }}</td>
                                        <td>{{ $item->EXPENSE_AMOUNT }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                <div class="col-sm-4">
                    <div class="panel panel-default card-view">
                        <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-info mr-10"></i>Status Pembayaran 
                            @if( $data['detail_transaction']->PAYMENT_STATUS == 1 ) 
                                <span class="label label-success pull-right">LUNAS</span>
                            @else 
                                <span class="label label-primary pull-right">DANA PERTAMA</span>
                            @endif
                        </h6>
                        <hr class="light-green-hr mb-10" />

                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="txt-dark pa-10">Harga
                                    </td><td class="txt-dark pa-10">:
                                    </td><td class="txt-dark pa-10" id="amount">{{ number_format($data['detail_transaction']->AMOUNT) }}</td>
                                    
                                </tr>
                                <tr>
                                    <td class="txt-dark pa-10">Dibayar
                                    </td><td class="txt-dark pa-10">:
                                    </td><td class="txt-dark pa-10" id="paid_payment">{{ number_format($data['detail_transaction']->PAID_PAYMENT) }}</td>
                                </tr>
                                <tr>
                                    <td class="txt-dark pa-10">Sisa
                                    </td><td class="txt-dark pa-10">:
                                    </td><td class="txt-dark pa-10" id="pending_payment">{{ number_format($data['detail_transaction']->PENDING_PAYMENT) }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <hr class="light-green-hr mb-10" />

                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6 mb-20">
                                <div class="panel panel-default card-view pa-0">
                                    <div class="panel-wrapper collapse in">
                                        <div class="panel-body pa-0">
                                            <article class="col-item">
                                                <div class="photo">
                                                    <a href="{{ route('transaksi.image', $data['detail_transaction']->IMG_PAID_PAYMENT) }}" target="_blank"> 
                                                        <img src="{{ asset('admin') }}/upload/{{ $data['detail_transaction']->IMG_PAID_PAYMENT }}" class="img-responsive" alt="Dana Pertama Image"> 
                                                    </a>
                                                </div>
                                                <div class="info">
                                                    <h6>Bukti Pembayaran</h6>
                                                </div>
                                            </article>
                                        </div>
                                    </div>	
                                </div>	
                            </div>

                            @if( $data['detail_transaction']->IMG_PENDING_PAYMENT != null ) 
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="panel panel-default card-view pa-0">
                                        <div class="panel-wrapper collapse in">
                                            <div class="panel-body pa-0">
                                                <article class="col-item">
                                                    <div class="photo">
                                                        <a href="{{ route('transaksi.image', $data['detail_transaction']->IMG_PENDING_PAYMENT) }}" target="_blank"> 
                                                            <img src="{{ asset('admin') }}/upload/{{ $data['detail_transaction']->IMG_PENDING_PAYMENT }}" class="img-responsive" alt="Pelunasan Image"> 
                                                        </a>
                                                    </div>
                                                    <div class="info">
                                                        <h6>Bukti Pelunasan</h6>
                                                    </div>
                                                </article>
                                            </div>
                                        </div>	
                                    </div>	
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="panel-footer">
            <div class="button-list pull-right mb-10">
                <!-- <button type="submit" class="btn btn-success mr-10">
                    Proceed to payment 
                </button> -->
                <a href="{{ route('transaksi') }}" type="button" class="btn btn-success btn-icon btn-sm left-icon pr-10 pl-10" id="btn_add"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
@include('transaction._javascript')
@endsection