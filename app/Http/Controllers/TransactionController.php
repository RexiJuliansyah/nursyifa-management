<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Transport;
use App\Models\Driver;
use App\Models\Kondektur;
use App\Models\Payment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use DataTables;
use File;
use Response;

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

    public function calender()
    {
        $events = [];
        $all_tansaction = Transaction::all();

        foreach($all_tansaction as $transaction) {
            if($transaction->TRANSACTION_STATUS == 1){
                $color = 'blue';
            } else if($transaction->TRANSACTION_STATUS == 2) {
                $color = 'red';
            } else if($transaction->TRANSACTION_STATUS == 3) {
                $color = 'green';
            } else {
                $color = 'yellow';
            } 
            array_push($events, [
                'id' => $transaction->TRANSACTION_ID, 
                'title' => $transaction->DESTINATION,
                'start' => Carbon::parse($transaction->DATE_FROM)->addDay(),
                'end' => Carbon::parse($transaction->DATE_TO)->addDay(),
                'color' => $color
            ]);
        }

        $data['title'] = 'Transaksi';
        $data['events'] = $events;
        return view('transaction/calender_transaction', compact('data'));
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
            ->where('tb_m_transport.TRANSPORT_STATUS', 1)
            ->get();

        $data['driver_list'] = Driver::where('DRIVER_STATUS', 1)->get();
        $data['kondektur_list'] = Kondektur::where('KONDEKTUR_STATUS', 1)->get();
        return view('transaction/add_transaction', compact('data'));
    }

    public function getbykey(Request $request) {
        $query = Transaction::select([
            'tb_transaction.*',
            'tb_m_driver.DRIVER_NAME',
            'tb_m_kondektur.KONDEKTUR_NAME',
            'tb_payment.AMOUNT',
            'tb_payment.PAID_PAYMENT',
            'tb_payment.PENDING_PAYMENT',
            'tb_payment.PAYMENT_STATUS',
            'tb_payment.IMG_PAID_PAYMENT',
            'tb_payment.IMG_PENDING_PAYMENT',
        ])->where(['tb_transaction.TRANSACTION_ID' => $request->TRANSACTION_ID])
        ->leftJoin('tb_m_driver', 'tb_transaction.DRIVER_ID', '=', 'tb_m_driver.DRIVER_ID') 
        ->leftJoin('tb_m_kondektur', 'tb_transaction.KONDEKTUR_ID', '=', 'tb_m_kondektur.KONDEKTUR_ID') 
        ->leftJoin('tb_payment', 'tb_transaction.TRANSACTION_ID', '=', 'tb_payment.TRANSACTION_ID')
        ->firstOrFail();
        echo json_encode($query);
    }

    public function getbykey_calender(Request $request) {
        $query = Transaction::select([
            'tb_transaction.*',
            'tb_m_driver.DRIVER_NAME',
            'tb_m_kondektur.KONDEKTUR_NAME',
        ])->where(['tb_transaction.TRANSACTION_ID' => $request->TRANSACTION_ID])
        ->leftJoin('tb_m_driver', 'tb_transaction.DRIVER_ID', '=', 'tb_m_driver.DRIVER_ID') 
        ->leftJoin('tb_m_kondektur', 'tb_transaction.KONDEKTUR_ID', '=', 'tb_m_kondektur.KONDEKTUR_ID') 
        ->firstOrFail();
        echo json_encode($query);
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
                'tb_payment.PAYMENT_STATUS',
                'sysA.SYSTEM_VAL as STATUS',
            ])
            ->leftJoin('tb_payment', 'tb_transaction.TRANSACTION_ID', '=', 'tb_payment.TRANSACTION_ID')
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
                    return '<span class="label label-warning font-weight"><strong>'.$item->STATUS .'</strong></span>';
                } else if ($item->TRANSACTION_STATUS == 1) {
                    return '<span class="label label-primary"><strong>'.$item->STATUS .'</strong></span>';
                } else if ($item->TRANSACTION_STATUS == 2) {
                    return '<span class="label label-danger"><strong>'.$item->STATUS .'</strong></span>';
                } else {
                    return '<span class="label label-success"><strong>'.$item->STATUS .'</strong></span>';
                }
            })
            ->addColumn('STATUS_PEMBAYARAN', function ($item) {
                if($item->PAYMENT_STATUS == 0) {
                    return '<span class="text-primary"><strong>DANA PERTAMA</strong></span>';
                } else {
                    return '<span class="text-success"><strong>LUNAS</strong></span>';
                }
            })
            ->rawColumns(['checkbox','STATUS','STATUS_PEMBAYARAN'])
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

            $request['TRANSACTION_ID'] = IdGenerator::generate(['table' => 'tb_transaction', 'field' => 'TRANSACTION_ID', 'length' => 14, 'prefix' => 'TRX'.date('Ymd')]);
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

            $update_transport_status = Transport::query()
            ->where(['TRANSPORT_CODE' => $request->TRANSPORT_CODE])->update(['TRANSPORT_STATUS' => 0]);

            $update_driver_status = Driver::query()
            ->where(['DRIVER_ID' => $request->DRIVER_ID])->update(['DRIVER_STATUS' => 0]);

            $update_kondektur_status = Kondektur::query()
            ->where(['KONDEKTUR_ID' => $request->KONDEKTUR_ID])->update(['KONDEKTUR_STATUS' => 0]);

            $fileName = 'PEMBAYARAN_'.$transaction->TRANSACTION_ID.'.'.$request->IMG_PAID_PAYMENT->extension();
            $upload = $request->IMG_PAID_PAYMENT->move(public_path('admin/upload'), $fileName);

            $pending_payment = $request->AMOUNT - $request->PAID_PAYMENT;

            if ($upload) {
                Payment::query()
                ->create([
                    'TRANSACTION_ID' => $transaction->TRANSACTION_ID,
                    'AMOUNT' => $request->AMOUNT,
                    'PAID_PAYMENT' => $request->PAID_PAYMENT,
                    'PENDING_PAYMENT' => ($request->PAID_PAYMENT <= $request->AMOUNT) ?  $pending_payment : 0,
                    'IMG_PAID_PAYMENT' => $fileName,
                    'PAYMENT_STATUS' => ($pending_payment <= 0) ?  1 : 0,
                ]);

                return redirect()->route('transaksi')->with(['status' => 'success', 'message' => 'Data Transaksi berhasil ditambahkan.']);
            }
            return back()->with(['status' => 'error', 'message' => 'Data Transaksi gagal ditambahkan']);
        }
        return back()->with(['status' => 'error', 'message' => 'Data Transaksi gagal ditambahkan']);
    }

    public function open_image($image) {
        $file = File::get(public_path('admin/upload/').$image);
        $type = File::mimeType(public_path('admin/upload/').$image);

        $response = Response::make($file, 200);
        return $response->header("Content-type", $type);
    }

    public function confirm(Request $request)
    {
        DB::beginTransaction();
        $transaction = Transaction::find($request->TRANSACTION_ID);
        try {
            DB::table('tb_transaction')->where(['TRANSACTION_ID' => $transaction->TRANSACTION_ID])->update(['TRANSACTION_STATUS' => 1]);
            DB::table('tb_m_transport')->where(['TRANSPORT_CODE' => $transaction->TRANSPORT_CODE])->update(['TRANSPORT_STATUS' => 2]);
            DB::table('tb_m_kondektur')->where(['KONDEKTUR_ID' => $transaction->KONDEKTUR_ID])->update(['KONDEKTUR_STATUS' => 2]);
            DB::table('tb_m_driver')->where(['DRIVER_ID' => $transaction->DRIVER_ID])->update(['DRIVER_STATUS' => 2]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Terjadi kesalahan!']);
        }
        return response()->json(['message' => 'Transaksi telah berhasil dikonfirmasi']);
    }

    public function transaksi_lunas(Request $request)
    {
            
        $validator = Validator::make($request->all(), [
            'IMG_PENDING_PAYMENT' => 'required|image|mimes:jpeg,png,jpg|max:3048',
        ], [
            'IMG_PENDING_PAYMENT.mimes' => 'Bukti Pelunasan harus berformat jpeg, png, jpg <br>',
            'IMG_PENDING_PAYMENT.max' => 'Bukti Pelunasan file maksimal 3 mb',
        ]);


        if ($validator->passes()) {
            $transaction = Transaction::find($request->TRANSACTION_ID_H);
            $payment = Payment::where(['TRANSACTION_ID' => $transaction->TRANSACTION_ID])->firstOrFail();

            $fileName = 'PELUNASAN_'.$transaction->TRANSACTION_ID.'.'.$request->IMG_PENDING_PAYMENT->extension();
            $upload = $request->IMG_PENDING_PAYMENT->move(public_path('admin/upload'), $fileName);

            if ($upload) {
                DB::beginTransaction();
                
                try {                 
                    DB::table('tb_payment')
                        ->where(['TRANSACTION_ID' => $transaction->TRANSACTION_ID])
                        ->update([
                            'PAID_PAYMENT' => $payment->PAID_PAYMENT + $payment->PENDING_PAYMENT,
                            'PENDING_PAYMENT' => 0,
                            'IMG_PENDING_PAYMENT' => $fileName,
                            'PAYMENT_STATUS' => 1,
                        ]);
        
                    // DB::table('tb_m_transport')->where(['TRANSPORT_CODE' => $transaction->TRANSPORT_CODE])->update(['TRANSPORT_STATUS' => 1]);
                    // DB::table('tb_m_kondektur')->where(['KONDEKTUR_ID' => $transaction->KONDEKTUR_ID])->update(['KONDEKTUR_STATUS' => 1]);
                    // DB::table('tb_m_driver')->where(['DRIVER_ID' => $transaction->DRIVER_ID])->update(['DRIVER_STATUS' => 1]);
                    DB::commit();

                    return response()->json(['message' => 'Transaksi telah berhasil dilunasi']);

                } catch (Exception $e) {
                    DB::rollback();
                    return response()->json(['error' => 'Terjadi kesalahan!']);
                }
            } else {
                return response()->json(['error' => 'Terjadi kesalahan!']);
            }
        } else {
            return response()->json(['error' => 'Terjadi kesalahan!']);
        }
    }

    public function transaksi_complete(Request $request)
    {
        DB::beginTransaction();
        try {
            DB::table('tb_transaction')->where(['TRANSACTION_ID' => $request->TRANSACTION_ID])->update(['TRANSACTION_STATUS' => 3]);
            DB::commit();

        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Terjadi kesalahan!']);
        }

        return response()->json(['message' => 'Transaksi telah berhasil diselesaikan']);
 
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();
        $transaction = Transaction::find($request->TRANSACTION_ID);
        $filename = Payment::where(['TRANSACTION_ID' => $request->TRANSACTION_ID])->first()->IMG_PAID_PAYMENT;

        try {
            DB::table('tb_m_transport')->where(['TRANSPORT_CODE' => $transaction->TRANSPORT_CODE])->update(['TRANSPORT_STATUS' => 1]);
            DB::table('tb_m_driver')->where(['DRIVER_ID' => $transaction->DRIVER_ID])->update(['DRIVER_STATUS' => 1]);
            DB::table('tb_m_kondektur')->where(['KONDEKTUR_ID' => $transaction->KONDEKTUR_ID])->update(['KONDEKTUR_STATUS' => 1]);

            DB::table('tb_transaction')->where(['TRANSACTION_ID' => $transaction->TRANSACTION_ID])->delete();
            DB::table('tb_payment')->where(['TRANSACTION_ID' => $transaction->TRANSACTION_ID])->delete();
            DB::commit();

            if (File::exists(public_path('admin/upload/'.$filename))) {
                    File::delete(public_path('admin/upload/'.$filename));
            }

        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Data gagal dihapus!']);
        }

        return response()->json(['message' => 'Data berhasil dihapus!']);
 
    }

}
