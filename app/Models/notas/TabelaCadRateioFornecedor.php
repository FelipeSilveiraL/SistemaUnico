<?php

namespace App\Models\notas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaCadRateioFornecedor extends Model
{
    use HasFactory;

    protected $table = 'cad_rateiofornecedor';
    protected $connection = 'mysql_dbnotas';
    protected $primaryKey = 'ID_RATEIOFORNECEDOR';

    public $timestamps = false;
}
