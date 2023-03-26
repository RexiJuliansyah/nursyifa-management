<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

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

}
