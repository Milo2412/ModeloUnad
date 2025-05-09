<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publicidad extends Model
{
    // Si tu tabla no se llama "publicidads", especifica el nombre real
    protected $table = 'publicidad';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'lobby_principal', 'lobby1', 'lobby2', 'lobby3', 'lobby4',
        'afichepublicidad1', 'afichepublicidad2', 'afichepublicidad3',
        'afichepublicidad4', 'afichepublicidad5', 'afichepublicidad6',
        'afichepublicidad7', 'afichepublicidad8', 'afichepublicidad9',
        'afichepublicidad10', 'afichepublicidad11', 'afichepublicidad12',
        'afichepared1', 'afichepared2', 'afichepared3',
        'afichepared4', 'afichepared5', 'afichepared6',
    ];
}
