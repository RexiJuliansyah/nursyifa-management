<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'tb_m_user';
    protected $guarded = ['USER_ID'];
    protected $primaryKey = 'USER_ID';
    
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

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAuthPassword()
    {
        return $this->PASSWORD;
    }
}
