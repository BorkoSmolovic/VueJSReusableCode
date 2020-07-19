<?php

use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contacts = [
            ['id' => 1, 'contact' => '069/363646', 'partner_id' => 4, 'contact_type_id' => 2, 'user_id' => 1, 'isActive' => 1],
            ['id' => 2, 'contact' => '69170004', 'partner_id' => 126, 'contact_type_id' => 2, 'user_id' => 1, 'isActive' => 1],
            ['id' => 3, 'contact' => '032/334536', 'partner_id' => 256, 'contact_type_id' => 2, 'user_id' => 1, 'isActive' => 1],
            ['id' => 4, 'contact' => '113334701', 'partner_id' => 394, 'contact_type_id' => 2, 'user_id' => 1, 'isActive' => 1],
            ['id' => 5, 'contact' => ' +382 67 222 737', 'partner_id' => 462, 'contact_type_id' => 2, 'user_id' => 1, 'isActive' => 1],
            ['id' => 6, 'contact' => '020/606-053', 'partner_id' => 631, 'contact_type_id' => 2, 'user_id' => 1, 'isActive' => 1],
            ['id' => 7, 'contact' => 'bnikcevic@karismaadriatic.com', 'partner_id' => 261, 'contact_type_id' => 1, 'user_id' => 1, 'isActive' => 1],
            ['id' => 8, 'contact' => 'vasoprele@t-com.me', 'partner_id' => 318, 'contact_type_id' => 1, 'user_id' => 1, 'isActive' => 1],
            ['id' => 9, 'contact' => 'andjela.kadovic@molsoncoors.com', 'partner_id' => 462, 'contact_type_id' => 1, 'user_id' => 1, 'isActive' => 1],
            ['id' => 10, 'contact' => 'milos.popovic@skijalista-cg.me', 'partner_id' => 535, 'contact_type_id' => 1, 'user_id' => 1, 'isActive' => 1],

        ];
        DB::table('contacts')->insert($contacts);
    }
}
