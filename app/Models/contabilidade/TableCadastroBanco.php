<?php

namespace App\Models\contabilidade;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableCadastroBanco extends Model
{
    use HasFactory;

    protected $table = 'contabilidade_cadastro_bancos CCB';
    protected $connection = 'oracle_bpmgp';

    public $timestamps = false;
}
