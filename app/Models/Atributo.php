<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Atributo extends Model
{
    use HasFactory;

    // Tabla asociada a este modelo
    protected $table = 'atributos';

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'tabla',
        'atributo',
        'sobrenombre',
    ];

    /**
     * Sincronizar atributos de las tablas especificadas con la tabla `atributos`.
     */
    public static function syncAttributes()
    {
        $tables = ['clientes','contactos','notas','nota_adjuntos','eventos']; // Añadir las tablas que deseas sincronizar

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                $columns = Schema::getColumnListing($table);
                
                foreach ($columns as $column) {
                    // Verificar si el atributo ya existe en la tabla `atributos`
                    if (!Atributo::where('tabla', $table)->where('atributo', $column)->exists()) {
                        Atributo::create([
                            'tabla' => $table,
                            'atributo' => $column,
                            'sobrenombre' => null,
                        ]);
                    }
                }
            }
        }
    }
}
