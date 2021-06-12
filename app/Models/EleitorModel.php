<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class EleitorModel extends Model
{
    use HasFactory, Notifiable;

    protected $primary = 'id';
    protected $table = 'eleitores';
    protected $fillable = [
        'user_id',
        'voto_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function voto()
    {
        return $this->belongsTo(VotosModel::class, 'voto_id', 'id');
    }

    public function scopeEleitor($query, $eleitor_id)
    {
        return  $query->whereUserId($eleitor_id);
    }
}
