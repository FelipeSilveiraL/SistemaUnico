<?php

namespace App\Models\notas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaDepartamentoNF extends Model
{
    use HasFactory;

    protected $table = 'DEPARTAMENTO_NF AS DNF';
    protected $connection = 'oracle_bpmgp';

    public $timestamps = false;
}
