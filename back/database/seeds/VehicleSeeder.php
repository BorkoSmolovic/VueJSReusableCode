<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vehicles = [
            ['type' => 'Renault Clio 1.5dci', 'plates' => 'PG FB-792', 'user_id' => 1],
            ['type' => 'Renault Clio 1.5dci', 'plates' => 'PG HE-218', 'user_id' => 1],
        ];

        DB::table('vehicles')->insert($vehicles);
    }
}
