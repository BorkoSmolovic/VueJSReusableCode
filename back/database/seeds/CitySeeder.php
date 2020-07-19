<?php

use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            ['id' => 1, 'name' => 'Bar', 'post_code' => '85000', 'country_id' => 1, 'user_id' => 1],
            ['id' => 2, 'name' => 'Beograd', 'post_code' => '11000', 'country_id' => 2, 'user_id' => 1],
            ['id' => 3, 'name' => 'Bijelo polje', 'post_code' => '84000', 'country_id' => 1, 'user_id' => 1],
            ['id' => 4, 'name' => 'Brisel', 'post_code' => '1000', 'country_id' => 3, 'user_id' => 1],
            ['id' => 5, 'name' => 'Budva', 'post_code' => '85300', 'country_id' => 1, 'user_id' => 1],
            ['id' => 6, 'name' => 'Cetinje', 'post_code' => '81250', 'country_id' => 1, 'user_id' => 1],
            ['id' => 7, 'name' => 'Danilovgrad', 'post_code' => '81410', 'country_id' => 1, 'user_id' => 1],
            ['id' => 8, 'name' => 'Ðenovići', 'post_code' => '85345', 'country_id' => 1, 'user_id' => 1],
            ['id' => 9, 'name' => 'Dobrota', 'post_code' => '85331', 'country_id' => 1, 'user_id' => 1],
            ['id' => 10, 'name' => 'Drniš', 'post_code' => '22320', 'country_id' => 4, 'user_id' => 1],
            ['id' => 11, 'name' => 'Herceg novi', 'post_code' => '85340', 'country_id' => 1, 'user_id' => 1],
            ['id' => 12, 'name' => 'Jerusalim', 'post_code' => '9100000', 'country_id' => 5, 'user_id' => 1],
            ['id' => 13, 'name' => 'Kolašin', 'post_code' => '81210', 'country_id' => 1, 'user_id' => 1],
            ['id' => 14, 'name' => 'Kongeus Lyngby', 'post_code' => '2800', 'country_id' => 6, 'user_id' => 1],
            ['id' => 15, 'name' => 'Kotor', 'post_code' => '85330', 'country_id' => 1, 'user_id' => 1],
            ['id' => 16, 'name' => 'Kragujevac', 'post_code' => '34000', 'country_id' => 2, 'user_id' => 1],
            ['id' => 17, 'name' => 'Madrid', 'post_code' => '28001', 'country_id' => 7, 'user_id' => 1],
            ['id' => 18, 'name' => 'Maribor', 'post_code' => '2000', 'country_id' => 8, 'user_id' => 1],
            ['id' => 19, 'name' => 'Milano', 'post_code' => '20019', 'country_id' => 9, 'user_id' => 1],
            ['id' => 20, 'name' => 'Mojkovac', 'post_code' => '84205', 'country_id' => 1, 'user_id' => 1],
            ['id' => 21, 'name' => 'Nikšić', 'post_code' => '81400', 'country_id' => 1, 'user_id' => 1],
            ['id' => 22, 'name' => 'Niš', 'post_code' => '18000', 'country_id' => 2, 'user_id' => 1],
            ['id' => 23, 'name' => 'Novi Sad', 'post_code' => '21000', 'country_id' => 2, 'user_id' => 1],
            ['id' => 24, 'name' => 'Pescara', 'post_code' => '65100', 'country_id' => 9, 'user_id' => 1],
            ['id' => 25, 'name' => 'Petnjica', 'post_code' => '84312', 'country_id' => 1, 'user_id' => 1],
            ['id' => 26, 'name' => 'Plandište ', 'post_code' => '26360', 'country_id' => 2, 'user_id' => 1],
            ['id' => 27, 'name' => 'Pljevlja', 'post_code' => '84210', 'country_id' => 1, 'user_id' => 1],
            ['id' => 28, 'name' => 'Podgorica', 'post_code' => '81000', 'country_id' => 1, 'user_id' => 1],
            ['id' => 29, 'name' => 'Samobor', 'post_code' => '10430', 'country_id' => 2, 'user_id' => 1],
            ['id' => 30, 'name' => 'Sarajevo', 'post_code' => '71000', 'country_id' => 10, 'user_id' => 1],
            ['id' => 31, 'name' => 'Tivat', 'post_code' => '85320', 'country_id' => 1, 'user_id' => 1],
            ['id' => 32, 'name' => 'Ulcinj', 'post_code' => '85360', 'country_id' => 1, 'user_id' => 1],
            ['id' => 33, 'name' => 'Žabljak', 'post_code' => '84220', 'country_id' => 1, 'user_id' => 1],
            ['id' => 34, 'name' => 'Zagreb', 'post_code' => '10000', 'country_id' => 4, 'user_id' => 1],
            ['id' => 35, 'name' => 'Zlatibor', 'post_code' => '31315', 'country_id' => 2, 'user_id' => 1],

        ];
        DB::table('cities')->insert($cities);
    }
}
