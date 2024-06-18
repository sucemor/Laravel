<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Importar SoftDeletes

class Evento extends Model
{
    use HasFactory, SoftDeletes; // Usar SoftDeletes

    protected $fillable = [
        'tipo',
        'titulo',
        'estado',
        'fecha_fin',
        'fecha_aviso',
        'descripcion',
        'cliente_id',
        'user_id', // Añadir el campo user_id
    ];

    protected $casts = [
        'fecha_fin' => 'datetime',
        'fecha_aviso' => 'datetime',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
