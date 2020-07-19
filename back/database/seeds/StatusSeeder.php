<?php

use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ['id' => 1, 'name' => 'Naručeno', 'isActive' => 1, 'user_id' => 1],
            ['id' => 2, 'name' => 'Prihvaćeno', 'isActive' => 1, 'user_id' => 1],
            ['id' => 3, 'name' => 'Odbijeno', 'isActive' => 1, 'user_id' => 1],
            ['id' => 4, 'name' => 'U izradi', 'isActive' => 1, 'user_id' => 1],
            ['id' => 5, 'name' => 'Završeno', 'isActive' => 1, 'user_id' => 1],
            ['id' => 6, 'name' => 'Kompletirano', 'isActive' => 1, 'user_id' => 1],
        ];

        DB::table('statuses')->insert($statuses);
    }
}
