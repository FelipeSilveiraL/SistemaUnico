<?php

namespace App\Models\inventario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaInventarioFuncionario extends Model
{
    use HasFactory;

    protected $table = 'manager_inventario_funcionario';
    protected $connection = 'mysql_manager';

    public $timestamps = false;
}
