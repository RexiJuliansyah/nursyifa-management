<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Transport;
use App\Models\Payment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use DataTables;
use File;

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

    public function datatable (Request $request)
    {
        $params = [];
        if ($request->ajax()) {

            if ($request->system_type) {
                array_push($params, ['SYSTEM_TYPE', 'like', '%' . $request->system_type . '%']);
            }

            if ($request->system_val) {
                array_push($params, ['SYSTEM_VAL', 'like', '%' . $request->system_val . '%']);
            }
            
            $q = Transaction::select([
                'tb_transaction.*',
                'sysA.SYSTEM_VAL as STATUS',
            ])
            ->leftJoin('tb_m_system as sysA', 'tb_transaction.TRANSACTION_STATUS', '=', 'sysA.SYSTEM_CD')  
            ->where('sysA.SYSTEM_TYPE', 'TRANSAKSI_STATUS')
            ->where($params)
            ->orderBy('UPDATED_DATE', 'DESC')
            ->get();

           

            return Datatables::of($q)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($item) {
                return '<input type="checkbox" name="chkRow"
                        data-TransactionId="'.$item->TRANSACTION_ID.'"
                        class="grid-checkbox grid-checkbox-body" />';
            })
            ->addColumn('DATE_FROM_TO', function ($q) {
                return with(new Carbon($q->DATE_FROM))->format('d M Y'). ' - ' .with(new Carbon($q->DATE_TO))->format('d M Y');
            })
            ->editColumn('STATUS', function ($item) {
                if($item->TRANSACTION_STATUS == 0) {
                    return '<span class="label label-warning font-weight">'.$item->STATUS .'</span>';
                } else if ($item->TRANSACTION_STATUS == 1) {
                    return '<span class="label label-primary">'.$item->STATUS .'</span>';
                } else if ($item->TRANSACTION_STATUS == 2) {
                    return '<span class="label label-danger">'.$item->STATUS .'</span>';
                } else {
                    return '<span class="label label-success">'.$item->STATUS .'</span>';
                }
            })
            ->editColumn('CREATED_DATE', function ($q) {
                return $q->CREATED_DATE ? with(new Carbon($q->CREATED_DATE))->format('d-m-Y H:i:s') : '';
            })
            ->rawColumns(['checkbox','STATUS'])
            ->make(true);
        }
    }

    public function store_transaction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'IMG_PAID_PAYMENT' => 'required|image|mimes:jpeg,png,jpg|max:3048',
            ], [
                'IMG_PAID_PAYMENT.mimes' => 'Bukti Pembayaran harus berformat jpeg, png, jpg <br>',
                'IMG_PAID_PAYMENT.max' => 'Bukti Pembayaran file maksimal 3 mb',
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
                'TIME' => $request->TIME,
                'DATE_FROM' => $request->DATE_FROM,
                'DATE_TO' => $request->DATE_TO,
                'DESTINATION' => $request->DESTINATION,
                'TRANSPORT_CODE' => $request->TRANSPORT_CODE,
                'KONDEKTUR_ID' => $request->KONDEKTUR_ID,
                'DRIVER_ID' => $request->DRIVER_ID,
                'TRANSACTION_STATUS' => 0
            ]);

            $fileName = 'BUKTI_PEMBARAYAN_'.$transaction->TRANSACTION_ID.'.'.$request->IMG_PAID_PAYMENT->extension();
            $upload = $request->IMG_PAID_PAYMENT->move(public_path('admin/upload'), $fileName);

            if ($upload) {
                Payment::query()
                ->create([
                    'TRANSACTION_ID' => $transaction->TRANSACTION_ID,
                    'AMOUNT' => $request->AMOUNT,
                    'PAID_PAYMENT' => $request->PAID_PAYMENT,
                    'PAYMENT_METHOD' => $request->PAYMENT_METHOD,
                    'IMG_PAID_PAYMENT' => $fileName,
                    'PAYMENT_STATUS' => $request->PAID_PAYMENT >= $request->AMOUNT ? 1 : 0,
                ]);

                return redirect()->route('transaksi')->with(['status' => 'success', 'message' => 'Data Transaksi berhasil ditambahkan.']);
            }
            return back()->with(['status' => 'error', 'message' => 'Data Transaksi gagal ditambahkan']);
        }
        return back()->with(['status' => 'error', 'message' => 'Data Transaksi gagal ditambahkan']);
    }



    public function delete(Request $request)
    {
        $delete_transaction = Transaction::where([
            'TRANSACTION_ID' => $request->TRANSACTION_ID
        ])->delete();
        
        if ($delete_transaction) {
            $filename = Payment::query()
            ->where(['TRANSACTION_ID' => $request->TRANSACTION_ID])
            ->first()->IMG_PAID_PAYMENT;

            if (File::exists(public_path('admin/upload/'.$filename))) {
                File::delete(public_path('admin/upload/'.$filename));
            }

            Payment::where([
                'TRANSACTION_ID' => $request->TRANSACTION_ID
            ])->delete(); 
        }
        return response()->json(['message' => 'Data berhasil dihapus!']);
    }   

}
