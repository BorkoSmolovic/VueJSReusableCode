<?php

use Illuminate\Database\Seeder;

class WorkerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $worker_types = [
            ['id' => 1, 'name' => 'Snimatelj', 'isActive' => 1, 'user_id' => 1],
            ['id' => 2, 'name' => 'Montažer', 'isActive' => 1, 'user_id' => 1],
            ['id' => 3, 'name' => 'Organizator', 'isActive' => 1, 'user_id' => 1],
            ['id' => 4, 'name' => 'Novinar', 'isActive' => 1, 'user_id' => 1],
        ];
        DB::table('worker_types')->insert($worker_types);
    }
}
