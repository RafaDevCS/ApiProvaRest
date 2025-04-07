<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoPessoa extends Model
{
    protected $fillable = [
        'pes_id',
        'ft_data',
        'ft_bucket',
        'ft_hash',
    ];
    protected $table = 'foto_pessoa';
    protected $primaryKey = 'ft_id';

    public function pessoa(): HasOne
    {
        return $this->hasOne(Pessoa::class);
    }
    /** @use HasFactory<\Database\Factories\FotoPessoaFactory> */
    use HasFactory;
}
