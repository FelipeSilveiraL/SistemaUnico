<?php

namespace App\Models\contabilidade;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableEmpresaApollo extends Model
{
    use HasFactory;

    protected $table = 'EMPRESA';
    protected $connection = 'oracle_bpmgp';

    public $timestamps = false;
}
