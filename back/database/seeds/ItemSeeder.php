<?php

use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['id' => 1, 'name' => 'Vozilo', 'isActive' => 1, 'user_id' => 1],
            ['id' => 2, 'name' => 'Sopstveno vozilo', 'isActive' => 1, 'user_id' => 1],
            ['id' => 3, 'name' => 'Dron', 'isActive' => 1, 'user_id' => 1],
            ['id' => 4, 'name' => 'Kran', 'isActive' => 1, 'user_id' => 1],
            ['id' => 5, 'name' => 'Fotoaparat', 'isActive' => 1, 'user_id' => 1],
            ['id' => 6, 'name' => 'Smjestaj', 'isActive' => 1, 'user_id' => 1],
            ['id' => 7, 'name' => 'Gorivo i parking', 'isActive' => 1, 'user_id' => 1],
            ['id' => 8, 'name' => 'Tunel/trajekt', 'isActive' => 1, 'user_id' => 1],
        ];

        DB::table('items')->insert($items);
    }
}
