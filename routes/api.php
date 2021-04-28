<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('lancamento_conta_saque', 'LancamentoContaController@saque');

Route::post('lancamento_conta_deposito', 'LancamentoContaController@deposito');

Route::get('lancamento_conta_saldo', 'LancamentoContaController@saldo');

Route::get('clientes', 'ClienteController@index');

Route::get('lancamento_conta_quantidade_deposito', 'LancamentoContaController@quantidadeDeposito');

Route::get('lancamento_conta_quantidade_saque', 'LancamentoContaController@quantidadeSaque');

Route::get('lancamento_conta_valor_grafico_transacoes', 'LancamentoContaController@obterValorGraficoTransacoes');

Route::post('clientes', 'ClienteController@create');

Route::get('clientes/{id}', 'ClienteController@getCliente');

Route::put('clientes/{id}', 'ClienteController@update');

Route::get('conta', 'ContaBancariaController@conta');
