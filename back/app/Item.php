<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['name', 'user_id', 'isActive'];
    protected $casts = ["isActive" => "boolean", 'user_id' => 'integer'];
    protected  $hidden = ['created_at', 'updated_at'];
    protected $appends = ['hasVehicles'];

    function getHasVehiclesAttribute() {
        //ako je u pitanju item vozilo, vrati da je potrebno otvoriti prozor za odabir automobila
        return $this->getAttribute('id') === 1;
    }
}
