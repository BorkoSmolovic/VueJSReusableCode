<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name', 'isActive', 'post_code', 'country_id', 'user_id'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $casts = ["isActive" => "boolean", 'user_id' => 'integer', 'country_id' => 'integer'];

    public function country(){
        return $this->belongsTo('App\Country');
    }
}
