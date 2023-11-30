<?php

namespace App\Models\unico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaDepartamento extends Model
{
    use HasFactory;
    
    protected $table = 'cad_depto';
    protected $connection = 'mysql_unico';
}
