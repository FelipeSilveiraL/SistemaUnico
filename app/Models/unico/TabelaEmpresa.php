<?php

namespace App\Models\unico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaEmpresa extends Model
{
    use HasFactory;

    protected $table = 'cad_empresa';
    protected $connection = 'mysql_unico';
}
