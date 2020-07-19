<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    protected $fillable = ['name', 'surname', 'isActive', 'user_id'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $appends = ['fullName', 'duty'];
    protected $casts = ['isActive' => 'boolean', 'user_id' => 'integer'];
    protected $with =['worker_type_worker'];

    public function worker_type_worker()
    {
        return $this->hasMany("App\WorkerTypeWorker")->where('isActive', 1);
    }

    public function getFullNameAttribute()
    {
        return $this->name . " " . $this->surname;
    }

    public function getDutyAttribute()
    {
        $worker_type_worker = WorkerTypeWorker::where('worker_id', $this->id)->where('isActive', 1)->get();
        $duty = "";
        foreach ($worker_type_worker as $wow) {
            $duty .= $wow->worker_type->name . ',';
        }
        return substr($duty, 0, strlen($duty)-1);
    }
}
