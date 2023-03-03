<?php

namespace App\Http\Controllers;

use App\Models\Expense;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use DataTables;
use File;
use Response;

use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class ExpenseController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function datatable (Request $request)
    {
        $params = [];
        if ($request->ajax()) {

            if ($request->transaction_id) {
                array_push($params, ['TRANSACTION_ID', '=', $request->transaction_id]);
            }
            
            $q = Expense::where($params)
            ->orderBy('UPDATED_DATE', 'DESC')
            ->get();
           
            return Datatables::of($q)
            ->addIndexColumn()
            ->addColumn('ACTION', function ($item) {
                return '<button type="button" id="deleteEx'.$item->EXPENSE_ID.'" class="btn btn-danger btn-sm btn-square center-icon" onClick="deleteExpense('.$item->EXPENSE_ID.')"><i class="fa fa-trash"></i></button>';
                
              })
            ->rawColumns(['ACTION'])
            ->make(true);
        }
    }

    public function store(Request $request)
    {
            
        $validator = Validator::make($request->all(), [
            'EXPENSE_IMG' => 'required|image|mimes:jpeg,png,jpg|max:3048',
            'EXPENSE_NAME' => 'required',
            'EXPENSE_AMOUNT' => 'required',
        ], [
            'EXPENSE_IMG.mimes' => 'Bukti Pengeluaran harus berformat jpeg, png, jpg <br>',
            'EXPENSE_IMG.max' => 'Bukti Pengeluaran file maksimal 3 mb',
            'EXPENSE_NAME.required' => 'Jenis Pengeluaran tidak boleh kosong! <br>',
            'EXPENSE_AMOUNT.required' => 'Jumlah Pengeluaran tidak boleh kosong! <br>',
            'EXPENSE_IMG.required' => 'Bukti Pengeluaran tidak boleh kosong! <br>',
        ]);


        if ($validator->passes()) {
            
            $fileName = 'PENGELUARAN_'.str_replace(' ', '_', strtoupper($request->EXPENSE_NAME)).'_'.$request->TRANSACTION_ID_EX.'.'.$request->EXPENSE_IMG->extension();
            $upload = $request->EXPENSE_IMG->move(public_path('admin/upload'), $fileName);

            if ($upload) {
                DB::beginTransaction();
                try {                 
                    $expense = Expense::query()
                        ->create([
                            'TRANSACTION_ID' => $request->TRANSACTION_ID_EX,
                            'EXPENSE_NAME' => $request->EXPENSE_NAME,
                            'EXPENSE_AMOUNT' => $request->EXPENSE_AMOUNT,
                            'EXPENSE_IMG' => $fileName,
                        ]);
                    DB::commit();

                    return response()->json(['message' => 'Data pengeluaran berhasil disimpan']);

                } catch (Exception $e) {
                    DB::rollback();
                    return response()->json(['error' => 'Terjadi kesalahan!']);
                }
            } else {
                return response()->json(['error' => 'Terjadi kesalahan!']);
            }
        } else {
            return response()->json(['error' => $validator->errors()->all()]);
        }
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();

        $filename = Expense::where(['EXPENSE_ID' => $request->EXPENSE_ID])->first()->EXPENSE_IMG;
        try {
            DB::table('tb_expense')->where(['EXPENSE_ID' => $request->EXPENSE_ID])->delete();
            DB::commit();

            if (File::exists(public_path('admin/upload/'.$filename))) {
                File::delete(public_path('admin/upload/'.$filename));
            }

        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Data gagal dihapus!']);
        }

        return response()->json(['message' => 'Data berhasil dihapus!']);
 
    }
}