<?php

namespace App\Models\contabilidade;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableLogUsuario extends Model
{
    use HasFactory;

    protected $table = 'contabilidade_log_usuario';
    protected $connection = 'mysql_unico';

    public $timestamps = false;
}
