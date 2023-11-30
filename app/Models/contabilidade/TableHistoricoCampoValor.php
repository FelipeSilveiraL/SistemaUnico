<?php

namespace App\Models\contabilidade;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableHistoricoCampoValor extends Model
{
    use HasFactory;

    protected $table = 'historico_campo_valor';
    protected $connection = 'oracle_selbetti';

    public $timestamps = false;
}
