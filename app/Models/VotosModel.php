<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class VotosModel extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'votos';
    protected $primary = 'id';
    protected $fillable = [
        'candidato_id',
        'qtd_votos',
        'votacao_id'
    ];
    protected $with = ['user'];

    /**
     * Get the user associated with the VotosModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'candidato_id');
    }

    /**
     * Get the eleitor that owns the VotosModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function eleitor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * The roles that belong to the VotosModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function votos(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'eleitores', 'voto_id', 'user_id')->withTimestamps();
    }

    public function scopeEleitor($query, $eleitor_id)
    {
        return $query->whereEleitorId($eleitor_id);
    }

    public function scopeCandidato($query, $candidadto_id)
    {
        return $query->whereCandidatoId($candidadto_id);
    }

    public function scopeVotacao($query, $votacao_id)
    {
        return $query->whereVotacaoId($votacao_id);
    }

    public function scopeVotosComputados($query)
    {
        return $query->sum('qtd_votos');
    }


}
