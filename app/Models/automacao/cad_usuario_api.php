<?php

namespace App\Models\automacao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cad_usuario_api extends Model
{
    use HasFactory;
    
    protected $table = 'cad_usuario_api';
    protected $connection = 'mysql_unico';

    public $timestamps = false;
}
