<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class bancoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bancos')->insert([
            'nm_banco' => 'Capgemini',
            'nu_banco' => 154,
        ]);
    }
}
