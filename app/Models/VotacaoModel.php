<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class VotacaoModel extends Model
{
    use HasFactory;

    protected $table = 'votacoes';
    protected $primary = 'id';
    protected $fillable = [
        'data_inicio',
        'data_fim',
        'hora_inicio',
        'hora_fim',
        'status',
        'avisar_encerramento'
    ];

    /**
     * Get all of the votos for the VotacaoModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function votos(): HasMany
    {
        return $this->hasMany(VotosModel::class, 'votacao_id', 'id')->orderBy('qtd_votos', 'DESC');
    }

    /**
     * Get all of the votos for the VotacaoModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function candidatos(): HasMany
    {
        return $this->hasMany(VotosModel::class, 'votacao_id', 'id')
                    ->select('votos.candidato_id', 'votos.id as voto_id', 'votos.votacao_id', 'users.id as user_id', 'users.name')
                    ->join('users', function($j) {
                        return $j->on('votos.candidato_id', '=', 'users.id');
                    })->orderBy('users.name', 'ASC');
    }

    /**
     * Get the tipoVotacao associated with the VotacaoModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tipoVotacao(): HasOne
    {
        return $this->hasOne(TipoVotacaoModel::class, 'votacao_id', 'id');
    }

}
