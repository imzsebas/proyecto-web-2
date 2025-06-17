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
        Log::info('Registro iniciado', ['data' => $request->except('password', 'password_confirmation')]);
        
        // Validación
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'occupation' => 'nullable|string|max:50',
            'age' => 'required|integer|min:18|max:99',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'email.unique' => 'Este correo ya está registrado',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ]);

        if ($validator->fails()) {
            Log::warning('Validación fallida', ['errors' => $validator->errors()]);
            return response()->json([
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Verificar conexión a base de datos
            DB::connection()->getPdo();
            Log::info('Conexión a BD exitosa');

            // Usar transacción para SQLite
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

            // Autenticar usuario
            Auth::login($user);

            return response()->json([
                'status' => 'success',
                'message' => '¡Registro exitoso!',
                'redirect' => route('dashboard')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en registro', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error interno del servidor: ' . $e->getMessage()
            ], 500);
        }
    }
}