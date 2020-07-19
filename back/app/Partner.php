<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Constraint\Count;

class Partner extends Model
{
    protected $fillable = ['code', 'name', 'address', 'pib', 'pdv', 'partner_type_id', 'city_id', 'isActive', 'user_id'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $casts = ["isActive" => "boolean", 'user_id' => 'integer', 'partner_type_id' => 'integer', 'city_id' => 'integer'];

    protected $with = ['partner_type', 'city'];

    public function partner_type()
    {
        return $this->belongsTo('App\PartnerType');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }
}
