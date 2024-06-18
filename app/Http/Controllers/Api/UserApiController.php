<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserApiController extends Controller
{
    public function index()
    {
        $usuarios = User::withTrashed()->get();
        return response()->json($usuarios);
    }

    public function iniciarSesion(Request $request)
    {
        // Validar la solicitud de entrada
        $validated = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        // Buscar al usuario por el nombre
        $usuario = User::where('name', $validated['name'])->first();

        // Verificar que el usuario exista
        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        // Verificar la contraseña
        if (!\Hash::check($validated['password'], $usuario->password)) {
            return response()->json(['message' => 'Contraseña incorrecta'], 401);
        }

        // Generar el token de autenticación
        $token = $usuario->createToken('auth_token')->plainTextToken;

        // Devolver el token de autenticación
        return response()->json(['token' => $token, 'message' => 'Autenticación exitosa'], 200);
    }





    public function agregar(Request $request)
{
    try {
        // Validación de los datos de entrada
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'tipo' => 'required|string|max:50',
        ]);

        // Creación del usuario con los datos validados
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']), // Encriptar la contraseña
            'tipo' => $validated['tipo'],
        ]);

        // Devolver un mensaje de éxito
        return response()->json(['message' => 'Usuario agregado correctamente'], 201);
    } catch (ValidationException $e) {
        // Manejo de errores de validación
        return response()->json(['errors' => $e->errors()], 422);
    } catch (\Exception $e) {
        // Manejo de errores generales
        return response()->json(['error' => 'Ha ocurrido un error al agregar el usuario'], 500);
    }
}


    public function actualizar(Request $request, $id)
    {
        // Primero tengo que comprobar que exista para eso uso detalles
        if ( !$this->detalles($id)) {
            return response()->json("No existe el usuario", 404); // Devolver un código de estado 404
        }
        // Si existe pruebo a actualizar
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id,
                'password' => 'nullable|string|min:8|confirmed',
                'tipo' => 'required|string|max:50',
            ]);

            $usuario = User::withTrashed()->findOrFail($id);
            $usuario->update($validated);

            return response()->json(['message' => 'Usuario actualizado correctamente'], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ha ocurrido un error al actualizar el usuario'], 500);
        }
    }

    public function borrar($id)
    {
        // Recogo el usuario
        $usuario = User::withTrashed()->find($id);

        // Compruebo que exista
        if (!$usuario) {
            return response()->json("No existe el usuario", 404);
        }

        // Elimino el usuario
        $usuario->delete();

        // Devuelvo la respuesta de confirmación
        return response()->json(['message' => 'Usuario borrado correctamente'], 200);
    }

    public function logout(Request $request)
    {
        // Revocar el token actual
        $request->user()->currentAccessToken()->delete();

        // Responder con un mensaje de éxito
        return response()->json(['message' => 'Sesión cerrada correctamente'], 200);
    }

    public function restaurar($id)
    {
        $usuario = User::withTrashed()->find($id);

        if (!$usuario) {
            return response()->json("No existe el usuario", 404);
        }

        $usuario->restore();

        return response()->json(['message' => 'Usuario restaurado correctamente'], 200);
    }
}
