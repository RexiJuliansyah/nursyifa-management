<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DataTables;

use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index()
    {
        $data['title'] = 'User';
        $data['role_list'] = Role::all();
        return view('user/index', compact('data'));
    }

    public function datatable (Request $request)
    {
        $params = [];

        if ($request->ajax()) {
            if ($request->username) {
                $params['USERNAME'] = $request->username;
            }

            if ($request->role_id) {
                $params['tb_m_user.ROLE_ID'] = $request->role_id;
            }

            $q = User::query()
            ->select([
                'tb_m_user.*',
                'tb_m_role.ROLE_NAME'
            ])
            ->join('tb_m_role', 'tb_m_user.ROLE_ID', '=', 'tb_m_role.ROLE_ID')
            ->where($params)
            ->orderBy('UPDATED_DATE', 'DESC')
            ->get();

            return Datatables::of($q)
            ->addIndexColumn()
            ->addColumn('checkbox', function($item) { 
                return '<input type="checkbox" name="chkRow" data-UserId="'.$item->USER_ID.'" class="grid-checkbox grid-checkbox-body" />';
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
                'USERNAME' => 'required',
                'FULL_NAME' => 'required',
                'EMAIL' => 'required',
                'PASSWORD' => 'required',
                'ROLE_ID' => 'required',
            ],
            // Error Message
            [
                'USERNAME.required' => 'Username field is required! <br>',
                'FULL_NAME.required' => 'Fullname field is required! <br>',
                'EMAIL.required' => 'Email field is required! <br>',
                'PASSWORD.required' => 'Password field is required! <br>',
                'ROLE_ID.required' => 'Role ID field is required! <br>',
            ]);
    
            if ($validator->passes()) {
                $request['PASSWORD'] = Hash::make($request->PASSWORD);
                User::updateOrCreate(['USER_ID' => $request->USER_ID], $request->all());
    
                return response()->json(['message' => 'Data stored succesfully!']);
            }
    
            return response()->json(['error' => $validator->errors()->all()]);
        }
    }

}