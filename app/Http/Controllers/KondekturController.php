<?php

namespace App\Http\Controllers;

use App\Models\Kondektur;
use App\Models\System;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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
        return view('kondektur/index', compact('data'));
    }

    public function datatable (Request $request)
    {
        $params = [];
        if ($request->ajax()) {

            if ($request->kondektur_name) {
                array_push($params, ['KONDEKTUR_NAME', 'like', '%' . $request->kondektur_name . '%']);
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
            ],
            // Error Message
            [
                'KONDEKTUR_NAME.required' => 'Name Kondektur tidak boleh kosong! <br>',
                'NO_TELP_KONDEKTUR.required' => 'No Telepon tidak boleh kosong! <br>',
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
                        'KONDEKTUR_STATUS' => 1
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
    
    public function kondekturSelect2(Request $request){

        if ($request->ajax()) {

            $daterange = explode(' - ', $request->date_from_to);
            $date_from = Carbon::createFromFormat('d/m/Y', $daterange[0])->format('Y-m-d');
            $date_to = Carbon::createFromFormat('d/m/Y', $daterange[1])->format('Y-m-d');


            $term = trim($request->term);

            $posts = DB::table('tb_m_kondektur')
            ->select([
                'tb_m_kondektur.KONDEKTUR_ID as id',
                'tb_m_kondektur.KONDEKTUR_NAME AS text',
            ])
            ->leftJoin(DB::raw('(SELECT * FROM tb_transaction 
                WHERE (tb_transaction.DATE_FROM BETWEEN "'.$date_from.'" AND "'.$date_to.'")
                OR (tb_transaction.DATE_TO BETWEEN "'.$date_from.'" AND "'.$date_to.'") 
                OR (tb_transaction.DATE_FROM <= "'.$date_from.'" AND tb_transaction.DATE_TO >= "'.$date_to.'"))
                transaction'), function($join)
            {
                $join->on('transaction.KONDEKTUR_ID', '=', 'tb_m_kondektur.KONDEKTUR_ID');
            })
            ->whereNull('transaction.TRANSACTION_ID')
            ->where('tb_m_kondektur.KONDEKTUR_NAME', 'LIKE',  '%' . $term. '%')
            ->orderBy('tb_m_kondektur.KONDEKTUR_ID', 'asc')->simplePaginate(10);
           
            $morePages=true;
            $pagination_obj= json_encode($posts);
            if (empty($posts->nextPageUrl())){
                $morePages=false;
            }
            $results = array(
                "results" => $posts->items(),
                "pagination" => array(
                    "more" => $morePages
                )
            );
        
            return response()->json($results);
        }
    }
}
