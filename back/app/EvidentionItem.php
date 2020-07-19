<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvidentionItem extends Model
{
    protected $fillable = ['evidention_id', 'item_id', 'isActive', 'user_id', 'value', 'vehicle_id'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $with = ['item', 'vehicle'];
    protected $casts = ["isActive" => "boolean", 'user_id' => 'integer', 'evidention_id' => 'integer', 'vehicle_id' => 'integer', 'value' => 'double'];

    public function item(){
        return $this->belongsTo('App\Item', 'item_id', 'id');
    }

    public function vehicle(){
        return $this->belongsTo('App\Vehicle', 'vehicle_id', 'id');
    }
}
