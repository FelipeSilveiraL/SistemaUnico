<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaTransporteRotaAutorizada extends Model
{
    use HasFactory;

    protected $table = 'vw_fluxo_transporte_rota_autorizada';
    protected $connection = 'oracle_selbetti';

    public $timestamps = false;
}
