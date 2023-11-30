<?php

namespace App\Models\contabilidade;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableFinBanco extends Model
{
    use HasFactory;

    protected $table = 'FIN_BANCO';
    protected $connection = 'oracle_apollo';

    public $timestamps = false;
}
