<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    const ID_BANCO_CAPGEMINI = 1;

    protected  $table = 'bancos';

    protected $fillable = [
        'id_banco',
        'nm_banco',
        'nu_banco'
    ];
}
