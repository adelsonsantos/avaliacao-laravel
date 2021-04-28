<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    const ID_CLIENTE_ADELSON = 1;

    protected  $table = 'clientes';

    protected $primaryKey = 'id_cliente';

    protected $fillable = [
        'id_cliente',
        'nm_cliente'
    ];
}
