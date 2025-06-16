<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content />
    <meta name="author" content />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Paciente / MiRefugio</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .question-container {
            min-height: 200px;
        }

        .option-btn {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .option-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .option-btn.selected {
            border-color: #0d6efd;
            background-color: #e7f3ff;
        }

        .progress-bar {
            transition: width 0.3s ease;
        }

        .mood-result {
            transition: all 0.5s ease;
        }

        .celebration {
            animation: celebration 0.6s ease-in-out;
        }

        @keyframes celebration {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }
    </style>
</head>

<body class="d-flex flex-column">
    <main class="flex-shrink-0">
        <!-- Navigation-->
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

        <!-- Page content-->
        <section class="py-5">
            <div class="container px-5">
                <div class="bg-light rounded-3 py-5 px-4 px-md-5 mb-5">
                    <div class="text-center mb-5">
                        <div class="feature bg-info bg-gradient text-white rounded-3 mb-3">
                            <i class="bi bi-person"></i>
                        </div>
                        <h1 class="fw-bolder">{{ Auth::user()->name }}</h1>
                        <p class="lead fw-normal text-muted mb-0">Bienvenido a MiRefugio </p>
                    </div>

                    <!-- Estadísticas principales -->
                    <div class="row gx-5 mb-5">
                        <div class="col-lg-3 mb-4">
                            <div class="card h-100 shadow border-0 bg-primary text-white">
                                <div class="card-body p-4 text-center">
                                    <div class="d-flex justify-content-center mb-3">
                                        <i class="fas fa-users fa-2x"></i>
                                    </div>
                                    <h3 class="fw-bold mb-0">{{ \App\Models\User::count() }}</h3>
                                    <p class="mb-0">Usuarios registrados</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 mb-4">
                            <div class="card h-100 shadow border-0 bg-info text-white">
                                <div class="card-body p-4 text-center">
                                    <div class="d-flex justify-content-center mb-3">
                                        <i class="fas fa-file-alt fa-2x"></i>
                                    </div>
                                    <h3 class="fw-bold mb-0">10</h3>
                                    <p class="mb-0">Contenido de apoyo</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 mb-4">
                            <div class="card h-100 shadow border-0 bg-warning text-white">
                                <div class="card-body p-4 text-center">
                                    <div class="d-flex justify-content-center mb-3">
                                        <i class="fas fa-laptop fa-2x"></i>
                                    </div>
                                    <h3 class="fw-bold mb-0">Virtual</h3>
                                    <p class="mb-0">Modalidades de apoyo</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 mb-4">
                            <div class="card h-100 shadow border-0 bg-success text-white mood-result" id="moodCard">
                                <div class="card-body p-4 text-center">
                                    <div class="d-flex justify-content-center mb-3">
                                        <i class="fas fa-smile fa-2x" id="moodIcon"></i>
                                    </div>
                                    <h3 class="fw-bold mb-0" id="moodScore">4.5</h3>
                                    <p class="mb-0">Estado de ánimo</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Vista 1 - Tarjeta con enlace dinámico -->
                    <div class="row gx-5 mb-4">
                        <div class="col-lg-6 mb-4">
                            <div class="card h-100 shadow border-0">
                                <div class="card-body p-4">
                                    <div class="badge bg-success bg-gradient rounded-pill mb-2">Sesiones</div>
                                    <h5 class="card-title mb-3" id="tituloSesion">Sesiones Virtuales</h5>
                                    <p class="card-text mb-3">Accede a tus sesiones terapéuticas en línea con tu
                                        psicólogo asignado.</p>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-1"><i class="bi bi-check text-success me-2"></i>Videollamadas
                                            seguras</li>
                                        <li class="mb-1"><i class="bi bi-check text-success me-2"></i>Recordatorios
                                            automáticos</li>
                                        <li class="mb-1"><i class="bi bi-check text-success me-2"></i>Encuentros
                                            puntuales</li>
                                    </ul>
                                </div>
                                <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                                    <div class="d-flex align-items-end justify-content-between">
                                        <button class="btn btn-success btn-sm" id="btnAccederPaciente">
                                            <span class="spinner-border spinner-border-sm me-2 d-none"
                                                id="spinnerCarga"></span>
                                            Acceder
                                        </button>
                                        <span class="text-muted small">Próxima: 14:00</span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                // Cargar enlace dinámico al cargar la página
                                cargarEnlaceDinamico();

                                // Actualizar enlace cada 30 segundos
                                setInterval(cargarEnlaceDinamico, 30000);

                                // Manejar clic en botón acceder
                                document.getElementById('btnAccederPaciente').addEventListener('click', function () {
                                    abrirSesion();
                                });

                                function cargarEnlaceDinamico() {
                                    const spinner = document.getElementById('spinnerCarga');
                                    const boton = document.getElementById('btnAccederPaciente');

                                    // Mostrar spinner
                                    spinner.classList.remove('d-none');
                                    boton.disabled = true;

                                    fetch('/api/enlace-sesion/activo')
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                // Actualizar enlace en el botón
                                                boton.setAttribute('data-enlace', data.enlace);

                                                // Actualizar título si es necesario
                                                if (data.nombre && data.nombre !== 'Sesión Virtual') {
                                                    document.getElementById('tituloSesion').textContent = data.nombre;
                                                }

                                                // Opcional: mostrar indicador de enlace actualizado
                                                mostrarIndicadorActualizado();
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error al cargar enlace dinámico:', error);
                                            // Mantener enlace por defecto si hay error
                                            boton.setAttribute('data-enlace', 'https://meet.google.com/iqh-ivmz-mrv');
                                        })
                                        .finally(() => {
                                            // Ocultar spinner
                                            spinner.classList.add('d-none');
                                            boton.disabled = false;
                                        });
                                }

                                function abrirSesion() {
                                    const enlace = document.getElementById('btnAccederPaciente').getAttribute('data-enlace');
                                    if (enlace) {
                                        window.open(enlace, '_blank');
                                    } else {
                                        // Enlace por defecto como fallback
                                        window.open('https://meet.google.com/iqh-ivmz-mrv', '_blank');
                                    }
                                }

                                function mostrarIndicadorActualizado() {
                                    const boton = document.getElementById('btnAccederPaciente');
                                    const originalText = boton.innerHTML;

                                    // Mostrar indicador temporal
                                    boton.innerHTML = '<i class="bi bi-check-circle me-1"></i>Actualizado';
                                    boton.classList.add('btn-outline-success');
                                    boton.classList.remove('btn-success');

                                    // Restaurar estado original después de 2 segundos
                                    setTimeout(() => {
                                        boton.innerHTML = originalText;
                                        boton.classList.remove('btn-outline-success');
                                        boton.classList.add('btn-success');
                                    }, 2000);
                                }
                            });
                        </script>

                        <div class="col-lg-6 mb-4">
                            <div class="card h-100 shadow border-0">
                                <div class="card-body p-4">
                                    <div class="badge bg-info bg-gradient rounded-pill mb-2">Apoyo</div>
                                    <h5 class="card-title mb-3">Chat de Apoyo</h5>
                                    <p class="card-text mb-3">Conéctate con un profesional para apoyo emocional
                                        inmediato cuando lo necesites.</p>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-1"><i class="bi bi-clock text-info me-2"></i>Horario: 7am-12pm y
                                            2:00pm a 6:00pm</li>
                                        <li class="mb-1"><i class="bi bi-chat-dots text-info me-2"></i>Respuesta en
                                            minutos</li>
                                        <li class="mb-1"><i class="bi bi-shield-lock text-info me-2"></i>Confidencial
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                                    <div class="d-flex align-items-end justify-content-between">
                                        <button class="btn btn-info btn-sm chat-toggle-btn">Iniciar Chat</button>
                                        <span class="badge bg-success chat-status">En línea</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjetas de funcionalidades - SEGUNDA FILA -->
                    <div class="row gx-5 mb-5">
                        <div class="col-lg-6 mb-5">
                            <div class="card h-100 shadow border-0">
                                <div class="card-body p-4">
                                    <div class="badge bg-warning bg-gradient rounded-pill mb-2">Bienestar</div>
                                    <h5 class="card-title mb-3">Recursos de Bienestar</h5>
                                    <p class="card-text mb-3">Herramientas y ejercicios para tu autocuidado y desarrollo
                                        personal.</p>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-1"><i class="bi bi-book text-warning me-2"></i>Guías de autoayuda
                                        </li>
                                        <li class="mb-1"><i class="bi bi-headphones text-warning me-2"></i>Meditaciones
                                            guiadas</li>
                                        <li class="mb-1"><i class="bi bi-activity text-warning me-2"></i>Ejercicios
                                            prácticos</li>
                                    </ul>
                                </div>
                                <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div class="dropdown">
                                            <button class="btn btn-warning btn-sm dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown">
                                                Explorar
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" onclick="mostrarRecurso('guias')">Guías de
                                                        autoayuda</a></li>
                                                <li><a class="dropdown-item"
                                                        onclick="mostrarRecurso('meditaciones')">Meditaciones
                                                        guiadas</a></li>
                                                <li><a class="dropdown-item"
                                                        onclick="mostrarRecurso('ejercicios')">Ejercicios prácticos</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <span class="text-muted small">15+ recursos</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-4">
                            <div class="card h-100 shadow border-0">
                                <div class="card-body p-4">
                                    <div class="badge bg-primary bg-gradient rounded-pill mb-2">Seguimiento</div>
                                    <h5 class="card-title mb-3">Registro Diario</h5>
                                    <p class="card-text mb-3">Lleva un registro de tu estado emocional y actividades
                                        diarias.</p>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-1"><i class="bi bi-emoji-smile text-primary me-2"></i>Estado de
                                            ánimo</li>
                                        <li class="mb-1"><i class="bi bi-journal-text text-primary me-2"></i>Notas
                                            personales</li>
                                        <li class="mb-1"><i class="bi bi-graph-up text-primary me-2"></i>Progreso
                                            mensual</li>
                                    </ul>
                                </div>
                                <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                                    <div class="d-flex align-items-end justify-content-between">
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#registroModal">
                                            Registrar Hoy
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Contenedor para mostrar el recurso seleccionado -->
                    <div id="contenedor-recursos" class="mt-4 d-none">
                        <div class="card shadow border-0">
                            <div class="card-body p-4">
                                <button class="btn btn-sm btn-outline-secondary mb-3" onclick="ocultarRecurso()">
                                    <i class="bi bi-arrow-left"></i> Volver
                                </button>
                                <div id="contenido-recurso"></div>
                            </div>
                        </div>
                    </div>
                    <script>
                        // Definir los recursos disponibles para cada categoría
                        const recursos = {
                            guias: [
                                { nombre: 'Guía de Manejo del Estrés', archivo: 'guia1.pdf' },
                                { nombre: 'Técnicas de Relajación', archivo: 'guia2.pdf' },
                                { nombre: 'Mindfulness Básico', archivo: 'guia3.pdf' },
                                { nombre: 'Autoestima y Confianza', archivo: 'guia4.pdf' }
                            ],
                            meditaciones: [
                                { nombre: 'Meditación para Principiantes', archivo: 'meditacion1.mp3' },
                                { nombre: 'Relajación Profunda', archivo: 'meditacion2.mp3' },
                                { nombre: 'Mindfulness Diario', archivo: 'meditacion3.mp3' },
                                { nombre: 'Meditación para Dormir', archivo: 'meditacion4.mp3' }
                            ],
                            ejercicios: [
                                'Respiración profunda (5 minutos)',
                                'Estiramiento de cuello (2 series)',
                                'Escritura emocional (1 página)',
                                'Técnica de grounding 5-4-3-2-1',
                                'Ejercicio de gratitud diaria',
                                'Relajación muscular progresiva'
                            ]
                        };

                        function mostrarRecurso(tipo) {
                            const contenedor = document.getElementById('contenedor-recursos');
                            const contenido = document.getElementById('contenido-recurso');

                            // Ocultar menú dropdown
                            const dropdown = document.querySelector('.dropdown-menu');
                            if (dropdown) {
                                dropdown.classList.remove('show');
                            }

                            // Mostrar contenedor
                            contenedor.classList.remove('d-none');

                            // Cargar contenido según el tipo
                            if (tipo === 'guias') {
                                contenido.innerHTML = `
                                    <h5><i class="bi bi-book text-warning me-2"></i>Guías de autoayuda</h5>
                                    
                                    <!-- Navegación por pestañas -->
                                    <ul class="nav nav-tabs" id="guias-tabs" role="tablist">
                                        ${recursos.guias.map((guia, index) => `
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link ${index === 0 ? 'active' : ''}" 
                                                        id="guia-${index}-tab" 
                                                        data-bs-toggle="tab" 
                                                        data-bs-target="#guia-${index}" 
                                                        type="button" 
                                                        role="tab"
                                                        aria-controls="guia-${index}"
                                                        aria-selected="${index === 0 ? 'true' : 'false'}">
                                                    ${guia.nombre}
                                                </button>
                                            </li>
                                        `).join('')}
                                    </ul>
                                    
                                    <!-- Contenido de las pestañas -->
                                    <div class="tab-content mt-3" id="guias-content">
                                        ${recursos.guias.map((guia, index) => `
                                            <div class="tab-pane fade ${index === 0 ? 'show active' : ''}" 
                                                id="guia-${index}" 
                                                role="tabpanel"
                                                aria-labelledby="guia-${index}-tab">
                                                <iframe src="/recursos/guias/${guia.archivo}#toolbar=0&navpanes=0" 
                                                        width="100%" 
                                                        height="600px" 
                                                        style="border: none;"
                                                        loading="lazy">
                                                </iframe>
                                                <p class="text-muted small mt-2">
                                                    Usa los controles del visor para navegar. 
                                                    <span class="text-danger">*No disponible para descarga.</span>
                                                </p>
                                            </div>
                                        `).join('')}
                                    </div>
                                `;
                            }
                            else if (tipo === 'meditaciones') {
                                contenido.innerHTML = `
                                    <h5><i class="bi bi-headphones text-warning me-2"></i>Meditaciones guiadas</h5>
                                    
                                    <!-- Navegación por pestañas -->
                                    <ul class="nav nav-tabs" id="meditaciones-tabs" role="tablist">
                                        ${recursos.meditaciones.map((meditacion, index) => `
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link ${index === 0 ? 'active' : ''}" 
                                                        id="meditacion-${index}-tab" 
                                                        data-bs-toggle="tab" 
                                                        data-bs-target="#meditacion-${index}" 
                                                        type="button" 
                                                        role="tab"
                                                        aria-controls="meditacion-${index}"
                                                        aria-selected="${index === 0 ? 'true' : 'false'}">
                                                    ${meditacion.nombre}
                                                </button>
                                            </li>
                                        `).join('')}
                                    </ul>
                                    
                                    <!-- Contenido de las pestañas -->
                                    <div class="tab-content mt-3" id="meditaciones-content">
                                        ${recursos.meditaciones.map((meditacion, index) => `
                                            <div class="tab-pane fade ${index === 0 ? 'show active' : ''}" 
                                                id="meditacion-${index}" 
                                                role="tabpanel"
                                                aria-labelledby="meditacion-${index}-tab">
                                                <div class="text-center p-4">
                                                    <h6 class="mb-3">${meditacion.nombre}</h6>
                                                    <audio controls class="w-100" style="max-width: 500px;" preload="none">
                                                        <source src="/recursos/meditaciones/${meditacion.archivo}" type="audio/mpeg">
                                                        Tu navegador no soporta el elemento de audio.
                                                    </audio>
                                                </div>
                                            </div>
                                        `).join('')}
                                    </div>
                                `;
                            }
                            else if (tipo === 'ejercicios') {
                                contenido.innerHTML = `
                                    <h5><i class="bi bi-activity text-warning me-2"></i>Ejercicios prácticos</h5>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                ${recursos.ejercicios.map((ejercicio, index) => `
                                                    <div class="col-md-6 mb-3">
                                                        <div class="d-flex align-items-start">
                                                            <span class="badge bg-primary me-2 mt-1">${index + 1}</span>
                                                            <span>${ejercicio}</span>
                                                        </div>
                                                    </div>
                                                `).join('')}
                                            </div>
                                        </div>
                                    </div>
                                `;
                            }
                        }

                        function ocultarRecurso() {
                            const contenedor = document.getElementById('contenedor-recursos');
                            if (contenedor) {
                                contenedor.classList.add('d-none');
                            }

                            // Pausar todos los audios que puedan estar reproduciéndose
                            const audios = document.querySelectorAll('audio');
                            audios.forEach(audio => {
                                audio.pause();
                                audio.currentTime = 0;
                            });
                        }

                        // Función adicional para agregar más recursos fácilmente
                        function agregarRecurso(tipo, recurso) {
                            if (recursos[tipo]) {
                                recursos[tipo].push(recurso);
                            }
                        }

                        // Función para obtener la lista de recursos de un tipo
                        function obtenerRecursos(tipo) {
                            return recursos[tipo] || [];
                        }
                    </script>

                    <!-- Modal de Registro -->
                    <div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="registroModalLabel">
                                        <i class="bi bi-journal-text me-2"></i>Registro Diario
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Barra de Progreso -->
                                    <div class="mb-4">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-muted">Progreso</span>
                                            <span class="text-muted"><span id="currentQuestion">1</span>/10</span>
                                        </div>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 10%"
                                                id="progressBar"></div>
                                        </div>
                                    </div>

                                    <!-- Contenedor de Preguntas -->
                                    <div class="question-container" id="questionContainer">
                                        <!-- Las preguntas se generarán dinámicamente -->
                                    </div>

                                    <!-- Botones de Navegación -->
                                    <div class="d-flex justify-content-between mt-4">
                                        <button class="btn btn-outline-secondary" id="prevBtn" style="display: none;">
                                            <i class="bi bi-arrow-left me-1"></i>Anterior
                                        </button>
                                        <button class="btn btn-primary ms-auto" id="nextBtn" style="display: none;">
                                            Siguiente<i class="bi bi-arrow-right ms-1"></i>
                                        </button>
                                        <button class="btn btn-success ms-auto" id="finishBtn" style="display: none;">
                                            <i class="bi bi-check-circle me-1"></i>Finalizar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <script>
                        class MoodTracker {
                            constructor() {
                                this.questions = [
                                    "¿Cómo te sientes físicamente hoy?",
                                    "¿Qué tal tu nivel de energía?",
                                    "¿Cómo ha sido tu estado de ánimo general?",
                                    "¿Qué tal tu concentración en las tareas?",
                                    "¿Cómo han sido tus relaciones sociales hoy?",
                                    "¿Qué tal tu calidad de sueño anoche?",
                                    "¿Cómo te sientes con respecto a tus logros del día?",
                                    "¿Qué tal tu nivel de estrés?",
                                    "¿Cómo ha sido tu apetito hoy?",
                                    "¿Qué tan optimista te sientes sobre mañana?"
                                ];

                                this.options = [
                                    { text: "No muy bien", value: 0.1, class: "btn-outline-danger" },
                                    { text: "Aceptable", value: 0.3, class: "btn-outline-warning" },
                                    { text: "De maravilla", value: 0.5, class: "btn-outline-success" }
                                ];

                                this.currentQuestionIndex = 0;
                                this.answers = [];
                                this.selectedAnswer = null;

                                this.init();
                            }

                            init() {
                                this.bindEvents();
                                this.showQuestion();
                            }

                            bindEvents() {
                                document.getElementById('prevBtn').addEventListener('click', () => this.previousQuestion());
                                document.getElementById('nextBtn').addEventListener('click', () => this.nextQuestion());
                                document.getElementById('finishBtn').addEventListener('click', () => this.finishSurvey());

                                // Reset cuando se abre el modal
                                document.getElementById('registroModal').addEventListener('show.bs.modal', () => {
                                    this.resetSurvey();
                                });
                            }

                            resetSurvey() {
                                this.currentQuestionIndex = 0;
                                this.answers = [];
                                this.selectedAnswer = null;
                                this.updateProgress();
                                this.showQuestion();
                            }

                            showQuestion() {
                                const container = document.getElementById('questionContainer');
                                const question = this.questions[this.currentQuestionIndex];

                                container.innerHTML = `
            <div class="fade-in">
                <h5 class="mb-4 text-center">${question}</h5>
                <div class="row g-3">
                    ${this.options.map((option, index) => `
                        <div class="col-12">
                            <button class="btn ${option.class} option-btn w-100 p-3" 
                                    data-value="${option.value}" 
                                    data-index="${index}">
                                <i class="me-2 ${this.getOptionIcon(index)}"></i>
                                ${option.text}
                            </button>
                        </div>
                    `).join('')}
                </div>
            </div>
        `;

                                // Restaurar selección previa si existe
                                if (this.answers[this.currentQuestionIndex] !== undefined) {
                                    const savedIndex = this.options.findIndex(opt => opt.value === this.answers[this.currentQuestionIndex]);
                                    if (savedIndex !== -1) {
                                        this.selectOption(savedIndex, this.answers[this.currentQuestionIndex]);
                                    }
                                }

                                // Bind eventos a las opciones
                                container.querySelectorAll('.option-btn').forEach(btn => {
                                    btn.addEventListener('click', (e) => {
                                        const value = parseFloat(e.target.dataset.value);
                                        const index = parseInt(e.target.dataset.index);
                                        this.selectOption(index, value);
                                    });
                                });

                                this.updateButtons();
                                this.updateProgress();
                            }

                            getOptionIcon(index) {
                                const icons = ['fas fa-frown', 'fas fa-meh', 'fas fa-smile'];
                                return icons[index] || 'fas fa-circle';
                            }

                            selectOption(index, value) {
                                // Remover selección previa
                                document.querySelectorAll('.option-btn').forEach(btn => {
                                    btn.classList.remove('selected');
                                });

                                // Agregar selección actual
                                document.querySelectorAll('.option-btn')[index].classList.add('selected');

                                this.selectedAnswer = value;
                                this.answers[this.currentQuestionIndex] = value;

                                // Mostrar botón siguiente después de seleccionar
                                setTimeout(() => {
                                    this.updateButtons();
                                }, 300);
                            }

                            updateButtons() {
                                const prevBtn = document.getElementById('prevBtn');
                                const nextBtn = document.getElementById('nextBtn');
                                const finishBtn = document.getElementById('finishBtn');

                                // Botón anterior
                                prevBtn.style.display = this.currentQuestionIndex > 0 ? 'block' : 'none';

                                // Botón siguiente/finalizar
                                if (this.answers[this.currentQuestionIndex] !== undefined) {
                                    if (this.currentQuestionIndex < this.questions.length - 1) {
                                        nextBtn.style.display = 'block';
                                        finishBtn.style.display = 'none';
                                    } else {
                                        nextBtn.style.display = 'none';
                                        finishBtn.style.display = 'block';
                                    }
                                } else {
                                    nextBtn.style.display = 'none';
                                    finishBtn.style.display = 'none';
                                }
                            }

                            updateProgress() {
                                const progress = ((this.currentQuestionIndex + 1) / this.questions.length) * 100;
                                document.getElementById('progressBar').style.width = progress + '%';
                                document.getElementById('currentQuestion').textContent = this.currentQuestionIndex + 1;
                            }

                            previousQuestion() {
                                if (this.currentQuestionIndex > 0) {
                                    this.currentQuestionIndex--;
                                    this.showQuestion();
                                }
                            }

                            nextQuestion() {
                                if (this.currentQuestionIndex < this.questions.length - 1 && this.answers[this.currentQuestionIndex] !== undefined) {
                                    this.currentQuestionIndex++;
                                    this.showQuestion();
                                }
                            }

                            finishSurvey() {
                                // Calcular puntuación con validación
                                const totalScore = this.answers.reduce((sum, answer) => sum + answer, 0);
                                const percentage = (totalScore / (this.questions.length * 0.5)) * 100;
                                let finalScore = (percentage / 100) * 10; // Escala de 0-10

                                // Asegurar que el score esté en el rango correcto
                                finalScore = Math.min(10, Math.max(0, finalScore));

                                if (isNaN(finalScore)) {
                                    console.error("Error en cálculo de score:", { totalScore, percentage, answers: this.answers });
                                    finalScore = 0;
                                }

                                // Actualizar la card de resultado primero
                                this.updateMoodCard(finalScore);

                                // Mostrar mensaje de éxito
                                this.showSuccessMessage(finalScore);

                                // Cerrar modal después de un breve retraso
                                setTimeout(() => {
                                    const modal = bootstrap.Modal.getInstance(document.getElementById('registroModal'));
                                    if (modal) {
                                        modal.hide();
                                    }

                                    // Recargar la página después de 1 segundo (1000ms)
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 1000);
                                }, 1000);
                            }

                            updateMoodCard(score) {
                                // Guardar el score en localStorage antes de actualizar la UI
                                localStorage.setItem('lastMoodScore', score);

                                const moodCard = document.getElementById('moodCard');
                                const moodScore = document.getElementById('moodScore');
                                const moodIcon = document.getElementById('moodIcon');

                                if (!moodCard || !moodScore || !moodIcon) {
                                    console.error("Elementos del mood card no encontrados");
                                    return;
                                }

                                // Actualizar puntuación
                                moodScore.textContent = score.toFixed(1);

                                // Cambiar color y icono según puntuación
                                moodCard.classList.remove('bg-success', 'bg-warning', 'bg-danger');

                                if (score >= 7) {
                                    moodCard.classList.add('bg-success');
                                    moodIcon.className = 'fas fa-smile fa-2x';
                                } else if (score >= 4) {
                                    moodCard.classList.add('bg-warning');
                                    moodIcon.className = 'fas fa-meh fa-2x';
                                } else {
                                    moodCard.classList.add('bg-danger');
                                    moodIcon.className = 'fas fa-frown fa-2x';
                                }

                                // Animación de celebración
                                moodCard.classList.add('celebration');
                                setTimeout(() => {
                                    moodCard.classList.remove('celebration');
                                }, 600);
                            }

                            showSuccessMessage(score) {
                                const message = score >= 7 ? '¡Excelente día!' :
                                    score >= 4 ? '¡Día regular, puedes mejorar!' :
                                        '¡Mañana será mejor!';

                                // Crear toast de Bootstrap
                                const toastHtml = `
            <div class="toast align-items-center text-white bg-primary border-0" role="alert" data-bs-autohide="true" data-bs-delay="5000">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-check-circle me-2"></i>
                        Registro completado. ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;

                                // Agregar toast al DOM
                                const toastContainer = document.createElement('div');
                                toastContainer.classList.add('position-fixed', 'top-0', 'end-0', 'p-3');
                                toastContainer.style.zIndex = '1055';
                                toastContainer.innerHTML = toastHtml;
                                document.body.appendChild(toastContainer);

                                // Inicializar y mostrar toast
                                const toastEl = toastContainer.querySelector('.toast');
                                const toast = new bootstrap.Toast(toastEl, {
                                    autohide: true,
                                    delay: 5000
                                });
                                toast.show();

                                // Limpiar después de ocultar
                                toastEl.addEventListener('hidden.bs.toast', () => {
                                    document.body.removeChild(toastContainer);
                                });
                            }
                        }

                        document.addEventListener('DOMContentLoaded', () => {
                            if (typeof bootstrap !== 'undefined' && bootstrap.Toast) {
                                new MoodTracker();

                                // Cargar último score si existe
                                const lastScore = localStorage.getItem('lastMoodScore');
                                if (lastScore) {
                                    const moodScore = document.getElementById('moodScore');
                                    if (moodScore) {
                                        moodScore.textContent = parseFloat(lastScore).toFixed(1);
                                    }
                                }
                            } else {
                                console.error("Bootstrap no está cargado correctamente");
                            }
                        });
                    </script>
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
                    <strong>Chat de Apoyo Psicológico</strong>
                    <div style="font-size:12px; opacity:0.9;">Conectado con psicólogo</div>
                </div>
                <div class="chat-controls" style="display:flex; gap:10px;">
                    <button class="chat-clear" title="Vaciar conversación"
                        style="background:none; border:none; color:white; font-size:16px; cursor:pointer; opacity:0.8; transition:all 0.3s;"
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

            <!-- Vista de Chat Individual -->
            <div class="chat-view" style="height:calc(100% - 70px); display:flex; flex-direction:column;">
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


        <footer class="bg-dark py-4 mt-auto">
            <div class="container px-5">
                <p class="m-0 text-center text-white">Proyecto Desarrollo web 2 &copy; MiRefugio 2025</p>
            </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                let currentConversationId = null;
                let isLoading = false;

                // Elementos del DOM
                const chatWidget = document.querySelector('.chat-widget');
                const chatToggle = document.querySelector('.chat-toggle');
                const chatToggleBtn = document.querySelector('.chat-toggle-btn');
                const chatClose = document.querySelector('.chat-close');
                const chatClear = document.querySelector('.chat-clear');
                const chatBody = document.querySelector('.chat-body');
                const chatInput = document.querySelector('.chat-input');
                const chatSend = document.querySelector('.chat-send');

                // Función para mostrar alertas con SweetAlert2
                function showAlert(type, title, message) {
                    Swal.fire({
                        icon: type,
                        title: title,
                        text: message,
                        timer: 3000,
                        showConfirmButton: false
                    });
                }

                // Event listeners para el chat
                chatToggle.addEventListener('click', toggleChat);
                chatToggleBtn.addEventListener('click', toggleChat);
                chatClose.addEventListener('click', closeChat);
                chatClear.addEventListener('click', clearConversation);
                chatSend.addEventListener('click', sendMessage);
                chatInput.addEventListener('keypress', function (e) {
                    if (e.key === 'Enter' && !e.shiftKey) {
                        e.preventDefault();
                        sendMessage();
                    }
                });

                // Event listeners para botones de estado de ánimo
                const moodButtons = document.querySelectorAll('.mood-btn');
                moodButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        // Remover clase activa de todos los botones
                        moodButtons.forEach(btn => btn.classList.remove('active'));
                        // Agregar clase activa al botón seleccionado
                        this.classList.add('active');

                        const mood = this.dataset.mood;
                        console.log('Estado de ánimo seleccionado:', mood);
                        // Aquí puedes enviar el estado de ánimo al servidor
                    });
                });

                // Event listeners para ejercicios rápidos
                const exerciseCards = document.querySelectorAll('.hover-shadow');
                exerciseCards.forEach(card => {
                    card.addEventListener('mouseenter', function () {
                        this.style.transform = 'translateY(-5px)';
                        this.style.boxShadow = '0 4px 15px rgba(0,0,0,0.1)';
                    });

                    card.addEventListener('mouseleave', function () {
                        this.style.transform = 'translateY(0)';
                        this.style.boxShadow = 'none';
                    });

                    card.addEventListener('click', function () {
                        const exerciseName = this.querySelector('h6').textContent;
                        console.log('Ejercicio seleccionado:', exerciseName);
                        // Aquí puedes abrir el ejercicio específico
                    });
                });

                // Verificar si hay conversación existente al cargar
                checkExistingConversation();

                function toggleChat() {
                    if (chatWidget.style.display === 'none' || !chatWidget.style.display) {
                        showChat();
                    } else {
                        closeChat();
                    }
                }

                function showChat() {
                    chatWidget.style.display = 'block';
                    chatToggle.style.display = 'none';
                    chatInput.focus();

                    if (currentConversationId) {
                        loadMessages();
                    }
                }

                function closeChat() {
                    chatWidget.style.display = 'none';
                    chatToggle.style.display = 'block';
                }

                // FUNCIÓN MEJORADA: Vaciar conversación con SweetAlert2
                function clearConversation() {
                    if (!currentConversationId) {
                        // Usar SweetAlert2 para mensaje informativo
                        Swal.fire({
                            icon: 'info',
                            title: 'Sin conversación',
                            text: 'No hay conversación activa para eliminar.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        return;
                    }

                    // Confirmar la acción con estilo mejorado
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
                        cancelButtonText: '<i class="fas fa-times me-2"></i>Cancelar',
                        background: '#fff',
                        customClass: {
                            popup: 'animated fadeIn',
                            confirmButton: 'btn-lg',
                            cancelButton: 'btn-lg'
                        },
                        buttonsStyling: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Mostrar loading mientras se elimina
                            Swal.fire({
                                title: 'Eliminando conversación...',
                                html: '<i class="fas fa-spinner fa-spin fa-2x"></i>',
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            });

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
                                        // Limpiar el chat visualmente
                                        chatBody.innerHTML = '';

                                        // Mostrar mensaje de éxito
                                        Swal.fire({
                                            icon: 'success',
                                            title: '¡Conversación eliminada!',
                                            text: 'Todos los mensajes han sido eliminados exitosamente.',
                                            timer: 2000,
                                            showConfirmButton: false,
                                            customClass: {
                                                popup: 'animated fadeIn'
                                            }
                                        });

                                        // Mostrar mensaje de bienvenida después de un momento
                                        setTimeout(() => {
                                            displaySystemMessage('¡Hola! ¿En qué puedo ayudarte hoy?');
                                        }, 2000);
                                    } else {
                                        showAlert('error', 'Error', 'No se pudo eliminar la conversación. Por favor, intenta de nuevo.');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    showAlert('error', 'Error', 'Ocurrió un error inesperado. Por favor, intenta de nuevo.');
                                });
                        }
                    });
                }

                function checkExistingConversation() {
                    fetch('/chat/conversation')
                        .then(response => response.json())
                        .then(data => {
                            if (data.conversation) {
                                currentConversationId = data.conversation.id;
                                document.querySelector('.chat-status').style.display = 'inline';
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }

                function sendMessage() {
                    const message = chatInput.value.trim();

                    if (message === '' || isLoading) return;

                    isLoading = true;
                    chatSend.disabled = true;

                    // Mostrar mensaje del usuario inmediatamente
                    displayMessage(message, {{ auth()->id() ?? 0 }}, 'Tú');
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
                        .then(response => {
                            if (!response.ok) throw new Error('Error en la respuesta');
                            return response.json();
                        })
                        .then(data => {
                            if (data.conversation_id) {
                                currentConversationId = data.conversation_id;
                                document.querySelector('.chat-status').style.display = 'inline';
                            }
                            displayMessages(data.messages);
                            chatInput.focus();
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showAlert('error', 'Error', 'No se pudo enviar el mensaje. Por favor, intenta de nuevo.');
                        })
                        .finally(() => {
                            isLoading = false;
                            chatSend.disabled = false;
                        });
                }

                function loadMessages() {
                    if (!currentConversationId) return;

                    fetch(`/chat/messages?conversation_id=${currentConversationId}`)
                        .then(response => response.json())
                        .then(data => displayMessages(data.messages))
                        .catch(error => console.error('Error:', error));
                }

                function displayMessages(messages) {
                    chatBody.innerHTML = '';

                    messages.forEach(msg => {
                        displayMessage(msg.message, msg.user_id, msg.user_name, msg.created_at);
                    });

                    scrollToBottom();
                }

                function displayMessage(message, userId, userName, time = null) {
                    const msgDiv = document.createElement('div');
                    const isCurrentUser = userId === {{ auth()->id() ?? 0 }};

                    msgDiv.style.marginBottom = '15px';
                    msgDiv.style.textAlign = isCurrentUser ? 'right' : 'left';

                    const timeStr = time || new Date().toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });

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
                    if (!chatBody) return;

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

                // Agregar mensaje de bienvenida si no hay conversación
                if (!currentConversationId) {
                    setTimeout(() => {
                        displaySystemMessage('¡Hola! Soy tu psicólogo de apoyo. ¿En qué puedo ayudarte hoy?');
                    }, 1000);
                }
            });
        </script>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>

</html>