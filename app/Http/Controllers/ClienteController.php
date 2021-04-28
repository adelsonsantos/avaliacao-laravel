<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClienteResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Cliente;
use Symfony\Component\Console\Input\Input;

class ClienteController extends Controller
{

    /**
     * Mostra todos os Clientes
     */
    public function index()
    {
        $clientes = Cliente::all();
        return $clientes;
    }

    /**
     * Store a newly created photo.
     */
    public function create(Request $request)
    {
        $cliente = Cliente::create([
            'nm_cliente' => $request->nm_cliente
        ]);

        return new ClienteResource($cliente);
    }

    public function getCliente($id) {
        $retorno = [];

        $cliente = Cliente::find($id);
        if(!empty($cliente)){
            $retorno = $cliente;
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

        $cliente = Cliente::find($id);
        if(!empty($cliente)){
            $cliente = Cliente::find($id);
            $cliente->nm_cliente = $request->nm_cliente;
            $cliente->save();
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

        $cliente = Cliente::find($id);
        if(!empty($cliente)){
            $cliente->delete();
        }else{
            $retorno['status'] = 404;
            $retorno['message'] = "Cliente não encontrado.";
        }

        return response()->json($retorno['message'], $retorno['status']);
    }
}
