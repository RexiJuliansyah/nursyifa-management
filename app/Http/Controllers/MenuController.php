<?php

namespace App\Http\Controllers;

use App\Exports\MenuExport;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use DataTables;

use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class MenuController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index()
    {
        $data['title'] = 'Menu';
        return view('menu/index', compact('data'));
    }

    public function datatable (Request $request)
    {
        $params = [];
        if ($request->ajax()) {
            if ($request->menu_name) {
                array_push($params, ['MENU_NAME', 'like', '%' . $request->menu_name . '%']) ;
            }

            if ($request->type) {
                if ($request->type == 1) {
                    $q = Menu::where($params)->where('PARENT_ID', '=', "0")->orderBy('MENU_ID')->get();
                } else {
                    $q = Menu::where($params)->where('PARENT_ID', '!=', "0")->orderBy('MENU_ID')->get();
                }
            } else {
                $q = Menu::where($params)->orderBy('MENU_ID')->get();
            }

            return Datatables::of($q)
            ->addIndexColumn()
            ->addColumn('checkbox', function($item) { 
                return '<input type="checkbox" name="chkRow" data-MenuId="'.$item->MENU_ID.'" class="grid-checkbox grid-checkbox-body" />';
            })
            ->editColumn('UPDATED_DATE', function ($q) {
                return $q->UPDATED_DATE ? with(new Carbon($q->UPDATED_DATE))->format('d-m-Y H:i:s') : '';
            })
            ->editColumn('PARENT_ID', function ($q) {
                if ($q->PARENT_ID != '0') {
                    $data = Menu::where('MENU_ID', $q->PARENT_ID)->first();
                    return $data->MENU_NAME;
                } else {
                    return '-';
                }
            })
            ->editColumn('MENU_ICON', function ($q) {
                return '<i class="'.$q->MENU_ICON.'"></i>  '.$q->MENU_ICON;
            })
            ->rawColumns(['checkbox', 'MENU_ICON'])
            ->make(true);
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            if ($request->PARENT_ID == "") {
                $request->merge([
                    'PARENT_ID' => 0,
                ]);
            }

            $validator = Validator::make($request->all(), [
                'MENU_NAME' => 'required',
                'MENU_ICON' => 'required',
                'MENU_URL' => 'required',
                'PARENT_ID' => 'required',
                'SEQUENCE' => 'required',
            ],
            // Error Message
            [
                'MENU_NAME.required' => 'Nama Menu tidak boleh kosong! <br>',
                'MENU_ICON.required' => 'Icon Menu tidak boleh kosong! <br>',
                'MENU_URL.required' => 'URL Menu tidak boleh kosong! <br>',
                'PARENT_ID.required' => 'Induk Menu tidak boleh kosong! <br>',
                'SEQUENCE.required' => 'Urutan tidak boleh kosong! <br>',
            ]);

            
            if ($validator->passes()) {
                Menu::updateOrCreate(['MENU_ID' => $request->MENU_ID], $request->all());
                return response()->json(['message' => 'Data berhasil disimpan!']);
            }
    
            return response()->json(['error' => $validator->errors()->all()]);
        }
    }

    public function getbykey(Request $request) {
        $query = Menu::where('MENU_ID', $request->MENU_ID)->firstOrFail();
        echo json_encode($query);
    }

    public function delete(Request $request)
    {
        Menu::where('MENU_ID', [$request->ids])->delete();
        return response()->json(['message' => 'Data berhasil dihapus!']);
    }   


    public function menuSelect2(Request $request){
        
        if ($request->ajax()) {

            $term = trim($request->term);
            $posts = Menu::select('MENU_ID as id','MENU_NAME as text')
                ->where('PARENT_ID', 0)
                ->where('MENU_NAME', 'LIKE',  '%' . $term. '%')
                ->orderBy('MENU_NAME', 'asc')->simplePaginate(10);
           
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

    public function getMenu(Request $request)
    {
        if ($request->ajax()) {
            $menus = Menu::orderBy('SEQUENCE')->get();
            return response()->json(['message' => 'Data berhasil didapatkan!', 'menus' => $menus]);
        }
    }

    public function export(Request $request) 
    {
        return Excel::download(new MenuExport($request->menu_name, $request->menu_type), 'test.xlsx');
    }
}