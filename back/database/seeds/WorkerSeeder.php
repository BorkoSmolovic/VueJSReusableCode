<?php

use Illuminate\Database\Seeder;

class WorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $workers = [
            ['id' => 1, 'name' => 'Rajko', 'surname' => 'Krgović', 'isActive' => 1, 'user_id' => 1],
            ['id' => 2, 'name' => 'Zoran', 'surname' => 'Mikulić', 'isActive' => 1, 'user_id' => 1],
            ['id' => 3, 'name' => 'Dušan', 'surname' => 'Paunović', 'isActive' => 1, 'user_id' => 1],
            ['id' => 4, 'name' => 'Jovan', 'surname' => 'Perić', 'isActive' => 1, 'user_id' => 1],
            ['id' => 5, 'name' => 'Tijana', 'surname' => 'Radulović', 'isActive' => 1, 'user_id' => 1],
        ];

        DB::table('workers')->insert($workers);
    }
}
