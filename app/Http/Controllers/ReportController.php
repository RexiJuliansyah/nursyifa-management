<?php

namespace App\Http\Controllers;

use App\Exports\TransactionExport;
use App\Models\System;
use App\Models\Transport;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use Exception;

class ReportController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index()
    {
        $data['title'] = 'Report Transaksi';
        $data['transport_list'] = Transport::all();
        $data['transaksi_status_list'] = System::select('SYSTEM_CD', 'SYSTEM_VAL')->where('SYSTEM_TYPE', '=', 'TRANSAKSI_STATUS')->orderBy('SYSTEM_CD')->get();
        return view('report/index', compact('data'));
    }

    public function get_transaction_data(Request $request)
    {
        $params = [];
        if ($request->transport_code) {
            array_push($params, ['TRANSPORT_CODE', 'like', '%' . $request->transport_code . '%']);
        }

        if ($request->destination) {
            array_push($params, ['DESTINATION', 'like', '%' . $request->destination . '%']);
        }

        if ($request->customer) {
            array_push($params, ['CUSTOMER_NAME', 'like', '%' . $request->customer . '%']);
        }

        if (isset($request->payment_status)) {
            array_push($params, ['PAYMENT_STATUS', 'like', '%' . $request->payment_status . '%']);
        }

        if (isset($request->transaction_status)) {
            array_push($params, ['TRANSACTION_STATUS', 'like', '%' . $request->transaction_status . '%']);
        }

        $q = Transaction::select([
            'tb_transaction.*',
            'tb_m_transport.TRANSPORT_NAME',
            'tb_payment.PAYMENT_STATUS',
            'tb_payment.AMOUNT',
            'tb_payment.PAID_PAYMENT',
            'tb_payment.PENDING_PAYMENT',
            'sysA.SYSTEM_VAL as STATUS',
        ])
            ->leftJoin('tb_payment', 'tb_transaction.TRANSACTION_ID', '=', 'tb_payment.TRANSACTION_ID')
            ->leftJoin('tb_m_system as sysA', 'tb_transaction.TRANSACTION_STATUS', '=', 'sysA.SYSTEM_CD')
            ->leftJoin('tb_m_transport', 'tb_transaction.TRANSPORT_CODE', '=', 'tb_m_transport.TRANSPORT_CODE')
            ->where('sysA.SYSTEM_TYPE', 'TRANSAKSI_STATUS')
            ->where($params);

        if ($request->DATE_FROM_TO) {
            $daterange = explode(' - ', $request->DATE_FROM_TO);

            $date_from = Carbon::createFromFormat('d/m/Y', $daterange[0])->format('Y-m-d');
            $date_to = Carbon::createFromFormat('d/m/Y', $daterange[1])->format('Y-m-d');

            $q->whereBetween('tb_transaction.DATE_FROM', [$date_from, $date_to]);
        }

        return $q->orderBy('UPDATED_DATE', 'DESC')->sharedLock()->get();
    }

    public function datatable(Request $request)
    {
        $params = [];
        if ($request->ajax()) {

            $q = $this->get_transaction_data($request);

            return Datatables::of($q)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($item) {
                    return '<input type="checkbox" name="chkRow"
                        data-TransactionId="' . $item->TRANSACTION_ID . '"
                        class="grid-checkbox grid-checkbox-body" />';
                })
                ->addColumn('DATE_FROM_TO', function ($q) {
                    return with(new Carbon($q->DATE_FROM))->format('d M Y') . ' - ' . with(new Carbon($q->DATE_TO))->format('d M Y');
                })
                ->editColumn('STATUS', function ($item) {
                    if ($item->TRANSACTION_STATUS == 0) {
                        return '<span class="label label-warning font-weight"><strong>' . $item->STATUS . '</strong></span>';
                    } else if ($item->TRANSACTION_STATUS == 1) {
                        return '<span class="label label-primary"><strong>' . $item->STATUS . '</strong></span>';
                    } else if ($item->TRANSACTION_STATUS == 2) {
                        return '<span class="label label-danger"><strong>' . $item->STATUS . '</strong></span>';
                    } else {
                        return '<span class="label label-success"><strong>' . $item->STATUS . '</strong></span>';
                    }
                })
                ->addColumn('STATUS_PEMBAYARAN', function ($item) {
                    if ($item->PAYMENT_STATUS == 0) {
                        return '<span class="text-primary"><strong>DANA PERTAMA</strong></span>';
                    } else {
                        return '<span class="text-success"><strong>LUNAS</strong></span>';
                    }
                })
                ->addColumn('HARGA', function ($q) {
                    return 'Rp. ' . number_format($q->AMOUNT, 0, '', '.');
                })
                ->addColumn('DIBAYAR', function ($q) {
                    return 'Rp. ' . number_format($q->PAID_PAYMENT, 0, '', '.');
                })
                ->rawColumns(['checkbox', 'STATUS', 'STATUS_PEMBAYARAN'])
                ->make(true);
        }
    }

    public function export_excel(Request $request)
    {
        $transaction_list = $this->get_transaction_data($request);
        foreach ($transaction_list as $transaction) {
            if ($transaction->PAYMENT_STATUS == 0) {
                $transaction->PAYMENT_STATUS_VAL = "DANA PERTAMA";
            } else {
                $transaction->PAYMENT_STATUS_VAL = "LUNAS";
            }

            $transaction->AMOUNT = 'Rp. ' . number_format($transaction->AMOUNT, 0, '', '.');
            $transaction->PAID_PAYMENT = 'Rp. ' . number_format($transaction->PAID_PAYMENT, 0, '', '.');
            $transaction->DATE_FROM_TO = with(new Carbon($transaction->DATE_FROM))->format('d M Y') . ' - ' . with(new Carbon($transaction->DATE_TO))->format('d M Y');
        }

        try {
            $export = new TransactionExport($transaction_list);
            return Excel::download($export, 'transaction_report_'.time().'.xlsx');
        } catch (Exception $e) {
            dd($e);
        }

        // $transaction_list = $this->get_transaction_data($request);
        // foreach ($transaction_list as $transaction) {
        //     if($transaction->PAYMENT_STATUS == 0) {
        //         $transaction->PAYMENT_STATUS_VAL = "DANA PERTAMA";
        //     } else {
        //         $transaction->PAYMENT_STATUS_VAL = "LUNAS";
        //     }

        //     $transaction->AMOUNT = 'Rp. '.number_format($transaction->AMOUNT, 0, '', '.');
        //     $transaction->PAID_PAYMENT = 'Rp. '.number_format($transaction->PAID_PAYMENT, 0, '', '.');
        //     $transaction->DATE_FROM_TO = with(new Carbon($transaction->DATE_FROM))->format('d M Y'). ' - ' .with(new Carbon($transaction->DATE_TO))->format('d M Y');
        // }

        // $export = new TransactionExport($transaction_list);

        // return Excel::download($export, 'siswa.xlsx');
    }
}
