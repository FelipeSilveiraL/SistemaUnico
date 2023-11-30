<?php

namespace App\Models\app_vendas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaCentralAjuda extends Model
{
    use HasFactory;

    protected $table = 'appVendas_central_ajuda';
    protected $connection = 'mysql_unico';

    public $timestamps = false;
}
