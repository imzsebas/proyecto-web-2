<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CitasController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\EnlaceSesionController;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/pricing', function () {
    return view('pricing');
})->name('pricing');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/dashboard_p', function () {
    return view('dashboard_p');
})->name('dashboard_p');

// Rutas del chat (requieren autenticación)
Route::middleware('auth')->group(function () {
    Route::post('/chat/send', [ChatController::class, 'sendMessage']);
    Route::get('/chat/messages', [ChatController::class, 'getMessages']);
    Route::get('/chat/conversation', [ChatController::class, 'getUserConversation']);
    
    // RUTAS CORREGIDAS PARA EL CHAT MÚLTIPLE
    Route::get('/chat/conversations', [ChatController::class, 'getConversations']); // ← Nueva ruta
    Route::post('/chat/mark-read/{conversationId}', [ChatController::class, 'markAsRead']); // ← Nueva ruta
    Route::get('/chat/check-new-messages/{conversationId}', [ChatController::class, 'checkNewMessages']); // ← Nueva ruta
    Route::delete('/chat/clear/{conversationId}', [ChatController::class, 'clearConversation']);
});

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas para usuarios autenticados
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->role === 'psicologo') {
            return view('dashboard_p');
        }
        return view('dashboard');
    })->name('dashboard');
});

// Rutas de registro
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Rutas de administración (requieren rol admin)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/users', [AdminController::class, 'store']);
    Route::get('/users/{id}', [AdminController::class, 'show']);
    Route::post('/users/{id}', [AdminController::class, 'update']);
    Route::delete('/users/{id}', [AdminController::class, 'destroy']);
    Route::patch('/users/{id}/role', [AdminController::class, 'changeRole']);
});

// Rutas para el sistema de citas
Route::resource('citas', CitasController::class);

// Rutas adicionales para funcionalidades específicas
Route::post('/citas/{cita}/confirmar', [CitasController::class, 'confirmar'])->name('citas.confirmar');
Route::post('/citas/{cita}/completar', [CitasController::class, 'completar'])->name('citas.completar');
Route::get('/citas/calendario', [CitasController::class, 'calendario'])->name('citas.calendario');

Route::get('/citas/{cita}/edit-data', [CitasController::class, 'editData'])->name('citas.edit-data');

Route::middleware(['auth'])->group(function () {
    Route::get('/api/patients', [App\Http\Controllers\PatientsController::class, 'index']);
    Route::post('/api/patients/notes', [App\Http\Controllers\PatientsController::class, 'storeNote']);
    Route::post('/api/patients/reports', [App\Http\Controllers\PatientsController::class, 'storeReport']);
    Route::get('/api/patients/{id}', [App\Http\Controllers\PatientsController::class, 'getPatientDetails']);
    Route::get('/api/patients/{id}/notes', [App\Http\Controllers\PatientsController::class, 'getPatientNotes']);
    Route::get('/api/patients/{id}/reports', [App\Http\Controllers\PatientsController::class, 'getPatientReports']);
    Route::delete('/api/patients/notes/{id}', [App\Http\Controllers\PatientsController::class, 'deleteNote']);
    Route::delete('/api/patients/reports/{id}', [App\Http\Controllers\PatientsController::class, 'deleteReport']);
});

Route::get('/reportes', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reportes/paciente/{patient}', [ReportController::class, 'viewPatientReports'])->name('reports.patient');
Route::get('/reportes/descargar/{patient}', [ReportController::class, 'downloadPatientReports'])->name('reports.download');

// Rutas para manejar enlaces de sesión
Route::get('/api/enlace-sesion/activo', [EnlaceSesionController::class, 'obtenerEnlaceActivo']);
Route::post('/api/enlace-sesion/guardar', [EnlaceSesionController::class, 'guardarEnlace']);
Route::get('/api/enlace-sesion/historial', [EnlaceSesionController::class, 'historial']);

Route::get('/test-db', function() {
    try {
        DB::connection()->getPdo();
        
        $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table'");
        $usersCount = DB::table('users')->count();
        $usersList = DB::table('users')->get(); // Añade esta línea
        $conversations = DB::table('conversations')->count();
        $messages = DB::table('messages')->count();
        
        return response()->json([
            'status' => 'SUCCESS',
            'tables' => array_map(fn($t) => $t->name, $tables),
            'counts' => [
                'users' => $usersCount, 
                'conversations' => $conversations, 
                'messages' => $messages
            ],
            'users_list' => $usersList // Añade esta línea
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'ERROR',
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});

Route::get('/debug-db', function() {
    try {
        $pdo = DB::connection()->getPdo();
        $dbPath = config('database.connections.sqlite.database');
        
        return response()->json([
            'status' => 'OK',
            'database_path' => $dbPath,
            'database_exists' => file_exists($dbPath),
            'database_writable' => is_writable(dirname($dbPath)),
            'users_table_exists' => Schema::hasTable('users'),
            'users_count' => DB::table('users')->count(),
            'connection_name' => DB::connection()->getName()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'ERROR',
            'error' => $e->getMessage()
        ], 500);
    }
});

Route::post('/debug-register', function(Request $request) {
    return response()->json([
        'received_data' => $request->all(),
        'headers' => $request->headers->all(),
        'content_type' => $request->header('Content-Type'),
        'csrf_token' => csrf_token(),
        'session_id' => session()->getId()
    ]);
});