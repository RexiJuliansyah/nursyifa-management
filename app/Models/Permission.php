<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Permission extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'tb_m_permission';
    protected $guarded = ['PERMISSION_ID'];
    protected $primaryKey = 'PERMISSION_ID';
    
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

   public function menu()
   {
       return $this->belongsTo(Menu::class, 'MENU_ID');
   }
}
