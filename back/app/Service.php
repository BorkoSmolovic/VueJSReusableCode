<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['name','user_id','isActive'];
    protected $casts = ["isActive" => "boolean", 'user_id' => 'integer'];
    protected  $hidden = ['created_at', 'updated_at'];
}
