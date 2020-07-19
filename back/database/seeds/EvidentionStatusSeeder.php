<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EvidentionStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $evidentions = \App\Evidention::all();
        foreach ($evidentions as $e){
            $status_id = rand(4, 5);
            $a = rand(1, 100);
            if($a < 10){
                $status_id = 6;
            }
            $nowPlus30Seconds = Carbon::now()->addSeconds(10);
            \App\EvidentionStatus::add(2, $e->id, 1);
            \App\EvidentionStatus::add($status_id, $e->id, 1, $nowPlus30Seconds, $nowPlus30Seconds);
        }
    }
}
