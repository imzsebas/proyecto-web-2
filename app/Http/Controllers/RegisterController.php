<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        // Log para ver qué datos llegan
        Log::info('Datos recibidos en registro:', [
            'all_data' => $request->all(),
            'headers' => $request->headers->all(),
            'content_type' => $request->header('Content-Type')
        ]);

        // Validación con mensajes específicos
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'occupation' => 'nullable|string|max:50',
            'age' => 'required|integer|min:18|max:99',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|string|min:8|same:password',
        ], [
            'name.required' => 'El nombre es requerido',
            'email.required' => 'El correo es requerido',
            'email.email' => 'El correo debe ser válido',
            'email.unique' => 'Este correo ya está registrado',
            'phone.required' => 'El teléfono es requerido',
            'age.required' => 'La edad es requerida',
            'age.integer' => 'La edad debe ser un número',
            'age.min' => 'Debes ser mayor de 18 años',
            'age.max' => 'La edad no puede ser mayor a 99',
            'password.required' => 'La contraseña es requerida',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password_confirmation.required' => 'Debes confirmar la contraseña',
            'password_confirmation.same' => 'Las contraseñas no coinciden',
        ]);

        if ($validator->fails()) {
            Log::warning('Validación fallida:', [
                'errors' => $validator->errors()->toArray(),
                'data' => $request->except(['password', 'password_confirmation'])
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => $validator->errors()->toArray(),
                'first_error' => $validator->errors()->first()
            ], 422);
        }

        try {
            // Verificar conexión a BD
            DB::connection()->getPdo();
            Log::info('Conexión a BD exitosa');

            // Crear usuario
            DB::beginTransaction();
            
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'occupation' => $request->occupation,
                'age' => $request->age,
                'role' => 'paciente',
                'password' => Hash::make($request->password),
            ]);

            DB::commit();
            Log::info('Usuario creado exitosamente', ['user_id' => $user->id]);

            // Autenticar
            Auth::login($user);

            return response()->json([
                'status' => 'success',
                'message' => '¡Registro exitoso!',
                'redirect' => route('dashboard')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en registro:', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error interno: ' . $e->getMessage()
            ], 500);
        }
    }
}