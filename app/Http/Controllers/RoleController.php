<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Menu;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use DataTables;

use Illuminate\Support\Facades\Auth;

class RoleController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        $data['title'] = 'Role';
        return view('role/index', compact('data'));
    }

    public function datatable(Request $request)
    {
        $params = [];

        if ($request->ajax()) {

            $q = Role::orderBy('UPDATED_DATE', 'DESC')->get();

            return Datatables::of($q)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($item) {
                    return '<input type="checkbox" name="chkRow" data-RoleId="' . $item->ROLE_ID . '" class="grid-checkbox grid-checkbox-body" />';
                })
                ->editColumn('UPDATED_DATE', function ($q) {
                    return $q->UPDATED_DATE ? with(new Carbon($q->UPDATED_DATE))->format('d-m-Y H:i:s') : '';
                })
                ->rawColumns(['checkbox'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {

            $validator = Validator::make(
                $request->all(),
                [
                    'ROLE_NAME' => 'required',
                    'ROLE_DESC' => 'required'
                ],
                // Error Message
                [
                    'ROLE_NAME.required' => 'Nama Role tidak boleh kosong! <br>',
                    'ROLE_DESC.required' => 'Deskripsi Role tidak boleh kosong! <br>'
                ]
            );

            if ($validator->passes()) {
                Role::updateOrCreate(['ROLE_ID' => $request->ROLE_ID], $request->all());

                return response()->json(['message' => 'Data berhasil disimpan!']);
            }

            return response()->json(['error' => $validator->errors()->all()]);
        }
    }

    public function getbykey(Request $request)
    {
        $query = Role::where('ROLE_ID', '=', $request->ROLE_ID)->firstOrFail();
        echo json_encode($query);
    }

    public function delete(Request $request)
    {
        Role::where('ROLE_ID', $request->ROLE_ID)->delete();
        return response()->json(['message' => 'Data berhasil dihapus!']);
    }

    public function getPermission(Request $request)
    {
        $data_role = Role::findOrFail($request->ROLE_ID);
        $data_permission = Permission::with('menu')->where('ROLE_ID', $request->ROLE_ID)->get();
        $data_menu = Menu::orderBy('SEQUENCE')->get();

        if ($data_role) {
            return response()->json([
                'message' => 'Data berhasil didapatkan!',
                'data_permission' => $data_permission,
                'data_menu' => $data_menu,
                'data_role' => $data_role
            ]);
        } else {
            return response()->json(['error' => 'Data tidak ditemukan!']);
        }
    }

    public function storePermission(Request $request)
    {
        if (empty($request->data)) {
            return response()->json(['error' => ['Pilih setidaknya 1 menu!']]);
        }

        DB::beginTransaction();

        try {
            Permission::where('ROLE_ID', $request->data[0]['ROLE_ID'])->delete();
            foreach ($request->data as $data) {
                Permission::create(['MENU_ID' => $data['MENU_ID'], 'ROLE_ID' => $data['ROLE_ID']]);
            }
            DB::commit();
            return response()->json(['message' => 'Data perizinan berhasil disimpan!']);
        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json(['error' => $e]);
        }
    }
}