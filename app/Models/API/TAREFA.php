<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TAREFA extends Model
{
    use HasFactory;

    protected $table = 'TAREFA';
    protected $connection = 'oracle_selbetti';

    public $timestamps = false;
}
