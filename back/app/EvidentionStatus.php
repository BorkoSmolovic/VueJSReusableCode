<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvidentionStatus extends Model
{
    protected $fillable = ['status_id', 'evidention_id', 'user_id', 'isActive'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $with = ['status'];
    protected $casts = ["isActive" => "boolean", 'user_id' => 'integer', 'evidention_id' => 'integer', 'status_id' => 'integer'];

    public function status()
    {
        return $this->belongsTo('App\Status');
    }

    public static function add($status_id, $evidention_id, $user_id, $created_at = null, $updated_at = null)
    {
        if($created_at != null && $updated_at != null) {
            return EvidentionStatus::create([
                'status_id' => $status_id,
                'evidention_id' => $evidention_id,
                'user_id' => $user_id,
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ]);
        }
        return EvidentionStatus::create([
            'status_id' => $status_id,
            'evidention_id' => $evidention_id,
            'user_id' => $user_id,
        ]);
    }
}
