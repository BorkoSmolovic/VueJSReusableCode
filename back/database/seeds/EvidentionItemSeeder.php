<?php

use Illuminate\Database\Seeder;

class EvidentionItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $evidentionItems = [
            ['vehicle_id' => 1, 'evidention_id' => 1, 'id' => 1, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 39.86],
            ['vehicle_id' => 1, 'evidention_id' => 2, 'id' => 2, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 9.81],
            ['vehicle_id' => 1, 'evidention_id' => 3, 'id' => 3, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 5.7],
            ['vehicle_id' => 1, 'evidention_id' => 4, 'id' => 4, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 27.68],
            ['vehicle_id' => 1, 'evidention_id' => 5, 'id' => 5, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 15.62],
            ['vehicle_id' => 1, 'evidention_id' => 6, 'id' => 6, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 4.82],
            ['vehicle_id' => 1, 'evidention_id' => 7, 'id' => 7, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 6.03],
            ['vehicle_id' => 1, 'evidention_id' => 8, 'id' => 8, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 27.7],
            ['vehicle_id' => 1, 'evidention_id' => 9, 'id' => 9, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 16.02],
            ['vehicle_id' => 1, 'evidention_id' => 10, 'id' => 10, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 42.74],
            ['vehicle_id' => 1, 'evidention_id' => 11, 'id' => 11, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 33.25],
            ['vehicle_id' => 1, 'evidention_id' => 12, 'id' => 12, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 41.87],
            ['vehicle_id' => 1, 'evidention_id' => 13, 'id' => 13, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 39.68],
            ['vehicle_id' => 1, 'evidention_id' => 14, 'id' => 14, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 29.47],
            ['vehicle_id' => 1, 'evidention_id' => 15, 'id' => 15, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 27.28],
            ['vehicle_id' => 1, 'evidention_id' => 16, 'id' => 16, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 44.48],
            ['vehicle_id' => 1, 'evidention_id' => 17, 'id' => 17, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 4.85],
            ['vehicle_id' => 1, 'evidention_id' => 18, 'id' => 18, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 9.08],
            ['vehicle_id' => 1, 'evidention_id' => 19, 'id' => 19, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 14.93],
            ['vehicle_id' => 1, 'evidention_id' => 20, 'id' => 20, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 11.65],
            ['vehicle_id' => 1, 'evidention_id' => 21, 'id' => 21, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 6.47],
            ['vehicle_id' => 1, 'evidention_id' => 22, 'id' => 22, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 27.28],
            ['vehicle_id' => 1, 'evidention_id' => 23, 'id' => 23, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 26.36],
            ['vehicle_id' => 1, 'evidention_id' => 24, 'id' => 24, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 17.02],
            ['vehicle_id' => 1, 'evidention_id' => 25, 'id' => 25, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 36.75],
            ['vehicle_id' => 1, 'evidention_id' => 26, 'id' => 26, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 44.84],
            ['vehicle_id' => 1, 'evidention_id' => 27, 'id' => 27, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 16.31],
            ['vehicle_id' => 1, 'evidention_id' => 28, 'id' => 28, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 22.89],
            ['vehicle_id' => 1, 'evidention_id' => 29, 'id' => 29, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 20.62],
            ['vehicle_id' => 1, 'evidention_id' => 30, 'id' => 30, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 11.66],
            ['vehicle_id' => 1, 'evidention_id' => 31, 'id' => 31, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 21.28],
            ['vehicle_id' => 1, 'evidention_id' => 32, 'id' => 32, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 25.85],
            ['vehicle_id' => 1, 'evidention_id' => 33, 'id' => 33, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 28.62],
            ['vehicle_id' => 1, 'evidention_id' => 34, 'id' => 34, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 35.6],
            ['vehicle_id' => 1, 'evidention_id' => 35, 'id' => 35, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 48.35],
            ['vehicle_id' => 1, 'evidention_id' => 36, 'id' => 36, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 16.8],
            ['vehicle_id' => 1, 'evidention_id' => 37, 'id' => 37, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 26.3],
            ['vehicle_id' => 1, 'evidention_id' => 38, 'id' => 38, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 19.73],
            ['vehicle_id' => 1, 'evidention_id' => 39, 'id' => 39, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 47.12],
            ['vehicle_id' => 1, 'evidention_id' => 40, 'id' => 40, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 36.66],
            ['vehicle_id' => 1, 'evidention_id' => 41, 'id' => 41, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 7.28],
            ['vehicle_id' => 1, 'evidention_id' => 42, 'id' => 42, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 49.04],
            ['vehicle_id' => 1, 'evidention_id' => 43, 'id' => 43, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 13.93],
            ['vehicle_id' => 1, 'evidention_id' => 44, 'id' => 44, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 12.11],
            ['vehicle_id' => 1, 'evidention_id' => 45, 'id' => 45, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 29.94],
            ['vehicle_id' => 1, 'evidention_id' => 46, 'id' => 46, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 39.32],
            ['vehicle_id' => 1, 'evidention_id' => 47, 'id' => 47, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 9.09],
            ['vehicle_id' => 1, 'evidention_id' => 48, 'id' => 48, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 7.73],
            ['vehicle_id' => 1, 'evidention_id' => 49, 'id' => 49, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 35.6],
            ['vehicle_id' => 1, 'evidention_id' => 50, 'id' => 50, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 10.27],
            ['vehicle_id' => 1, 'evidention_id' => 51, 'id' => 51, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 46.63],
            ['vehicle_id' => 1, 'evidention_id' => 52, 'id' => 52, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 10.81],
            ['vehicle_id' => 1, 'evidention_id' => 53, 'id' => 53, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 7.44],
            ['vehicle_id' => 1, 'evidention_id' => 54, 'id' => 54, 'item_id' => 1, 'isActive' => 1, 'user_id' => 1, 'value' => 22.28],
        ];

        DB::table('evidention_items')->insert($evidentionItems);
    }
}
