<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contacto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'apellidos',
        'telefono1',
        'telefono2',
        'cliente_id',
        'email',
        'observaciones',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function eventos()
    {
        return $this->hasMany(Evento::class);
    }
}
