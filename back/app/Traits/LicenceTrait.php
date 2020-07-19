<?php namespace App\Traits;

trait LicenceTrait
{
    public function makeLicenceID($licence_id)
    {
        $s = "";
        $len = strlen($licence_id);
        for($i = $len+8; $i < 16; $i++){
            $s .= "0";
        }
        return "AM_TEST_" . $s . "$licence_id";
    }
}
