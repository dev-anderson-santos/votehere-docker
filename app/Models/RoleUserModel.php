<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoleUserModel extends Model
{
    use HasFactory;

    protected $table = 'role_users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'role_id', 
        'user_id', 
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo(RoleModel::class, 'role_id', 'id');
    }

    public function scopeUsuario($query, $usuario_id)
    {
        return  $query->whereUserId($usuario_id);
    }

    public function scopeCandidato($query)
    {
        return $query->whereRoleId(RoleModel::CANDIDATO);
    }

    public function scopeEleitores($query)
    {
        return $query->whereRoleId(2);
    }
}
