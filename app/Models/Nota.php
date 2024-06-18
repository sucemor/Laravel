<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nota extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['titulo', 'cuerpo', 'user_id', 'cliente_id']; // Incluir cliente_id

    public function adjuntos()
    {
        return $this->hasMany(NotaAdjunto::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}

