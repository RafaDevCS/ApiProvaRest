<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    protected $fillable = [
        'uni_nome',
        'uni_sigla',
        
    ];
    protected $table = 'unidade';
    protected $primaryKey = 'uni_id';
    /** @use HasFactory<\Database\Factories\UnidadeFactory> */
    use HasFactory;
}
