<?php

use Illuminate\Support\Facades\DB;

class UserSeeder extends DatabaseSeeder

{
    public function run()
    {
        $users = [
            [
                "name" => "Administrator",
                'username' => 'admin',
                'language_id' => '1',
                'partner_id' => null,
                'password' => '$2y$10$vTdIdVw7Hf6znLUxQxdW5OZMATE/8DTyJl1JnfhPvBNaybZTbwcAa', //Admin.123
            ],
            [
                "name" => "Petar Radunović",
                'username' => 'petarr',
                'language_id' => '1',
                'partner_id' => null,
                'password' => '$2y$10$8GuKitPJLIbIMqwNHFmlFO1GXTpm6xZ/Bzlvnwr7yVlxpJ4YrZJ8m', //Petar.123
            ],
            [
                "name" => "Mirjana Mišurović",
                'username' => 'mirjanam',
                'language_id' => '1',
                'partner_id' => null,
                'password' => '$2y$10$FmrIcs/3ypi0PUw.K.bnmuB7j4eoJi2SV0XLxDaIE1BAPUPcqMDae', //Mirjana.123
            ],
            [
                "name" => "Dušan Paunović",
                'username' => 'dusanp',
                'language_id' => '1',
                'partner_id' => null,
                'password' => '$2y$10$UgD2y9QuDiPm7MVthYIVheBxKpgu.6EeP9Q4mdb0/9PsnjaXQCWvO', //Dusan.123
            ],
            [
                "name" => "Lazar Mišurović",
                'username' => 'lazarm',
                'language_id' => '1',
                'partner_id' => null,
                'password' => '$2y$10$hlzc.n23JklxpoquFJ/b/uqCAb9aGIQWGpytlf8p/2TJg/qEbBbq.', //Lazar.123
            ],
        ];

        DB::table('users')->insert($users);
    }
}
