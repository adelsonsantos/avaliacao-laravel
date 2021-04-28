<?php

namespace App;

use App\Client;
use Illuminate\Database\Eloquent\Model;

class ContaBancaria extends Model
{
    const ID_CONTA_ADELSON = 1;

    protected  $table = 'conta_bancaria';

    protected $primaryKey = 'id_conta_bancaria';

    protected $fillable = [
        'id_conta_bancaria',
        'id_cliente',
        'id_banco',
        'nu_agencia',
        'nu_conta',
        'nu_senha',
        'nu_saldo'
    ];

    public function cliente()
    {
        return $this->belongsTo(Client::class, 'foreign_key');
    }
}
