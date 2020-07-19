<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactType extends Model
{
    protected $fillable = ['name', 'isActive', 'user_id', 'icon'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $casts = ["isActive" => "boolean", 'user_id' => 'integer'];
}
