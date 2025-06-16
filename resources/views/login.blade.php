<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content />
    <meta name="author" content />
    <title>Iniciar Sesion / MiRefugio</title>
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
        <section class="py-5">
            <div class="container px-5">
                <div class="bg-light rounded-3 py-5 px-4 px-md-5 mb-5">
                    <div class="text-center mb-5">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <h1 class="fw-bolder">Iniciar Sesión</h1>
                        <p class="lead fw-normal text-muted mb-0">Ingresa tus credenciales para acceder</p>
                    </div>
                    <div class="row gx-5 justify-content-center">
                        <div class="col-lg-8 col-xl-6">
                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form action="{{ route('login.authenticate') }}" method="POST">
                                @csrf
                                <div class="form-floating mb-3">
                                    <input class="form-control @error('email') is-invalid @enderror" id="email"
                                        name="email" type="text" placeholder="nombre@ejemplo.com"
                                        value="{{ old('email') }}" required />
                                    <label for="email">Correo</label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control @error('password') is-invalid @enderror" id="password"
                                        name="password" type="password" placeholder="Contraseña" required />
                                    <label for="password">Contraseña</label>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-primary btn-lg" type="submit">Iniciar Sesión</button>
                                </div>
                                <div class="text-center mt-2">
                                    <p class="small">¿No tienes una cuenta? <a
                                            href="{{ route('register') }}">Regístrate</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer class="bg-dark py-4 mt-auto">
        <div class="container px-5">
            <p class="m-0 text-center text-white">Proyecto Desarrollo web 2 &copy; MiRefugio 2025</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>