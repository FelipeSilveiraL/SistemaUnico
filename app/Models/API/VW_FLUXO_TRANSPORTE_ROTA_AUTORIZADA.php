<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VW_FLUXO_TRANSPORTE_ROTA_AUTORIZADA extends Model
{
    use HasFactory;

    protected $table = 'VW_FLUXO_TRANSPORTE_ROTA_AUTORIZADA';
    protected $connection = 'oracle_selbetti';

    public $timestamps = false;
}
