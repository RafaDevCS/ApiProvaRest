<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PessoaEndereco extends Model
{
    protected $fillable = [
        'pes_id',
        'end_id',
    ];
    protected $table = 'pessoa_endereco';
    protected $primaryKey = 'pes_id';
    /** @use HasFactory<\Database\Factories\PessoaEnderecoFactory> */
    use HasFactory;
}
