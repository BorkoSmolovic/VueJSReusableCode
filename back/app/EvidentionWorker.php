<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvidentionWorker extends Model
{
    protected $fillable = ['evidention_id', 'worker_id', 'worker_type_id', 'isActive', 'user_id', 'salary'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $appends = ['fullName'];
    protected $casts = ["isActive" => "boolean", 'user_id' => 'integer', 'evidention_id' => 'integer', 'worker_id' => 'integer', 'worker_type_id' => 'integer', 'salary' => 'double'];

    public function getFullNameAttribute()
    {
        $worker = Worker::where('id', $this->worker_id)->first();
        return $worker->name . ' ' . $worker->surname;
    }

    public function worker(){
        return $this->belongsTo('App\Worker');
    }

    public function worker_type(){
        return $this->belongsTo('App\WorkerType');
    }

}
