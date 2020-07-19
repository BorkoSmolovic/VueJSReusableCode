<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class EvidentionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Evidention::class, 400)->create();
//        $contracts = \App\Contract::all();
//        foreach ($contracts as $contract) {
//            factory(\App\Evidention::class, rand(1, $contract->recordings_remaining))->create(['contract_id' => $contract->id]);
//        }


        $evidentions = [
            ];
//        DB::table('evidentions')->insert($evidentions);
    }
}
