<?php

namespace App\Models\automacao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaSelbettiUsers extends Model
{
    use HasFactory;

    protected $table = 'selbetti_users';
    protected $connection = 'mysql_unico';

    public $timestamps = false;
}
