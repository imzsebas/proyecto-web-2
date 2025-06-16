<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content />
    <meta name="author" content />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ auth()->id() }}">
    <title>Psicólogo / MiRefugio</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body class="d-flex flex-column">
    <main class="flex-shrink-0">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container px-5">
                <a class="navbar-brand" href="{{ route('home') }}">{{ Auth::user()->name }}</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-light">
                                    <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <section class="py-5">
            <div class="container px-5">
                <div class="bg-light rounded-3 py-5 px-4 px-md-5 mb-5">
                    <div class="text-center mb-5">
                        <div class="feature bg-success bg-gradient text-white rounded-3 mb-3">
                            <i class="bi bi-person-badge"></i>
                        </div>
                        <h1 class="fw-bolder">{{ Auth::user()->name }}</h1>
                        <p class="lead fw-normal text-muted mb-0">Bienvenido a MiRefugio</p>
                    </div>

                    <!-- Tarjetas de funcionalidades -->
                    <div class="row gx-5">
                        <div class="col-lg-6 mb-5">
                            <div class="card h-100 shadow border-0">
                                <div class="card-body p-4">
                                    <div class="badge bg-success bg-gradient rounded-pill mb-2">Pacientes</div>
                                    <h5 class="card-title mb-3">Gestión de Pacientes</h5>
                                    <p class="card-text mb-3">Administra la información de tus pacientes, historiales
                                        clínicos y seguimiento de tratamientos.</p>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-1"><i class="bi bi-check text-success me-2"></i>Historiales
                                            médicos</li>
                                        <li class="mb-1"><i class="bi bi-check text-success me-2"></i>Notas de sesiones
                                        </li>
                                        <li class="mb-1"><i class="bi bi-check text-success me-2"></i>Planes de
                                            tratamiento</li>
                                    </ul>
                                </div>
                                <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                                    <div class="d-flex align-items-end justify-content-between">
                                        <button class="btn btn-success btn-sm" id="btnVerPacientes">Ver
                                            Pacientes</button>
                                        <span class="text-muted small" id="cantidadPacientes"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal de Pacientes -->
                        <div class="modal fade" id="modalPacientes" tabindex="-1" aria-labelledby="modalPacientesLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header bg-success text-white">
                                        <h5 class="modal-title" id="modalPacientesLabel">
                                            <i class="bi bi-people-fill me-2"></i>Lista de Pacientes
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="loadingPacientes" class="text-center py-4">
                                            <div class="spinner-border text-success" role="status">
                                                <span class="visually-hidden">Cargando...</span>
                                            </div>
                                            <p class="mt-2">Cargando pacientes...</p>
                                        </div>
                                        <div id="listaPacientes" class="d-none">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead class="table-success">
                                                        <tr>
                                                            <th>Nombre</th>
                                                            <th>Email</th>
                                                            <th>Fecha Registro</th>
                                                            <th>Notas</th>
                                                            <th>Reportes</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tablaPacientes">
                                                        <!-- Los pacientes se cargan aquí -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal para Agregar Nota -->
                        <div class="modal fade" id="modalAgregarNota" tabindex="-1"
                            aria-labelledby="modalAgregarNotaLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="modalAgregarNotaLabel">
                                            <i class="bi bi-journal-plus me-2"></i>Agregar Nota
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="formNota">
                                            <input type="hidden" id="notaPatientId" name="patient_id">
                                            <div class="mb-3">
                                                <label for="notaContent" class="form-label">Contenido de la nota</label>
                                                <textarea class="form-control" id="notaContent" name="content" rows="4"
                                                    maxlength="1000" required></textarea>
                                                <div class="form-text">Máximo 1000 caracteres</div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancelar</button>
                                        <button type="button" class="btn btn-primary" id="btnGuardarNota">
                                            <i class="bi bi-save me-1"></i>Guardar Nota
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal para Agregar Reporte -->
                        <div class="modal fade" id="modalAgregarReporte" tabindex="-1"
                            aria-labelledby="modalAgregarReporteLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-info text-white">
                                        <h5 class="modal-title" id="modalAgregarReporteLabel">
                                            <i class="bi bi-file-earmark-text me-2"></i>Agregar Reporte
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="formReporte">
                                            <input type="hidden" id="reportePatientId" name="patient_id">
                                            <div class="mb-3">
                                                <label for="reporteTitle" class="form-label">Título del reporte</label>
                                                <input type="text" class="form-control" id="reporteTitle" name="title"
                                                    maxlength="255" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="reporteType" class="form-label">Tipo de reporte</label>
                                                <select class="form-select" id="reporteType" name="type">
                                                    <option value="general">General</option>
                                                    <option value="diagnostico">Diagnóstico</option>
                                                    <option value="seguimiento">Seguimiento</option>
                                                    <option value="tratamiento">Tratamiento</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="reporteContent" class="form-label">Contenido del
                                                    reporte</label>
                                                <textarea class="form-control" id="reporteContent" name="content"
                                                    rows="6" required></textarea>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancelar</button>
                                        <button type="button" class="btn btn-info" id="btnGuardarReporte">
                                            <i class="bi bi-save me-1"></i>Guardar Reporte
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal para Ver Notas -->
                        <div class="modal fade" id="modalVerNotas" tabindex="-1" aria-labelledby="modalVerNotasLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="modalVerNotasLabel">
                                            <i class="bi bi-journal-text me-2"></i>Notas del Paciente
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="loadingNotas" class="text-center py-4">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Cargando...</span>
                                            </div>
                                            <p class="mt-2">Cargando notas...</p>
                                        </div>
                                        <div id="listaNotas" class="d-none">
                                            <!-- Las notas se cargan aquí -->
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal para Ver Reportes -->
                        <div class="modal fade" id="modalVerReportes" tabindex="-1"
                            aria-labelledby="modalVerReportesLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-info text-white">
                                        <h5 class="modal-title" id="modalVerReportesLabel">
                                            <i class="bi bi-file-earmark-text me-2"></i>Reportes del Paciente
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="loadingReportes" class="text-center py-4">
                                            <div class="spinner-border text-info" role="status">
                                                <span class="visually-hidden">Cargando...</span>
                                            </div>
                                            <p class="mt-2">Cargando reportes...</p>
                                        </div>
                                        <div id="listaReportes" class="d-none">
                                            <!-- Los reportes se cargan aquí -->
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script
                            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
                        <script>
                            // Configurar CSRF token para todas las peticiones AJAX
                            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                            // Referencias a los modales
                            const modalPacientes = new bootstrap.Modal(document.getElementById('modalPacientes'));
                            const modalAgregarNota = new bootstrap.Modal(document.getElementById('modalAgregarNota'));
                            const modalAgregarReporte = new bootstrap.Modal(document.getElementById('modalAgregarReporte'));
                            const modalVerNotas = new bootstrap.Modal(document.getElementById('modalVerNotas'));
                            const modalVerReportes = new bootstrap.Modal(document.getElementById('modalVerReportes'));

                            // Cargar cantidad de pacientes al cargar la página
                            document.addEventListener('DOMContentLoaded', function () {
                                cargarCantidadPacientes();
                            });

                            // Event listener para el botón "Ver Pacientes"
                            document.getElementById('btnVerPacientes').addEventListener('click', function () {
                                modalPacientes.show();
                                cargarPacientes();
                            });

                            // Función para cargar la cantidad de pacientes
                            async function cargarCantidadPacientes() {
                                try {
                                    const response = await fetch('/api/patients', {
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken
                                        }
                                    });
                                    const pacientes = await response.json();
                                    document.getElementById('cantidadPacientes').textContent = `${pacientes.length} activos`;
                                } catch (error) {
                                    console.error('Error al cargar cantidad de pacientes:', error);
                                    document.getElementById('cantidadPacientes').textContent = 'Error al cargar';
                                }
                            }

                            // Función para cargar la lista de pacientes
                            async function cargarPacientes() {
                                try {
                                    document.getElementById('loadingPacientes').classList.remove('d-none');
                                    document.getElementById('listaPacientes').classList.add('d-none');

                                    const response = await fetch('/api/patients', {
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken
                                        }
                                    });

                                    if (!response.ok) {
                                        throw new Error('Error al cargar pacientes');
                                    }

                                    const pacientes = await response.json();
                                    mostrarPacientes(pacientes);
                                } catch (error) {
                                    console.error('Error al cargar pacientes:', error);
                                    mostrarError('Error al cargar la lista de pacientes');
                                }
                            }

                            // Función para mostrar los pacientes en la tabla
                            function mostrarPacientes(pacientes) {
                                const tbody = document.getElementById('tablaPacientes');
                                tbody.innerHTML = '';

                                if (pacientes.length === 0) {
                                    tbody.innerHTML = '<tr><td colspan="6" class="text-center">No hay pacientes registrados</td></tr>';
                                } else {
                                    pacientes.forEach(paciente => {
                                        const fechaRegistro = new Date(paciente.created_at).toLocaleDateString();
                                        const row = `
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="bg-success rounded-circle p-2 me-2">
                                <i class="bi bi-person text-white"></i>
                            </div>
                            <strong>${paciente.name}</strong>
                        </div>
                    </td>
                    <td>${paciente.email}</td>
                    <td>${fechaRegistro}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" onclick="verNotas(${paciente.id}, '${paciente.name}')">
                            <span class="badge bg-primary">${paciente.notes_count || 0}</span>
                        </button>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-info" onclick="verReportes(${paciente.id}, '${paciente.name}')">
                            <span class="badge bg-info">${paciente.reports_count || 0}</span>
                        </button>
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <button class="btn btn-outline-primary btn-sm" onclick="abrirModalNota(${paciente.id}, '${paciente.name}')">
                                <i class="bi bi-journal-plus"></i> Nota
                            </button>
                            <button class="btn btn-outline-info btn-sm" onclick="abrirModalReporte(${paciente.id}, '${paciente.name}')">
                                <i class="bi bi-file-earmark-text"></i> Reporte
                            </button>
                        </div>
                    </td>
                </tr>
            `;
                                        tbody.innerHTML += row;
                                    });
                                }

                                document.getElementById('loadingPacientes').classList.add('d-none');
                                document.getElementById('listaPacientes').classList.remove('d-none');
                            }

                            // Función para abrir el modal de agregar nota
                            function abrirModalNota(patientId, patientName) {
                                document.getElementById('notaPatientId').value = patientId;
                                document.getElementById('modalAgregarNotaLabel').innerHTML = `<i class="bi bi-journal-plus me-2"></i>Agregar Nota - ${patientName}`;
                                document.getElementById('notaContent').value = '';
                                modalAgregarNota.show();
                            }

                            // Función para abrir el modal de agregar reporte
                            function abrirModalReporte(patientId, patientName) {
                                document.getElementById('reportePatientId').value = patientId;
                                document.getElementById('modalAgregarReporteLabel').innerHTML = `<i class="bi bi-file-earmark-text me-2"></i>Agregar Reporte - ${patientName}`;
                                document.getElementById('reporteTitle').value = '';
                                document.getElementById('reporteType').value = 'general';
                                document.getElementById('reporteContent').value = '';
                                modalAgregarReporte.show();
                            }

                            // Event listener para guardar nota
                            document.getElementById('btnGuardarNota').addEventListener('click', async function () {
                                const form = document.getElementById('formNota');
                                const formData = new FormData(form);

                                try {
                                    const response = await fetch('/api/patients/notes', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken
                                        },
                                        body: formData
                                    });

                                    const result = await response.json();

                                    if (result.success) {
                                        mostrarAlerta('Nota agregada exitosamente', 'success');
                                        modalAgregarNota.hide();
                                        cargarPacientes(); // Recargar la lista
                                    } else {
                                        mostrarAlerta('Error al agregar la nota', 'danger');
                                    }
                                } catch (error) {
                                    console.error('Error:', error);
                                    mostrarAlerta('Error al agregar la nota', 'danger');
                                }
                            });

                            // Event listener para guardar reporte
                            document.getElementById('btnGuardarReporte').addEventListener('click', async function () {
                                const form = document.getElementById('formReporte');
                                const formData = new FormData(form);

                                try {
                                    const response = await fetch('/api/patients/reports', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken
                                        },
                                        body: formData
                                    });

                                    const result = await response.json();

                                    if (result.success) {
                                        mostrarAlerta('Reporte agregado exitosamente', 'success');
                                        modalAgregarReporte.hide();
                                        cargarPacientes(); // Recargar la lista
                                    } else {
                                        mostrarAlerta('Error al agregar el reporte', 'danger');
                                    }
                                } catch (error) {
                                    console.error('Error:', error);
                                    mostrarAlerta('Error al agregar el reporte', 'danger');
                                }
                            });

                            // Función para ver notas de un paciente
                            async function verNotas(patientId, patientName) {
                                try {
                                    document.getElementById('modalVerNotasLabel').innerHTML = `<i class="bi bi-journal-text me-2"></i>Notas de ${patientName}`;
                                    modalVerNotas.show();

                                    document.getElementById('loadingNotas').classList.remove('d-none');
                                    document.getElementById('listaNotas').classList.add('d-none');

                                    const response = await fetch(`/api/patients/${patientId}/notes`, {
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken
                                        }
                                    });

                                    if (!response.ok) {
                                        throw new Error('Error al cargar notas');
                                    }

                                    const data = await response.json();
                                    mostrarNotas(data.notes);
                                } catch (error) {
                                    console.error('Error al cargar notas:', error);
                                    mostrarErrorNotas('Error al cargar las notas');
                                }
                            }

                            // Función para ver reportes de un paciente
                            async function verReportes(patientId, patientName) {
                                try {
                                    document.getElementById('modalVerReportesLabel').innerHTML = `<i class="bi bi-file-earmark-text me-2"></i>Reportes de ${patientName}`;
                                    modalVerReportes.show();

                                    document.getElementById('loadingReportes').classList.remove('d-none');
                                    document.getElementById('listaReportes').classList.add('d-none');

                                    const response = await fetch(`/api/patients/${patientId}/reports`, {
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken
                                        }
                                    });

                                    if (!response.ok) {
                                        throw new Error('Error al cargar reportes');
                                    }

                                    const data = await response.json();
                                    mostrarReportes(data.reports);
                                } catch (error) {
                                    console.error('Error al cargar reportes:', error);
                                    mostrarErrorReportes('Error al cargar los reportes');
                                }
                            }

                            // Función para mostrar las notas
                            function mostrarNotas(notas) {
                                const container = document.getElementById('listaNotas');
                                container.innerHTML = '';

                                if (notas.length === 0) {
                                    container.innerHTML = '<div class="alert alert-info text-center">No hay notas registradas para este paciente</div>';
                                } else {
                                    notas.forEach(nota => {
                                        const fechaCreacion = new Date(nota.created_at).toLocaleString();
                                        const notaHtml = `
                <div class="card mb-3" id="nota-${nota.id}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-journal-text text-primary me-2"></i>
                                <small class="text-muted">
                                    Por: <strong>${nota.creator.name}</strong> | ${fechaCreacion}
                                </small>
                            </div>
                            <button class="btn btn-outline-danger btn-sm" onclick="eliminarNota(${nota.id})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                        <p class="card-text">${nota.content}</p>
                    </div>
                </div>
            `;
                                        container.innerHTML += notaHtml;
                                    });
                                }

                                document.getElementById('loadingNotas').classList.add('d-none');
                                document.getElementById('listaNotas').classList.remove('d-none');
                            }

                            // Función para mostrar los reportes
                            function mostrarReportes(reportes) {
                                const container = document.getElementById('listaReportes');
                                container.innerHTML = '';

                                if (reportes.length === 0) {
                                    container.innerHTML = '<div class="alert alert-info text-center">No hay reportes registrados para este paciente</div>';
                                } else {
                                    reportes.forEach(reporte => {
                                        const fechaCreacion = new Date(reporte.created_at).toLocaleString();
                                        const tipoBadge = getTipoBadge(reporte.type);
                                        const reporteHtml = `
                <div class="card mb-3" id="reporte-${reporte.id}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="card-title mb-1">
                                    ${reporte.title}
                                    <span class="badge ${tipoBadge.class} ms-2">${tipoBadge.text}</span>
                                </h6>
                                <small class="text-muted">
                                    Por: <strong>${reporte.creator.name}</strong> | ${fechaCreacion}
                                </small>
                            </div>
                            <button class="btn btn-outline-danger btn-sm" onclick="eliminarReporte(${reporte.id})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                        <p class="card-text">${reporte.content}</p>
                    </div>
                </div>
            `;
                                        container.innerHTML += reporteHtml;
                                    });
                                }

                                document.getElementById('loadingReportes').classList.add('d-none');
                                document.getElementById('listaReportes').classList.remove('d-none');
                            }

                            // Función para obtener el badge del tipo de reporte
                            function getTipoBadge(tipo) {
                                const tipos = {
                                    'general': { class: 'bg-secondary', text: 'General' },
                                    'diagnostico': { class: 'bg-warning', text: 'Diagnóstico' },
                                    'seguimiento': { class: 'bg-info', text: 'Seguimiento' },
                                    'tratamiento': { class: 'bg-success', text: 'Tratamiento' }
                                };
                                return tipos[tipo] || tipos['general'];
                            }

                            // Función para eliminar una nota
                            async function eliminarNota(notaId) {
                                if (!confirm('¿Estás seguro de que deseas eliminar esta nota?')) {
                                    return;
                                }

                                try {
                                    const response = await fetch(`/api/patients/notes/${notaId}`, {
                                        method: 'DELETE',
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken
                                        }
                                    });

                                    const result = await response.json();

                                    if (result.success) {
                                        mostrarAlerta('Nota eliminada exitosamente', 'success');
                                        document.getElementById(`nota-${notaId}`).remove();

                                        // Actualizar la lista de pacientes para reflejar el nuevo contador
                                        cargarPacientes();
                                    } else {
                                        mostrarAlerta(result.message || 'Error al eliminar la nota', 'danger');
                                    }
                                } catch (error) {
                                    console.error('Error:', error);
                                    mostrarAlerta('Error al eliminar la nota', 'danger');
                                }
                            }

                            // Función para eliminar un reporte
                            async function eliminarReporte(reporteId) {
                                if (!confirm('¿Estás seguro de que deseas eliminar este reporte?')) {
                                    return;
                                }

                                try {
                                    const response = await fetch(`/api/patients/reports/${reporteId}`, {
                                        method: 'DELETE',
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken
                                        }
                                    });

                                    const result = await response.json();

                                    if (result.success) {
                                        mostrarAlerta('Reporte eliminado exitosamente', 'success');
                                        document.getElementById(`reporte-${reporteId}`).remove();

                                        // Actualizar la lista de pacientes para reflejar el nuevo contador
                                        cargarPacientes();
                                    } else {
                                        mostrarAlerta(result.message || 'Error al eliminar el reporte', 'danger');
                                    }
                                } catch (error) {
                                    console.error('Error:', error);
                                    mostrarAlerta('Error al eliminar el reporte', 'danger');
                                }
                            }

                            // Función para mostrar alertas
                            function mostrarAlerta(mensaje, tipo) {
                                const alertaDiv = document.createElement('div');
                                alertaDiv.className = `alert alert-${tipo} alert-dismissible fade show position-fixed`;
                                alertaDiv.style.top = '20px';
                                alertaDiv.style.right = '20px';
                                alertaDiv.style.zIndex = '9999';
                                alertaDiv.innerHTML = `
        ${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
                                document.body.appendChild(alertaDiv);

                                // Auto-eliminar después de 5 segundos
                                setTimeout(() => {
                                    if (alertaDiv.parentNode) {
                                        alertaDiv.parentNode.removeChild(alertaDiv);
                                    }
                                }, 5000);
                            }

                            // Función para mostrar errores en notas
                            function mostrarErrorNotas(mensaje) {
                                const container = document.getElementById('listaNotas');
                                container.innerHTML = `<div class="alert alert-danger text-center">${mensaje}</div>`;
                                document.getElementById('loadingNotas').classList.add('d-none');
                                document.getElementById('listaNotas').classList.remove('d-none');
                            }

                            // Función para mostrar errores en reportes
                            function mostrarErrorReportes(mensaje) {
                                const container = document.getElementById('listaReportes');
                                container.innerHTML = `<div class="alert alert-danger text-center">${mensaje}</div>`;
                                document.getElementById('loadingReportes').classList.add('d-none');
                                document.getElementById('listaReportes').classList.remove('d-none');
                            }

                            // Función para mostrar errores
                            function mostrarError(mensaje) {
                                const tbody = document.getElementById('tablaPacientes');
                                tbody.innerHTML = `<tr><td colspan="6" class="text-center text-danger">${mensaje}</td></tr>`;
                                document.getElementById('loadingPacientes').classList.add('d-none');
                                document.getElementById('listaPacientes').classList.remove('d-none');
                            }
                        </script>

                        <div class="col-lg-6 mb-5">
                            <div class="card h-100 shadow border-0">
                                <div class="card-body p-4">
                                    <div class="badge bg-info bg-gradient rounded-pill mb-2">Agenda</div>
                                    <h5 class="card-title mb-3">Calendario de Citas</h5>
                                    <p class="card-text mb-3">Gestiona tu agenda, programa citas y revisa tu horario de
                                        consultas.</p>
                                    <ul class="list-unstyled mb-0">
                                        @php
                                            $proximaCita = App\Models\Cita::proximas()->first();
                                            $citasHoy = App\Models\Cita::hoy()->count();
                                        @endphp

                                        @if($proximaCita)
                                            <li class="mb-1">
                                                <i class="bi bi-calendar text-info me-2"></i>
                                                Próxima cita: {{ $proximaCita->hora->format('H:i') }}
                                            </li>
                                            <li class="mb-1">
                                                <i class="bi bi-clock text-info me-2"></i>
                                                Duración: {{ $proximaCita->duracion }} min
                                            </li>
                                            <li class="mb-1">
                                                <i class="bi bi-person text-info me-2"></i>
                                                Paciente: {{ $proximaCita->paciente }}
                                            </li>
                                        @else
                                            <li class="mb-1">
                                                <i class="bi bi-calendar-x text-muted me-2"></i>
                                                No hay citas programadas
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                                <!-- Vista 2 - Sección para administrar enlaces -->
                                <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="d-flex gap-2 align-items-center">
                                            <a href="{{ route('citas.index') }}" class="btn btn-info btn-sm">
                                                <i class="bi bi-calendar3 me-1"></i>Agenda
                                            </a>
                                            <button class="btn btn-info btn-sm" id="btnAccederAdmin">
                                                <i class="bi bi-link-45deg me-1"></i>Acceder
                                            </button>
                                            <!-- Botón para abrir modal de configuración -->
                                            <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#modalEnlace">
                                                <i class="bi bi-gear me-1"></i>Configurar Enlace
                                            </button>
                                        </div>
                                        <span class="text-muted small">{{ $citasHoy }} citas hoy</span>
                                    </div>
                                </div>

                                <!-- Modal para configurar enlace -->
                                <div class="modal fade" id="modalEnlace" tabindex="-1"
                                    aria-labelledby="modalEnlaceLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalEnlaceLabel">Configurar Enlace de
                                                    Sesión</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="formEnlace">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="nombreEnlace" class="form-label">Nombre de la
                                                            sesión</label>
                                                        <input type="text" class="form-control" id="nombreEnlace"
                                                            name="nombre" placeholder="Sesión Virtual"
                                                            value="Sesión Virtual">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="urlEnlace" class="form-label">URL del enlace</label>
                                                        <input type="url" class="form-control" id="urlEnlace"
                                                            name="enlace" placeholder="https://meet.google.com/..."
                                                            required>
                                                        <div class="form-text">Ingresa el enlace completo de la
                                                            videollamada</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <small class="text-muted">
                                                            <i class="bi bi-info-circle me-1"></i>
                                                            Este enlace se actualizará automáticamente en todas las
                                                            vistas donde aparece el botón de acceso.
                                                        </small>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancelar</button>
                                                <button type="button" class="btn btn-success" id="btnGuardarEnlace">
                                                    <i class="bi bi-save me-1"></i>Guardar Enlace
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                // Cargar enlace actual al abrir la página
                                cargarEnlaceActual();

                                // Manejar clic en botón acceder (admin)
                                document.getElementById('btnAccederAdmin').addEventListener('click', function () {
                                    abrirEnlaceActual();
                                });

                                // Manejar guardar enlace
                                document.getElementById('btnGuardarEnlace').addEventListener('click', function () {
                                    guardarEnlace();
                                });

                                function cargarEnlaceActual() {
                                    fetch('/api/enlace-sesion/activo')
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                // Guardar enlace actual en el botón
                                                document.getElementById('btnAccederAdmin').setAttribute('data-enlace', data.enlace);
                                                // Opcional: mostrar el nombre actual en el modal
                                                document.getElementById('nombreEnlace').value = data.nombre;
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error al cargar enlace:', error);
                                        });
                                }

                                function abrirEnlaceActual() {
                                    const enlace = document.getElementById('btnAccederAdmin').getAttribute('data-enlace');
                                    if (enlace) {
                                        window.open(enlace, '_blank');
                                    }
                                }

                                function guardarEnlace() {
                                    const formData = new FormData(document.getElementById('formEnlace'));
                                    const btnGuardar = document.getElementById('btnGuardarEnlace');

                                    // Deshabilitar botón y mostrar spinner
                                    btnGuardar.disabled = true;
                                    btnGuardar.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Guardando...';

                                    fetch('/api/enlace-sesion/guardar', {
                                        method: 'POST',
                                        body: formData,
                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                        }
                                    })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                // Cerrar modal
                                                const modal = bootstrap.Modal.getInstance(document.getElementById('modalEnlace'));
                                                modal.hide();

                                                // Mostrar mensaje de éxito temporal
                                                mostrarAlertaExito('Enlace guardado correctamente. Recargando página...');

                                                // Recargar la página después de 1.5 segundos
                                                setTimeout(() => {
                                                    window.location.reload();
                                                }, 1500);
                                            } else {
                                                mostrarAlerta('Error al guardar el enlace', 'danger');
                                                // Restaurar botón
                                                btnGuardar.disabled = false;
                                                btnGuardar.innerHTML = '<i class="bi bi-save me-1"></i>Guardar Enlace';
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error:', error);
                                            mostrarAlerta('Error al guardar el enlace', 'danger');
                                            // Restaurar botón
                                            btnGuardar.disabled = false;
                                            btnGuardar.innerHTML = '<i class="bi bi-save me-1"></i>Guardar Enlace';
                                        });
                                }

                                function mostrarAlerta(mensaje, tipo) {
                                    const alertaHtml = `
            <div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
                ${mensaje}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

                                    // Insertar alerta al inicio del modal body
                                    const modalBody = document.querySelector('#modalEnlace .modal-body');
                                    modalBody.insertAdjacentHTML('afterbegin', alertaHtml);

                                    // Auto-remover después de 3 segundos
                                    setTimeout(() => {
                                        const alerta = modalBody.querySelector('.alert');
                                        if (alerta) {
                                            alerta.remove();
                                        }
                                    }, 3000);
                                }

                                function mostrarAlertaExito(mensaje) {
                                    // Crear alerta flotante en la página principal
                                    const alertaHtml = `
            <div class="alert alert-success alert-dismissible fade show position-fixed" 
                 style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;" role="alert">
                <i class="bi bi-check-circle me-2"></i>${mensaje}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

                                    // Insertar alerta en el body
                                    document.body.insertAdjacentHTML('beforeend', alertaHtml);
                                }
                            });
                        </script>
                        <div class="col-lg-6 mb-5">
                            <div class="card h-100 shadow border-0">
                                <div class="card-body p-4">
                                    <div class="badge bg-warning bg-gradient rounded-pill mb-2">Mensajería</div>
                                    <h5 class="card-title mb-3">Centro de Mensajes</h5>
                                    <p class="card-text mb-3">Gestiona las conversaciones con tus pacientes y
                                        responde
                                        consultas urgentes.</p>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-1">
                                            <i class="bi bi-chat-dots-fill text-warning me-2"></i>
                                            Conversaciones en tiempo real
                                        </li>
                                        <li class="mb-1">
                                            <i class="bi bi-envelope-fill text-warning me-2"></i>
                                            Notificaciones instantáneas
                                        </li>
                                        <li class="mb-1">
                                            <i class="bi bi-archive-fill text-warning me-2"></i>
                                            Historial de mensajes guardados
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                                    <div class="d-flex align-items-end justify-content-between">
                                        <button class="btn btn-warning btn-sm" onclick="toggleChatWidget()">Ver
                                            Mensajes</button>
                                        <span class="badge bg-danger" id="footer-unread-badge">5</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-5">
                            <div class="card h-100 shadow border-0">
                                <div class="card-body p-4">
                                    <div class="badge bg-primary bg-gradient rounded-pill mb-2">Reportes</div>
                                    <h5 class="card-title mb-3">Estadísticas y Reportes</h5>
                                    <p class="card-text mb-3">Analiza el progreso de tus pacientes y genera
                                        reportes
                                        detallados en PDF.</p>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-1">
                                            <i class="bi bi-graph-up text-primary me-2"></i>
                                            Progreso de tratamientos
                                        </li>
                                        <li class="mb-1">
                                            <i class="bi bi-file-earmark-text text-primary me-2"></i>
                                            Reportes personalizados
                                        </li>
                                        <li class="mb-1">
                                            <i class="bi bi-file-pdf text-primary me-2"></i>
                                            Descarga en PDF
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                                    <div class="d-flex align-items-end justify-content-between">
                                        <a href="{{ route('reports.index') }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-graph-up me-1"></i>
                                            Ver Reportes
                                        </a>
                                        <span class="text-muted small">Actualizado hoy</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Chat Widget Mejorado -->
        <div class="chat-widget"
            style="position:fixed; bottom:20px; right:20px; width:450px; height:600px; background:white; border:1px solid #ddd; display:none; border-radius:15px; box-shadow: 0 8px 32px rgba(0,0,0,0.15); z-index: 1000; overflow:hidden;">
            <!-- Header del Chat -->
            <div class="chat-header"
                style="padding:15px; background:#007bff; color:white; cursor:pointer; border-radius:10px 10px 0 0; display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <strong id="chat-title">Conversaciones Activas</strong>
                    <div id="chat-subtitle" style="font-size:12px; opacity:0.9;">Selecciona una conversación</div>
                </div>
                <div class="chat-controls" style="display:flex; gap:10px;">
                    <button class="chat-list-btn" title="Ver lista de conversaciones"
                        style="background:none; border:none; color:white; font-size:16px; cursor:pointer; opacity:0.8; transition:all 0.3s;"
                        onmouseover="this.style.opacity='1'; this.style.transform='scale(1.1)'"
                        onmouseout="this.style.opacity='0.8'; this.style.transform='scale(1)'">
                        <i class="fas fa-list"></i>
                    </button>
                    <button class="chat-clear" title="Vaciar conversación actual"
                        style="background:none; border:none; color:white; font-size:16px; cursor:pointer; opacity:0.8; transition:all 0.3s; display:none;"
                        onmouseover="this.style.opacity='1'; this.style.transform='scale(1.1)'"
                        onmouseout="this.style.opacity='0.8'; this.style.transform='scale(1)'">
                        <i class="fas fa-trash"></i>
                    </button>
                    <button class="chat-close" title="Cerrar chat"
                        style="background:none; border:none; color:white; font-size:20px; cursor:pointer; opacity:0.8; transition:all 0.3s;"
                        onmouseover="this.style.opacity='1'; this.style.transform='scale(1.1)'"
                        onmouseout="this.style.opacity='0.8'; this.style.transform='scale(1)'">
                        &times;
                    </button>
                </div>
            </div>

            <!-- Lista de Conversaciones -->
            <div class="conversations-list"
                style="height:calc(100% - 70px); overflow-y:auto; background:#f8f9fa; display:block;">
                <div class="conversations-header"
                    style="padding:20px; text-align:center; border-bottom:1px solid #dee2e6;">
                    <h6 style="margin:0; color:#6c757d;">
                        <i class="fas fa-comments me-2"></i>Conversaciones Activas
                    </h6>
                </div>
                <div id="conversations-container" style="padding:10px;">
                    <!-- Las conversaciones se cargarán aquí dinámicamente -->
                </div>
            </div>

            <!-- Vista de Chat Individual -->
            <div class="chat-view" style="height:calc(100% - 70px); display:none; flex-direction:column;">
                <div class="chat-body" style="flex:1; overflow-y:auto; padding:15px; background:#f8f9fa;"></div>
                <div class="chat-footer"
                    style="padding:15px; display:flex; border-top:1px solid #eee; background:white;">
                    <input type="text" class="chat-input" placeholder="Escribe tu mensaje..."
                        style="flex-grow:1; padding:12px; margin-right:10px; border:1px solid #ddd; border-radius:25px; outline:none; font-size:14px;">
                    <button class="chat-send"
                        style="padding:12px 18px; background:#007bff; color:white; border:none; border-radius:25px; cursor:pointer; transition:all 0.3s;"
                        onmouseover="this.style.background='#0056b3'" onmouseout="this.style.background='#007bff'">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Chat Toggle Button con Badge -->
        <div class="chat-toggle-container" style="position:fixed; bottom:20px; right:20px; z-index: 999;">
            <button class="chat-toggle"
                style="padding:18px; background:linear-gradient(135deg, #007bff, #0056b3); color:white; border:none; border-radius:50%; cursor:pointer; box-shadow: 0 6px 20px rgba(0,123,255,0.3); transition:all 0.3s; position:relative;"
                onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 8px 25px rgba(0,123,255,0.4)'"
                onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 6px 20px rgba(0,123,255,0.3)'">
                <i class="fas fa-comment"></i>
            </button>
            <span class="chat-notification-badge"
                style="position:absolute; top:-8px; right:-8px; background:#dc3545; color:white; border-radius:50%; width:24px; height:24px; font-size:12px; display:none; align-items:center; justify-content:center; font-weight:bold; animation:pulse 2s infinite;">0</span>
        </div>

        <style>
            .conversation-item {
                padding: 15px;
                border-radius: 10px;
                margin-bottom: 8px;
                cursor: pointer;
                transition: all 0.3s ease;
                border: 1px solid #e9ecef;
                background: white;
                position: relative;
            }

            .conversation-item:hover {
                background: #e3f2fd;
                border-color: #007bff;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
            }

            .conversation-item.active {
                background: #007bff;
                color: white;
                border-color: #0056b3;
            }

            .conversation-item.has-unread {
                border-left: 4px solid #28a745;
            }

            .conversation-name {
                font-weight: 600;
                font-size: 14px;
                margin-bottom: 5px;
            }

            .conversation-preview {
                font-size: 12px;
                opacity: 0.8;
                margin-bottom: 5px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .conversation-time {
                font-size: 10px;
                opacity: 0.6;
            }

            .unread-badge {
                position: absolute;
                top: 10px;
                right: 10px;
                background: #dc3545;
                color: white;
                border-radius: 12px;
                padding: 2px 8px;
                font-size: 10px;
                font-weight: bold;
            }

            .conversation-item.active .unread-badge {
                background: rgba(255, 255, 255, 0.3);
            }

            @keyframes pulse {
                0% {
                    transform: scale(1);
                }

                50% {
                    transform: scale(1.1);
                }

                100% {
                    transform: scale(1);
                }
            }

            .chat-clear:hover {
                color: #ff6b6b !important;
                transform: scale(1.1);
            }

            .empty-conversations {
                text-align: center;
                padding: 40px 20px;
                color: #6c757d;
            }

            .empty-conversations i {
                font-size: 48px;
                opacity: 0.5;
                margin-bottom: 15px;
            }
        </style>

        <script>
            // Variables globales
            let currentConversationId = null;
            let isLoading = false;
            let conversations = {};
            let currentView = 'list'; // 'list' o 'chat'

            // Elementos del DOM
            let chatWidget, chatToggle, chatClose, chatClear, chatListBtn, chatBody, chatInput, chatSend;
            let conversationsList, chatView, conversationsContainer, chatTitle, chatSubtitle, notificationBadge;

            document.addEventListener('DOMContentLoaded', function () {
                // Inicializar elementos del DOM
                chatWidget = document.querySelector('.chat-widget');
                chatToggle = document.querySelector('.chat-toggle');
                chatClose = document.querySelector('.chat-close');
                chatClear = document.querySelector('.chat-clear');
                chatListBtn = document.querySelector('.chat-list-btn');
                chatBody = document.querySelector('.chat-body');
                chatInput = document.querySelector('.chat-input');
                chatSend = document.querySelector('.chat-send');
                conversationsList = document.querySelector('.conversations-list');
                chatView = document.querySelector('.chat-view');
                conversationsContainer = document.querySelector('#conversations-container');
                chatTitle = document.querySelector('#chat-title');
                chatSubtitle = document.querySelector('#chat-subtitle');
                notificationBadge = document.querySelector('.chat-notification-badge');

                // Event listeners
                chatToggle.addEventListener('click', toggleChatWidget);
                chatClose.addEventListener('click', closeChatWidget);
                chatClear.addEventListener('click', clearCurrentConversation);
                chatListBtn.addEventListener('click', showConversationsList);
                chatSend.addEventListener('click', sendMessage);
                chatInput.addEventListener('keypress', function (e) {
                    if (e.key === 'Enter' && !e.shiftKey) {
                        e.preventDefault();
                        sendMessage();
                    }
                });

                // Cargar conversaciones al iniciar
                loadConversations();

                // Actualizar conversaciones cada 30 segundos
                setInterval(loadConversations, 30000);

                // Verificar nuevos mensajes cada 10 segundos
                setInterval(checkForNewMessages, 10000);
            });

            // Funciones globales (fuera del DOMContentLoaded)
            function toggleChatWidget() {
                if (chatWidget.style.display === 'none' || !chatWidget.style.display) {
                    showChatWidget();
                } else {
                    closeChatWidget();
                }
            }

            function showChatWidget() {
                chatWidget.style.display = 'block';
                chatToggle.parentElement.style.display = 'none';
                showConversationsList();
            }

            function closeChatWidget() {
                chatWidget.style.display = 'none';
                chatToggle.parentElement.style.display = 'block';
            }

            function showConversationsList() {
                currentView = 'list';
                conversationsList.style.display = 'block';
                chatView.style.display = 'none';
                chatClear.style.display = 'none';
                chatTitle.textContent = 'Conversaciones Activas';
                chatSubtitle.textContent = 'Selecciona una conversación';
                loadConversations();
            }

            function showChatView(conversationId) {
                currentView = 'chat';
                currentConversationId = conversationId;
                conversationsList.style.display = 'none';
                chatView.style.display = 'flex';
                chatClear.style.display = 'inline-block';

                const conversation = conversations[conversationId];
                if (conversation) {
                    chatTitle.textContent = conversation.patient_name;
                    chatSubtitle.textContent = 'En línea';

                    // Marcar como leída
                    markConversationAsRead(conversationId);
                }

                loadMessages(conversationId);
                chatInput.focus();
            }

            // Esta función DEBE estar disponible globalmente
            function selectConversation(conversationId) {
                console.log('Seleccionando conversación:', conversationId);
                showChatView(conversationId);
            }

            function loadConversations() {
                fetch('/chat/conversations')
                    .then(response => response.json())
                    .then(data => {
                        console.log('Conversaciones cargadas:', data);
                        conversations = {};
                        let totalUnread = 0;

                        data.conversations.forEach(conv => {
                            conversations[conv.id] = conv;
                            totalUnread += conv.unread_count || 0;
                        });

                        updateUnreadBadges(totalUnread);
                        renderConversations(data.conversations);
                    })
                    .catch(error => console.error('Error loading conversations:', error));
            }

            function renderConversations(conversationsList) {
                if (conversationsList.length === 0) {
                    conversationsContainer.innerHTML = `
            <div class="empty-conversations">
                <i class="fas fa-comment-slash"></i>
                <h6>No hay conversaciones</h6>
                <p>Las nuevas conversaciones aparecerán aquí</p>
            </div>
        `;
                    return;
                }

                conversationsContainer.innerHTML = conversationsList.map(conv => `
        <div class="conversation-item ${conv.unread_count > 0 ? 'has-unread' : ''}" 
             onclick="selectConversation(${conv.id})"
             data-conversation-id="${conv.id}"
             style="cursor: pointer;">
            <div class="conversation-name">${conv.patient_name}</div>
            <div class="conversation-preview">${conv.last_message_preview || 'Nueva conversación'}</div>
            <div class="conversation-time">${formatTime(conv.last_message_time)}</div>
            ${conv.unread_count > 0 ? `<span class="unread-badge">${conv.unread_count}</span>` : ''}
        </div>
    `).join('');

                console.log('Conversaciones renderizadas:', conversationsList.length);
            }

            function markConversationAsRead(conversationId) {
                fetch(`/chat/mark-read/${conversationId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                    .then(() => {
                        // Actualizar el contador local
                        if (conversations[conversationId]) {
                            conversations[conversationId].unread_count = 0;
                        }
                        // Recargar conversaciones para actualizar la vista
                        if (currentView === 'list') {
                            loadConversations();
                        }
                    })
                    .catch(error => console.error('Error marking as read:', error));
            }

            function updateUnreadBadges(totalUnread) {
                // Actualizar badge del botón flotante
                if (totalUnread > 0) {
                    notificationBadge.textContent = totalUnread;
                    notificationBadge.style.display = 'flex';
                } else {
                    notificationBadge.style.display = 'none';
                }

                // Actualizar contadores en el dashboard
                const unreadCountElement = document.querySelector('#unread-count');
                const sidebarUnreadElement = document.querySelector('#sidebar-unread-count');
                const footerBadgeElement = document.querySelector('#footer-unread-badge');

                if (unreadCountElement) unreadCountElement.textContent = totalUnread;
                if (sidebarUnreadElement) sidebarUnreadElement.textContent = totalUnread;
                if (footerBadgeElement) {
                    footerBadgeElement.textContent = totalUnread;
                    footerBadgeElement.style.display = totalUnread > 0 ? 'inline' : 'none';
                }
            }

            function clearCurrentConversation() {
                if (!currentConversationId) return;

                Swal.fire({
                    title: '¿Estás seguro?',
                    html: `
            <div style="text-align: center; margin: 20px 0;">
                <i class="fas fa-trash-alt" style="font-size: 48px; color: #ff6b6b; margin-bottom: 15px;"></i>
                <p>Se eliminarán <strong>todos los mensajes</strong> de esta conversación.</p>
                <p style="color: #666; font-size: 14px;">Esta acción no se puede deshacer.</p>
            </div>
        `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '<i class="fas fa-trash me-2"></i>Sí, eliminar',
                    cancelButtonText: '<i class="fas fa-times me-2"></i>Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/chat/clear/${currentConversationId}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    chatBody.innerHTML = '';
                                    Swal.fire({
                                        icon: 'success',
                                        title: '¡Conversación eliminada!',
                                        text: 'Todos los mensajes han sido eliminados exitosamente.',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });

                                    // Volver a la lista de conversaciones
                                    setTimeout(() => {
                                        showConversationsList();
                                    }, 2000);
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'No se pudo eliminar la conversación.',
                                        confirmButtonColor: '#d33'
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error inesperado',
                                    text: 'Ocurrió un error al eliminar la conversación.',
                                    confirmButtonColor: '#d33'
                                });
                            });
                    }
                });
            }

            function sendMessage() {
                if (!currentConversationId) return;

                const message = chatInput.value.trim();
                if (message === '' || isLoading) return;

                isLoading = true;
                chatSend.disabled = true;

                // Obtener el ID del usuario autenticado de forma segura
                const userId = document.querySelector('meta[name="user-id"]')?.content || '{{ auth()->id() ?? 0 }}';

                // Mostrar mensaje del usuario inmediatamente
                displayMessage(message, parseInt(userId), 'Tú');
                chatInput.value = '';

                fetch('/chat/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        message: message,
                        conversation_id: currentConversationId
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.messages && data.messages.length > 0) {
                            // Recargar todos los mensajes para mantener sincronización
                            loadMessages(currentConversationId);
                        }
                        chatInput.focus();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        displaySystemMessage('Error al enviar el mensaje. Por favor, intenta de nuevo.');
                    })
                    .finally(() => {
                        isLoading = false;
                        chatSend.disabled = false;
                    });
            }

            function loadMessages(conversationId) {
                if (!conversationId) return;

                fetch(`/chat/messages?conversation_id=${conversationId}`)
                    .then(response => response.json())
                    .then(data => {
                        chatBody.innerHTML = '';
                        if (data.messages && data.messages.length > 0) {
                            data.messages.forEach(msg => {
                                displayMessage(msg.message, msg.user_id, msg.user_name, msg.created_at);
                            });
                        } else {
                            displaySystemMessage('Inicia la conversación escribiendo un mensaje.');
                        }
                        scrollToBottom();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        displaySystemMessage('Error al cargar los mensajes.');
                    });
            }

            function displayMessage(message, userId, userName, time = null) {
                const msgDiv = document.createElement('div');
                const userIdAuth = document.querySelector('meta[name="user-id"]')?.content || '{{ auth()->id() ?? 0 }}';
                const isCurrentUser = userId == parseInt(userIdAuth);

                msgDiv.style.marginBottom = '15px';
                msgDiv.style.textAlign = isCurrentUser ? 'right' : 'left';

                const timeStr = time ? formatTime(time) : new Date().toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });

                msgDiv.innerHTML = `
        <div style="display:inline-block; max-width:75%; padding:12px 16px; border-radius:18px; background:${isCurrentUser ? 'linear-gradient(135deg, #007bff, #0056b3)' : '#ffffff'}; color:${isCurrentUser ? 'white' : '#333'}; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border: ${isCurrentUser ? 'none' : '1px solid #e9ecef'};">
            <div style="font-weight:600; font-size:11px; margin-bottom:6px; opacity:0.8; text-transform:uppercase; letter-spacing:0.5px;">
                ${isCurrentUser ? 'Tú' : userName}
            </div>
            <div style="line-height:1.4; word-wrap:break-word;">${message}</div>
            <div style="font-size:10px; margin-top:8px; opacity:0.7;">
                ${timeStr}
            </div>
        </div>
    `;

                chatBody.appendChild(msgDiv);
                scrollToBottom();
            }

            function displaySystemMessage(message) {
                const msgDiv = document.createElement('div');
                msgDiv.style.textAlign = 'center';
                msgDiv.style.margin = '15px 10px';
                msgDiv.style.padding = '12px';
                msgDiv.style.background = 'linear-gradient(135deg, #fff3cd, #ffeaa7)';
                msgDiv.style.border = '1px solid #ffeaa7';
                msgDiv.style.borderRadius = '12px';
                msgDiv.style.fontSize = '13px';
                msgDiv.style.color = '#856404';
                msgDiv.innerHTML = `<i class="fas fa-info-circle me-2"></i>${message}`;

                chatBody.appendChild(msgDiv);
                scrollToBottom();
            }

            function scrollToBottom() {
                chatBody.scrollTop = chatBody.scrollHeight;
            }

            function formatTime(timeString) {
                if (!timeString) return '';

                const date = new Date(timeString);
                const now = new Date();
                const diffMinutes = Math.floor((now - date) / (1000 * 60));

                if (diffMinutes < 1) return 'Ahora';
                if (diffMinutes < 60) return `${diffMinutes}m`;

                const diffHours = Math.floor(diffMinutes / 60);
                if (diffHours < 24) return `${diffHours}h`;

                const diffDays = Math.floor(diffHours / 24);
                if (diffDays < 7) return `${diffDays}d`;

                return date.toLocaleDateString('es-ES', {
                    day: '2-digit',
                    month: '2-digit'
                });
            }

            function checkForNewMessages() {
                if (currentView === 'list') {
                    loadConversations();
                } else if (currentConversationId) {
                    // Verificar solo la conversación actual
                    fetch(`/chat/check-new-messages/${currentConversationId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.hasNewMessages) {
                                loadMessages(currentConversationId);
                            }
                        })
                        .catch(error => console.error('Error checking new messages:', error));
                }
            }

        </script>
    </main>
    <footer class="bg-dark py-4 mt-auto">
        <div class="container px-5">
            <p class="m-0 text-center text-white">Proyecto Desarrollo web 2 &copy; MiRefugio 2025</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/scripts.js"></script>
</body>

</html>