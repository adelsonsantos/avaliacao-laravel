<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LancamentoTipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lancamento_tipo')->insert([
            'nm_lancamento_tipo' => 'Depósito'
        ]);

        DB::table('lancamento_tipo')->insert([
            'nm_lancamento_tipo' => 'Saque'
        ]);
    }
}
