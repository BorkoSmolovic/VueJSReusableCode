<?php namespace App\Traits;

trait TenantTrait
{
    public function createTenantId($id)
    {
        $id .= "";
        $len = strlen($id);
        for($i = $len; $i < 8; $i++){
            $id = "0" . $id;
        }
        return $id;
    }
}
