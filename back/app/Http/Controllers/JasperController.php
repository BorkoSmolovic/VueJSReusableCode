<?php

namespace App\Http\Controllers;

use App\City;
use App\Partner;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\File;
use JasperPHP\JasperPHP;


//use PHPJasper\PHPJasper;

class JasperController
{
    public static function createInvoice(Faker $faker)
    {
        $jasper = new JasperPHP();
        for ($i = 0; $i < 1000; $i++) {
            $params = [
                'ime' => "a",
                'adresa' => "a",
                'postanski_broj' => 123,
                'pd' => 123,
                'datum' => '09-2019',
                'datum_izdavanja' => "a",
                'broj_izdavanja' => "a",
                'pib' => "a",
                'ziro_racun' => "a",
                'tip_stambene_jedinice' => 'Zgrada',
                'kvadraturaa' => "a",
                'vrijednost_boda' => 1,
                'nadoknada' => 1,
                'saldo' => 1,
                'pnb' => 1
            ];

            $jasper->process(
                storage_path() . "\jasper\Racunparams.jasper",
                "C:\Users\WindDjordje\Desktop\TestJasper\\$i",
                array('pdf'),
                array('ime' => 'ime')
            )->execute();
        }
    }

    public static function createCityReports()
    {
        $jasper = new JasperPHP();

        $format = ['pdf'];
        $parameters = [];
        $database = [
            'driver' => env('DB_CONNECTION'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'host' => env('DB_HOST'),
            'database' => env('DB_DATABASE'),
            'port' => env('DB_PORT'),
        ];
        $input = storage_path() . "/jasper/City.jasper";
        $output = storage_path() . "/reports_temp/";

        if (!file_exists($output)) {
            if (!mkdir($output)) {
                abort(422, "Error creating temp folder!");
            }
        }

        $output_file = $output . hash_hmac('sha256', microtime(), substr(str_shuffle(MD5(microtime())), 0, 10));

        $jasper->process(
            $input,
            $output_file,
            $format,
            $parameters,
            $database
        )->execute();

        $fileStream = File::get("$output_file.$format[0]");

        File::delete("$output_file.$format[0]");

        return $fileStream;

    }
}
