<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServidorTemporario extends Model
{
    protected $fillable = [
        'st_data_admissao',
        'st_data_demissao',
        
    ];
    protected $table = 'servidor_temporario';
    //protected $primaryKey = 'pes_id';
    /** @use HasFactory<\Database\Factories\ServidorTemporarioFactory> */
    use HasFactory;
}
