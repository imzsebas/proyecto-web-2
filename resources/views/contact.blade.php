<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content />
        <meta name="author" content />
        <title>Contactanos / MiRefugio</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body class="d-flex flex-column">
        <main class="flex-shrink-0">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container px-5">
                    <a class="navbar-brand" href="{{ route('home') }}">Mi Refugio</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
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
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-envelope"></i></div>
                            <h1 class="fw-bolder">Contactanos</h1>
                            <p class="lead fw-normal text-muted mb-0">¡Nos encantaría saber de tí!</p>
                        </div>
                        <div class="row gx-5 justify-content-center">
                            <div class="col-lg-8 col-xl-6">
                                <form id="contactForm" method="POST" action="{{ route('contact.send') }}">
                                    @csrf
                                    <div class="form-floating mb-3">
                                        <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" type="text" placeholder="Enter your name..." value="{{ old('name') }}" required />
                                        <label for="name">Nombre</label>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @else
                                            <div class="invalid-feedback" data-sb-feedback="name:required">El nombre es obligatorio.</div>
                                        @enderror
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" placeholder="name@example.com" value="{{ old('email') }}" required />
                                        <label for="email">Correo</label>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @else
                                            <div class="invalid-feedback" data-sb-feedback="email:required">El correo es obligatorio.</div>
                                            <div class="invalid-feedback" data-sb-feedback="email:email">El correo no es valido.</div>
                                        @enderror
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" type="tel" placeholder="(123) 456-7890" value="{{ old('phone') }}" required />
                                        <label for="phone">Telefono</label>
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @else
                                            <div class="invalid-feedback" data-sb-feedback="phone:required">El telefono es obligatorio.</div>
                                        @enderror
                                    </div>
                                    <div class="form-floating mb-3">
                                        <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" type="text" placeholder="Enter your message here..." style="height: 10rem" required>{{ old('message') }}</textarea>
                                        <label for="message">Mensaje</label>
                                        @error('message')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @else
                                            <div class="invalid-feedback" data-sb-feedback="message:required">El mensaje es obligatorio.</div>
                                        @enderror
                                    </div>
                                    <div class="d-none" id="submitSuccessMessage">
                                        <div class="text-center mb-3">
                                            <div class="fw-bolder">Correo enviado con exito!</div>
                                            <p class="mb-0">Te responderemos pronto a tu correo electrónico.</p>
                                        </div>
                                    </div>
                                    @if(session('success'))
                                        <div class="text-center mb-3">
                                            <div class="fw-bolder text-success">{{ session('success') }}</div>
                                        </div>
                                    @endif
                                    <div class="d-none" id="submitErrorMessage">
                                        <div class="text-center text-danger mb-3">Error al enviar el mensaje!</div>
                                    </div>
                                    @if(session('error'))
                                        <div class="text-center text-danger mb-3">{{ session('error') }}</div>
                                    @endif
                                    <div class="d-grid">
                                        <button class="btn btn-primary btn-lg" id="submitButton" type="submit">Enviar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row gx-5 row-cols-2 row-cols-lg-4 py-5">
                        <div class="col">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-chat-dots"></i></div>
                            <div class="h5 mb-2">Chatea con nosotros</div>
                            <p class="text-muted mb-0">Chatea en vivo con uno de nuestros especialistas de soporte.</p>
                        </div>
                        <div class="col">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-people"></i></div>
                            <div class="h5">Pregunta a la comunidad</div>
                            <p class="text-muted mb-0">Explora los foros de nuestra comunidad y comunícate con otros usuarios.</p>
                        </div>
                        <div class="col">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-question-circle"></i></div>
                            <div class="h5">Centro de soporte</div>
                            <p class="text-muted mb-0">Explore las preguntas frecuentes y los artículos de soporte para encontrar soluciones.</p>
                        </div>
                        <div class="col">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-telephone"></i></div>
                            <div class="h5">LLamanos</div>
                            <p class="text-muted mb-0">Llámenos durante el horario comercial normal al (301) 713-2513.</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <footer class="bg-dark py-4 mt-auto">
            <div class="container px-5"><p class="m-0 text-center text-white">Proyecto Desarrollo web 2 &copy; MiRefugio 2025</p></div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
        <script>
        document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitButton = document.getElementById('submitButton');
    const originalText = submitButton.textContent;
    
    // Mostrar estado de carga
    submitButton.textContent = 'Enviando...';
    submitButton.disabled = true;
    
    // Ocultar mensajes anteriores
    document.getElementById('submitSuccessMessage').classList.add('d-none');
    document.getElementById('submitErrorMessage').classList.add('d-none');
    
    // Limpiar validaciones visuales anteriores
    document.querySelectorAll('.is-invalid').forEach(field => field.classList.remove('is-invalid'));
    document.querySelectorAll('[data-sb-feedback]').forEach(feedback => feedback.style.display = 'none');
    
    const formData = new FormData(this);
    
    // SOLUCIÓN: Usar URL relativa o asegurar HTTPS
    const contactUrl = '{{ route("contact.send") }}';
    
    fetch(contactUrl, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Mostrar mensaje de éxito
            document.getElementById('submitSuccessMessage').classList.remove('d-none');
            
            // Limpiar formulario
            this.reset();
        } else {
            throw new Error(data.message || 'Error al enviar el mensaje');
        }
    })
    .catch(error => {
        // Mostrar mensaje de error
        document.getElementById('submitErrorMessage').classList.remove('d-none');
        console.error('Error:', error);
        
        // Mostrar error específico en desarrollo
        if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
            console.error('Error detallado:', error);
        }
    })
    .finally(() => {
        // Restaurar botón
        submitButton.textContent = originalText;
        submitButton.disabled = false;
    });
});
        </script>
    </body>
</html>