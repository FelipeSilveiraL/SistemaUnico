<?php

namespace App\Models\notas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaCadRateioCentroCusto extends Model
{
    use HasFactory;

    protected $table = 'cad_rateiocentrocusto';
    protected $connection = 'mysql_dbnotas';
    protected $primaryKey = 'ID_RATEIOCENTROCUSTO';

    public $timestamps = false;
}
