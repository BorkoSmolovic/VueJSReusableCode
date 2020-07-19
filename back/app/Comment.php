<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['comment', 'seen', 'isActive', 'user_id', 'evidention_id'];
    protected $hidden = ['updated_at'];
    protected $with = ['user'];
    protected $casts = ["isActive" => "boolean", 'user_id' => 'integer', 'evidention_id' => 'integer'];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
