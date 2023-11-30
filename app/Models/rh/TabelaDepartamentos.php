<?php

namespace App\Models\rh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaDepartamentos extends Model
{
    use HasFactory;

    protected $table = 'DEPARTAMENTO_RH';
    protected $connection = 'oracle_bpmgp';

    public $timestamps = false;
}
