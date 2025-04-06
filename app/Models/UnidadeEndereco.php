<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnidadeEndereco extends Model
{
    protected $fillable = [
        'unid_id',
        'end_id',
    ];
    protected $table = 'unidade_endereco';
    protected $primaryKey = 'unid_id';
}
