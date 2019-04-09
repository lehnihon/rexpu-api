<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configs')->insert([
            'id' => 1,
            'wp_endpoint' => '',
            'wp_login' => '',
            'wp_password' => ''
        ]);
    }
}
