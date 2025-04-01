<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    protected $fillable = [
        'pes_nome',
        'pes_data_nascimento',
        'pes_sexo',
        'pes_mae',
        'pes_pai',
    ];
    protected $table = 'pessoa';
    protected $primaryKey = 'pes_id';
    /** @use HasFactory<\Database\Factories\PessoaFactory> */
    use HasFactory;
}
