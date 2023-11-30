<?php

namespace App\Models\automacao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaUserApollo extends Model
{
    use HasFactory;
    
    protected $table = 'GER_USUARIO';
    protected $connection = 'oracle_apollo';

    public $timestamps = false;

}
