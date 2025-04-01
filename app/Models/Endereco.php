<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $fillable = [
        'end_tipo_logradouro',
        'end_logradouro',
        'end_numero',
        'end_bairro',
    ];
    protected $table = 'pessoa';
    protected $primaryKey = 'pes_id';

    public function cidade(): HasOne
    {
        return $this->hasOne(Cidade::class);
    }
    /** @use HasFactory<\Database\Factories\EnderecoFactory> */
    use HasFactory;
}
