<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log; // ← AGREGAR ESTA LÍNEA
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    // Función helper para verificar si el usuario es admin
    private function checkAdminAccess()
    {
        if (!auth()->user() || auth()->user()->role !== 'admin') {
            // Para peticiones AJAX, devolver JSON en lugar de redirect
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Acceso denegado'
                ], 403);
            }
            return redirect()->route('home')->with('error', 'Acceso denegado');
        }
        return null;
    }

    public function dashboard()
    {
        // Verificar acceso de admin
        $accessCheck = $this->checkAdminAccess();
        if ($accessCheck) return $accessCheck;
        
        $psychologists = User::where('role', 'psicologo')->orderBy('name')->get();
        $patients = User::where('role', 'paciente')->orderBy('name')->get();
        $admins = User::where('role', 'admin')->orderBy('name')->get();
        
        return view('admin.dashboard', compact('psychologists', 'patients', 'admins'));
    }

    public function store(Request $request)
    {
        try {
            Log::info('AdminController store called', $request->all());

            // Verificar acceso de admin
            $accessCheck = $this->checkAdminAccess();
            if ($accessCheck) return $accessCheck;
            
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|string|max:20',
                'occupation' => 'nullable|string|max:255', // Cambiado de 50 a 255
                'age' => 'required|integer|min:18|max:99',
                'role' => 'required|in:paciente,psicologo,admin',
                'password' => 'required|string|min:8',
            ]);

            if ($validator->fails()) {
                Log::error('Validation failed', $validator->errors()->toArray());
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error de validación',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'occupation' => $request->occupation,
                'age' => $request->age,
                'role' => $request->role,
                'password' => Hash::make($request->password),
            ]);

            Log::info('User created successfully', ['user_id' => $user->id]);

            return response()->json([
                'status' => 'success',
                'message' => 'Usuario creado exitosamente',
                'user' => $user
            ]);

        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error interno del servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            // Verificar acceso de admin
            $accessCheck = $this->checkAdminAccess();
            if ($accessCheck) return $accessCheck;
            
            $user = User::findOrFail($id);
            return response()->json($user);
        } catch (\Exception $e) {
            Log::error('Error fetching user: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Usuario no encontrado'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Verificar acceso de admin
            $accessCheck = $this->checkAdminAccess();
            if ($accessCheck) return $accessCheck;
            
            $user = User::findOrFail($id);
            
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'phone' => 'required|string|max:20',
                'occupation' => 'nullable|string|max:255',
                'age' => 'required|integer|min:18|max:99',
                'role' => 'required|in:paciente,psicologo,admin',
                'password' => 'nullable|string|min:8',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error de validación',
                    'errors' => $validator->errors()
                ], 422);
            }

            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'occupation' => $request->occupation,
                'age' => $request->age,
                'role' => $request->role,
            ];

            if ($request->password) {
                $updateData['password'] = Hash::make($request->password);
            }

            $user->update($updateData);

            return response()->json([
                'status' => 'success',
                'message' => 'Usuario actualizado exitosamente',
                'user' => $user
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            // Verificar acceso de admin
            $accessCheck = $this->checkAdminAccess();
            if ($accessCheck) return $accessCheck;
            
            $user = User::findOrFail($id);
            
            // Evitar que el admin se elimine a sí mismo
            if ($user->id === auth()->id()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No puedes eliminar tu propia cuenta'
                ], 422);
            }

            $user->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Usuario eliminado exitosamente'
            ]);

        } catch (\Exception $e) {
            Log::error('Error deleting user: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error al eliminar usuario'
            ], 500);
        }
    }

    public function changeRole(Request $request, $id)
    {
        try {
            // Verificar acceso de admin
            $accessCheck = $this->checkAdminAccess();
            if ($accessCheck) return $accessCheck;
            
            $user = User::findOrFail($id);
            
            $validator = Validator::make($request->all(), [
                'role' => 'required|in:paciente,psicologo,admin',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Rol inválido'
                ], 422);
            }

            // Evitar que el admin cambie su propio rol
            if ($user->id === auth()->id()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No puedes cambiar tu propio rol'
                ], 422);
            }

            $user->update(['role' => $request->role]);

            return response()->json([
                'status' => 'success',
                'message' => 'Rol actualizado exitosamente',
                'user' => $user
            ]);

        } catch (\Exception $e) {
            Log::error('Error changing role: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error al cambiar rol'
            ], 500);
        }
    }
}