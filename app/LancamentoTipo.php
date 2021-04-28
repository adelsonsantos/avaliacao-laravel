<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LancamentoTipo extends Model
{
    const ID_LANCAMENTO_TIPO_DEPOSITO = 1;
    const ID_LANCAMENTO_TIPO_SAQUE = 2;

    protected  $table = 'lancamento_tipo';

    protected $fillable = [
        'id_lancamento_tipo',
        'nm_lancamento_tipo'
    ];
}
