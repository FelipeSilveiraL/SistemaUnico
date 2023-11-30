<?php

namespace App\Models\bpmServopa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaLogisticaRotas extends Model
{
    use HasFactory;
    protected $table = 'logistica_rotas';
    protected $connection = 'pgsql_bpmgp';

    public $timestamps = false;

}
