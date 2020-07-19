<?php

use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            ['id' => 1, 'name' => 'Crna Gora', 'user_id' => 1],
            ['id' => 2, 'name' => 'Srbija', 'user_id' => 1],
            ['id' => 3, 'name' => 'Belgija', 'user_id' => 1],
            ['id' => 4, 'name' => 'Hrvatska', 'user_id' => 1],
            ['id' => 5, 'name' => 'Izrael', 'user_id' => 1],
            ['id' => 6, 'name' => 'Danska', 'user_id' => 1],
            ['id' => 7, 'name' => 'Španija', 'user_id' => 1],
            ['id' => 8, 'name' => 'Slovenija', 'user_id' => 1],
            ['id' => 9, 'name' => 'Italija', 'user_id' => 1],
            ['id' => 10, 'name' => 'Bosna i Hercegovina', 'user_id' => 1],
        ];
        DB::table('countries')->insert($countries);
    }
}
