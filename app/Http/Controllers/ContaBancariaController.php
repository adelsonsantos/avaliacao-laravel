<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ContaBancaria;
use Illuminate\Support\Facades\DB;

class ContaBancariaController extends Controller
{
    /**
     * Mostra todos os Clientes
     */
    public function index()
    {
        $contaBancaria = ContaBancaria::all();
        return $contaBancaria;
    }

    /**
     * Store a newly created photo.
     */
    public function create(Request $request)
    {
        $contaBancaria = ContaBancaria::create([
            'nm_cliente' => $request->nm_cliente
        ]);

        return new ClienteResource($contaBancaria);
    }

    public function conta() {
        $retorno = [];

        $cliente = DB::table('conta_bancaria')
            ->join('clientes', 'conta_bancaria.id_cliente', '=', 'clientes.id_cliente')
            ->join('bancos', 'bancos.id_banco', '=', 'conta_bancaria.id_banco')
            ->select(
                 'conta_bancaria.id_conta_bancaria',
                    'conta_bancaria.nu_agencia',
                    'conta_bancaria.nu_conta',
                    'bancos.nm_banco',
                    'clientes.nm_cliente'
            )->where('conta_bancaria.id_conta_bancaria', '=', ContaBancaria::ID_CONTA_ADELSON)
            ->get();

        if(!empty($cliente[0])){
            $retorno = $cliente[0];
        }else{
            $retorno['message'] = "Cliente não encontrado.";
        }
        return response()->json($retorno);
    }

    /**
     * Método para alterar um Cliente
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $retorno = [
            'status'  => 200,
            'message' => 'Cliente atualizado com sucesso.'
        ];

        $contaBancaria = ContaBancaria::find($id);
        if(!empty($contaBancaria)){
            $contaBancaria = ContaBancaria::find($id);
            $contaBancaria->nm_cliente = $request->nm_cliente;
            $contaBancaria->save();
        }else{
            $retorno['status'] = 404;
            $retorno['message'] = "Cliente não encontrado.";
        }
        return response()->json($retorno['message'], $retorno['status']);
    }

    /**
     * Método para excluir um Cliente
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $retorno = [
            'status'  => 200,
            'message' => 'Cliente excluído com sucesso.'
        ];

        $contaBancaria = ContaBancaria::find($id);
        if(!empty($contaBancaria)){
            $contaBancaria->delete();
        }else{
            $retorno['status'] = 404;
            $retorno['message'] = "Cliente não encontrado.";
        }

        return response()->json($retorno['message'], $retorno['status']);
    }
}
