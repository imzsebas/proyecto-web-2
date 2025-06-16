@extends('layouts.app')

@section('title', 'Gestión de Citas')

@section('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
<style>
    .cita-card {
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }
    .cita-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .estado-programada { border-left-color: #6c757d !important; }
    .estado-confirmada { border-left-color: #0dcaf0 !important; }
    .estado-completada { border-left-color: #198754 !important; }
    .estado-cancelada { border-left-color: #dc3545 !important; }
    
    .badge-estado {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
    
    #calendar {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        padding: 1rem;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">Gestión de Citas</h2>
                    <p class="text-muted mb-0">Administra tu agenda de consultas psicológicas</p>
                </div>
                <div>
                    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#nuevaCitaModal">
                        <i class="bi bi-plus-circle me-2"></i>Nueva Cita
                    </button>
                    <button class="btn btn-outline-secondary" id="toggleView">
                        <i class="bi bi-calendar3 me-2"></i>Vista Calendario
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $citasHoy }}</h4>
                            <p class="mb-0">Citas Hoy</p>
                        </div>
                        <i class="bi bi-calendar-day fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            @if($proximaCita)
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="mb-1">Próxima Cita</h5>
                            <p class="mb-0">
                                <strong>{{ $proximaCita->paciente }}</strong> - 
                                {{ $proximaCita->fecha->format('d/m/Y') }} a las {{ $proximaCita->hora->format('H:i') }}
                            </p>
                        </div>
                        <i class="bi bi-clock fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Vista Lista -->
    <div id="vistaLista">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Lista de Citas</h5>
            </div>
            <div class="card-body">
                @if($citas->count() > 0)
                    <div class="row">
                        @foreach($citas as $cita)
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="card cita-card estado-{{ $cita->estado }}">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="card-title mb-0">{{ $cita->paciente }}</h6>
                                        <span class="badge bg-{{ $cita->estado == 'programada' ? 'secondary' : ($cita->estado == 'confirmada' ? 'info' : ($cita->estado == 'completada' ? 'success' : 'danger')) }} badge-estado">
                                            {{ ucfirst($cita->estado) }}
                                        </span>
                                    </div>
                                    <p class="card-text text-muted small mb-2">
                                        <i class="bi bi-person me-1"></i>{{ $cita->psicologo }}
                                    </p>
                                    <p class="card-text mb-2">
                                        <i class="bi bi-calendar me-1"></i>{{ $cita->fecha->format('d/m/Y') }}<br>
                                        <i class="bi bi-clock me-1"></i>{{ $cita->hora->format('H:i') }} 
                                        <small class="text-muted">({{ $cita->duracion }} min)</small>
                                    </p>
                                    
                                    <div class="btn-group btn-group-sm w-100" role="group">
                                        @if($cita->estado == 'programada')
                                            <button class="btn btn-outline-info btn-confirmar" data-id="{{ $cita->id }}">
                                                <i class="bi bi-check"></i>
                                            </button>
                                        @endif
                                        @if($cita->estado == 'confirmada')
                                            <button class="btn btn-outline-success btn-completar" data-id="{{ $cita->id }}">
                                                <i class="bi bi-check-circle"></i>
                                            </button>
                                        @endif
                                        <button class="btn btn-outline-primary btn-editar" data-id="{{ $cita->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-outline-danger btn-eliminar" data-id="{{ $cita->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Paginación -->
                    <div class="d-flex justify-content-center">
                        {{ $citas->links() }}
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-calendar-x fs-1 text-muted"></i>
                        <p class="text-muted">No hay citas programadas</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevaCitaModal">
                            Crear Primera Cita
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Vista Calendario (inicialmente oculta) -->
    <div id="vistaCalendario" style="display: none;">
        <div id="calendar"></div>
    </div>

    <!-- Modal Nueva/Editar Cita -->
    @include('citas.modal')
</div>
@endsection

@section('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let calendar;
    let vistaActual = 'lista';
    
    // Inicializar calendario
    function initCalendar() {
        const calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: '/citas/calendario',
            eventClick: function(info) {
                // Mostrar detalles de la cita
                mostrarDetallesCita(info.event);
            },
            height: 'auto'
        });
    }

    // Toggle entre vista lista y calendario
    document.getElementById('toggleView').addEventListener('click', function() {
        const vistaLista = document.getElementById('vistaLista');
        const vistaCalendario = document.getElementById('vistaCalendario');
        const btn = this;
        
        if (vistaActual === 'lista') {
            vistaLista.style.display = 'none';
            vistaCalendario.style.display = 'block';
            btn.innerHTML = '<i class="bi bi-list me-2"></i>Vista Lista';
            vistaActual = 'calendario';
            
            if (!calendar) {
                initCalendar();
            }
            calendar.render();
        } else {
            vistaLista.style.display = 'block';
            vistaCalendario.style.display = 'none';
            btn.innerHTML = '<i class="bi bi-calendar3 me-2"></i>Vista Calendario';
            vistaActual = 'lista';
        }
    });

    // Confirmar cita
    document.querySelectorAll('.btn-confirmar').forEach(btn => {
        btn.addEventListener('click', function() {
            const citaId = this.dataset.id;
            confirmarCita(citaId);
        });
    });

    // Completar cita
    document.querySelectorAll('.btn-completar').forEach(btn => {
        btn.addEventListener('click', function() {
            const citaId = this.dataset.id;
            completarCita(citaId);
        });
    });

    // Eliminar cita
    document.querySelectorAll('.btn-eliminar').forEach(btn => {
        btn.addEventListener('click', function() {
            const citaId = this.dataset.id;
            if (confirm('¿Estás seguro de que quieres eliminar esta cita?')) {
                eliminarCita(citaId);
            }
        });
    });

    function confirmarCita(id) {
        fetch(`/citas/${id}/confirmar`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }

    function completarCita(id) {
        fetch(`/citas/${id}/completar`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }

    function eliminarCita(id) {
        fetch(`/citas/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (response.ok) {
                location.reload();
            }
        });
    }
});
</script>
@endsection