<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Mi Refugio</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body class="d-flex flex-column h-100">
    <main class="flex-shrink-0">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container px-5">
                <a class="navbar-brand" href="{{ route('home') }}">Mi Refugio</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation"><span
                        class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">Quienes Somos</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contactanos</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('faq') }}">Servicios</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <header class="bg-dark py-5">
            <div class="container px-5">
                <div class="row gx-5 align-items-center justify-content-center">
                    <div class="col-lg-8 col-xl-7 col-xxl-6">
                        <div class="my-5 text-center text-xl-start">
                            <h1 class="display-5 fw-bolder text-white mb-2">Bienvenido a <br>Mi Refugio</h1>
                            <p class="lead fw-normal text-white-50 mb-4">Construyendo un camino hacia el bienestar y el
                                crecimiento personal. La adolescencia es una etapa de grandes cambios y descubrimientos.
                                En mi refugio te acompañamos en este viaje.</p>
                            <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start">
                                <a class="btn btn-primary btn-lg px-4 me-sm-3" href="{{ route('login') }}">Iniciar
                                    Sesion</a>
                                <a class="btn btn-outline-light btn-lg px-4"
                                    href="{{ route('register') }}">Resgistrarse</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center">
                        <div class="rounded-3 my-5 overflow-hidden">
                            <iframe width="600" height="400" src="https://www.youtube.com/embed/VgV0wC_cg74"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <section class="py-5" id="features">
            <div class="container px-5 my-5">
                <div class="row gx-5">
                    <div class="col-lg-4 mb-5 mb-lg-0">
                        <h2 class="fw-bolder mb-0">Tu bienestar emocional empieza aquí.</h2>
                    </div>
                    <div class="col-lg-8">
                        <div class="row gx-5 row-cols-1 row-cols-md-2">
                            <div class="col mb-5 h-100">
                                <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i
                                        class="bi bi-collection"></i></div>
                                <h2 class="h5">Terapia Psicológica Individual</h2>
                                <p class="mb-0">Espacios de acompañamiento personalizado para ayudarte a afrontar la
                                    ansiedad, el estrés, la depresión y otros desafíos emocionales.</p>
                            </div>
                            <div class="col mb-5 h-100">
                                <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i
                                        class="bi bi-building"></i></div>
                                <h2 class="h5">Terapia Familiar y de Pareja</h2>
                                <p class="mb-0">Mejora la comunicación, fortalece vínculos y encuentra herramientas para
                                    resolver conflictos de manera saludable y respetuosa.</p>
                            </div>
                            <div class="col mb-5 mb-md-0 h-100">
                                <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i
                                        class="bi bi-toggles2"></i></div>
                                <h2 class="h5">Orientación Psicológica Educativa</h2>
                                <p class="mb-0">Acompañamiento a estudiantes, padres y docentes en procesos de
                                    aprendizaje, adaptación escolar y desarrollo personal.</p>
                            </div>
                            <div class="col h-100">
                                <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i
                                        class="bi bi-toggles2"></i></div>
                                <h2 class="h5">Talleres de Bienestar y Desarrollo Personal</h2>
                                <p class="mb-0">Actividades grupales enfocadas en el manejo del estrés, inteligencia
                                    emocional, autoestima y crecimiento personal.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="py-5 bg-light">
            <div class="container px-5 my-5">
                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-10 col-xl-7">
                        <div class="text-center">
                            <div class="fs-4 mb-4 fst-italic">"Gracias al acompañamiento terapéutico, he podido
                                reconectarme conmigo mismo y retomar el control de mi vida emocional. Recomiendo este
                                espacio a quienes buscan una transformación real.</div>
                            <div class="d-flex align-items-center justify-content-center">
                                <img class="rounded-circle me-3" src="https://dummyimage.com/40x40/ced4da/6c757d"
                                    alt="..." />
                                <div class="fw-bold">
                                    Andres Gomez
                                    <span class="fw-bold text-primary mx-1">/</span>
                                    Paciente en proceso terapéutico
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="py-5">
            <div class="container px-5 my-5">
                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-8 col-xl-6">
                        <div class="text-center">
                            <h2 class="fw-bolder">Desde nuestro blog</h2>
                            <p class="lead fw-normal text-muted mb-5">Reflexiones, consejos y herramientas para tu
                                bienestar emocional.</p>
                        </div>
                    </div>
                </div>
                <div class="row gx-5">
                    <div class="col-lg-4 mb-5">
                        <div class="card h-100 shadow border-0">
                            <div class="ratio ratio-16x9">
                                <iframe src="https://www.youtube.com/embed/EGiK0B8xsOc?autoplay=1&mute=1"
                                    title="YouTube video" allowfullscreen></iframe>
                            </div>
                            <div class="card-body p-4">
                                <div class="badge bg-primary bg-gradient rounded-pill mb-2">Autoestima</div>
                                <a class="text-decoration-none link-dark stretched-link" href="#!">
                                    <h5 class="card-title mb-3">Construyendo una autoestima saludable</h5>
                                </a>
                                <p class="card-text mb-0">La autoestima es la base de nuestro bienestar emocional. En
                                    este artículo exploramos cómo cultivar una imagen positiva de ti mismo mediante
                                    hábitos conscientes y autocompasión.</p>
                            </div>
                            <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                                <div class="d-flex align-items-end justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <img class="rounded-circle me-3"
                                            src="https://dummyimage.com/40x40/ced4da/6c757d" alt="..." />
                                        <div class="small">
                                            <div class="fw-bold">Kelly Rowan</div>
                                            <div class="text-muted">March 12, 2023 &middot; 6 min read</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-5">
                        <div class="card h-100 shadow border-0">
                            <div class="ratio ratio-16x9">
                                <iframe src="https://www.youtube.com/embed/BlOagO1p1ZQ?autoplay=1&mute=1"
                                    title="YouTube video" allowfullscreen></iframe>
                            </div>
                            <div class="card-body p-4">
                                <div class="badge bg-primary bg-gradient rounded-pill mb-2">Relaciones</div>
                                <a class="text-decoration-none link-dark stretched-link" href="#!">
                                    <h5 class="card-title mb-3">Cómo establecer límites emocionales sanos</h5>
                                </a>
                                <p class="card-text mb-0">Establecer límites es un acto de amor propio. Aprende por qué
                                    son esenciales para tu equilibrio emocional y cómo comunicarlos de forma asertiva en
                                    tus relaciones personales.</p>
                            </div>
                            <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                                <div class="d-flex align-items-end justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <img class="rounded-circle me-3"
                                            src="https://dummyimage.com/40x40/ced4da/6c757d" alt="..." />
                                        <div class="small">
                                            <div class="fw-bold">Josiah Barclay</div>
                                            <div class="text-muted">March 23, 2023 &middot; 4 min read</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-5">
                        <div class="card h-100 shadow border-0">
                            <div class="ratio ratio-16x9">
                                <iframe src="https://www.youtube.com/embed/3iXjHf12ed4?autoplay=1&mute=1"
                                    title="YouTube video" allowfullscreen></iframe>
                            </div>
                            <div class="card-body p-4">
                                <div class="badge bg-primary bg-gradient rounded-pill mb-2">Ansiedad</div>
                                <a class="text-decoration-none link-dark stretched-link" href="#!">
                                    <h5 class="card-title mb-3">Técnicas efectivas para manejar la ansiedad diaria</h5>
                                </a>
                                <p class="card-text mb-0">Descubre estrategias prácticas como la respiración consciente,
                                    journaling y mindfulness que puedes aplicar cada día para reducir el estrés y
                                    recuperar el control emocional.</p>
                            </div>
                            <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                                <div class="d-flex align-items-end justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <img class="rounded-circle me-3"
                                            src="https://dummyimage.com/40x40/ced4da/6c757d" alt="..." />
                                        <div class="small">
                                            <div class="fw-bold">Evelyn Martinez</div>
                                            <div class="text-muted">April 2, 2023 &middot; 10 min read</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <aside class="bg-primary bg-gradient rounded-3 p-4 p-sm-5 mt-5">
                    <div
                        class="d-flex align-items-center justify-content-between flex-column flex-xl-row text-center text-xl-start">
                        <div class="mb-4 mb-xl-0">
                            <div class="fs-3 fw-bold text-white">¿Necesitas hablar con alguien?</div>
                            <div class="text-white-50">Estamos aquí para apoyarte. Contáctanos para una sesión de
                                orientación o consulta psicológica.</div>
                        </div>
                        <div class="ms-xl-4">
                            <div class="input-group mb-2">
                                <a href="{{ route('contact') }}" class="btn btn-outline-light"
                                    id="button-newsletter">Solicitar cita</a>
                            </div>
                            <div class="small text-white-50">Tus datos se mantendran privados</div>
                        </div>
                    </div>
                </aside>
            </div>
        </section>
    </main>
    <footer class="bg-dark py-4 mt-auto">
        <div class="container px-5">
            <p class="m-0 text-center text-white">Proyecto Desarrollo web 2 &copy; MiRefugio 2025</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>