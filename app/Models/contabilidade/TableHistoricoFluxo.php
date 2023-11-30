<?php

namespace App\Models\contabilidade;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableHistoricoFluxo extends Model
{
    use HasFactory;

    protected $table = 'historico_fluxo';
    protected $connection = 'oracle_selbetti';

    public $timestamps = false;

}
