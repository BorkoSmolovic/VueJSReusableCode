<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'password', 'isActive', 'language_id', 'partner_id'
    ];


    protected $casts = ["isActive" => "boolean", 'language_id' => 'integer', 'partner_id' => 'integer'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'updated_at', 'created_at'
    ];



    protected $with = ['partner'];

    public function language(){
        return $this->belongsTo('App\Language');
    }

    public function partner(){
        return $this->belongsTo('App\Partner');
    }
}
