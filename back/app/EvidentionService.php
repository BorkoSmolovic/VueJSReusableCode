<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvidentionService extends Model
{
    protected $fillable = ['service_id', 'evidention_id', 'user_id', 'isActive'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $with = ['services'];
    protected $casts = ['service_id' => 'integer', 'evidention_id' => 'integer', 'user_id' => 'integer', 'isActive' => 'boolean'];

    public function services()
    {
        return $this->belongsTo('App\Service', 'service_id', 'id');
    }

}
