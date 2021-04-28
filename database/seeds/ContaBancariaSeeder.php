<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Cliente;
use App\Banco;

class ContaBancariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('conta_bancaria')->insert([
            'id_cliente' => Cliente::ID_CLIENTE_ADELSON,
            'id_banco' => Banco::ID_BANCO_CAPGEMINI,
            'nu_agencia'=> '1358',
            'nu_conta' => '25489-5',
            'nu_senha' => '1234',
            'nu_saldo' => 0
        ]);
    }
}
