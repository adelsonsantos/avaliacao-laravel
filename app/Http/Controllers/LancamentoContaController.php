<?php


namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\ContaBancaria;
use App\LancamentoConta;
use App\LancamentoTipo;

class LancamentoContaController extends Controller
{
    /**
     * Mostra todos os Clientes
     */
    public function index()
    {
        $lancamentoConta = LancamentoConta::all();
        return $lancamentoConta;
    }

    public function validaSaldo($valorSaque){
        $retorno = [
            'ok' => true,
            'message' => ''
        ];

        $contaBancaria = ContaBancaria::find(ContaBancaria::ID_CONTA_ADELSON);
        if($contaBancaria->nu_saldo < $valorSaque){
            $retorno['ok'] = false;
            $retorno['message'] = 'Saldo insuficiente';
        }

        return $retorno;
    }

    private function atualizaSaldo($lancamentoTipo, $valor){

        $contaBancaria = ContaBancaria::find(ContaBancaria::ID_CONTA_ADELSON);

        if($lancamentoTipo == LancamentoTipo::ID_LANCAMENTO_TIPO_SAQUE){
            $novoSaldo = ($contaBancaria->nu_saldo - $valor);
        }else{
            $novoSaldo = ($contaBancaria->nu_saldo + $valor);
        }

        $contaBancaria->nu_saldo = $novoSaldo;
        $contaBancaria->save();

    }

    /**
     * Método para realizar o saque.
     */
    public function saque(Request $request)
    {
        $retorno = [
            'status'  => 200,
            'mensagem' => 'Saque realizado com sucesso.'
        ];

        $validaSaldo = $this->validaSaldo($request->valor_lancamento);
        if($validaSaldo['ok']){
            $lancamentoConta = LancamentoConta::create([
                'id_conta_bancaria' => ContaBancaria::ID_CONTA_ADELSON,
                'id_lancamento_tipo' => LancamentoTipo::ID_LANCAMENTO_TIPO_SAQUE,
                'data_lancamento' => Carbon::now(),
                'valor_lancamento' => doubleval($request->valor_lancamento)
            ]);

           // $retorno['dados']['dadosLancamento'] = $lancamentoConta;
            $this->atualizaSaldo(LancamentoTipo::ID_LANCAMENTO_TIPO_SAQUE, $request->valor_lancamento);

        }else{
            $retorno['mensagem'] = $validaSaldo['message'];
        }

        return response()->json($retorno['mensagem'], $retorno['status']);
    }

    /**
     * Método para realizar o deposito.
     */
    public function deposito(Request $request)
    {
        $retorno = [
            'status'  => 200,
            'mensagem' => 'Depósito realizado com sucesso.'
        ];

        LancamentoConta::create([
            'id_conta_bancaria' => ContaBancaria::ID_CONTA_ADELSON,
            'id_lancamento_tipo' => LancamentoTipo::ID_LANCAMENTO_TIPO_DEPOSITO,
            'data_lancamento' => Carbon::now(),
            'valor_lancamento' => doubleval($request->valor_lancamento)
        ]);
        $this->atualizaSaldo(LancamentoTipo::ID_LANCAMENTO_TIPO_DEPOSITO, $request->valor_lancamento);

        return response()->json($retorno['mensagem'], $retorno['status']);
    }

    public function saldo() {
        $retorno = [
            'status' => 200,
        ];

        $contaBancaria = ContaBancaria::find(ContaBancaria::ID_CONTA_ADELSON);
        if(!empty($contaBancaria)){
            $retorno['dados'] = 'R$: '. number_format($contaBancaria->nu_saldo,2,",",".");
        }else{
            $retorno['status'] = 404;
            $retorno['message'] = "Cliente não encontrado.";
        }
        return response()->json($retorno);
    }

    public function quantidadeDeposito($retornaJson = true){
        $retorno = [
            'status' => 200,
        ];

        $contaBancaria = LancamentoConta::where([
                ['id_conta_bancaria', '=',  ContaBancaria::ID_CONTA_ADELSON],
                ['id_lancamento_tipo', '=',  LancamentoTipo::ID_LANCAMENTO_TIPO_DEPOSITO]
            ]
        )->get();

        if(!empty($contaBancaria)){
            $retorno['dados'] = $contaBancaria->count();
        }else{
            $retorno['status'] = 404;
            $retorno['message'] = "Dados não encontrados.";
        }

        $dados = $retornaJson == true ?  response()->json($retorno) : $retorno;
        return $dados;
    }

    public function quantidadeSaque($retornaJson = true){
        $retorno = [
            'status' => 200,
        ];

        $contaBancaria = LancamentoConta::where([
                ['id_conta_bancaria', '=',  ContaBancaria::ID_CONTA_ADELSON],
                ['id_lancamento_tipo', '=',  LancamentoTipo::ID_LANCAMENTO_TIPO_SAQUE]
            ]
        )->get();

        if(!empty($contaBancaria)){
            $retorno['dados'] = $contaBancaria->count();
        }else{
            $retorno['status'] = 404;
            $retorno['message'] = "Dados não encontrados.";
        }
        $dados = $retornaJson == true ?  response()->json($retorno) : $retorno;
        return $dados;
    }


    public function obterValorGraficoTransacoes(){
        $retorno = [
            'status' => 200,
            'porcentagemDeposito' => 0,
            'porcentagemSaque' => 0,
            'porcentagemDepositoString' => "",
            'porcentagemSaqueString' => "",
        ];

        $quantidadeDeposito = $this->quantidadeDeposito(false);
        $quantidadeSaque = $this->quantidadeSaque(false);

        if($quantidadeDeposito['status'] == 200 && $quantidadeSaque['status'] == 200){
            $quantidadeTotal = $quantidadeDeposito['dados'] + $quantidadeSaque['dados'];
            $porcentagemDeposito = number_format((float)($quantidadeDeposito['dados'] * 100) / $quantidadeTotal, 2, '.', '');
            $porcentagemSaque = number_format((float)($quantidadeSaque['dados'] * 100) / $quantidadeTotal, 2, '.', '');;

            $retorno['porcentagemDeposito'] = $porcentagemDeposito;
            $retorno['porcentagemSaque'] = $porcentagemSaque;
            $retorno['porcentagemDepositoString'] = $porcentagemDeposito."%";
            $retorno['porcentagemSaqueString'] = $porcentagemSaque."%";

        }else{
            $retorno['status'] = 404;
            $retorno['message'] = "Dados não encontrados.";
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
