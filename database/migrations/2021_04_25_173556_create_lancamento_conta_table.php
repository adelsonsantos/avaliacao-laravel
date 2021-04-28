<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLancamentoContaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lancamento_conta', function (Blueprint $table) {
            $table->id('id_lancamento_conta');
            $table->integer('id_conta_bancaria')->nullable(false);
            $table->integer('id_lancamento_tipo')->nullable(false);
            $table->dateTime('data_lancamento')->nullable(false);
            $table->double('valor_lancamento')->nullable(false);
            $table->timestamps();
        });

        Schema::table('lancamento_conta', function (Blueprint $table){
            $table->foreign('id_conta_bancaria')->references('id_conta_bancaria')->on('conta_bancaria')->onDelete('cascade');
            $table->foreign('id_lancamento_tipo')->references('id_lancamento_tipo')->on('lancamento_tipo')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lancamento_conta');
    }
}
