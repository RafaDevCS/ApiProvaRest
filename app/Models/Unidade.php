<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    protected $fillable = [
        'unid_nome',
        'unid_sigla',
        
    ];
    protected $table = 'unidade';
    protected $primaryKey = 'unid_id';
    /** @use HasFactory<\Database\Factories\UnidadeFactory> */
    use HasFactory;
}
