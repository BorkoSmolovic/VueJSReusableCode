<?php

use Illuminate\Support\Facades\DB;

class UserPartnerSeeder extends DatabaseSeeder

{
    public function run()
    {
        /*
        $partners = \App\Partner::all();
        foreach ($partners as $partner){
            \App\User::create([
                'name' => 'p'.$partner->id,
                'username' => 'p'.$partner->id,
                'language_id' => 1,
                'partner_id' => $partner->id,
            ]);
        }
        */
        $users = [
            [
                "name" => "p1",
                'username' => 'p1',
                'language_id' => '1',
                'partner_id' => 2,
                'password' => '$2y$10$WB7TPW0MIdpZPJLVre7jJOEvZm03Lu0/ipyCjU1rNd2imgHdCp92C', //p1
            ],
            [
                "name" => "p2",
                'username' => 'p2',
                'language_id' => '1',
                'partner_id' => 3,
                'password' => '$2y$10$tTQzmQKPzFpXOCWQlIO/beYnEZg2BCUQIZU8D3.vVjGSvR4tLYQFW', //p2
            ],
            [
                "name" => "p3",
                'username' => 'p3',
                'language_id' => '1',
                'partner_id' => 4,
                'password' => '$2y$10$3MU7/SnmMwXPXyQwa8Iyf.bMlxI0kmjZPxGb8Q33AnTgaB67LOyra', //p3
            ],
            [
                "name" => "p4",
                'username' => 'p4',
                'language_id' => '1',
                'partner_id' => 5,
                'password' => '$2y$10$8hevxxNSdvpkK1Nor8LpXu.AUWwirlFkFG8KotO6g.fEJwjBM1FxK', //p4
            ],
        ];

        DB::table('users')->insert($users);
    }
}
