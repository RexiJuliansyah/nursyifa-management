<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Transport;
use App\Models\Payment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use DataTables;

use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class TransactionController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index()
    {
        $data['title'] = 'Transaksi';
        return view('transaction/index');
    }

    public function add_transaction()
    {
        $data['title'] = 'Transaksi';
        $data['transport_list'] = Transport::select([
                'tb_m_transport.*',
                'tb_m_system.SYSTEM_VAL as BUS_SEAT_TYPE',
            ])
            ->leftJoin('tb_m_system', 'tb_m_transport.TRANSPORT_TYPE', '=', 'tb_m_system.SYSTEM_CD') 
            ->where('tb_m_system.SYSTEM_TYPE', 'BUS_SEAT_TYPE')
            ->get();
        return view('transaction/add_transaction', compact('data'));
    }

    public function store_transaction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'IMG_PAID_PAYMENT' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ], [
                'IMG_PAID_PAYMENT.mimes' => 'Bukti Pembayaran harus berformat jpeg, png, jpg, gif, svg  <br>',
                'IMG_PAID_PAYMENT.max' => 'Bukti Pembayaran file maksimal 2 mb',
            ]);

        if ($validator->passes()) {

            $daterange = explode(' - ', $request->DATE_FROM_TO);

            $request['TRANSACTION_ID'] = IdGenerator::generate(['table' => 'tb_transaction', 'field' => 'TRANSACTION_ID', 'length' => 16, 'prefix' => 'TRX'.date('Ymd') ]);
            $request['DATE_FROM'] = Carbon::createFromFormat('d/m/Y', $daterange[0])->format('Y-m-d');
            $request['DATE_TO'] = Carbon::createFromFormat('d/m/Y', $daterange[1])->format('Y-m-d');

            $transaction = Transaction::query()
            ->create([
                'TRANSACTION_ID' => $request->TRANSACTION_ID,
                'CUSTOMER_NAME' => $request->CUSTOMER_NAME,
                'CUSTOMER_CONTACT' => $request->CUSTOMER_CONTACT,
                'CUSTOMER_AMOUNT' => $request->CUSTOMER_AMOUNT,
                'REMARK' => $request->REMARK,
                'DATE_FROM' => $request->DATE_FROM,
                'DATE_TO' => $request->DATE_TO,
                'DESTINATION' => $request->DESTINATION,
                'TRANSPORT_CODE' => $request->TRANSPORT_CODE,
                'DRIVER_ID' => $request->DRIVER_ID,
                'TRANSACTION_STATUS' => 0
            ]);

            $fileName = 'BUKTI_PEMBARAYAN_'.$transaction->TRANSACTION_ID.'.'.$request->IMG_PAID_PAYMENT->extension();
            $upload = $request->IMG_PAID_PAYMENT->move(public_path('admin\upload'), $fileName);

            if ($upload) {
                Payment::query()
                ->create([
                    'TRANSACTION_ID' => $transaction->TRANSACTION_ID,
                    'AMOUNT' => $request->AMOUNT,
                    'PAID_PAYMENT' => $request->PAID_PAYMENT,
                    'PAYMENT_METHOD' => $request->PAYMENT_METHOD,
                    'IMG_PAID_PAYMENT' => $fileName,
                    'PAYMENT_STATUS' => $request->PAID_AMOUNT >= $request->AMOUNT ? 1 : 0,
                ]);

                return back()->with(['status' => 'success', 'message' => 'Data Transaksi berhasil ditambahkan.']);
            }
            return back()->with(['status' => 'error', 'message' => 'Data Transaksi gagal ditambahkan']);
        }
        return back()->with(['status' => 'error', 'message' => 'Data Transaksi gagal ditambahkan']);
    }

}
