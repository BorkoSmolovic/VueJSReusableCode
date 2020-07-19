<?php

use Illuminate\Database\Seeder;

class WorkerTypeWorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $workerTypeWorkers = [
            ['worker_type_id' => 2, 'worker_id' => 3, 'user_id' => 1],
            ['worker_type_id' => 1, 'worker_id' => 3, 'user_id' => 1],
            ['worker_type_id' => 1, 'worker_id' => 1, 'user_id' => 1],
            ['worker_type_id' => 1, 'worker_id' => 2, 'user_id' => 1],
            ['worker_type_id' => 2, 'worker_id' => 4, 'user_id' => 1],
            ['worker_type_id' => 3, 'worker_id' => 4, 'user_id' => 1],
            ['worker_type_id' => 4, 'worker_id' => 4, 'user_id' => 1],
            ['worker_type_id' => 2, 'worker_id' => 5, 'user_id' => 1],
            ['worker_type_id' => 4, 'worker_id' => 5, 'user_id' => 1],
        ];

        \Illuminate\Support\Facades\DB::table('worker_type_workers')->insert($workerTypeWorkers);
    }
}
