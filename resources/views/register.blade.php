<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content />
    <meta name="author" content />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Registro / MiRefugio</title>
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
                            <i class="bi bi-person-plus"></i>
                        </div>
                        <h1 class="fw-bolder">Registro de Usuario</h1>
                        <p class="lead fw-normal text-muted mb-0">Completa tus datos para crear una cuenta</p>
                    </div>
                    <div class="row gx-5 justify-content-center">
                        <div class="col-lg-8 col-xl-6">
                            <form id="registerForm">
                                @csrf
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="name" type="text" placeholder="Nombre completo"
                                        data-sb-validations="required" />
                                    <label for="name">Nombre completo</label>
                                    <div class="invalid-feedback" data-sb-feedback="name:required">El nombre es
                                        requerido.</div>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="email" type="email" placeholder="nombre@ejemplo.com"
                                        data-sb-validations="required,email" />
                                    <label for="email">Correo electrónico</label>
                                    <div class="invalid-feedback" data-sb-feedback="email:required">El correo es
                                        requerido.</div>
                                    <div class="invalid-feedback" data-sb-feedback="email:email">El correo no es válido.
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="phone" type="tel" placeholder="Número de teléfono"
                                        data-sb-validations="required" />
                                    <label for="phone">Teléfono</label>
                                    <div class="invalid-feedback" data-sb-feedback="phone:required">El teléfono es
                                        requerido.</div>
                                </div>
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="occupation" aria-label="Ocupación">
                                        <option selected disabled value="">Seleccione una opción</option>
                                        <option value="student">Estudiante</option>
                                        <option value="employed">Empleado</option>
                                        <option value="freelancer">Freelancer</option>
                                        <option value="business">Empresario</option>
                                        <option value="other">Otro</option>
                                    </select>
                                    <label for="occupation">Ocupación</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="age" type="number" min="18" max="99"
                                        placeholder="Edad" data-sb-validations="required" />
                                    <label for="age">Edad</label>
                                    <div class="invalid-feedback" data-sb-feedback="age:required">La edad es requerida.
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="password" type="password" placeholder="Contraseña"
                                        data-sb-validations="required" />
                                    <label for="password">Contraseña</label>
                                    <div class="invalid-feedback" data-sb-feedback="password:required">La contraseña es
                                        requerida.</div>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="confirmPassword" type="password"
                                        placeholder="Confirmar contraseña" data-sb-validations="required" />
                                    <label for="confirmPassword">Confirmar contraseña</label>
                                    <div class="invalid-feedback" data-sb-feedback="confirmPassword:required">Debes
                                        confirmar tu contraseña.</div>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" id="terms" type="checkbox" value="" required />
                                    <label class="form-check-label" for="terms">
                                        Acepto los <a href="#terms">términos y condiciones</a>
                                    </label>
                                    <div class="invalid-feedback">Debes aceptar los términos para continuar.</div>
                                </div>
                                <div class="d-none" id="registerSuccessMessage">
                                    <div class="text-center mb-3">
                                        <div class="fw-bolder">¡Registro exitoso!</div>
                                        Redirigiendo...
                                    </div>
                                </div>
                                <div class="d-none" id="registerErrorMessage">
                                    <div class="text-center text-danger mb-3">Error en el registro. Por favor intenta
                                        nuevamente.</div>
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-primary btn-lg" id="registerButton"
                                        type="submit">Registrarse</button>
                                </div>
                                <div class="text-center mt-3">
                                    <p class="small">¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia
                                            sesión</a></p>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/register.js"></script>
</body>

</html>