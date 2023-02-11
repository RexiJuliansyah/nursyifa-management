<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    protected $table = 'tb_transaction';
    protected $guarded = [];
    protected $primaryKey = 'TRANSACTION_ID';
    public $incrementing = false;
    
    const CREATED_AT = 'CREATED_DATE';
    const UPDATED_AT = 'UPDATED_DATE';

    public static function boot()
    {
       parent::boot();
       static::creating(function($model)
       {   
            $model->CREATED_BY = Auth::user()->USERNAME;
            $model->UPDATED_BY = Auth::user()->USERNAME;
       });
       static::updating(function($model)
       {
           $model->UPDATED_BY = Auth::user()->USERNAME;
       });       
    }
}