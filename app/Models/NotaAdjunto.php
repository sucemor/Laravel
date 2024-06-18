<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Importar SoftDeletes

class NotaAdjunto extends Model
{
    use HasFactory, SoftDeletes; // Usar SoftDeletes

    protected $fillable = ['nota_id', 'archivo'];

    public function nota()
    {
        return $this->belongsTo(Nota::class);
    }

    public function getArchivoUrlAttribute()
    {
        return asset('storage/' . $this->archivo);
    }
}
