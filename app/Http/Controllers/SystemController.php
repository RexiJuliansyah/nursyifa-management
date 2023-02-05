<?php

namespace App\Http\Controllers;

use App\Models\System;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use DataTables;

use Illuminate\Support\Facades\Auth;

class SystemController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index()
    {
        $data['title'] = 'System';
        return view('system/index', compact('data'));
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
            
            $q = System::query()
            ->where($params)
            ->orderBy('SYSTEM_TYPE', 'ASC')
            ->orderBy('SYSTEM_CD', 'ASC')
            ->get();

            return Datatables::of($q)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($item) {
                return '<input type="checkbox" name="chkRow"
                        data-SystemType="'.$item->SYSTEM_TYPE.'"
                        data-SystemCd="'.$item->SYSTEM_CD.'"
                        class="grid-checkbox grid-checkbox-body" />';
              })
            ->editColumn('CREATED_DATE', function ($q) {
                return $q->CREATED_DATE ? with(new Carbon($q->CREATED_DATE))->format('d-m-Y H:i:s') : '';
            })
            ->rawColumns(['checkbox'])
            ->make(true);
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'SYSTEM_TYPE' => 'required',
                'SYSTEM_CD' => 'required',
                'SYSTEM_VAL' => 'required',
            ],
            // Error Message
            [
                'SYSTEM_TYPE.required' => 'System Type tidak boleh kosong! <br>',
                'SYSTEM_CD.required' => 'System Code tidak boleh kosong! <br>',
                'SYSTEM_VAL.required' => 'System Value tidak boleh kosong! <br>',
            ]);

            
            if ($validator->passes()) {
                if ($request->MODE == 'ADD') {
                    $check = System::query()
                    ->where([
                        'SYSTEM_TYPE' => $request->SYSTEM_TYPE, 
                        'SYSTEM_CD' => $request->SYSTEM_CD])
                    ->first();
                    
                    if ($check != null) {
                        return response()
                            ->json(['error' => "Data Already Exist !"]);
                    }

                    System::query()
                    ->create($request->except('MODE'));
                }
                else {
                    System::query()
                    ->where([
                        'SYSTEM_TYPE' => $request->SYSTEM_TYPE,
                        'SYSTEM_CD' => $request->SYSTEM_CD
                    ])->update($request->except('MODE'));
                }

                
                return response()->json(['message' => 'Data berhasil disimpan!']);
            }
    
            return response()->json(['error' => $validator->errors()->all()]);
        }
    }

    public function getbykey(Request $request) {
        $query = System::where([
            'SYSTEM_TYPE' => $request->SYSTEM_TYPE,
            'SYSTEM_CD' => $request->SYSTEM_CD
        ])->firstOrFail();
        echo json_encode($query);
    }

    public function delete(Request $request)
    {
        System::where([
            'SYSTEM_TYPE' => $request->SYSTEM_TYPE,
            'SYSTEM_CD' => $request->SYSTEM_CD
        ])->delete();
        return response()->json(['message' => 'Data berhasil dihapus!']);
    }   

}