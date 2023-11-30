<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VW_FLUXO_TRANSPORTE_ROTA_A_PROGRAMAR extends Model
{
    use HasFactory;

    protected $table = 'VW_FLUXO_TRANSPORTE_ROTA_A_PROGRAMAR';
    protected $connection = 'oracle_selbetti';

    public $timestamps = false;
}
