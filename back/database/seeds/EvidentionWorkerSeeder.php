<?php

use Illuminate\Database\Seeder;

class EvidentionWorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\EvidentionWorker::class, 800)->create();
    }
}
