<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['user_id', 'evidention_id', 'isActive'];
    protected $casts = ["isActive" => "boolean", 'user_id' => 'integer', 'evidention_id' => 'integer'];
    protected $hidden = ['created_at', 'updated_at'];

    public static function add($user_id, $evidention_id){
        return Notification::create([
            'user_id' => $user_id,
            'evidetnion_id' => $evidention_id
        ]);
    }
}
