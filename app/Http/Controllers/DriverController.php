<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\System;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use DataTables;

use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class DriverController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index()
    {
        $data['title'] = 'Supir Master';
        $data['driver_status_list'] = System::select('SYSTEM_CD', 'SYSTEM_VAL')->where('SYSTEM_TYPE', '=', 'STATUS_OPERASIONAL')->orderBy('SYSTEM_CD')->get();
        return view('driver/index', compact('data'));
    }

    public function datatable (Request $request)
    {
        $params = [];
        if ($request->ajax()) {

            if ($request->driver_name) {
                array_push($params, ['DRIVER_NAME', 'like', '%' . $request->driver_name . '%']);
            }

            if ($request->driver_status) {
                array_push($params, ['DRIVER_STATUS', 'like', '%' . $request->driver_status . '%']);
            }
            
            $q = Driver::select([
                'tb_m_driver.*',
                'sysA.SYSTEM_VAL as STS_DRIVER',
            ])
            ->leftJoin('tb_m_system as sysA', 'tb_m_driver.DRIVER_STATUS', '=', 'sysA.SYSTEM_CD')
            ->where('sysA.SYSTEM_TYPE', 'STATUS_OPERASIONAL')
            ->where($params)
            ->orderBy('DRIVER_ID')
            ->get();

            return Datatables::of($q)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($item) {
                return '<input type="checkbox" name="chkRow"
                        data-DriverId="'.$item->DRIVER_ID.'"
                        class="grid-checkbox grid-checkbox-body" />';
              })
            ->editColumn('STS_DRIVER', function ($item) {
                if($item->DRIVER_STATUS == 1) {
                    return '<span class="label label-success">'.$item->STS_DRIVER .'</span>';
                } else {
                    return '<span class="label label-warning">'.$item->STS_DRIVER .'</span>';
                }
            })
            ->rawColumns(['checkbox', 'STS_DRIVER'])
            ->make(true);
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            if($request->DRIVER_ID == "") {
                $request['DRIVER_ID'] = IdGenerator::generate(['table' => 'tb_m_driver', 'field' => 'DRIVER_ID', 'length' => 5, 'prefix' => 'SP' ]);   
            }


            $validator = Validator::make($request->all(), [
                'DRIVER_NAME' => 'required',
                'NO_TELP_DRIVER' => 'required',
                'DRIVER_STATUS' => 'required',
            ],
            // Error Message
            [
                'DRIVER_NAME.required' => 'Name Supir tidak boleh kosong! <br>',
                'NO_TELP_DRIVER.required' => 'No Telepon tidak boleh kosong! <br>',
                'DRIVER_STATUS.required' => 'Status tidak boleh kosong! <br>',
            ]);

            
            if ($validator->passes()) {
                if ($request->MODE == 'ADD') {
                    $check = Driver::query()
                    ->where(['DRIVER_NAME' => $request->DRIVER_NAME])
                    ->first();
                    
                    if ($check != null) {
                        return response()
                            ->json(['error' => "Nama Supir sudah tersedia, harap masukan nama lain."]);
                    }

                    Driver::query()
                    ->create([
                        'DRIVER_ID' => $request->DRIVER_ID,
                        'DRIVER_NAME' => $request->DRIVER_NAME,
                        'NO_TELP_DRIVER' => $request->NO_TELP_DRIVER,
                        'DRIVER_STATUS' => $request->DRIVER_STATUS
                    ]);
                }
                else {
                    Driver::query()
                    ->where([
                        'DRIVER_ID' => $request->DRIVER_ID
                    ])->update($request->except('MODE'));
                }

                
                return response()->json(['message' => 'Data berhasil disimpan!']);
            }
    
            return response()->json(['error' => $validator->errors()->all()]);
        }
    }

    public function getbykey(Request $request) {
        $query = Driver::where([
            'DRIVER_ID' => $request->DRIVER_ID
        ])->firstOrFail();
        echo json_encode($query);
    }

    public function delete(Request $request)
    {
        Driver::where([
            'DRIVER_ID' => $request->DRIVER_ID
        ])->delete();
        return response()->json(['message' => 'Data berhasil dihapus!']);
    }   
}
