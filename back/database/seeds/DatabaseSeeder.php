<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            LanguageSeeder::class,
            UserSeeder::class,
            CountrySeeder::class,
            CitySeeder::class,
            PartnerType::class,
            PartnerSeeder::class,
//            UserPartnerSeeder::class,
            ContactType::class,
//            ContractSeeder::class,
            ContactSeeder::class,
            BankSeeder::class,
//            BankAccountSeeder::class,
            ContactPersonSeeder::class,
            StatusSeeder::class,
//            EvidentionSeeder::class,
            ItemSeeder::class,
            WorkerTypeSeeder::class,
            WorkerSeeder::class,
            WorkerTypeWorkerSeeder::class,
//            EvidentionStatusSeeder::class,
            VehicleSeeder::class,
//            EvidentionItemSeeder::class,
//            EvidentionWorkerSeeder::class,
//            CommentSeeder::class,
            ServiceSeeder::class
        ]);
        Artisan::call('passport:install');
    }
}
