<?php

namespace App\Models\rh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaHorarioTrabalho extends Model
{
    use HasFactory;

    protected $table = 'HORARIO_TRABALHO';
    protected $connection = 'oracle_bpmgp';
    protected $primaryKey = 'id_horario';

    public $timestamps = false;
}
