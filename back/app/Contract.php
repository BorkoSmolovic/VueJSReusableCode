<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = ['recordings_remaining', 'contract_name', 'isActive', 'dateFrom', 'dateTo', 'partner_id', 'user_id', 'number_of_recordings'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $with = ['partner'];
    protected $casts = ["isActive" => "boolean", 'user_id' => 'integer', 'recordings_remaining' => 'integer', 'partner_id' => 'integer', 'number_of_recordings' => 'integer'];

    public function partner(){
        return $this->belongsTo('App\Partner');
    }

}
