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
        'cid_id',
    ];
    protected $table = 'endereco';
    protected $primaryKey = 'end_id';

    public function cidade(): HasOne
    {
        return $this->hasOne(Cidade::class, "cid_id");
    }
    /** @use HasFactory<\Database\Factories\EnderecoFactory> */
    use HasFactory;
}
