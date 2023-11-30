<?php

namespace App\Models\unico;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;


class TabelaUsuarios extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $connection = 'mysql_unico';

    protected $fillable = [
        'deletar',
    ];

    public $timestamps = false;
}
