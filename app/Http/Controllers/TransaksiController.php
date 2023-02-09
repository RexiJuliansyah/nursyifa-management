<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransaksiController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index()
    {
        $data['title'] = 'Transaksi';
        return view('transaksi/index');
    }

    public function transaksi_baru()
    {
        $data['title'] = 'Transaksi';
        return view('transaksi/input_transaksi');
    }

}
