<?php

namespace App\Models\notas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaCadAnexo extends Model
{
    use HasFactory;

    protected $table = 'cad_anexos';
    protected $connection = 'mysql_dbnotas';

    public $timestamps = false;
}
