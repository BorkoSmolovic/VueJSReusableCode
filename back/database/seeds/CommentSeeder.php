<?php

use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $comments = [
            ['evidention_id' => 1, 'comment' => 'Tekst neki 1', 'user_id' => 1, 'created_at' => '2019-12-01 01:01:01'],
            ['evidention_id' => 1, 'comment' => 'Tekst neki 2', 'user_id' => 2, 'created_at' => '2019-12-01 01:02:01'],
            ['evidention_id' => 1, 'comment' => 'Tekst neki 3', 'user_id' => 2, 'created_at' => '2019-12-01 01:03:01'],
            ['evidention_id' => 1, 'comment' => 'Tekst neki 4', 'user_id' => 1, 'created_at' => '2019-12-01 01:04:01'],
            ['evidention_id' => 1, 'comment' => 'Tekst neki 5', 'user_id' => 2, 'created_at' => '2019-12-01 01:05:01'],
        ];

        \Illuminate\Support\Facades\DB::table('comments')->insert($comments);
    }
}
