<?php

use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            ['id' => 1, 'name' => 'Snimanje kamerom', 'isActive' => 1, 'user_id' => 1],
            ['id' => 2, 'name' => 'Montaža', 'isActive' => 1, 'user_id' => 1],
            ['id' => 3, 'name' => 'Distribucija', 'isActive' => 1, 'user_id' => 1],
            ['id' => 4, 'name' => 'Fotografisanje', 'isActive' => 1, 'user_id' => 1],
            ['id' => 5, 'name' => 'Snimanje dronom', 'isActive' => 1, 'user_id' => 1],
            ['id' => 6, 'name' => 'Produkcijske usluge', 'isActive' => 1, 'user_id' => 1],
            ['id' => 7, 'name' => 'Snimanje i izrada spota', 'isActive' => 1, 'user_id' => 1],
            ['id' => 8, 'name' => 'Snimanje i izrada promo filma', 'isActive' => 1, 'user_id' => 1],
        ];











        DB::table('services')->insert($services);
    }
}
