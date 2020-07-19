<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['name','isActive', 'user_id'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $casts = ["isActive" => "boolean", 'user_id' => 'integer'];
//    protected $with = ['city'];

    public function city(){
        return $this->hasMany('App\City')->where('isActive', 1);
    }

}
