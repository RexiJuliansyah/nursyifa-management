<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use App\Models\Transport;
use App\Models\Driver;
use App\Models\Kondektur;
use Illuminate\Support\Carbon;
use Carbon\CarbonPeriod;
use stdClass;
use App\Models\Transaction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

use DataTables;

class HomeController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->ROLE_ID == 4 ) // TV Display 
        {
            return view('tv_display.index');
        } else {
            $data['title'] = 'Dashboard';
            $data['transport_list_count'] = Transport::select([
                'tb_m_transport.*',
                'tb_m_system.SYSTEM_VAL as BUS_SEAT_TYPE',
            ])
                ->leftJoin('tb_m_system', 'tb_m_transport.TRANSPORT_TYPE', '=', 'tb_m_system.SYSTEM_CD')
                ->where('tb_m_system.SYSTEM_TYPE', 'BUS_SEAT_TYPE')
                ->get()->count();
    
            $data['driver_list_count'] = Driver::get()->count();
            $data['kondektur_list_count'] = Kondektur::get()->count();
            
            return view('dashboard.admin.index', compact('data'));
        }
       
    }

    public function datatable_schedule (Request $request)
    {
        $params = [];
        if ($request->ajax()) {
            
            $q = Transaction::select([
                'tb_transaction.*',
                'tb_m_driver.DRIVER_NAME',
                'tb_m_kondektur.KONDEKTUR_NAME',
                'tb_m_system.SYSTEM_VAL as STATUS',
            ])
            ->leftJoin('tb_m_driver', 'tb_transaction.DRIVER_ID', '=', 'tb_m_driver.DRIVER_ID') 
            ->leftJoin('tb_m_kondektur', 'tb_transaction.KONDEKTUR_ID', '=', 'tb_m_kondektur.KONDEKTUR_ID') 
            ->leftJoin('tb_m_system', 'tb_transaction.TRANSACTION_STATUS', '=', 'tb_m_system.SYSTEM_CD')
            ->where('tb_m_system.SYSTEM_TYPE', 'TRANSAKSI_STATUS')
            ->whereMonth('tb_transaction.DATE_FROM', '=', date('m'))
            ->where('tb_transaction.TRANSACTION_STATUS', '=', 1)
            ->orderBy('DATE_FROM')
            ->limit(15)
            ->get();

            return Datatables::of($q)
            ->addIndexColumn()
            ->editColumn('DATE_FROM', function ($q) {
                return with(new Carbon($q->DATE_FROM))->format('d/m/Y');
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
            ->rawColumns(['STATUS'])
            ->make(true);
        }
    }

    public function getChartData(Request $request)
    {
        $daterange = explode(' - ', $request->DATE_FROM_TO);

        $date_from = Carbon::createFromFormat('d/m/Y', $daterange[0])->format('Y-m-d');
        $date_to = Carbon::createFromFormat('d/m/Y', $daterange[1])->format('Y-m-d');

        //create date array
        $period = CarbonPeriod::create($date_from, $date_to);
        $date_array = [];

        foreach ($period as $date) {
            array_push($date_array,  with(new Carbon($date))->format('d M Y'));
        }
        //

        //create bar array
        $bar_array = [];

        $transport_list = Transport::all();

        foreach($transport_list as $item) {
            $bar_obj = new stdClass();
            $transport_data = [];

            foreach($period as $date) {
                $data = $this->getTransactionDataByTransport($item->TRANSPORT_CODE, $date);
                if ($data == NULL) {
                    array_push($transport_data, 0);
                } else {
                    array_push($transport_data, $data->AMOUNT);
                }
            }

            $bar_obj->name = $item->TRANSPORT_CODE.' - '.$item->TRANSPORT_NAME;
            $bar_obj->type = "bar";
            $bar_obj->data = $transport_data;
            $bar_obj->stack = 'st1';
            array_push($bar_array, $bar_obj);
        }

        $return = new stdClass();
        $return->DATE_ARRAY = $date_array;
        $return->BAR_ARRAY = $bar_array;

        echo json_encode($return);
    }

    public function getTransactionDataByTransport($transport_code, $date) {
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
        ])->where('tb_transaction.TRANSPORT_CODE', $transport_code)->where('tb_transaction.DATE_FROM', $date)
        ->leftJoin('tb_m_driver', 'tb_transaction.DRIVER_ID', '=', 'tb_m_driver.DRIVER_ID') 
        ->leftJoin('tb_m_kondektur', 'tb_transaction.KONDEKTUR_ID', '=', 'tb_m_kondektur.KONDEKTUR_ID') 
        ->leftJoin('tb_payment', 'tb_transaction.TRANSACTION_ID', '=', 'tb_payment.TRANSACTION_ID')
        ->first();

        return $query;
    }
}
