<?php

namespace App\Models\automacao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaEmpresaUsuarios extends Model
{
    use HasFactory;

    protected $table = 'EMPRESAS_USUARIOS';
    protected $connection = 'oracle_nbs';

    public $timestamps = false;
}
