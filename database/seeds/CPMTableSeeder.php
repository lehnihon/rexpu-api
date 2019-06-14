<?php

use Illuminate\Database\Seeder;

class CPMTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cpms')->insert([[
            'role_id' => '2',
            'amount' => 10
        ],
        [
            'role_id' => '3',
            'amount' => 5
        ]
        ]);
    }
}
