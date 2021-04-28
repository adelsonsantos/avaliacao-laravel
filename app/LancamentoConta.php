<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LancamentoConta extends Model
{
    protected  $table = 'lancamento_conta';

    protected $primaryKey = 'id_lancamento_conta';

    protected $fillable = [
        'id_lancamento_conta',
        'id_conta_bancaria',
        'id_lancamento_tipo',
        'data_lancamento',
        'valor_lancamento'
    ];
}
