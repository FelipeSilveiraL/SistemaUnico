<?php

namespace App\Models\bpmServopa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaLogisticaOrigemDestino extends Model
{
    use HasFactory;
    protected $table = 'logistica_origem_destino';
    protected $connection = 'pgsql_bpmgp';

    public $timestamps = false;
}
