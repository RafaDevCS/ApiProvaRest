<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lotacao extends Model
{
    protected $fillable = [
        'pes_id',
        'unid_id',
        'lot_data_lotacao',
        'lot_data_remocao',
        'lot_portaria',
    ];
    protected $table = 'lotacao';
    protected $primaryKey = 'lot_id';

    public function pessoa(): HasOne
    {
        return $this->hasOne(Pessoa::class);
    }
    /** @use HasFactory<\Database\Factories\LotacaoFactory> */
    use HasFactory;
}
