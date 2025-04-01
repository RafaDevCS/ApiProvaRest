<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lotacao extends Model
{
    protected $fillable = [
        'lt_data_lotacao',
        'lt_data_remocao',
        'lt_portaria',
    ];
    protected $table = 'lotacao';
    protected $primaryKey = 'lt_id';
    /** @use HasFactory<\Database\Factories\LotacaoFactory> */
    use HasFactory;
}
