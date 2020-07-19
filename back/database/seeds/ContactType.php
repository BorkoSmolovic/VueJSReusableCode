<?php

use Illuminate\Database\Seeder;

class ContactType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contactTypeSeeder = [
            ['id' => 1, 'name' => 'email', 'user_id' => '1', 'icon' => 'mdi-email-outline'],
            ['id' => 2, 'name' => 'phone', 'user_id' => '1', 'icon' => 'mdi-phone-outline']
        ];
        DB::table('contact_types')->insert($contactTypeSeeder);
    }
}
