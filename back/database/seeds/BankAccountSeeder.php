<?php

use Illuminate\Database\Seeder;

class BankAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bankAccounts = [
            ['id' => 1, 'account_number' => '505-222222-86', 'bank_id' => 7, 'partner_id' => 32,  'user_id' => 1, 'isActive' => 1],
            ['id' => 2, 'account_number' => '520-13193-72', 'bank_id' => 1, 'partner_id' => 139,  'user_id' => 1, 'isActive' => 1],
            ['id' => 3, 'account_number' => '520-19729-58', 'bank_id' => 1, 'partner_id' => 148,  'user_id' => 1, 'isActive' => 1],
            ['id' => 4, 'account_number' => '520-19729-58', 'bank_id' => 1, 'partner_id' => 149,  'user_id' => 1, 'isActive' => 1],
            ['id' => 5, 'account_number' => '520-10651-35', 'bank_id' => 1, 'partner_id' => 318,  'user_id' => 1, 'isActive' => 1],
            ['id' => 6, 'account_number' => '540-6951-50', 'bank_id' => 2, 'partner_id' => 463,  'user_id' => 1, 'isActive' => 1],
            ['id' => 7, 'account_number' => '510-2970-54', 'bank_id' => 6, 'partner_id' => 467,  'user_id' => 1, 'isActive' => 1],
            ['id' => 8, 'account_number' => '510-2105-30', 'bank_id' => 6, 'partner_id' => 570,  'user_id' => 1, 'isActive' => 1],
            ['id' => 9, 'account_number' => '510-262-30', 'bank_id' => 6, 'partner_id' => 574,  'user_id' => 1, 'isActive' => 1],
            ['id' => 10, 'account_number' => '520-39701-88', 'bank_id' => 1, 'partner_id' => 641,  'user_id' => 1, 'isActive' => 1],
        ];
        DB::table('bank_accounts')->insert($bankAccounts);
    }
}
