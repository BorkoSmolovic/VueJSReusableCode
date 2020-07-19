<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkerTypeWorker extends Model
{
    protected $fillable = ['worker_type_id', 'worker_id', 'isActive', 'user_id'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $casts = ["isActive" => "boolean", 'user_id' => 'integer', 'worker_id' => 'integer', 'worker_type_id' => 'integer'];
    protected $with = ['worker_type'];

    public function worker_type()
    {
        return $this->belongsTo('App\WorkerType');
    }

    public function worker()
    {
        return $this->belongsTo('App\Worker');
    }

    public static function workerPerformDuty($worker_type_id, $worker_id)
    {
        $wtw = WorkerTypeWorker::where('worker_type_id', $worker_type_id)->where('worker_id', $worker_id)->first();

        if ($wtw === null || $wtw->isActive == 0) {
            abort(422, 'This worker does not perform this duty');
        }
        return true;
    }

}
