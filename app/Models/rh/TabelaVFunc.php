<?php

namespace App\Models\rh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaVFunc extends Model
{
    use HasFactory;

    protected $table = 'v_func';
    protected $connection = 'sqlsrv_vetor';
    public $timestamps = false;
}
