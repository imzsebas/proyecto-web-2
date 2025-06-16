<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .user-card {
            transition: transform 0.2s;
        }
        .user-card:hover {
            transform: translateY(-2px);
        }
        .role-badge {
            font-size: 0.85em;
        }
        .section-header {
            border-left: 4px solid #007bff;
            padding-left: 15px;
            margin: 30px 0 20px 0;
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-user-shield me-2"></i>Panel Admin
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    Bienvenido, {{ auth()->user()->name }}
                </span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-sign-out-alt"></i> Salir
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1><i class="fas fa-users-cog me-2"></i>Gestión de Usuarios</h1>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="fas fa-plus me-2"></i>Agregar Usuario
                    </button>
                </div>

                <!-- Estadísticas -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h5><i class="fas fa-user-md"></i> Psicólogos</h5>
                                <h3>{{ $psychologists->count() }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5><i class="fas fa-users"></i> Pacientes</h5>
                                <h3>{{ $patients->count() }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <h5><i class="fas fa-user-shield"></i> Admins</h5>
                                <h3>{{ $admins->count() }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5><i class="fas fa-users-cog"></i> Total</h5>
                                <h3>{{ $psychologists->count() + $patients->count() + $admins->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Psicólogos -->
                <div class="section-header">
                    <h3><i class="fas fa-user-md text-info me-2"></i>Psicólogos</h3>
                </div>
                <div class="row" id="psychologists-section">
                    @forelse($psychologists as $user)
                        @include('admin.partials.user-card', ['user' => $user])
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>No hay psicólogos registrados
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pacientes -->
                <div class="section-header">
                    <h3><i class="fas fa-users text-success me-2"></i>Pacientes</h3>
                </div>
                <div class="row" id="patients-section">
                    @forelse($patients as $user)
                        @include('admin.partials.user-card', ['user' => $user])
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>No hay pacientes registrados
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Administradores -->
                <div class="section-header">
                    <h3><i class="fas fa-user-shield text-warning me-2"></i>Administradores</h3>
                </div>
                <div class="row" id="admins-section">
                    @forelse($admins as $user)
                        @include('admin.partials.user-card', ['user' => $user])
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>No hay otros administradores
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Modales -->
    @include('admin.partials.add-user-modal')
    @include('admin.partials.edit-user-modal')

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
            // Configurar CSRF token para fetch
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Función para mostrar alertas
        function showAlert(type, title, message) {
            Swal.fire({
                icon: type,
                title: title,
                text: message,
                timer: 3000,
                showConfirmButton: false
            });
        }

        // Función para recargar la página inmediatamente
        function reloadPage() {
            location.reload();
        }

        // FUNCIÓN GLOBAL - Editar usuario
        window.editUser = function(id) {
            fetch(`/admin/users/${id}`, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(user => {
                // Llenar formulario de edición
                document.getElementById('editUserId').value = user.id;
                document.getElementById('editName').value = user.name;
                document.getElementById('editEmail').value = user.email;
                document.getElementById('editPhone').value = user.phone;
                document.getElementById('editOccupation').value = user.occupation || '';
                document.getElementById('editAge').value = user.age;
                document.getElementById('editRole').value = user.role;
                
                // Mostrar modal
                const modal = new bootstrap.Modal(document.getElementById('editUserModal'));
                modal.show();
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('error', 'Error', 'No se pudo cargar la información del usuario');
            });
        };

        // FUNCIÓN GLOBAL - Eliminar usuario
        window.deleteUser = function(id, name) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: `Se eliminará permanentemente el usuario: ${name}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/users/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.status === 'success') {
                            showAlert('success', '¡Eliminado!', data.message);
                            setTimeout(() => {
                                reloadPage();
                            }, 1000);
                        } else {
                            showAlert('error', 'Error', data.message || 'Error al eliminar usuario');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('error', 'Error', 'Ocurrió un error inesperado: ' + error.message);
                    });
                }
            });
        };

        // FUNCIÓN GLOBAL - Cambiar rol
        window.changeRole = function(id, currentRole) {
            const roles = {
                'paciente': 'Paciente',
                'psicologo': 'Psicólogo',
                'admin': 'Administrador'
            };
            
            Swal.fire({
                title: 'Cambiar Rol',
                input: 'select',
                inputOptions: roles,
                inputValue: currentRole,
                showCancelButton: true,
                confirmButtonText: 'Cambiar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed && result.value !== currentRole) {
                    // Usar FormData con _method para compatibilidad con Laravel
                    const formData = new FormData();
                    formData.append('role', result.value);
                    formData.append('_method', 'PATCH');
                    
                    fetch(`/admin/users/${id}/role`, {
                        method: 'POST', // Laravel usa POST con _method para PATCH
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.status === 'success') {
                            showAlert('success', '¡Éxito!', data.message);
                            setTimeout(() => {
                                reloadPage();
                            }, 1000);
                        } else {
                            showAlert('error', 'Error', data.message || 'Error al cambiar rol');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('error', 'Error', 'Ocurrió un error inesperado: ' + error.message);
                    });
                }
            });
        };

        // Esperar a que el DOM esté completamente cargado
        document.addEventListener('DOMContentLoaded', function() {
            
            // Agregar usuario
            const addUserForm = document.getElementById('addUserForm');
            if (addUserForm) {
                addUserForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    const submitBtn = document.getElementById('addUserSubmit');
                    
                    // Deshabilitar botón
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creando...';
                    
                    fetch('/admin/users', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Respuesta del servidor:', data);
                        
                        if (data.status === 'success') {
                            // Cerrar modal
                            const modal = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
                            modal.hide();
                            
                            // Limpiar formulario
                            addUserForm.reset();
                            
                            // Mostrar mensaje de éxito
                            showAlert('success', '¡Éxito!', data.message);
                            
                            // Recargar página después de mostrar el mensaje
                            setTimeout(() => {
                                reloadPage();
                            }, 1000);
                            
                        } else {
                            showAlert('error', 'Error', data.message || 'Error al crear usuario');
                            console.error('Error del servidor:', data);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('error', 'Error', 'Ocurrió un error inesperado: ' + error.message);
                    })
                    .finally(() => {
                        // Rehabilitar botón
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="fas fa-plus me-2"></i>Crear Usuario';
                    });
                });
            }

            // Actualizar usuario
            const editUserForm = document.getElementById('editUserForm');
            if (editUserForm) {
                editUserForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    formData.append('_method', 'PUT'); // Agregar método PUT
                    const userId = document.getElementById('editUserId').value;
                    const submitBtn = document.getElementById('editUserSubmit');
                    
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Actualizando...';
                    
                    fetch(`/admin/users/${userId}`, {
                        method: 'POST', // Laravel usa POST con _method para PUT
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Respuesta del servidor:', data);
                        
                        if (data.status === 'success') {
                            // Cerrar modal
                            const modal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
                            modal.hide();
                            
                            showAlert('success', '¡Éxito!', data.message);
                            
                            setTimeout(() => {
                                reloadPage();
                            }, 1000);
                        } else {
                            showAlert('error', 'Error', data.message || 'Error al actualizar usuario');
                            console.error('Error del servidor:', data);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('error', 'Error', 'Ocurrió un error inesperado: ' + error.message);
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Actualizar';
                    });
                });
            }
        });

        // Log para debugging
        console.log('Dashboard JavaScript loaded');
        console.log('Functions available:', {
            editUser: typeof window.editUser,
            deleteUser: typeof window.deleteUser,
            changeRole: typeof window.changeRole
        });
    </script>
</body>
</html>