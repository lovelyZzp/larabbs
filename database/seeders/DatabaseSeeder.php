<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(UsersTableSeeder::class);
		$this->call(RepliesTableSeeder::class);
        $this->call(TopicsTableSeeder::class);
    }
}
