<?php

namespace App\Http\Controllers;

use App\Models\Kondektur;
use App\Models\System;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use DataTables;

use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class KondekturController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index()
    {
        $data['title'] = 'Kondektur Master';
        $data['kondektur_status_list'] = System::select('SYSTEM_CD', 'SYSTEM_VAL')->where('SYSTEM_TYPE', '=', 'STATUS_OPERASIONAL')->orderBy('SYSTEM_CD')->get();
        return view('kondektur/index', compact('data'));
    }

    public function datatable (Request $request)
    {
        $params = [];
        if ($request->ajax()) {

            if ($request->kondektur_name) {
                array_push($params, ['KONDEKTUR_NAME', 'like', '%' . $request->kondektur_name . '%']);
            }

            if ($request->kondektur_status) {
                array_push($params, ['KONDEKTUR_STATUS', 'like', '%' . $request->kondektur_status . '%']);
            }
            
            $q = Kondektur::select([
                'tb_m_kondektur.*',
                'sysA.SYSTEM_VAL as STS_KONDEKTUR',
            ])
            ->leftJoin('tb_m_system as sysA', 'tb_m_kondektur.KONDEKTUR_STATUS', '=', 'sysA.SYSTEM_CD')
            ->where('sysA.SYSTEM_TYPE', 'STATUS_OPERASIONAL')
            ->where($params)
            ->orderBy('KONDEKTUR_ID')
            ->get();

            return Datatables::of($q)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($item) {
                return '<input type="checkbox" name="chkRow"
                        data-KondekturId="'.$item->KONDEKTUR_ID.'"
                        class="grid-checkbox grid-checkbox-body" />';
              })
            ->editColumn('STS_KONDEKTUR', function ($item) {
                if($item->KONDEKTUR_STATUS == 0) {
                    return '<span class="label label-warning font-weight">'.$item->STS_KONDEKTUR.'</span>';
                } else if ($item->KONDEKTUR_STATUS == 1) {
                    return '<span class="label label-success">'.$item->STS_KONDEKTUR.'</span>';
                } else if ($item->KONDEKTUR_STATUS == 2) {
                    return '<span class="label label-primary">'.$item->STS_KONDEKTUR.'</span>';
                } else {
                    return '<span class="label label-danger">'.$item->STS_KONDEKTUR.'</span>';
                }
            })
            ->rawColumns(['checkbox', 'STS_KONDEKTUR'])
            ->make(true);
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            if($request->KONDEKTUR_ID == "") {
                $request['KONDEKTUR_ID'] = IdGenerator::generate(['table' => 'tb_m_kondektur', 'field' => 'KONDEKTUR_ID', 'length' => 5, 'prefix' => 'KD' ]);   
            }


            $validator = Validator::make($request->all(), [
                'KONDEKTUR_NAME' => 'required',
                'NO_TELP_KONDEKTUR' => 'required',
                'KONDEKTUR_STATUS' => 'required',
            ],
            // Error Message
            [
                'KONDEKTUR_NAME.required' => 'Name Kondektur tidak boleh kosong! <br>',
                'NO_TELP_KONDEKTUR.required' => 'No Telepon tidak boleh kosong! <br>',
                'KONDEKTUR_STATUS.required' => 'Status tidak boleh kosong! <br>',
            ]);

            
            if ($validator->passes()) {
                if ($request->MODE == 'ADD') {
                    $check = Kondektur::query()
                    ->where(['KONDEKTUR_NAME' => $request->KONDEKTUR_NAME])
                    ->first();
                    
                    if ($check != null) {
                        return response()
                            ->json(['error' => "Nama Kondektur sudah tersedia, harap masukan nama lain."]);
                    }

                    Kondektur::query()
                    ->create([
                        'KONDEKTUR_ID' => $request->KONDEKTUR_ID,
                        'KONDEKTUR_NAME' => $request->KONDEKTUR_NAME,
                        'NO_TELP_KONDEKTUR' => $request->NO_TELP_KONDEKTUR,
                        'KONDEKTUR_STATUS' => $request->KONDEKTUR_STATUS
                    ]);
                }
                else {
                    Kondektur::query()
                    ->where([
                        'KONDEKTUR_ID' => $request->KONDEKTUR_ID
                    ])->update($request->except('MODE'));
                }

                
                return response()->json(['message' => 'Data berhasil disimpan!']);
            }
    
            return response()->json(['error' => $validator->errors()->all()]);
        }
    }

    public function getbykey(Request $request) {
        $query = Kondektur::where([
            'KONDEKTUR_ID' => $request->KONDEKTUR_ID
        ])->firstOrFail();
        echo json_encode($query);
    }

    public function delete(Request $request)
    {
        Kondektur::where([
            'KONDEKTUR_ID' => $request->KONDEKTUR_ID
        ])->delete();
        return response()->json(['message' => 'Data berhasil dihapus!']);
    }   
}
