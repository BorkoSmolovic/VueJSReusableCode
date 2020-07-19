<?php

namespace App;

use function foo\func;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Evidention extends Model
{
    protected $fillable = [
        'name',
        'event_name',
        'date',
        'description',
        'is_commercial',
        'invoice',
        'contract_id',
        'city_id',
        'isActive',
        'user_id',
        'net',
        'rebate',
        'net_rebate',
        'vat',
        'gross'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    protected $with = [
        'city',
        'user',
        'status',
        'comment',
        'contract',
        'services'
    ];
    protected $casts = [
        "isActive" => "boolean",
        'user_id' => 'integer',
        'is_commercial' => 'boolean',
        'contract_id' => 'integer',
        'city_id' => 'integer',
    ];

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function user()
    {
        return $this->belongsTo('App\User')->setEagerLoads([]);
    }

    public function contract()
    {
        return $this->belongsTo('App\Contract');
    }

    public function items()
    {
        return $this->hasMany('App\EvidentionItem')->where('isActive', 1)->orderBy('item_id');
    }

    public function workers()
    {
        return $this->hasMany('App\EvidentionWorker')->where('isActive', 1)->orderBy('worker_type_id');
    }

    public function status()
    {
        return $this->hasOne('App\EvidentionStatus')->latest();
    }

    public function comment()
    {
        return $this->hasMany('App\Comment');
    }

    public function services()
    {
        return $this->hasManyThrough('App\Service', 'App\EvidentionService', "evidention_id", "id", "id", "service_id")->where('evidention_services.isActive', 1)->orderBy("services.name");
    }


    public static function updatePermissions($evidention_id, $user_id)
    {
        $status = EvidentionStatus::where('evidention_id', $evidention_id)->get()->last();

        if ($status == null) {
            abort(422, "There is no status for that evidention");
        } elseif ($status->status_id == 1) {
            true;
        } else {
            return $status->user_id == $user_id ? true : abort(422, "This user is not leading this evidention");;
        }
    }
}
