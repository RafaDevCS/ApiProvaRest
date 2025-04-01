<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServidorEfetivo extends Model
{
    protected $fillable = [
        'se_matricula',
    ];
    protected $table = 'servidor_efetivo';
    //protected $primaryKey = 'pes_id';
    /** @use HasFactory<\Database\Factories\ServidorEfetivoFactory> */
    use HasFactory;
}
