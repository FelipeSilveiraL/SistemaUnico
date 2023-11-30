<?php

namespace App\Models\automacao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaUserVendedorApollo extends Model
{
    use HasFactory;

    protected $table = 'FAT_VENDEDOR';
    protected $connection = 'oracle_apollo';

    public $timestamps = false;
}
