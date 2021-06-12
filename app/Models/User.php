<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar'
    ];

    protected $with = ['roleUser'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the roleUser associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function roleUser(): HasOne
    {
        return $this->hasOne(RoleUserModel::class, 'user_id', 'id');
    }

    public function candidato(): HasOne
    {
        return $this->hasOne(RoleUserModel::class, 'user_id', 'id')->whereRoleId(RoleModel::CANDIDATO);
    }

    /**
     * The roles that belong to the VotosModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function votos(): HasMany
    {
        return $this->hasMany(VotosModel::class, 'user_id', 'id');
    }

    public function scopeEmail($query, $email)
    {
        return $query->whereEmail($email);
    }
}
