<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        // Validación de los datos
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'occupation' => 'nullable|string|max:50',
            'age' => 'required|integer|min:18|max:99',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        // Crear el usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'occupation' => $request->occupation,
            'age' => $request->age,
            'password' => Hash::make($request->password),
        ]);

        // Autenticar al usuario
        Auth::login($user);

        return response()->json([
            'status' => 'success',
            'message' => '¡Registro exitoso!',
            'redirect' => route('home')
        ]);
    }
}