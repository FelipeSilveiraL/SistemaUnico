<?php

namespace App\Models\notas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaEmpresaDepartamentoNF extends Model
{
    use HasFactory;

    protected $table = 'empresa_departamento_nf';
    protected $connection = 'oracle_bpmgp';

    public $timestamps = false;
}
