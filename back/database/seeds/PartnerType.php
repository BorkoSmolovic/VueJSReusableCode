<?php

use Illuminate\Database\Seeder;

class PartnerType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $partnerTypes = [
            ['id' => '1', 'name' => 'Pravno lice', 'user_id' => '1'],
            ['id' => '2', 'name' => 'Fizicko lice', 'user_id' => '1'],
        ];
        DB::table('partner_types')->insert($partnerTypes);
    }
}
