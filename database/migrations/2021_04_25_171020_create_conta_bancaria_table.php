<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContaBancariaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conta_bancaria', function (Blueprint $table) {
            $table->id('id_conta_bancaria');
            $table->integer('id_cliente')->nullable(false);
            $table->integer('id_banco')->nullable(false);
            $table->integer('nu_agencia')->nullable(false);
            $table->string('nu_conta')->nullable(false);
            $table->string('nu_senha')->nullable(false);
            $table->double('nu_saldo')->nullable(false);
            $table->timestamps();
        });

        Schema::table('conta_bancaria', function (Blueprint $table){
            $table->foreign('id_cliente')->references('id_cliente')->on('clientes')->onDelete('cascade');
            $table->foreign('id_banco')->references('id_banco')->on('bancos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conta_bancaria');
    }
}
