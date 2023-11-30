<?php

namespace App\Models\notas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaCadLancarNotas extends Model
{
    use HasFactory;

    protected $table = 'cad_lancarnotas';
    protected $connection = 'mysql_dbnotas';
    protected $primaryKey = 'ID_LANCARNOTAS';

    public $timestamps = false;


}
