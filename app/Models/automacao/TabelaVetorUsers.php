<?php

namespace App\Models\automacao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaVetorUsers extends Model
{
    use HasFactory;

    protected $table = 'vetor_users';
    protected $connection = 'mysql_unico';

    public $timestamps = false;
}
