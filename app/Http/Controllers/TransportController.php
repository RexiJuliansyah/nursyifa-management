<?php

namespace App\Http\Controllers;

use App\Models\Transport;
use App\Models\System;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use DataTables;

use Illuminate\Support\Facades\Auth;

class TransportController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index()
    {
        $data['title'] = 'Bus Master';
        $data['transport_list'] = System::select('SYSTEM_CD', 'SYSTEM_VAL')->where('SYSTEM_TYPE', '=', 'BUS_SEAT_TYPE')->get();
        $data['transport_status_list'] = System::select('SYSTEM_CD', 'SYSTEM_VAL')->where('SYSTEM_TYPE', '=', 'STATUS_BUS')->orderBy('SYSTEM_CD')->get();
        return view('transport/index', compact('data'));
    }

    public function datatable (Request $request)
    {
        $params = [];
        if ($request->ajax()) {

            if ($request->transport_name) {
                array_push($params, ['TRANSPORT_NAME', 'like', '%' . $request->transport_name . '%']);
            }

            if ($request->transport_code) {
                array_push($params, ['TRANSPORT_CODE', 'like', '%' . $request->transport_code . '%']);
            }

            if ($request->transport_type) {
                array_push($params, ['TRANSPORT_TYPE', '=', $request->transport_type ]);
            }

            
            $q = Transport::select([
                'tb_m_transport.*',
                'sysA.SYSTEM_VAL as BUS_TYPE',
                'sysB.SYSTEM_VAL as BUS_STATUS',
            ])
            ->leftJoin('tb_m_system as sysA', 'tb_m_transport.TRANSPORT_TYPE', '=', 'sysA.SYSTEM_CD') 
            ->leftJoin('tb_m_system as sysB', 'tb_m_transport.TRANSPORT_STATUS', '=', 'sysB.SYSTEM_CD') 
            ->where('sysA.SYSTEM_TYPE', 'BUS_SEAT_TYPE')
            ->where('sysB.SYSTEM_TYPE', 'STATUS_BUS')
            ->where($params)
            ->orderBy('UPDATED_DATE', 'DESC')
            ->get();

            return Datatables::of($q)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($item) {
                return '<input type="checkbox" name="chkRow"
                        data-TransportId="'.$item->TRANSPORT_ID.'"
                        class="grid-checkbox grid-checkbox-body" />';
              })
            ->editColumn('BUS_STATUS', function ($item) {
                if($item->TRANSPORT_STATUS == 1) {
                    return '<span class="label label-success">'.$item->BUS_STATUS .'</span>';
                } else {
                    return '<span class="label label-warning">'.$item->BUS_STATUS .'</span>';
                }
            })
            ->rawColumns(['checkbox', 'BUS_STATUS'])
            ->make(true);
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'TRANSPORT_CODE' => 'required',
                'TRANSPORT_NAME' => 'required',
                'TRANSPORT_TYPE' => 'required',
                'TRANSPORT_STATUS' => 'required',
            ],
            // Error Message
            [
                'TRANSPORT_CODE.required' => 'Kode Bus tidak boleh kosong! <br>',
                'TRANSPORT_NAME.required' => 'Nama Bus tidak boleh kosong! <br>',
                'TRANSPORT_TYPE.required' => 'Jenis Bus boleh kosong! <br>',
                'TRANSPORT_STATUS.required' => 'Status tidak boleh kosong! <br>',
            ]);

            
            if ($validator->passes()) {
                if ($request->MODE == 'ADD') {
                    $check = Transport::query()
                    ->where(['TRANSPORT_CODE' => $request->TRANSPORT_CODE])
                    ->first();
                    
                    if ($check != null) {
                        return response()
                            ->json(['error' => "Kode Bus sudah tersedia, harap masukan Kode Bus yang lain."]);
                    }

                    Transport::query()
                    ->create([
                        'TRANSPORT_CODE' => $request->TRANSPORT_CODE,
                        'TRANSPORT_NAME' => $request->TRANSPORT_NAME,
                        'TRANSPORT_STATUS' => $request->TRANSPORT_STATUS,
                        'TRANSPORT_TYPE' => $request->TRANSPORT_TYPE,
                        'TRANSPORT_STATUS' => $request->TRANSPORT_STATUS
                    ]);
                }
                else {
                    Transport::query()
                    ->where([
                        'TRANSPORT_ID' => $request->TRANSPORT_ID
                    ])->update($request->except('MODE'));
                }

                
                return response()->json(['message' => 'Data berhasil disimpan!']);
            }
    
            return response()->json(['error' => $validator->errors()->all()]);
        }
    }

    public function getbykey(Request $request) {
        $query = Transport::where([
            'TRANSPORT_ID' => $request->TRANSPORT_ID
        ])->firstOrFail();
        echo json_encode($query);
    }

    public function delete(Request $request)
    {
        Transport::where([
            'TRANSPORT_ID' => $request->TRANSPORT_ID
        ])->delete();
        return response()->json(['message' => 'Data berhasil dihapus!']);
    }   
}
