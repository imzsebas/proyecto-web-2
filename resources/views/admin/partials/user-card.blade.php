<div class="col-md-6 col-lg-4 mb-3">
    <div class="card user-card h-100">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <h6 class="card-title mb-0">
                    <i class="fas fa-user me-2"></i>{{ $user->name }}
                </h6>
                @if($user->role === 'psicologo')
                    <span class="badge bg-info role-badge">Psicólogo</span>
                @elseif($user->role === 'paciente')
                    <span class="badge bg-success role-badge">Paciente</span>
                @elseif($user->role === 'admin')
                    <span class="badge bg-warning role-badge">Admin</span>
                @endif
            </div>
            
            <p class="card-text text-muted mb-1">
                <i class="fas fa-envelope me-2"></i>{{ $user->email }}
            </p>
            
            @if($user->phone)
                <p class="card-text text-muted mb-1">
                    <i class="fas fa-phone me-2"></i>{{ $user->phone }}
                </p>
            @endif
            
            @if($user->occupation)
                <p class="card-text text-muted mb-1">
                    <i class="fas fa-briefcase me-2"></i>{{ $user->occupation }}
                </p>
            @endif
            
            <p class="card-text text-muted mb-3">
                <i class="fas fa-birthday-cake me-2"></i>{{ $user->age }} años
            </p>
            
            <div class="btn-group w-100" role="group">
                <button class="btn btn-outline-primary btn-sm" onclick="editUser({{ $user->id }})" title="Editar">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-outline-warning btn-sm" onclick="changeRole({{ $user->id }}, '{{ $user->role }}')" title="Cambiar Rol">
                    <i class="fas fa-user-tag"></i>
                </button>
                @if(auth()->id() !== $user->id)
                    <button class="btn btn-outline-danger btn-sm" onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')" title="Eliminar">
                        <i class="fas fa-trash"></i>
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>