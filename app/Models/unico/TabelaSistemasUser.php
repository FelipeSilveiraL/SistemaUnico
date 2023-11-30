<?php

namespace App\Models\unico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaSistemasUser extends Model
{
    use HasFactory;

    protected $table = 'cad_sis_user';
    protected $connection ='mysql_unico';

    protected $fillable = [
        'id_sistema',
        'id_usuario',
    ];

    public $timestamps = false;
}
