<?php

use Illuminate\Database\Seeder;

class GeneralConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('general_configs')->insert([[
            'perc_member' => 0
        ]]);
    }
}
