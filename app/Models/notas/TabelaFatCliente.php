<?php

namespace App\Models\notas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaFatCliente extends Model
{
    use HasFactory;

    protected $table = 'FAT_CLIENTE';
    protected $connection = 'oracle_apollo';

    public $timestamps = false;
}
