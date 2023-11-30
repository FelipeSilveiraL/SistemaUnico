<?php

namespace App\Models\unico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaSistemas extends Model
{
    use HasFactory;

    protected $table = 'cad_sistemas';
    protected $connection = 'mysql_unico';

    public $timestamps = false;
}
