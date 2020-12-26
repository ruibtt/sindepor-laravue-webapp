<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class Socio extends Model
{
    protected $fillable = [
        'nome',
        'num_socio',
        'regiao',
        'local_trabalho',
    ];
}
