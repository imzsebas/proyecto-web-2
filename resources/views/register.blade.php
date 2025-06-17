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
                                    <input class="form-control" id="name" name="name" type="text"
                                        placeholder="Nombre completo" required />
                                    <label for="name">Nombre completo</label>
                                    <div class="invalid-feedback">El nombre es requerido.</div>
                                </div>

                                <div class="form-floating mb-3">
                                    <input class="form-control" id="email" name="email" type="email"
                                        placeholder="nombre@ejemplo.com" required />
                                    <label for="email">Correo electrónico</label>
                                    <div class="invalid-feedback">El correo es requerido.</div>
                                </div>

                                <div class="form-floating mb-3">
                                    <input class="form-control" id="phone" name="phone" type="tel"
                                        placeholder="Número de teléfono" required />
                                    <label for="phone">Teléfono</label>
                                    <div class="invalid-feedback">El teléfono es requerido.</div>
                                </div>

                                <div class="form-floating mb-3">
                                    <select class="form-select" id="occupation" name="occupation"
                                        aria-label="Ocupación">
                                        <option value="">Seleccione una opción</option>
                                        <option value="student">Estudiante</option>
                                        <option value="employed">Empleado</option>
                                        <option value="freelancer">Freelancer</option>
                                        <option value="business">Empresario</option>
                                        <option value="other">Otro</option>
                                    </select>
                                    <label for="occupation">Ocupación</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input class="form-control" id="age" name="age" type="number" min="18" max="99"
                                        placeholder="Edad" required />
                                    <label for="age">Edad</label>
                                    <div class="invalid-feedback">La edad es requerida.</div>
                                </div>

                                <div class="form-floating mb-3">
                                    <input class="form-control" id="password" name="password" type="password"
                                        placeholder="Contraseña" required />
                                    <label for="password">Contraseña</label>
                                    <div class="invalid-feedback">La contraseña es requerida.</div>
                                </div>

                                <div class="form-floating mb-3">
                                    <input class="form-control" id="confirmPassword" name="confirmPassword"
                                        type="password" placeholder="Confirmar contraseña" required />
                                    <label for="confirmPassword">Confirmar contraseña</label>
                                    <div class="invalid-feedback">Debes confirmar tu contraseña.</div>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('registerForm');
            const button = document.getElementById('registerButton');
            const successMessage = document.getElementById('registerSuccessMessage');
            const errorMessage = document.getElementById('registerErrorMessage');

            // Función para mostrar errores específicos
            function showError(message) {
                errorMessage.innerHTML = `<div class="text-center text-danger mb-3">${message}</div>`;
                errorMessage.classList.remove('d-none');
                successMessage.classList.add('d-none');
            }

            // Función para limpiar errores
            function clearErrors() {
                document.querySelectorAll('.invalid-feedback').forEach(el => {
                    el.style.display = 'none';
                });
                document.querySelectorAll('.form-control').forEach(el => {
                    el.classList.remove('is-invalid');
                });
                errorMessage.classList.add('d-none');
            }

            // Función para mostrar errores de validación
            function showValidationErrors(errors) {
                Object.keys(errors).forEach(field => {
                    const input = document.getElementById(field);
                    if (input) {
                        input.classList.add('is-invalid');
                        const feedback = input.parentNode.querySelector('.invalid-feedback');
                        if (feedback) {
                            feedback.textContent = errors[field][0];
                            feedback.style.display = 'block';
                        }
                    }
                });
            }

            form.addEventListener('submit', async function (e) {
                e.preventDefault();

                // Limpiar errores previos
                clearErrors();

                // Validaciones básicas del frontend
                const name = document.getElementById('name').value.trim();
                const email = document.getElementById('email').value.trim();
                const phone = document.getElementById('phone').value.trim();
                const age = document.getElementById('age').value;
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('confirmPassword').value;
                const terms = document.getElementById('terms').checked;
                const occupation = document.getElementById('occupation').value;

                // Validar campos vacíos
                if (!name) {
                    showError('El nombre es requerido');
                    return;
                }
                if (!email) {
                    showError('El correo es requerido');
                    return;
                }
                if (!phone) {
                    showError('El teléfono es requerido');
                    return;
                }
                if (!age) {
                    showError('La edad es requerida');
                    return;
                }
                if (!password) {
                    showError('La contraseña es requerida');
                    return;
                }
                if (!confirmPassword) {
                    showError('Debes confirmar la contraseña');
                    return;
                }

                // Validar contraseñas
                if (password !== confirmPassword) {
                    showError('Las contraseñas no coinciden');
                    return;
                }

                if (password.length < 8) {
                    showError('La contraseña debe tener al menos 8 caracteres');
                    return;
                }

                // Validar términos
                if (!terms) {
                    showError('Debes aceptar los términos y condiciones');
                    return;
                }

                // Validar edad
                if (age < 18 || age > 99) {
                    showError('La edad debe estar entre 18 y 99 años');
                    return;
                }

                // Deshabilitar botón
                button.disabled = true;
                button.textContent = 'Registrando...';

                // Preparar datos
                const data = {
                    name: name,
                    email: email,
                    phone: phone,
                    occupation: occupation || null,
                    age: parseInt(age),
                    password: password,
                    password_confirmation: confirmPassword,
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                };

                console.log('Datos a enviar:', data);

                try {
                    const response = await fetch('/register', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': data._token,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify(data)
                    });

                    console.log('Response status:', response.status);

                    const result = await response.json();
                    console.log('Response data:', result);

                    if (response.ok && result.status === 'success') {
                        successMessage.classList.remove('d-none');
                        setTimeout(() => {
                            window.location.href = result.redirect || '/dashboard';
                        }, 1500);
                    } else if (response.status === 422) {
                        // Error de validación
                        if (result.errors) {
                            showValidationErrors(result.errors);
                        } else {
                            showError(result.first_error || result.message || 'Error de validación');
                        }
                    } else {
                        showError(result.message || 'Error en el servidor');
                    }

                } catch (error) {
                    console.error('Error completo:', error);
                    showError('Error de conexión: ' + error.message);
                } finally {
                    button.disabled = false;
                    button.textContent = 'Registrarse';
                }
            });
        });</script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>