<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Importar SoftDeletes

class Cliente extends Model
{
    use HasFactory, SoftDeletes; // Usar SoftDeletes

    protected $fillable = [
        'nombre',
        'email',
        'telefono1',
        'telefono2',
        'tipo_empresa',
        'user_id',
        'web',
        'direccion',
        'ciudad',
        'provincia',
        'pais',
        'codigo_postal',
        'observaciones',
        'estado',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contactos()
    {
        return $this->hasMany(Contacto::class);
    }
}
