<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoModel extends Model
{
    use HasFactory;

    protected $table = 'tipos';
    protected $primary = 'id';
    protected $fillable = ['nome'];
}
