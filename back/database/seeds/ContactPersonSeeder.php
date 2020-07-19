<?php

use Illuminate\Database\Seeder;

class ContactPersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contactPersons = [
            ['id' => 1, 'person' => 'Dejan Jovanovic', 'partner_id' => 318, 'description' => null, 'user_id' => 1, 'isActive' => 1],
            ['id' => 2, 'person' => 'Andjela Kadovic', 'partner_id' => 462, 'description' => null, 'user_id' => 1, 'isActive' => 1],
        ];
        DB::table('contact_people')->insert($contactPersons);
    }
}
