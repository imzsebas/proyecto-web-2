<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Quienes Somos / MiRefugio</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body class="d-flex flex-column">
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
        <header class="py-5">
            <div class="container px-5">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-xxl-6">
                        <div class="text-center my-5">
                            <h1 class="fw-bolder mb-3">Nuestro propósito es ayudarte a construir una vida con más
                                bienestar y equilibrio.</h1>
                            <p class="lead fw-normal text-muted mb-4">En Mi Refugio, creemos que el cuidado de la salud
                                mental debe ser accesible, cercano y libre de prejuicios. Por eso, diseñamos este
                                espacio digital con el objetivo de brindarte herramientas, orientación profesional y
                                recursos que te acompañen en tu proceso de sanación y crecimiento personal.</p>
                            <a class="btn btn-primary btn-lg" href="#scroll-target">Leer nuestra historia</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <section class="py-5 bg-light" id="scroll-target">
            <div class="container px-5 my-5">
                <div class="row gx-5 align-items-center">
                    <div class="col-lg-6"><img class="img-fluid rounded mb-5 mb-lg-0" src="/img/6.jpg" alt="..." />
                    </div>
                    <div class="col-lg-6">
                        <h2 class="fw-bolder">Sanar es avanzar</h2>
                        <p class="lead fw-normal text-muted mb-0">En Mi Refugio creemos que cada paso hacia la sanación
                            es también un paso hacia el crecimiento personal. No se trata de olvidar lo vivido, sino de
                            aprender a vivir con mayor consciencia, calma y fuerza interior. Aquí, te acompañamos en ese
                            camino con recursos pensados para ti.</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-5">
            <div class="container px-5 my-5">
                <div class="row gx-5 align-items-center">
                    <div class="col-lg-6 order-first order-lg-last"><img class="img-fluid rounded mb-5 mb-lg-0"
                            src="/img/7.jpg" alt="..." /></div>
                    <div class="col-lg-6">
                        <h2 class="fw-bolder">Más allá del acompañamiento</h2>
                        <p class="lead fw-normal text-muted mb-0">No solo ofrecemos orientación psicológica, sino
                            también herramientas que te ayudan a reconectar contigo mismo. Desde ejercicios de
                            autocuidado hasta espacios de escucha profesional, nuestro objetivo es que este lugar sea
                            más que una plataforma: sea tu espacio seguro.</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-5 bg-light">
            <div class="container px-5 my-5">
                <div class="text-center">
                    <h2 class="fw-bolder">Nuestro Equipo</h2>
                    <p class="lead fw-normal text-muted mb-5">Dedicados a la calidad y a su éxito</p>
                </div>
                <div class="row gx-5 row-cols-1 row-cols-sm-2 row-cols-xl-4 justify-content-center">
                    <div class="col mb-5 mb-5 mb-xl-0">
                        <div class="text-center">
                            <div class="team-image-container mb-4 mx-auto">
                                <img class="team-image rounded-circle" src="/img/4.jpg" alt="..." />
                            </div>
                            <h5 class="fw-bolder">Ibbie Eckart</h5>
                            <div class="fst-italic text-muted">Founder &amp; CEO</div>
                        </div>
                    </div>
                    <div class="col mb-5 mb-5 mb-xl-0">
                        <div class="text-center">
                            <div class="team-image-container mb-4 mx-auto">
                                <img class="team-image rounded-circle" src="/img/1.jpg" alt="..." />
                            </div>
                            <h5 class="fw-bolder">Arden Vasek</h5>
                            <div class="fst-italic text-muted">CFO</div>
                        </div>
                    </div>
                    <div class="col mb-5 mb-5 mb-sm-0">
                        <div class="text-center">
                            <div class="team-image-container mb-4 mx-auto">
                                <img class="team-image rounded-circle" src="/img/5.jpg" alt="..." />
                            </div>
                            <h5 class="fw-bolder">Toribio Nerthus</h5>
                            <div class="fst-italic text-muted">Operations Manager</div>
                        </div>
                    </div>
                    <div class="col mb-5">
                        <div class="text-center">
                            <div class="team-image-container mb-4 mx-auto">
                                <img class="team-image rounded-circle" src="/img/3.jpg" alt="..." />
                            </div>
                            <h5 class="fw-bolder">Malvina Cilla</h5>
                            <div class="fst-italic text-muted">CTO</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <style>
            /* Estilo para las imágenes del equipo */
            .team-image-container {
                width: 150px;
                height: 150px;
                position: relative;
                overflow: hidden;
            }

            .team-image {
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: center;
            }
        </style>
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