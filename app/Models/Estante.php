<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; 

class Estante extends Model
{
    protected $fillable = [
        'user_id', 'instagram', 'facebook', 'whatsapp', 'logo_url', 'imagenes_productos_url'
    ];

    protected $casts = [
        'imagenes_productos_url' => 'array'
    ];

public function user()
{
    return $this->belongsTo(User::class, 'id_user');
}
}

