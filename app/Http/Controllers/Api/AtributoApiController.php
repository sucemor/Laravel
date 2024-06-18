<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\Atributo;
use Illuminate\Support\Facades\DB; 

class AtributoApiController extends Controller
{
    /**
     * Añadir un nuevo atributo a una tabla y registrarlo en la tabla `atributos`.
     */
    public function store(Request $request)
    {
        try {
            // Validar la solicitud
            $request->validate([
                'tabla' => 'required|string', // Nombre de la tabla
                'atributo' => 'required|string', // Nombre del nuevo atributo
                'tipo' => 'required|string', // Tipo de dato del atributo
                'longitud' => 'nullable|integer', // Longitud del atributo (opcional para tipos como string)
                'sobrenombre' => 'nullable|string', // Sobrenombre del atributo (opcional)
            ]);

            $tabla = $request->input('tabla');
            $atributo = $request->input('atributo');
            $tipo = $request->input('tipo');
            $longitud = $request->input('longitud', 255); // Longitud del atributo (por defecto 255 para string)

            // Verificar si la tabla existe
            if (!Schema::hasTable($tabla)) {
                return response()->json(['error' => 'La tabla especificada no existe.'], 400);
            }

            // Verificar si el atributo ya existe en la tabla especificada
            if (Schema::hasColumn($tabla, $atributo)) {
                return response()->json(['error' => 'El atributo ya existe en la tabla especificada.'], 400);
            }

            // Verificar si el atributo ya existe en la tabla `atributos`
            if (Atributo::where('tabla', $tabla)->where('atributo', $atributo)->exists()) {
                return response()->json(['error' => 'El atributo ya existe en la tabla atributos.'], 400);
            }

            // Añadir el atributo a la tabla especificada
            Schema::table($tabla, function (Blueprint $table) use ($atributo, $tipo, $longitud) {
                if (!Schema::hasColumn($table->getTable(), $atributo)) {
                    switch ($tipo) {
                        case 'string':
                        case 'varchar':
                            $table->string($atributo, $longitud)->nullable();
                            break;
                        case 'integer':
                        case 'int':
                            $table->integer($atributo)->nullable();
                            break;
                        case 'text':
                            $table->text($atributo)->nullable();
                            break;
                        case 'boolean':
                        case 'bool':
                            $table->boolean($atributo)->nullable();
                            break;
                        case 'date':
                            $table->date($atributo)->nullable();
                            break;
                        case 'datetime':
                            $table->dateTime($atributo)->nullable();
                            break;
                        default:
                            throw new \Exception("Tipo de dato no soportado: $tipo");
                    }
                }
            });

            // Guardar el atributo en la tabla `atributos`
            Atributo::create([
                'tabla' => $tabla,
                'atributo' => $atributo,
                'sobrenombre' => $request->input('sobrenombre'),
            ]);

            return response()->json(['message' => 'Atributo agregar adecuadamente.'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Hubo un error al agregar el atributo: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Eliminar un atributo de una tabla y de la tabla `atributos`.
     */
    public function destroy(Request $request)
    {
        try {
            // Validar la solicitud
            $request->validate([
                'tabla' => 'required|string', // Nombre de la tabla
                'atributo' => 'required|string', // Nombre del atributo a eliminar
            ]);

            $tabla = $request->input('tabla');
            $atributo = $request->input('atributo');

            // Lista de atributos protegidos
            $protectedAttributes = ['id', 'nombre', 'created_at', 'updated_at', 'deleted_at'];
            if (in_array($atributo, $protectedAttributes) || str_contains($atributo, 'id')) {
                return response()->json(['error' => 'El atributo especificado no puede ser eliminado.'], 403);
            }

            // Verificar si la tabla y el atributo existen
            if (!Schema::hasTable($tabla) || !Schema::hasColumn($tabla, $atributo)) {
                return response()->json(['error' => 'La tabla o el atributo especificado no existe.'], 400);
            }

            // Eliminar el atributo de la tabla especificada
            Schema::table($tabla, function (Blueprint $table) use ($atributo) {
                $table->dropColumn($atributo);
            });

            // Eliminar el atributo de la tabla `atributos`
            Atributo::where('tabla', $tabla)->where('atributo', $atributo)->delete();

            return response()->json(['message' => 'Atributo eliminado adecuadamente.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Hubo un error al eliminar el atributo: ' . $e->getMessage()], 500);
        }
    }

    /**
 * Obtener todos los datos de una tabla específica.
 */
public function datosDeUnaTabla(Request $request)
{
    try {
        // Validar la solicitud
        $request->validate([
            'tabla' => 'required|string', // Nombre de la tabla
        ]);

        $tabla = $request->input('tabla');

        // Verificar si la tabla existe
        if (!Schema::hasTable($tabla)) {
            return response()->json(['error' => 'La tabla especificada no existe.'], 400);
        }

        // Obtener los datos de la tabla `atributos` donde `tabla` coincida con el valor dado
        $data = Atributo::where('tabla', $tabla)->get();

        return response()->json($data, 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Hubo un error al obtener los datos de la tabla: ' . $e->getMessage()], 500);
    }
}


     /**
     * Editar el sobrenombre de un atributo específico.
     */
    public function update(Request $request)
    {
        try {
            // Validar la solicitud
            $request->validate([
                'tabla' => 'required|string', // Nombre de la tabla
                'atributo' => 'required|string', // Nombre del atributo a modificar
                'sobrenombre' => 'nullable|string', // Nuevo sobrenombre
            ]);

            $tabla = $request->input('tabla');
            $atributo = $request->input('atributo');
            $sobrenombre = $request->input('sobrenombre');

            // Verificar si el atributo existe en la tabla `atributos`
            $atributoRecord = Atributo::where('tabla', $tabla)->where('atributo', $atributo)->first();
            if (!$atributoRecord) {
                return response()->json(['error' => 'El atributo especificado no existe.'], 400);
            }

            // Actualizar el sobrenombre
            $atributoRecord->sobrenombre = $sobrenombre;
            $atributoRecord->save();

            return response()->json(['message' => 'Sobrenombre actualizado adecuadamente.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Hubo un error al actualizar el sobrenombre: ' . $e->getMessage()], 500);
        }
    }

     /**
     * Sincronizar atributos de las tablas especificadas con la tabla `atributos`.
     */
    public function syncAttributes()
    {
        try {
            Atributo::syncAttributes();
            return response()->json(['message' => 'Atributos sincronizados adecuadamente.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Hubo un error al sincronizar los atributos: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Obtener todos los atributos con su tipo, nombre y sobrenombre.
     */
    public function index()
    {
        try {
            // Obtener todos los registros de la tabla `atributos`
            $atributos = Atributo::all();

            return response()->json($atributos, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Hubo un error al obtener los atributos: ' . $e->getMessage()], 500);
        }
    }
}
