<?php

namespace App\Models\notas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaBancos extends Model
{
    use HasFactory;

    protected $table = 'bancos';
    protected $connection = 'mysql_unico';

    public $timestamps = false;
}
