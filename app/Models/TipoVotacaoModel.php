<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TipoVotacaoModel extends Model
{
    use HasFactory;

    protected $table = 'tipo_votacoes';
    protected $primary = 'id';
    protected $fillable = [
        'tipo_id',
        'votacao_id'
    ];
    
    public function scopeTipoVotacao($query)
    {
        return $query->join('votacoes', 'votacoes.id', 'votacao_id')
                    ->join('tipos', 'tipos.id', 'tipo_id');
    }

    public function scopeVotacao($query, $votacao_id)
    {
        return $query->join('votacoes', 'votacoes.id', 'votacao_id')
                    ->join('tipos', 'tipos.id', 'tipo_id')
                    ->where('votacao_id', $votacao_id);
    }

    /**
     * Get the tipo that owns the TipoVotacaoModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipo(): BelongsTo
    {
        return $this->belongsTo(TipoModel::class, 'tipo_id', 'id');
    }
}
