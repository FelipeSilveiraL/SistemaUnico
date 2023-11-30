<?php

namespace App\Models\notas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaCadBancos extends Model
{
    use HasFactory;

    protected $table = 'cad_rateiobanco AS CB';
    protected $connection = 'mysql_dbnotas';

    public $timestamps = false;
}
