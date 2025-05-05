<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estante extends Model
{
    protected $fillable = [
        'user_id', 'instagram', 'facebook', 'whatsapp', 'logo_url', 'imagenes_productos_url'
    ];

    protected $casts = [
        'imagenes_productos_url' => 'array'
    ];
}

