<?php

use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks = [
            ['name' => 'Hipotekarna banka', 'no' => '520', 'user_id' => '1'],
            ['name' => 'Erste banka', 'no' => '540', 'user_id' => '1'],
            ['name' => 'Podgorička banka Societe Generale', 'no' => '550', 'user_id' => '1'],
            ['name' => 'Prva banka Crne Gore', 'no' => '535', 'user_id' => '1'],
            ['name' => 'Addiko banka', 'no' => '555', 'user_id' => '1'],
            ['name' => 'Crnogorska komercijalna banka', 'no' => '510', 'user_id' => '1'],
            ['name' => 'Atlas Mont banka', 'no' => '505', 'user_id' => '1'],
            ['name' => 'Montenegrobanka AD Podgorica', 'no' => '530', 'user_id' => '1'],
        ];
        DB::table('banks')->insert($banks);
    }
}
