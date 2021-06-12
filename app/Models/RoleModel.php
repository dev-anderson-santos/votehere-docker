<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 
        'display_name'
    ];

    public const ADMINISTRADOR = 1;
    public const ELEITOR = 2;
    public const CANDIDATO = 3;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
