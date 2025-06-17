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


// ========================================================================

Route::get('/database-viewer', function() {
    try {
        // Verificar conexión
        DB::connection()->getPdo();
        
        // Obtener todas las tablas
        $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table'");
        $databaseData = [];
        
        foreach ($tables as $table) {
            $tableName = $table->name;
            
            // Obtener estructura de la tabla
            $columns = DB::select("PRAGMA table_info({$tableName})");
            
            // Obtener todos los registros
            $records = DB::table($tableName)->get();
            
            $databaseData[$tableName] = [
                'columns' => $columns,
                'records' => $records,
                'count' => count($records)
            ];
        }
        
        // Generar HTML
        $html = '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="csrf-token" content="' . csrf_token() . '">
            <title>Database Viewer</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                    background-color: #f5f5f5;
                }
                .container {
                    max-width: 1200px;
                    margin: 0 auto;
                }
                h1 {
                    color: #333;
                    text-align: center;
                    margin-bottom: 30px;
                }
                .table-section {
                    background: white;
                    margin-bottom: 30px;
                    border-radius: 8px;
                    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                    overflow: hidden;
                }
                .table-header {
                    background: #4CAF50;
                    color: white;
                    padding: 15px 20px;
                    font-size: 18px;
                    font-weight: bold;
                }
                .table-info {
                    padding: 10px 20px;
                    background: #f8f9fa;
                    border-bottom: 1px solid #dee2e6;
                    font-size: 14px;
                    color: #666;
                }
                .data-table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 0;
                }
                .data-table th {
                    background: #f8f9fa;
                    padding: 12px 8px;
                    text-align: left;
                    border-bottom: 2px solid #dee2e6;
                    font-weight: 600;
                    color: #495057;
                    font-size: 13px;
                }
                .data-table td {
                    padding: 10px 8px;
                    border-bottom: 1px solid #dee2e6;
                    font-size: 13px;
                    vertical-align: top;
                }
                .data-table tr:hover {
                    background-color: #f8f9fa;
                }
                .no-data {
                    text-align: center;
                    padding: 40px;
                    color: #666;
                    font-style: italic;
                }
                .summary {
                    background: #e3f2fd;
                    padding: 20px;
                    border-radius: 8px;
                    margin-bottom: 20px;
                }
                .summary h2 {
                    margin: 0 0 10px 0;
                    color: #1976d2;
                }
                .summary-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                    gap: 10px;
                    margin-top: 15px;
                }
                .summary-item {
                    background: white;
                    padding: 10px;
                    border-radius: 4px;
                    text-align: center;
                }
                .long-text {
                    max-width: 200px;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                }
                .null-value {
                    color: #999;
                    font-style: italic;
                }
                .json-value {
                    font-family: monospace;
                    background: #f1f3f4;
                    padding: 2px 4px;
                    border-radius: 3px;
                    font-size: 12px;
                }
                .delete-btn {
                    background: #dc3545;
                    color: white;
                    border: none;
                    padding: 5px 10px;
                    border-radius: 4px;
                    cursor: pointer;
                    font-size: 12px;
                    transition: background 0.3s;
                }
                .delete-btn:hover {
                    background: #c82333;
                }
                .actions-column {
                    width: 80px;
                    text-align: center;
                }
                .modal {
                    display: none;
                    position: fixed;
                    z-index: 1000;
                    left: 0;
                    top: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(0,0,0,0.5);
                }
                .modal-content {
                    background-color: white;
                    margin: 15% auto;
                    padding: 20px;
                    border-radius: 8px;
                    width: 400px;
                    text-align: center;
                }
                .modal-buttons {
                    margin-top: 20px;
                }
                .modal-btn {
                    margin: 0 10px;
                    padding: 10px 20px;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                    font-size: 14px;
                }
                .confirm-btn {
                    background: #dc3545;
                    color: white;
                }
                .cancel-btn {
                    background: #6c757d;
                    color: white;
                }
                .loading {
                    opacity: 0.6;
                    pointer-events: none;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>🗄️ Database Viewer</h1>
                
                <div class="summary">
                    <h2>Resumen de la Base de Datos</h2>
                    <div class="summary-grid">';
        
        foreach ($databaseData as $tableName => $data) {
            $html .= "
                        <div class=\"summary-item\">
                            <strong>{$tableName}</strong><br>
                            {$data['count']} registros
                        </div>";
        }
        
        $html .= '
                    </div>
                </div>';
        
        foreach ($databaseData as $tableName => $data) {
            $html .= "
                <div class=\"table-section\">
                    <div class=\"table-header\">
                        📋 Tabla: {$tableName}
                    </div>
                    <div class=\"table-info\">
                        Total de registros: <strong>{$data['count']}</strong> | 
                        Columnas: <strong>" . count($data['columns']) . "</strong>
                    </div>";
            
            if ($data['count'] > 0) {
                $html .= "<table class=\"data-table\"><thead><tr>";
                
                // Headers
                foreach ($data['columns'] as $column) {
                    $html .= "<th>{$column->name}<br><small>({$column->type})</small></th>";
                }
                $html .= "<th class=\"actions-column\">Acciones</th>";
                $html .= "</tr></thead><tbody>";
                
                // Data rows
                foreach ($data['records'] as $index => $record) {
                    $html .= "<tr id=\"row-{$tableName}-{$index}\">";
                    
                    // Encontrar la columna de ID (primary key)
                    $primaryKey = null;
                    $primaryKeyValue = null;
                    foreach ($data['columns'] as $column) {
                        if ($column->pk == 1) { // Es primary key
                            $primaryKey = $column->name;
                            $primaryKeyValue = $record->{$column->name};
                            break;
                        }
                    }
                    
                    foreach ($data['columns'] as $column) {
                        $value = $record->{$column->name} ?? null;
                        
                        if ($value === null) {
                            $html .= "<td><span class=\"null-value\">NULL</span></td>";
                        } elseif (is_string($value) && (strlen($value) > 50)) {
                            $html .= "<td><div class=\"long-text\" title=\"" . htmlspecialchars($value) . "\">" . htmlspecialchars(substr($value, 0, 50)) . "...</div></td>";
                        } elseif (is_string($value) && (json_decode($value) !== null)) {
                            $html .= "<td><span class=\"json-value\">" . htmlspecialchars($value) . "</span></td>";
                        } else {
                            $html .= "<td>" . htmlspecialchars($value) . "</td>";
                        }
                    }
                    
                    // Botón de eliminar
                    if ($primaryKey && $primaryKeyValue) {
                        $html .= "<td class=\"actions-column\">
                            <button class=\"delete-btn\" onclick=\"confirmDelete('{$tableName}', '{$primaryKey}', '{$primaryKeyValue}', 'row-{$tableName}-{$index}')\">
                                🗑️ Eliminar
                            </button>
                        </td>";
                    } else {
                        $html .= "<td class=\"actions-column\">N/A</td>";
                    }
                    
                    $html .= "</tr>";
                }
                
                $html .= "</tbody></table>";
            } else {
                $html .= "<div class=\"no-data\">No hay registros en esta tabla</div>";
            }
            
            $html .= "</div>";
        }
        
        $html .= '
            </div>
            
            <!-- Modal de confirmación -->
            <div id="deleteModal" class="modal">
                <div class="modal-content">
                    <h3>⚠️ Confirmar eliminación</h3>
                    <p id="deleteMessage">¿Estás seguro de que quieres eliminar este registro?</p>
                    <div class="modal-buttons">
                        <button class="modal-btn cancel-btn" onclick="closeModal()">Cancelar</button>
                        <button class="modal-btn confirm-btn" onclick="executeDelete()">Eliminar</button>
                    </div>
                </div>
            </div>
            
            <script>
                let deleteData = {};
                
                function confirmDelete(table, primaryKey, primaryValue, rowId) {
                    deleteData = {
                        table: table,
                        primaryKey: primaryKey,
                        primaryValue: primaryValue,
                        rowId: rowId
                    };
                    
                    document.getElementById("deleteMessage").innerText = 
                        `¿Estás seguro de que quieres eliminar el registro con ${primaryKey} = ${primaryValue} de la tabla ${table}?`;
                    document.getElementById("deleteModal").style.display = "block";
                }
                
                function closeModal() {
                    document.getElementById("deleteModal").style.display = "none";
                    deleteData = {};
                }
                
                function executeDelete() {
                    const modal = document.getElementById("deleteModal");
                    const row = document.getElementById(deleteData.rowId);
                    
                    // Mostrar loading
                    row.classList.add("loading");
                    modal.style.display = "none";
                    
                    // Hacer la petición DELETE
                    fetch("/delete-record", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector(\'meta[name="csrf-token"]\')?.getAttribute("content") || ""
                        },
                        body: JSON.stringify({
                            table: deleteData.table,
                            primaryKey: deleteData.primaryKey,
                            primaryValue: deleteData.primaryValue
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Eliminar la fila de la tabla
                            row.remove();
                            alert("Registro eliminado exitosamente");
                            
                            // Actualizar contador
                            location.reload();
                        } else {
                            alert("Error al eliminar: " + data.message);
                            row.classList.remove("loading");
                        }
                    })
                    .catch(error => {
                        alert("Error: " + error.message);
                        row.classList.remove("loading");
                    });
                }
                
                // Cerrar modal al hacer clic fuera
                window.onclick = function(event) {
                    const modal = document.getElementById("deleteModal");
                    if (event.target === modal) {
                        closeModal();
                    }
                }
            </script>
        </body>
        </html>';
        
        return response($html);
        
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'ERROR',
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});



// Ruta para eliminar registros
Route::post('/delete-record', function(Request $request) {
    try {
        $table = $request->input('table');
        $primaryKey = $request->input('primaryKey');
        $primaryValue = $request->input('primaryValue');
        
        // Validar que los datos están presentes
        if (!$table || !$primaryKey || !$primaryValue) {
            return response()->json([
                'success' => false,
                'message' => 'Datos incompletos'
            ], 400);
        }
        
        // Lista de tablas permitidas (por seguridad)
        $allowedTables = DB::select("SELECT name FROM sqlite_master WHERE type='table'");
        $allowedTableNames = array_map(fn($t) => $t->name, $allowedTables);
        
        if (!in_array($table, $allowedTableNames)) {
            return response()->json([
                'success' => false,
                'message' => 'Tabla no válida'
            ], 400);
        }
        
        // Ejecutar la eliminación
        $deleted = DB::table($table)
            ->where($primaryKey, $primaryValue)
            ->delete();
        
        if ($deleted > 0) {
            return response()->json([
                'success' => true,
                'message' => 'Registro eliminado exitosamente'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró el registro para eliminar'
            ], 404);
        }
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al eliminar: ' . $e->getMessage()
        ], 500);
    }
});