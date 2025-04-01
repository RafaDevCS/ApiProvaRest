<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    protected $fillable = [
        'cid_nome',
        'cid_uf',
        
    ];
    protected $table = 'unidade';
    protected $primaryKey = 'uni_id';
    /** @use HasFactory<\Database\Factories\CidadeFactory> */
    use HasFactory;
}
