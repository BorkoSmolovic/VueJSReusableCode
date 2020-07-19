<?php

use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = [
            ['name' => 'Crnogorski', 'value' => 'me', 'flag' => 'me'],
            ['name' => 'English', 'value' => 'en', 'flag' => 'gb'],
        ];
        DB::table('languages')->insert($languages);
    }
}
